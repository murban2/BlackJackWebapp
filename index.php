<!-- Created by Matthew Urban
		This file is the homepage for the project.
	-->

<?php include("top.php"); ?>

<?php 

    #checking for request 
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = $_POST['username'];
        $password = $_POST['password'];


        try {
            #removed username and pw
            $db = new PDO('mysql:dbname=accounts;host=localhost', '', '');

            $rows = $db->query("SELECT * FROM account_info");
            

            

            #starting session
            foreach ($rows as $row) {
                $un = $row[0];
                $pw = $row[1];
                if ($un === $username && $pw === $password) {
                    $_SESSION['user'] = $username;

                    header('Location: index.php');
                    exit();
                }
            }
        } catch (PDOException $ex) {
            print($ex);
        }

    }


?>



<html>
    

    
    <body>
        <br />
        <br />
        <br />
        <br />

        <div class="outer">

            <div class="inner">
        
                <h1>Welcome to the Home Page!</h1>


        <?php 
            if (!isset($_SESSION['user'])) {
                ?>

                <p>Please login to your account.</p>
                <?php
            } else {
                ?>
                    <p>Rules: </br >
                           <span class='rules'>1. Dealer draws until they reach 17 or more.</span> </br >
                           <span class='rules'>2. Dealer and player can only have up to 5 cards at one time.</span> </br >
                           <span class='rules'>3. Return on a win is 2x the bet. Return on a draw is 1x the bet.</span> </br >
                           <span class='rules'>4. There is no double down option.</span> </br >
                           <span class='rules'>5. You start a run with 100 currency.</span> </br >
                           <span class='rules'>6. You must click 'quit' for a new high score to be saved. </span> </br >
                           
                    </p>

                    <p id="returningText">
                        To proceed, please click continue. 
                    </p>
                <?php

            }
        ?>
        
        <br /> 

        <?php

        if (isset($_SESSION['user'])) {

            ?>
            <div class="continueButton">
                
                <a href="blackjack.php">
                    <button>Continue</button>
                </a>
        
            </div>
        <?php



        }
       
        
        ?>
            </div>
        </div>

    </body>
</html>

