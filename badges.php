<?php
session_start(); // Start the session to access session variables.
$userID = $_SESSION['user_id']; // Assuming user_id is stored in session.

// Include your database connection file
require_once('connection.php');

// Check for Perfect Quiz badge
$query = "SELECT COUNT(*) AS perfect_quiz_count FROM player_sessions WHERE user_id = ? AND correct_answers = total_questions";
$stmt = $mysqli->prepare($query);
$stmt->bind_param('i', $userID);
$stmt->execute();
$stmt->bind_result($perfectQuizCount);
$stmt->fetch();
$stmt->close();
$perfectQuizBadge = ($perfectQuizCount > 0);


$queryUnlockAll = "SELECT SUM(score) AS total_score FROM player_sessions WHERE user_id = ?";
$stmtUnlockAll = $mysqli->prepare($queryUnlockAll);
$stmtUnlockAll->bind_param('i', $userID);
$stmtUnlockAll->execute();
$stmtUnlockAll->bind_result($totalScore);
$stmtUnlockAll->fetch();
$stmtUnlockAll->close();

// Check if the user has reached the Unlocking All achievement
$unlockAllAchievement = ($totalScore >= 50);


$queryAccuracy = "SELECT COUNT(*) AS consecutive_perfect_sessions FROM (
    SELECT user_id, start_time
    FROM player_sessions
    WHERE user_id = ?
      AND correct_answers = total_questions
    ORDER BY start_time DESC
    LIMIT 3
  ) AS recent_perfect_sessions";

$stmtAccuracy = $mysqli->prepare($queryAccuracy);
$stmtAccuracy->bind_param('i', $userID);
$stmtAccuracy->execute();
$stmtAccuracy->bind_result($consecutivePerfectSessions);
$stmtAccuracy->fetch();
$stmtAccuracy->close();

// Check if the user has the Accuracy Badge
$accuracyBadge = ($consecutivePerfectSessions >= 3);

$mysqli->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mathematricks - Game Difficulty Selection</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <!-- FontAwesome CDN -->
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap');

        body,
        html {
            height: 100%;
            margin: 0;
        }

        body {
            background-image: url("assets/img/bg.png");
            background-size: cover;
            font-family: 'Press Start 2P', cursive;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #FFF;
            overflow: hidden;
            background-color: #000;
        }

        .button-container {
            text-align: center;
            background-color: rgba(0, 0, 0, 0.75);
            padding: 2vw;
            /* Use viewport width for responsive padding */
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(255, 255, 0, 0.5);
            z-index: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            max-width: 90%;
            /* Max width to prevent it from becoming too wide on larger screens */
            margin: 2vh auto;
            /* Center the container with vertical margin */
        }

        .difficulty-button {
            margin: 10px 0;
            /* Consistent margin for top and bottom */
            padding: 2vh 4vw;
            /* Responsive padding based on viewport size */
            font-size: 4vw;
            /* Responsive font size */
            width: 80%;
            /* Responsive width */
            max-width: 300px;
            /* Max width to prevent buttons from being too wide */
        }

        @media (max-width: 768px) {
            .difficulty-button {
                font-size: 5vw;
                /* Increase font size for smaller screens */
            }

            .button-container {
                padding: 4vw;
                /* Increase padding for smaller screens */
            }
        }


        .icon-button {
            background: none;
            border: none;
            color: #FFD700;
            cursor: pointer;
            font-size: 24px;
            margin-top: 20px;
            display: block;
            /* Ensure the icon button also aligns with the layout */
            width: 100%;
            /* Ensure it spans the full width of its container */
        }

        .game-title {
            font-size: 32px;
            /* Increased size for the title */
            color: #FFD700;
            /* Gold color */
            margin-bottom: 30px;
            /* Increased spacing */
        }

        .welcome-message {
            font-size: 20px;
            /* Increased size for the welcome message */
            color: #FFD700;
            /* Matching the gold color theme */
            margin-bottom: 30px;
            /* Increased spacing */
        }

        .difficulty-button {
            margin: 10px;
            padding: 20px;
            /* Adjust padding to fit content and shape */
            font-size: 1rem;
            /* Adjust font size as needed */
            width: auto;
            /* Adjust width to content */
            height: auto;
            /* Adjust height to content */
            background-image: none;
            /* Remove gradient for a solid color if preferred */
            background-color: #FFD700;
            /* Badge-like gold color */
            color: #000;
            /* Text color */
            border: 2px solid #FFA500;
            /* Solid border to resemble a badge */
            border-radius: 50%;
            /* Circular shape */
            display: inline-block;
            /* Change display for alignment */
            text-align: center;
            /* Ensure text is centered */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            /* Optional: Add shadow for depth */
            transition: transform 0.3s, box-shadow 0.3s;
            /* Smooth transitions */
            cursor: pointer;
            /* Cursor to pointer to indicate clickable */
            line-height: 1.25;
            /* Adjust line height for text within the badge */
            white-space: nowrap;
            /* Prevent text wrapping */
            overflow: hidden;
            /* Prevent overflow */
            text-overflow: ellipsis;
            /* Handle text overflow for small badges */
            position: relative;
            /* For positioning any badge icons or text */
        }

        /* Adjustments for hover and focus states for interactivity */
        .difficulty-button:hover,
        .difficulty-button:focus {
            transform: scale(1.1);
            /* Slightly enlarge on hover/focus */
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
            /* Increase shadow for "lift" effect */
            background-color: #FFD700;
            /* Brighten or change color on hover/focus */
        }


        .icon-button {
            background: none;
            border: none;
            color: #FFD700;
            /* Gold color */
            cursor: pointer;
            font-size: 24px;
            /* Increased size */
            margin-top: 20px;
            /* Ensure spacing */
        }

        .logo-container img {
            width: 120px;
            /* Adjust based on your logo size */
            display: block;
            /* Center the logo */
            margin: 0 auto 20px;
            /* Centering margin and spacing from the title */
        }

        .disabled-button {
            cursor: not-allowed;
            opacity: 0.5;
        }

        .disabled-button:hover::after {
            content: attr(data-tooltip);
            position: absolute;
            top: -5px;
            right: 105%;
            background-color: black;
            color: white;
            padding: 5px;
            border-radius: 5px;
            font-size: smaller;
            white-space: nowrap;
        }
    </style>
</head>

<body>
    <div class="button-container">
        <button type="button" onclick="window.location.href='play.php';">Back</button>
        <div class="logo-container">
            <img src="assets/img/logo.png" alt="Mathematricks Logo"> <!-- Logo placement -->
        </div>
        <div class="game-title">Your Badges</div>
        <!-- <div class="welcome-message">Select Grade -->
        <!-- </div> Welcome message -->
        <form action="#" method="post">
            <button class="difficulty-button <?php echo $perfectQuizBadge ? '' : 'disabled-button'; ?>"
                name="difficulty" value="medium" <?php echo $perfectQuizBadge ? '' : 'disabled'; ?>
                data-tooltip="<?php echo $perfectQuizBadge ? '' : 'Earn the Perfect Quiz badge to unlock this difficulty.'; ?>">Perfect
                Quize <br>Badge</button>
            <button class="difficulty-button <?php echo $unlockAllAchievement ? '' : 'disabled-button'; ?>"
                name="difficulty" value="2" <?php echo $unlockAllAchievement ? '' : 'disabled'; ?>>
                Unlocking All <br>Levels
            </button>
            <button class="difficulty-button <?php echo $accuracyBadge ? '' : 'disabled-button'; ?>" name="difficulty"
                value="3" <?php echo $accuracyBadge ? '' : 'disabled'; ?>>
                Accuracy <br>Badge
            </button><br>
        </form><br>

        <button class="icon-button" onclick="toggleSound()">
            <i class="fas fa-volume-mute"></i> <!-- Mute icon initially -->
        </button>
    </div>
    <audio id="backgroundMusic" src="mathematricks.mp3" loop></audio>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var audio = document.getElementById("backgroundMusic");
            // Start with audio muted
            audio.muted = true;
        });

        function toggleSound() {
            var audio = document.getElementById("backgroundMusic");
            var icon = document.querySelector('.icon-button i');
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