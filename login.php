<!-- Created by Matthew Urban
		This file gets login input from the user.
	-->
        
<?php include("top.php"); ?>

<?php


#checking for session
if (isset($_SESSION['user'])) {
    header('Location: index.php');
    exit();
}


# checking for request
if ($_SERVER['REQUEST_METHOD'] === 'POST') { 
    $ousername = $_POST['username'];
    $opassword = $_POST['password'];

    

    #accessing db
    try {

        #removed username and pw
        $db = new PDO('mysql:dbname=accounts;host=localhost', '', '');
        

        $username = $db->quote($ousername);
        $password = $db->quote($opassword);
        
        #inserting account data
        $statement = $db->prepare("INSERT INTO account_info (account_id, account_pw, highest_balance) 
        VALUES (?,?,?)");
        $connectionSuccess = "inserted data";

        $statement->execute([$ousername, $opassword, 100]);

        $rows = $db->query("SELECT * FROM account_info");

        $data = $rows->fetchAll();

        
        ?>

            <p>Account created!</p>
        <?php


    } catch (PDOException $ex) {
        print("Something went wrong." . $ex);
    
    }
    
}



?>

<html>

    
    <body>
        <br />
        <br />
        <br />
        <br />

        <form action="index.php" method="post">
            <fieldset>
                <p>
                    Username:
                    <input type="text" name="username"  required='required'/>
                    <br />
                    <br />
                    Password: 
                    <input type="password" name="password" required='required'/>
                </p>

                <div class="submitButtons">
                    <input type="submit" value="Login">
                </div>

                <p id="create">
                    <a href="createAccount.php">
                    Click here to create a new account!
                    </a>
                </p>
           
            </fieldset>
        </form>
        

        
        
        
        

    </body>
</html>


