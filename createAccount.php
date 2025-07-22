
<!-- Created by Matthew Urban
		This file reviews user input, and submits the data to login.php.
	-->

<?php include("top.php"); ?>

<?php 
session_start(); 

if (isset($_SESSION['user'])) {
    header('Location: index.php');
    exit();
}
?>


<html>

    
    <body>
        <br />
        <br />
        <br />
        <br />

        <form action="login.php" method="post">
            <fieldset>
            <p>
                
                Username:
                <input type="text" name="username" required="required"/>
                <br />
                <br />
                Password: 
                <input type="password" name="password" required="required"/>
            </p>

            <div class="submitButtons">
            <input type="button" value="Cancel"  onclick="window.location.href='login.php';">
            <input type="submit" value="Create">
            </div>
         
        
            </fieldset>
        </form>
        

        
        
        
        

    </body>
</html>


