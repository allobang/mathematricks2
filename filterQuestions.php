<?php
include('connection.php'); // Ensure the path is correct

$grade = isset($_GET['grade']) && !empty($_GET['grade']) ? $_GET['grade'] : null;
$difficulty = isset($_GET['difficulty']) && !empty($_GET['difficulty']) ? $_GET['difficulty'] : null;

// Starting the query
$query = "SELECT * FROM `quizquestions` WHERE 1=1";

// Adding conditions based on the presence of filters
$params = []; // For storing parameters
$types = ""; // For storing parameter types

if (!is_null($grade)) {
    $query .= " AND `grade` = ?";
    $params[] = $grade;
    $types .= "s"; // 's' denotes a string
}

if (!is_null($difficulty)) {
    $query .= " AND `difficulty` = ?";
    $params[] = $difficulty;
    $types .= "s"; // Adding another 's' for the string parameter
}

$query .= " ORDER BY `created_at` DESC";

$stmt = $mysqli->prepare($query);

// Dynamically binding parameters
if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();

if($result->num_rows > 0){
    while($row = $result->fetch_assoc()){
        echo "<tr>
                <td>".htmlspecialchars($row['id'])."</td>
                <td>".htmlspecialchars($row['grade'])."</td>
                <td>".htmlspecialchars($row['difficulty'])."</td>
                <td>".htmlspecialchars($row['question'])."</td>
                <td>".htmlspecialchars($row['choice1'])."</td>
                <td>".htmlspecialchars($row['choice2'])."</td>
                <td>".htmlspecialchars($row['choice3'])."</td>
                <td>".htmlspecialchars($row['choice4'])."</td>
                <td>".htmlspecialchars($row['answer'])."</td>
                <td>".htmlspecialchars($row['explanation'])."</td>
                <td>";
        if (!empty($row['image_url'])) {
            echo "<img src='".htmlspecialchars($row['image_url'])."' alt='Question Image' style='width: 100px; height: auto;'>";
        }
        echo "</td>
                <td>
                    <a href='editQuestion.php?id=".htmlspecialchars($row['id'])."' title='Edit'><i class='fas fa-edit'></i></a> |
                    <a href='deleteQuestion.php?id=".htmlspecialchars($row['id'])."' onclick=\"return confirm('Are you sure you want to delete this?');\" title='Delete'><i class='fas fa-trash-alt'></i></a>
                </td>
              </tr>";
    }
} else {
    echo "<tr><td colspan='12'>No questions found for the selected filters.</td></tr>";
}

$stmt->close();
?>
