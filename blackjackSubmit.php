<!-- Created by Matthew Urban
		This file handles highscore submission for a blackjack run.
	-->
<?php

#checking session
    session_start();
    if (!isset($_SESSION['user'])) {
        header('Location: index.php');
        exit();
    }

    #checking for post request
    if ($_SERVER['REQUEST_METHOD'] === 'POST') { 
        $oNewScore = $_POST['scoreSubmission'];
        $username = $_SESSION['user'];

        #removed username and pw
        $db = new PDO('mysql:dbname=accounts;host=localhost', '', '');

        $rows = $db->query("SELECT * FROM account_info;");

        

        foreach ($rows as $row) {
            
           #checking if user got a new personal highscore.
            if ($row[0] == $username && $oNewScore >= $row[2]) {
                
                
                ?>
                <p><?= $username . $oNewScore; ?></p>
                <?php
                
                #setting new highscore
                $stmt = $db->prepare("UPDATE account_info SET highest_balance = ? WHERE account_id = ?;");
                $stmt->execute([$oNewScore, $username]);
            }
            
        }





    }


    header('Location: index.php');
    exit();


?>