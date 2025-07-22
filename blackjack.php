<!-- Created by Matthew Urban
		This is the main blackjack page. This file provides data + visuals.
	-->
<?php include("top.php"); ?>

<head>
    <script type="text/javascript" src="blackjack.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/prototype/1.7.3.0/prototype.js" type="text/javascript"></script>
</head>

<?php
    
    #check session
    if (!isset($_SESSION['user'])) {
        header('Location: index.php');
        exit();
    }


    ?>
    <div class='main'>
        <div class='leaderboard'>

            <div class="highScores">
                <?php
                try {
                    #access db
                    #removed username and pw
                    $db = new PDO('mysql:dbname=accounts;host=localhost', '', '');

                    $rows = $db->query("SELECT account_id, highest_balance FROM account_info
                                        ORDER BY highest_balance DESC
                                        LIMIT 10;");

                    $data = $rows->fetchAll();

                    #check if there is data
                    if (sizeof($data) > 0) {
                        for ($i = 0; $i < sizeof($data); $i++) {
                            #placing top 10 users on the leaderboard
                            ?>
                                <p><span id="accountName"><?= $i + 1 . ". " . $data[$i][0]?></span>: <?= $data[$i][1] ?></p>
                            <?php
                        }
                    }

                } catch (PDOException $ex) {
                    print("Something went wrong." . $ex);
                }
                ?>

            </div>
            <hr>
            <div class="balances">
                <p>Current Balance: <span id="currentBalance"> </span> </p>
                <p>Highest Balance: <span id="highestBalance"> </span> </p>
            </div>
        </div>
    

        <div class='middle'>

           
            <div id='dealerCards'>
                
            </div>

            <div id='playerCards'>

            </div>

            <div class="buttons">

                <div class='actions'>
                    <button id="hit">Hit</button>
                    <button id="stand">Stand</button>
                </div>

                <div class='bid'>
                    Bid Amount: <input type='number' id="bid" min="0" step="1"/>
                </div>

                <div class='startFinish'>
                    <form method="post" action="blackjackSubmit.php">
                        <input type="hidden" id="hiddenScore" name="scoreSubmission" value="100">
                        <button id="quitGame">Quit</button>
                    </form>
                        <button id="newGame">New Game</button>
                    
                </div>
            </div>
        </div>

        <div class="right">
            <p id="dealerTotal">Dealer Score: </p>
            <p id="playerTotal">Player Score: </p>
            <p id="resultText">Result: </p>
            <p id="errorText"></p>
        </div>

    </div>


    

    
    

