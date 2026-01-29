<?php //this opens the php code section
session_start(); // start session

require_once "assets/dbconn.php"; // connects to another file
require_once "assets/common.php"; // connects to another file

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

if (!isset($_SESSION["user"])) {// checks if a user is logged in to reduce attack vectors
    $_SESSION["usermessage"] = "You must be logged in to access this page!";
    header("Location: index.php");
    exit;
}elseif($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["bookingdelete"])){

            if (cancel_booking(dbconnect_delete(),$_POST["bookingid"])){
                $_SESSION["usermessage"] = "booking has been deleted successfully!.";
                auditor(dbconnect_insert(),$_SESSION['userid'],"del","deleted booking");
            }else{
                $_SESSION["usermessage"] = "Unable to delete booking!.";
            }

    }elseif(isset($_POST["bookingchange"])){

            $booking=booking_fetch(dbconnect_select(),$_POST["bookingid"]);
            if ($booking){
                $_SESSION["bookingid"]=$_POST["bookingid"];
                header("location: booking_change.php");
                exit;
            }

    }
}
else  {// checks request method
    echo user_message();// echo message to screen

        $bookings=booking_getter(dbconnect_select());
        if (!$bookings){
            echo "No bookings found!";
        }else {
            echo "<table>";
            echo "<tr>";
            echo "<th>user</th>";
            echo "<th>booking date</th>";
            echo "<th>staff</th>";
            echo "<th>change/delete</th>";
            echo "</tr>";
            foreach ($bookings as $booking) {
                echo "<form method='post' action=''>";
                echo "<tr>";
                echo "<td>".$booking['userid']."</td>";
                echo "<td>date: ".date('M d, Y @ h:i A',$booking['date_of_booking'])." </td>";
                echo "<td>with: ".$booking['staff_name']."</td>";
                echo "<td><input type='hidden' name='bookingid' value='".$booking['bookingid']."'>
                    <input type='submit' name='bookingdelete' value='delete booking'>
                    <input type='submit' name='bookingchange' value='change booking'></td>";
                echo "</tr>";
                echo "</form>";

            }
            echo "</table>";

        }
}


echo "</div>";

echo "</div>";

echo "</body>";

echo "</html>";
?>
