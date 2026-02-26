<?php //this opens the php code section
session_start();

require_once "assets/dbconn.php";
require_once "assets/common.php";

echo "<!DOCTYPE html>";  // desired tag to declare what type of page it is

echo "<html>";  // opening html
echo "<head>";  // opening head

echo "<title>rolsa tech</title>";  // creating title
echo "<link rel='stylesheet' type='text/css' href='css\styles.css'>";// getting css formatting for website from external

echo "</head>";
echo "<body>"; // opening body


echo "<div class ='container'>"; // class container to give all items a default to reduce need for styling later
require_once "assets/topbar.php"; // presenting header
require_once "assets/nav.php";// presenting navigation bar

echo "<div class ='content'>"; // class context to give all items that give information an overall css to reduce need for styling later and standardise formatting
echo "<br>";
echo "<br>";
echo "<form method='post' action=''>";
echo "<input type= 'text' name ='username' placeholder='username'>";
echo "<br>";
echo "<input type= 'password' name ='password' placeholder='password'>";
echo "<br>";
echo "<input type= 'submit' value='register' id='submit'>";
echo "</form>";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    try {
        $result = check_password_strength($_POST['password']);

        echo "<div class='{$result['level']}'>";
        echo "Strength: {$result['strength']}/9";
        echo "</div>";

        foreach ($result['messages'] as $message) {
            echo "<div class='bad'>$message</div>";
        }
        if ($result["strength"] >= 7){
            new_user(dbconnect_insert(), $_POST);
            $_SESSION["usermessage"]="SUCCESS: user created!";
            //auditor(dbconnect_insert(),getnewuserid(dbconnect_select(),$_POST["username"]),"reg","created new user ");
            echo user_message();
        }else{
            $_SESSION["usermessage"]="Failed: password must be a strength of at least 7";
            echo user_message();
        }
        unset($_SESSION["strength"]); // unsets variable

    } catch (Exception $e){

        $_SESSION["usermessage"]="ERROR: Could not create user: ".$e->getMessage();
        throw $e;
    }

}

echo "</div>";

echo "</div>";

echo "</body>";

echo "</html>";
?>
