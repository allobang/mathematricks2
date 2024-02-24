<?php
session_start(); // Start the session to access session variables.
$username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Player'; // Default to 'Player' if not set.

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
            font-family: 'Press Start 2P', cursive;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #FFF;
            overflow: hidden;
            background-color: #000;
            /* In case the video doesn't load */
        }

        .video-bg {
            position: fixed;
            right: 0;
            bottom: 0;
            min-width: 100%;
            min-height: 100%;
            z-index: -1;
            /* Ensure video stays in the background */
        }

        .button-container {
            text-align: center;
            background-color: rgba(0, 0, 0, 0.75);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(255, 255, 0, 0.5);
            z-index: 1;
            display: flex;
            flex-direction: column;
            /* Align buttons vertically */
            align-items: center;
            /* Center buttons horizontally */
        }

        .difficulty-button {
            background-color: #008080;
            color: #FFFFFF;
            padding: 15px 30px;
            margin: 10px;
            border: 2px solid #FFF;
            border-radius: 5px;
            font-size: 20px;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.2s;
            outline: none;
            display: block;
            /* Ensure buttons are block-level for vertical layout */
            width: 80%;
            /* Optional: Adjust the width as per your design requirement */
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
            width: 90%;
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
    </style>
</head>

<body>
    <video autoplay loop muted class="video-bg">
        <source src="bee.mp4" type="video/mp4">
        Your browser does not support the video tag.
    </video>
    <div class="button-container">
        <div class="logo-container">
            <img src="assets/img/logo.png" alt="Mathematricks Logo"> <!-- Logo placement -->
        </div>
        <div class="game-title">Mathematricks</div>
        <div class="welcome-message">Welcome,
            <?= htmlspecialchars($username); ?>!
        </div> <!-- Welcome message -->
        <form action="game.php" method="post">
            <button class="difficulty-button" name="difficulty" value="easy">Play</button>
            <button class="difficulty-button" name="difficulty" value="medium">Badges</button>
            <button type="button" class="difficulty-button" onclick="window.location.href='stats.php';">Stats</button>
            <button type="button" class="difficulty-button" onclick="window.location.href='leaderboard.php';">Leaderboard</button>
            <?php
            // Check if the user type is set and equals 'admin'
            if (isset($_SESSION['usertype']) && $_SESSION['usertype'] == 'admin') {
                echo '<button type="button" class="difficulty-button" onclick="window.location.href=\'displayQuestions.php\';">Question</button>';
            }
            ?>
            <button type="button" class="difficulty-button" onclick="window.location.href='logout.php';">Logout</button>
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