<?php
// var_dump($_POST['difficulty']); die();
session_start();
require_once('connection.php'); // Using require_once to ensure the connection file is included only once

// Redirect if not logged in
if (empty($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
    header("Location: login.php");
    exit;
}

// Prepare and execute query to fetch quiz questions
$questions = fetchQuizQuestions($userGrade);
$timerDurationMinutes = fetchTimerSetting();

// Insert a new player session if questions are available
if (!empty($questions)) {
    $sessionID = insertPlayerSession(count($questions));
    if ($sessionID) {
        initializeSessionVariables($sessionID, count($questions));
    } else {
        echo "Error preparing session insert statement.";
    }
} else {
    echo "No questions found for the specified grade.";
}

// Redirect or further process

// Functions used above for clarity and reusability
function fetchQuizQuestions($grade)
{
    global $mysqli; // Ensure $mysqli is accessible within the function
    $stmt = $mysqli->prepare("SELECT id, question, choice1, choice2, choice3, choice4, answer, image_url FROM quizquestions WHERE grade = ?");
    $stmt->bind_param("s", $grade);
    $stmt->execute();
    $result = $stmt->get_result();
    $questions = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    return $questions;
}

function insertPlayerSession($totalQuestions)
{
    global $mysqli; // Ensure $mysqli is accessible within the function
    $userID = $_SESSION['user_id'];
    $insertSessionSql = "INSERT INTO player_sessions (user_id, start_time, total_questions) VALUES (?, NOW(), ?)";
    $stmt = $mysqli->prepare($insertSessionSql);
    $stmt->bind_param("ii", $userID, $totalQuestions);
    $stmt->execute();
    $sessionID = $mysqli->insert_id;
    $stmt->close();
    return $sessionID;
}

function initializeSessionVariables($sessionID, $totalQuestions)
{
    $_SESSION['current_session_id'] = $sessionID;
    $_SESSION['total_questions'] = $totalQuestions;
    $_SESSION['quiz_score'] = 0;
    $_SESSION['correct_answers'] = 0;
    $_SESSION['incorrect_answers'] = 0;
    $_SESSION['answered_questions'] = 0;
}

function fetchTimerSetting() {
    global $mysqli; // Ensure $mysqli is accessible within the function
    $query = "SELECT setting_value FROM quiz_settings WHERE setting_name = 'quiz_duration' ORDER BY updated_at DESC LIMIT 1";
    $result = $mysqli->query($query);

    if ($result && $row = $result->fetch_assoc()) {
        return $row['setting_value']; // Return the most recent timer duration in minutes
    } else {
        return 0; // Default value in case the setting is not found
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <!-- Style here or link to external CSS -->
    <style>
        body {
            background-image: url("assets/img/bg.png");
            background-size: cover;
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #abe9cd 0%, #3eadcf 100%);
            padding: 20px;
            text-align: center;
            color: #02475e;
        }

        .question-form {
            background-color: #ffffffaa;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 15px;
            box-shadow: 0px 8px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .question-form:hover {
            transform: translateY(-5px);
        }

        .question p {
            font-size: 22px;
            color: #333;
        }

        .question-image img {
            max-width: 30%;
            height: auto;
            border-radius: 10px;
            margin: 10px 0;
        }

        .choices label {
            background-color: #f9f9f9;
            display: block;
            margin: 10px auto;
            font-size: 18px;
            padding: 10px;
            border-radius: 25px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            width: 80%;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .choices label:hover {
            background-color: #e2e2e2;
        }

        .choices input[type="radio"] {
            appearance: none;
            -webkit-appearance: none;
            clip: rect(0, 0, 0, 0);
            clip-path: inset(50%);
            overflow: hidden;
            position: absolute;
            white-space: nowrap;
            width: 1px;
            height: 1px;
            margin: -1px;
            padding: 0;
        }

        .choices label:before {
            content: '';
            display: inline-block;
            height: 20px;
            width: 20px;
            border-radius: 50%;
            margin-right: 10px;
            vertical-align: middle;
            border: 2px solid #333;
            background-color: #fff;
        }

        .choices input[type="radio"]:checked+label:before {
            background-color: #4caf50;
            border-color: #4caf50;
        }

        .submit-btn,
        #finishQuizBtn {
            background-color: #00b4d8;
            color: white;
            border: none;
            padding: 12px 24px;
            font-size: 18px;
            border-radius: 25px;
            cursor: pointer;
            display: inline-block;
            margin: 20px auto;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s, transform 0.3s;
        }

        .submit-btn:hover,
        #finishQuizBtn:hover {
            background-color: #0096c7;
            transform: translateY(-3px);
        }

        .timer-sound-container {
            position: fixed;
            left: 20px;
            top: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px;
            border-radius: 10px;
            background-color: #ffffffaa;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            z-index: 100;
        }

        .icon-button,
        .icon-button.home-icon {
            padding: 5px;
            background: none;
            border: none;
            cursor: pointer;
            font-size: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #333;
            text-decoration: none;
        }

        @media (max-width: 768px) {
            .question-image img {
                max-width: 80%;
                /* Adjust for smaller screens */
            }

            #timer,
            #finishQuizBtn {
                top: auto;
                bottom: 10px;
                left: 10px;
                font-size: 16px;
                padding: 8px;
            }

            #finishQuizBtn {
                right: 10px;
            }
        }

        .submit-btn:disabled,
        #finishQuizBtn:disabled {
            background-color: #b0bec5;
            color: #78909c;
            cursor: not-allowed;
            box-shadow: none;
        }

        .choices {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
            margin-top: 20px;
        }

        .video-bg {
            position: fixed;
            right: 0;
            bottom: 0;
            min-width: 100%;
            min-height: 100%;
            z-index: -1;
        }
    </style>
</head>

<body>
    <div class="timer-sound-container">
        <div id="timer" style="font-size:20px;">00:00:00</div>

        <!-- Home Icon Button -->
        <a href="play.php" class="icon-button home-icon">
            <i class="fas fa-home"></i> <!-- Home icon -->
        </a>

        <button id="icon-button" class="icon-button" onclick="toggleSound()">
            <i class="fas fa-volume-mute"></i> <!-- Mute icon initially -->
        </button>
    </div>

    <audio id="backgroundMusic" src="mathematricks.mp3" loop></audio>

    <?php if (!empty($questions)): ?>
        <?php foreach ($questions as $row): ?>
            <form action="process_answer.php" method="post" class="question-form">
                <input type="hidden" name="question_id" value="<?= htmlspecialchars($row['id']); ?>">
                <div class="question">
                    <p>
                        <?= htmlspecialchars($row['question']) ?>
                    </p>
                    <?php if (!empty($row['image_url'])): ?>
                        <div class="question-image">
                            <img src="<?= htmlspecialchars($row['image_url']) ?>" alt="Question image">
                        </div>
                    <?php endif; ?>
                    <div class="choices">
                        <input type="radio" id="choice1-<?= $row['id']; ?>" name="answer"
                            value="<?= htmlspecialchars($row['choice1']) ?>">
                        <label for="choice1-<?= $row['id']; ?>">
                            <?= htmlspecialchars($row['choice1']) ?>
                        </label>

                        <input type="radio" id="choice2-<?= $row['id']; ?>" name="answer"
                            value="<?= htmlspecialchars($row['choice2']) ?>">
                        <label for="choice2-<?= $row['id']; ?>">
                            <?= htmlspecialchars($row['choice2']) ?>
                        </label>

                        <input type="radio" id="choice3-<?= $row['id']; ?>" name="answer"
                            value="<?= htmlspecialchars($row['choice3']) ?>">
                        <label for="choice3-<?= $row['id']; ?>">
                            <?= htmlspecialchars($row['choice3']) ?>
                        </label>

                        <input type="radio" id="choice4-<?= $row['id']; ?>" name="answer"
                            value="<?= htmlspecialchars($row['choice4']) ?>">
                        <label for="choice4-<?= $row['id']; ?>">
                            <?= htmlspecialchars($row['choice4']) ?>
                        </label>
                    </div>
                </div>
                <button type="submit" class="submit-btn">Submit</button>
            </form>
        <?php endforeach; ?>
    <?php endif; ?>


    <!-- Finish Quiz Button -->
    <button id="finishQuizBtn" style="font-size: 16px; padding: 10px; margin: 20px;">Finish Quiz</button>

    <!-- Additional scripts and HTML go here -->

    <!-- end of body -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var timerDurationInSeconds = <?php echo $timerDurationMinutes * 60; ?>; // Convert minutes to seconds
            initializeTimer(timerDurationInSeconds);
            // Handle form submissions
            document.querySelectorAll('.question-form').forEach(form => {
                form.addEventListener('submit', function (event) {
                    event.preventDefault(); // Prevent default form submission
                    submitForm(form); // Submit the form data
                });
            });

            // Handle "Finish Quiz" button click
            document.getElementById('finishQuizBtn').addEventListener('click', function () {
                finishQuiz(); // Manually finish the quiz
            });
        });

        function initializeTimer(duration) {
            let timeRemaining = duration;
            const timerDisplay = document.getElementById('timer');
            updateTimerDisplay(timeRemaining);

            const timer = setInterval(() => {
                timeRemaining--;
                updateTimerDisplay(timeRemaining);

                if (timeRemaining < 0) {
                    clearInterval(timer);
                    finishQuiz(true); // Finish the quiz due to time up
                }
            }, 1000);
        }

        function updateTimerDisplay(time) {
            const hours = Math.floor(time / 3600);
            time %= 3600; // Update time to remaining seconds after extracting hours
            const minutes = Math.floor(time / 60);
            const seconds = time % 60;
            document.getElementById('timer').textContent =
                `${hours < 10 ? '0' : ''}${hours}:` +
                `${minutes < 10 ? '0' : ''}${minutes}:` +
                `${seconds < 10 ? '0' : ''}${seconds}`;
        }


        function submitForm(form) {
            const submitButton = form.querySelector('.submit-btn');
            submitButton.disabled = true; // Disable the submit button to prevent multiple submissions

            const formData = new FormData(form);
            fetch('check_answer.php', {
                method: 'POST',
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    console.log(data);
                    // Update UI based on the response
                })
                .catch(error => console.error('Error:', error));
        }

        function finishQuiz(timeUp = false) {
            fetch('check_answer.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `quiz_finished=true&time_up=${timeUp}`
            })
                .then(response => response.json())
                .then(data => {
                    console.log("Quiz finished.", data);
                    window.location.href = 'result.php'; // Redirect to result.php
                })
                .catch(error => console.error('Error:', error));
        }
    </script>
    <script>
        function disableButton(button) {
            button.disabled = true; // Disable the button
            button.innerText = 'Submitted'; // Optional: change button text
        }
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var audio = document.getElementById("backgroundMusic");
            // Start with audio muted
            audio.muted = true;
        });

        function toggleSound() {
            var audio = document.getElementById("backgroundMusic");
            var icon = document.querySelector('#icon-button i');
            if (audio.muted) {
                audio.muted = false;
                audio.play(); // Play audio if it was not playing
                icon.classList.remove('fa-volume-mute');
                icon.classList.add('fa-volume-up');
            } else {
                audio.muted = true;
                icon.classList.remove('fa-volume-up');
                icon.classList.add('fa-volume-mute');
            }
        }
    </script>
</body>

</html>