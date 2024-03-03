<?php
// Include the connection setup
include_once 'connection.php';

// Start or resume a session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit;
}

// Assuming $_SESSION['user_id'] is set after login
$user_id = $_SESSION['user_id'];

// Fetch user's full name for the welcome message
$userQuery = "SELECT firstname, lastname FROM users WHERE id = ?";
$stmt = $mysqli->prepare($userQuery);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($firstname, $lastname);
$stmt->fetch();
$stmt->close();

$fullname = isset($firstname) ? htmlspecialchars($firstname) . ' ' . htmlspecialchars($lastname) : 'Player';

// Query to fetch the leaderboard data
$leaderboardQuery = "SELECT u.username, SUM(ps.score) AS total_score
                     FROM users u
                     JOIN player_sessions ps ON u.id = ps.user_id
                     GROUP BY u.id
                     ORDER BY total_score DESC
                     LIMIT 10";

$result = $mysqli->query($leaderboardQuery);

// Initialize an empty array to store the leaderboard data
$leaderboard_data = [];

// Fetch the results
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $leaderboard_data[] = $row;
    }
    $result->free();
} else {
    echo "Error fetching leaderboard data: " . $mysqli->error;
}

// Close the database connection if it's no longer needed
$mysqli->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Leaderboard - Mathematricks</title>
    <style>
        body {
            background-image: url("assets/img/bg.png");
            background-size: cover;
            font-family: 'Arial', sans-serif;
            background-color: #f0f0f0;
            color: #333;
            margin: 0;
            padding: 20px;
            box-sizing: border-box;
        }

        .leaderboard-container {
            max-width: 600px;
            margin: auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .welcome-message {
            margin-bottom: 20px;
            font-size: 20px;
            color: #666;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            text-align: left;
            padding: 8px;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #ddd;
        }

        td {
            font-size: 16px;
        }

        th {
            font-size: 18px;
        }
        .video-bg {
    position: fixed;
    right: 0;
    bottom: 0;
    min-width: 100%;
    min-height: 100%;
    z-index: -1;
    opacity: 0.75; /* Lower opacity to ensure content stands out */
}
    </style>
</head>
<body>
    <div class="leaderboard-container">
        <!-- <div class="welcome-message">Welcome, <?= $fullname; ?>!</div> -->
        
    <button type="button" class="difficulty-button" onclick="window.location.href='play.php';">Home</button>
        <h1>Leaderboard</h1>
        <table>
            <thead>
                <tr>
                    <th>Rank</th>
                    <th>Username</th>
                    <th>Total Score</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($leaderboard_data)): ?>
                    <?php foreach($leaderboard_data as $index => $data): ?>
                        <tr>
                            <td><?= $index + 1; ?></td>
                            <td><?= htmlspecialchars($data['username']); ?></td>
                            <td><?= htmlspecialchars($data['total_score']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3">No data available.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>

