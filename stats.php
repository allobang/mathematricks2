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

// Prepare a SQL statement to fetch the 10 latest games with correct answers for the logged-in user
$sql = "SELECT score, created_at FROM player_sessions WHERE user_id = ? AND correct_answers > 0 ORDER BY created_at DESC LIMIT 10";

// Prepare and bind parameters
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("i", $user_id);

// Execute the query
$stmt->execute();

// Bind the result variables
$stmt->bind_result($score, $created_at);

// Fetch all rows and store in an array
$games_data = [];
while ($stmt->fetch()) {
    $games_data[] = ['score' => $score, 'created_at' => $created_at];
}

// Close statement and connection
$stmt->close();
$mysqli->close();

// Reverse the array to ensure the graph shows the oldest game first
$games_data = array_reverse($games_data);

// Convert data into a format suitable for Chart.js
$scores = array_map(function ($game) {
    return $game['score'];
}, $games_data);

$dates = array_map(function ($game) {
    return date("Y-m-d", strtotime($game['created_at']));
}, $games_data);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mathematricks - Stats</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap');

        body, html {
            height: 100%;
            margin: 0;
            /* background-color: #000; */
        }

        body {
            font-family: 'Press Start 2P', cursive;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: #FFF;
        }
        .content-container {
            z-index: 2;
            background-color: rgba(0, 0, 0, 0.8); /* Semi-transparent overlay */
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(255, 255, 0, 0.5);
            margin: 20px;
            width: 90%;
            max-width: 800px;
        }

        h3 {
            color: #FFD700;
            margin-bottom: 20px;
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #FFFFFF;
            padding: 8px;
            text-align: left;
            color: #FFF;
        }

        th {
            background-color: #004D40;
        }

        tr:nth-child(even) {
            background-color: #002f2f;
        }

        tr:hover {
            background-color: #013636;
        }

        .scoresChartContainer {
            margin: 20px 0;
            background-color: rgba(0, 0, 0, 0.5);
            padding: 10px;
            border-radius: 10px;
        }

        canvas {
            max-width: 100%;
            height: auto;
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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <video autoplay loop muted class="video-bg">
        <source src="bee.mp4" type="video/mp4">
        Your browser does not support the video tag.
    </video>
    <div class="content-container">
        
    <button type="button" class="difficulty-button" onclick="window.location.href='play.php';">Home</button>
        <canvas id="scoresChart"></canvas>
        <div class="scoresChartContainer">
            <h3>Game History</h3>
            <table>
                <thead>
                    <tr>
                        <th>Session Date</th>
                        <th>Score</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($games_data as $session): ?>
                        <tr>
                            <td><?php echo date("Y-m-d H:i:s", strtotime($session['created_at'])); ?></td>
                            <td><?php echo htmlspecialchars($session['score']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        var scores = <?php echo json_encode($scores); ?>;
        var dates = <?php echo json_encode($dates); ?>;
        
        var ctx = document.getElementById('scoresChart').getContext('2d');
        var scoresChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: dates,
                datasets: [{
                    label: 'Scores',
                    borderColor: 'rgb(75, 192, 192)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    data: scores,
                    fill: true,
                    tension: 0.3
                }]
            },
            options: {
                scales: {
                    y: { beginAtZero: true },
                    x: {
                        ticks: {
                            autoSkip: true,
                            maxTicksLimit: 10
                        }
                    }
                },
                plugins: {
                    legend: {
                        labels: {
                            color: '#FFF' // ensures legend is visible
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>