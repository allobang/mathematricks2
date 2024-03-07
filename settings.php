<?php
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit;
}

// Rest of your index.php code...
?>

<!doctype html>
<!-- 
* Bootstrap Simple Admin Template
* Version: 2.1
* Author: Alexis Luna
* Website: https://github.com/alexis-luna/bootstrap-simple-admin-template
-->
<html lang="en">

<?php include 'layout/head.php'; ?>

<body>
    <div class="wrapper">
        <?php include 'layout/side.php'; ?>
        <div id="body" class="active">
            <?php include 'layout/nav.php'; ?>
            <div class="content">
                <div class="container">
                    <div class="page-title">
                        <h3>Settings</h3>
                    </div>
                    <div class="box box-primary">
                        <div class="box-body">
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="general-tab" data-bs-toggle="tab" href="#general"
                                        role="tab" aria-controls="general" aria-selected="true">Game Settings</a>
                                </li>
                            </ul>
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade active show" id="general" role="tabpanel"
                                    aria-labelledby="general-tab">
                                    <div class="col-md-6">
                                        <form id="game-timer-form" action="save_timer_settings.php" method="post">
                                            <div class="mb-3">
                                                <label for="game-timer-hours" class="form-label">Game Timer -
                                                    Hours</label>
                                                <input type="number" name="game_timer_hours" id="game-timer-hours"
                                                    class="form-control" min="0" max="23" placeholder="Hours">
                                            </div>
                                            <div class="mb-3">
                                                <label for="game-timer-minutes" class="form-label">Game Timer -
                                                    Minutes</label>
                                                <input type="number" name="game_timer_minutes" id="game-timer-minutes"
                                                    class="form-control" min="0" max="59" placeholder="Minutes">
                                            </div>
                                            <div class="mb-3 text-end">
                                                        <input class="btn btn-success" type="submit">
                                            </div>
                                        </form>
                                    </div>

                                    <script>
                                        document.addEventListener('DOMContentLoaded', function () {
                                            document.getElementById('game-timer-form').addEventListener('submit', function (event) {
                                                var hours = document.getElementById('game-timer-hours').value;
                                                var minutes = document.getElementById('game-timer-minutes').value;

                                                // Assuming you want to store the total time in minutes
                                                var totalTimeInMinutes = parseInt(hours) * 60 + parseInt(minutes);

                                                // Use this totalTimeInMinutes for further processing
                                                console.log("Total time in minutes: ", totalTimeInMinutes);

                                                // Prevent form submission for demonstration
                                                // event.preventDefault();
                                            });
                                        });
                                    </script>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include 'layout/foot.php'; ?>