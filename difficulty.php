<?php

session_start(); // Start the session to access session variables.
require_once('connection.php');
$username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Player'; // Default to 'Player' if not set.
$userGrade = $_POST['difficulty'] ?? ''; // Using null coalescing operator for safety
$_SESSION['grade'] = $userGrade;
$user_id = $_SESSION['user_id']; // Use the user_id from session directly.

// Retrieve the total correct answers for the current user
$total_correct_answers_query = "SELECT SUM(correct_answers) AS total_correct_answers FROM player_sessions WHERE user_id = ?";
$stmt = $mysqli->prepare($total_correct_answers_query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$total_correct_answers = $row['total_correct_answers'];

// Determine if the medium and hard buttons should be enabled
$medium_unlocked = $total_correct_answers >= 20;
$hard_unlocked = $total_correct_answers >= 50;
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
    padding: 2vw; /* Use viewport width for responsive padding */
    border-radius: 10px;
    box-shadow: 0 0 15px rgba(255, 255, 0, 0.5);
    z-index: 1;
    display: flex;
    flex-direction: column;
    align-items: center;
    max-width: 90%; /* Max width to prevent it from becoming too wide on larger screens */
    margin: 2vh auto; /* Center the container with vertical margin */
}

.difficulty-button {
    margin: 10px 0; /* Consistent margin for top and bottom */
    padding: 2vh 4vw; /* Responsive padding based on viewport size */
    font-size: 4vw; /* Responsive font size */
    width: 80%; /* Responsive width */
    max-width: 300px; /* Max width to prevent buttons from being too wide */
}

@media (max-width: 768px) {
    .difficulty-button {
        font-size: 5vw; /* Increase font size for smaller screens */
    }

    .button-container {
        padding: 4vw; /* Increase padding for smaller screens */
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
            background-image: linear-gradient(to right, #009688, #004D40);
            /* Teal gradient */
            color: #FFFFFF;
            padding: 15px 40px;
            /* Increased padding for better spacing */
            margin: 10px 0;
            /* Adjusted for vertical layout */
            border: none;
            /* Clean look without border */
            border-radius: 10px;
            /* Rounded corners */
            font-size: 20px;
            /* Readable font size */
            cursor: pointer;
            transition: transform 0.3s, box-shadow 0.3s, background-color 0.3s;
            /* Smooth transitions */
            outline: none;
            display: block;
            width: 100%;
            /* Increased width for more space */
            max-width: 600px;
            /* Optional: Prevents the button from becoming too wide on large screens */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            /* Subtle shadow for depth */
            text-shadow: 1px 1px 2px black;
            /* Text shadow for contrast */
            text-align: center;
            /* Ensure text is centered */
        }

        .difficulty-button:hover,
        .difficulty-button:focus {
            transform: translateY(-5px);
            /* Lift effect on hover for interactivity */
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.25);
            /* Deeper shadow on hover for a "pop" effect */
            background-image: linear-gradient(to right, #FFD700, #FFA000);
            /* Gold gradient on hover for visual feedback */
            color: #000;
            /* Contrast color change on hover */
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
        <div class="logo-container">
            <img src="assets/img/logo.png" alt="Mathematricks Logo"> <!-- Logo placement -->
        </div>
        <div class="game-title">Select Difficulty</div>
        <!-- <div class="welcome-message">Select Grade -->
        <!-- </div> Welcome message -->
        <form action="game.php" method="post">
            <button class="difficulty-button" name="difficulty" value="easy">Easy</button>

            <button class="difficulty-button <?php echo $medium_unlocked ? '' : 'disabled-button'; ?>" name="difficulty" value="medium" <?php echo $medium_unlocked ? '' : 'disabled'; ?> data-tooltip="Unlock Medium by answering 20 correct questions.">Medium</button>

            <button class="difficulty-button <?php echo $hard_unlocked ? '' : 'disabled-button'; ?>" name="difficulty" value="hard" <?php echo $hard_unlocked ? '' : 'disabled'; ?> data-tooltip="Unlock Hard by answering 50 correct questions.">Hard</button>

            <button type="button" class="difficulty-button" onclick="window.location.href='grade.php';">Back</button>
        </form>

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