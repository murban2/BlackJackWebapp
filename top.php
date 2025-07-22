<!-- Created by Matthew Urban
		This file handles the banner at the top of the screen.
	-->


<html>


    <head>
        <title>BlackJack</title>
        <link rel="stylesheet" href="blackjack.css">
    </head>

    <body>
        <?php
            #checking for session and setting banner
            session_start();
            if (isset($_SESSION['user'])) {
                ?>
                <div class="banner">
                    <div class="leftBanner">
                    <a href="index.php"><img class="logo" src="logo.png" alt="Card Logo"></a>
                        <span class='head'>Blackjack</span>
                    </div>

                    <div class="rightBanner">
                        
                        <a href="logout.php"><span id="log">Logout</span></a>
                    </div>
                </div>
            <?php
            } else {
                ?>

                <div class="banner">
                    <div class="leftBanner">
                        <a href="index.php"><img class="logo" src="logo.png" alt="Card Logo"></a>
                        <span class='head' id="head">Blackjack</span>
                    </div>

                    <div class="rightBanner">
                        <a href="login.php"><span id="log">Login</span></a>
                    </div>
                </div>
                
                <?php
            }
        ?>
    </body>





</html>