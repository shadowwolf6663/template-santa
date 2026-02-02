<?php //this opens the php code section
session_start(); // start session

require_once "assets/dbconn.php"; // connects to another file
require_once "assets/common.php"; // connects to another file

echo "<!DOCTYPE html>";  // desired tag to declare what type of page it is

echo "<html>";  // opening html
    echo "<head>";  // opening head

        echo "<title>page title</title>";  // creating title
        echo "<link rel='stylesheet' type='text/css' href='css\styles.css'>";// getting css formatting for website from external

    echo "</head>";
    echo "<body>"; // opening body


        echo "<div class ='container'>"; // class container to give all items a default to reduce need for styling later
            require_once "assets/topbar.php"; // presenting header
            require_once "assets/nav.php";// presenting navigation bar

            echo "<div class ='content'>"; // class context to give all items that give information an overall css to reduce need for styling later and standardise formatting

                if (!isset($_SESSION["user"]  )and(!isset($_SESSION["staff"]) )) {// checks if a user is logged in to reduce attack vectors

                    $_SESSION["usermessage"] = "You must be logged in to access this page!";
                    header("Location: index.php");
                    exit;

                }
                elseif ($_SERVER["REQUEST_METHOD"] === "POST") {// checks request method

                        $tmp=$_POST["bookingdate"]. ' '.$_POST["bookingtime"];
                        $epoch = strtotime($tmp);
                        echo $epoch." seconds";
                        echo "<br>";
                        echo "current: ".time()." seconds";
                        if(booking_update(dbconnect_update(),$_SESSION['bookingid'], $epoch)){
                            $_SESSION["usermessage"] = "changed booking";// assigning message
                            if (isset($_SESSION["user"])){

                                //auditor(dbconnect_insert(),$_SESSION['userid'],"upd","changed booking");
                                header("Location: view_bookings.php");
                                exit;

                            }
                        }else{

                            $_SESSION["usermessage"] = "failed to create booking";// assigning message

                        }
                        echo user_message();// echo message to screen
                }

                $booking=booking_getter(dbconnect_select());//should have a try except around this isnce it calls a subroutine that may fail
                echo "<form method='post' action=''>";// opens a form

                    $staffs=staff_getter(dbconnect_select());
                    $booking_time=date('h:i:s',$booking[0]["date_of_booking"]);
                    $booking_date=date('Y-m-d',$booking[0]["date_of_booking"]);

                    echo "<label for ='bookingtime'>booking time: </labelfor></label>";
                    echo "<input type= 'time' name ='bookingtime' value = '".$booking_time. "'>";// creates input box
                    echo "<br>";// breaks to next line
                    echo "<label for ='bookingdate'>booking time: </labelfor></label>";
                    echo "<input type= 'date' name ='bookingdate' value = '".$booking_date. "'>";// creates input box
                    echo "<br>";// breaks to next line

                    if (isset($_SESSION["user"])) {

                        echo "<select name='staff'>";

                            foreach ($staffs as $staff) {

                                if ($booking[0]['staffid'] == $staff['staffid']) {
                                    $selected = 'selected';

                                } else {
                                    echo $booking[0]['staffid'];

                                    $selected = '';

                                }
                                echo "<option  value =" . $staff['staffid'] . ">" . $selected . " ". $staff['staff_name'] ."</option>";

                            }
                        echo "</select>";
                    }else{

                        echo "<input type='hidden' name='staff' value='".$_SESSION['staffid']."'>";

                    }

                    echo "<input type= 'submit' value='book appointment' id='submit'>";// creates input box

                echo "</form>";


            echo "</div>";

        echo "</div>";

    echo "</body>";

echo "</html>";
?>
