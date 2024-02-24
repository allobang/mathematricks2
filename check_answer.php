<?php
session_start();
include('connection.php');

function updatePlayerSession($mysqli, $sessionId, $forceUpdate = false) {
    if ($forceUpdate || $_SESSION['answered_questions'] >= $_SESSION['total_questions']) {
        $score = $_SESSION['quiz_score'];
        $correctAnswers = $_SESSION['correct_answers'];
        $updateSessionSql = "UPDATE player_sessions SET score = ?, end_time = NOW(), correct_answers = ? WHERE session_id = ?";
        
        if ($updateStmt = $mysqli->prepare($updateSessionSql)) {
            $updateStmt->bind_param("iii", $score, $correctAnswers, $sessionId);
            $updateStmt->execute();
            $updateStmt->close();
            return true;
        }
        return false;
    }
    return false;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $sessionId = $_SESSION['current_session_id'] ?? null;

    // Early exit for quiz completion triggers
    if (isset($_POST['quiz_finished']) || isset($_POST['time_up'])) {
        $wasUpdateSuccessful = updatePlayerSession($mysqli, $sessionId, true);
        echo json_encode(['quiz_finished' => true, 'success' => $wasUpdateSuccessful, 'message' => 'Quiz ended.']);
        exit;
    }

    // Proceed with question handling
    $questionId = $_POST['question_id'] ?? '';
    $selectedAnswer = $_POST['answer'] ?? '';
    $isCorrect = false;

    if ($questionId && $selectedAnswer) {
        $query = "SELECT answer FROM quizquestions WHERE id = ?";
        if ($stmt = $mysqli->prepare($query)) {
            $stmt->bind_param("i", $questionId);
            $stmt->execute();
            $stmt->bind_result($correctAnswer);
            if ($stmt->fetch() && $selectedAnswer == $correctAnswer) {
                $isCorrect = true;
                $_SESSION['quiz_score'] += 1;
                $_SESSION['correct_answers'] += 1;
            } else {
                $_SESSION['incorrect_answers'] += 1;
            }
            $stmt->close();

            // Insert attempt
            $insertAttemptSql = "INSERT INTO answer_attempts (session_id, question_id, selected_answer, is_correct) VALUES (?, ?, ?, ?)";
            if ($insertStmt = $mysqli->prepare($insertAttemptSql)) {
                $insertStmt->bind_param("iisi", $sessionId, $questionId, $selectedAnswer, $isCorrect);
                $insertStmt->execute();
                $insertStmt->close();
            }

            $_SESSION['answered_questions'] += 1;
            $quizFinished = updatePlayerSession($mysqli, $sessionId);

            // Prepare and send response
            $response = [
                'result' => $isCorrect ? 'correct' : 'incorrect',
                'selected' => $selectedAnswer,
                'answer' => $correctAnswer,
                'quiz_finished' => $quizFinished,
                'correct_count' => $_SESSION['correct_answers'],
                'incorrect_count' => $_SESSION['incorrect_answers'],
                'remaining_questions' => $_SESSION['total_questions'] - $_SESSION['answered_questions']
            ];
            echo json_encode($response);
        } else {
            echo json_encode(['error' => 'Database error while fetching question']);
        }
    } else {
        echo json_encode(['error' => 'Missing question ID or answer']);
    }
} else {
    echo json_encode(['error' => 'Invalid request method']);
}
?>
