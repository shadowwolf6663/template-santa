<?php

function user_message(){  // declaring function

    if(isset($_SESSION["usermessage"])){  // checks condition is met

        $message= '<div id = "message">'.$_SESSION["usermessage"].'</div>';  // gets user message from session
        unset($_SESSION["usermessage"]);  // removes message from session
        return  $message;  // returns value to calling function

    }else{  // if other conditions aren't met

        $message= "";  // sets value to blank
        return $message;  // returns value

    }
}

function new_user($conn, $post)
{  // declaring function

    $sql = "INSERT INTO users(username,password,date_joined) VALUES(?,?,?)";// doing a prepared statement by sending values separately, bound separately
    $stmt = $conn->prepare($sql);  // prepares sql statement with connection to database

    // binding data from form to sql statement parameter making it more secure from a sql injection attack unlikely to hijack my sql statement
    $hpsw=password_hash($post['password'],PASSWORD_DEFAULT);
    $epoch=time(); // getting current time in epoch time
    $stmt->bindparam(1,$post['username']);
    $stmt->bindparam(2,$hpsw);
    $stmt->bindparam(3,$epoch);
    $stmt->execute(); // runs the insert query

    $conn = null;  // voids connection to db for security reason since it no longer needs to be accessed

}

function new_staff($conn, $post)
{  // declaring function

    $sql = "INSERT INTO staffs(username,password,date_joined,staff_name) VALUES(?,?,?,?)";// doing a prepared statement by sending values separately, bound separately
    $stmt = $conn->prepare($sql);  // prepares sql statement with connection to database

    // binding data from form to sql statement parameter making it more secure from a sql injection attack unlikely to hijack my sql statement
    $hpsw=password_hash($post['password'],PASSWORD_DEFAULT);
    $epoch=time(); // getting current time in epoch time
    $stmt->bindparam(1,$post['username']);
    $stmt->bindparam(2,$hpsw);
    $stmt->bindparam(3,$epoch);
    $stmt->bindparam(4,$post['name']);
    $stmt->execute(); // runs the insert query

    $conn = null;  // voids connection to db for security reason since it no longer needs to be accessed

}

function login($conn, $post){  // declaring function

    $sql = "SELECT * FROM users WHERE username=?";  // doing a prepared statement by sending values separately, bound separately
    $stmt = $conn->prepare($sql);  // prepares sql statement with connection to database

    // binding data from form to sql statement parameter making it more secure from a sql injection attack unlikely to hijack my sql statement
    $stmt->bindparam(1, $post["username"]);
    $stmt->execute();  // executes sql query

    $result = $stmt->fetch(PDO::FETCH_ASSOC);  // fetches results from sql query
    $conn = null;    // terminates connection to database

    if($result){  // checks condition is met

        return $result;  // returns value

    }else{  // if other conditions aren't met

        $_SESSION["error"] = "user not found";
        header("Location: login.php");  // redirects to different page
        exit;  // stops further execution

    }

}

function login_staff($conn, $post){  // declaring function

    $sql = "SELECT * FROM staffs WHERE username=?";  // doing a prepared statement by sending values separately, bound separately
    $stmt = $conn->prepare($sql);  // prepares sql statement with connection to database

    // binding data from form to sql statement parameter making it more secure from a sql injection attack unlikely to hijack my sql statement
    $stmt->bindparam(1, $post["username"]);
    $stmt->execute();  // executes sql query

    $result = $stmt->fetch(PDO::FETCH_ASSOC);  // fetches results from sql query
    $conn = null;    // terminates connection to database

    if($result){  // checks condition is met

        return $result;  // returns value

    }else{  // if other conditions aren't met

        $_SESSION["error"] = "user not found";
        header("Location: login.php");  // redirects to different page
        exit;  // stops further execution

    }

}

function staff_getter($conn){  // declaring function

    $sql = "SELECT * FROM staffs";  // doing a prepared statement by sending values separately, bound separately
    $stmt = $conn->prepare($sql);  // prepares sql statement with connection to database
    $stmt->execute();  // executes sql query

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);  // fetches results from sql query
    $conn=null;  // voids connection to db for security reason since it no longer needs to be accessed
    return $result;  // returns value

}

function create_booking($conn,$epoch){  // declaring function

    $sql="INSERT INTO bookings (userid,staffid,date_of_booking,date_booked) VALUES (?,?,?,?)";  // doing a prepared statement by sending values separately, bound separately
    $stmt=$conn->prepare($sql);  // prepares sql statement with connection to database
    $epoch_current=time(); // getting current time in epoch time

    // binding data from form to sql statement parameter making it more secure from a sql injection attack unlikely to hijack my sql statement
    $stmt->bindparam(1,$_SESSION['userid']);
    $stmt->bindparam(2,$_POST['staff']);
    $stmt->bindparam(3,$epoch);
    $stmt->bindparam(4,$epoch_current);
    $stmt->execute();  // executes sql query

    $conn=null;  // voids connection to db for security reason since it no longer needs to be accessed
    return True;  // returns value

}

function booking_fetch($conn,$bookingid){  // declaring function

    $sql="SELECT * FROM bookings WHERE bookingid=?";  // doing a prepared statement by sending values separately, bound separately
    $stmt=$conn->prepare($sql);  // prepares sql statement with connection to database

    // binding data from form to sql statement parameter making it more secure from a sql injection attack unlikely to hijack my sql statement
    $stmt->bindparam(1,$bookingid);
    $stmt->execute();

    $results=$stmt->fetch(PDO::FETCH_ASSOC);  // fetches results from sql query
    $conn=null;  // voids connection to db for security reason since it no longer needs to be accessed
    return $results;  // returns value

}

function cancel_booking($conn,$bookingid){  // declaring function

    $sql="DELETE FROM bookings WHERE bookingid=?";  // doing a prepared statement by sending values separately, bound separately
    $stmt=$conn->prepare($sql);  // prepares sql statement with connection to database

    // binding data from form to sql statement parameter making it more secure from a sql injection attack unlikely to hijack my sql statement
    $stmt->bindparam(1,$bookingid);
    $stmt->execute();  // executes sql query

    $conn=null;  // voids connection to db for security reason since it no longer needs to be accessed
    return True;  // returns value

}


function booking_getter($conn){  // declaring function

    $sql = "SELECT c.bookingid,c.date_of_booking,co.staff_name,c.staffid,c.userid FROM bookings c JOIN staffs co on c.staffid=co.staffid where c.userid=? order by c.date_of_booking ASC";  // doing a prepared statement by sending values separately, bound separately
    $stmt = $conn->prepare($sql);  // prepares sql statement with connection to database

    // binding data from form to sql statement parameter making it more secure from a sql injection attack unlikely to hijack my sql statement
    $stmt->bindparam(1,$_SESSION['userid']);
    $stmt->execute();  // executes sql query

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);  // fetches results from sql query
    $conn=null;  // voids connection to db for security reason since it no longer needs to be accessed
    return $result;  // returns value

}

function booking_getter_staff($conn){  // declaring function

    $sql = "SELECT c.bookingid,c.date_of_booking,u.username,c.staffid,c.userid FROM bookings c JOIN users u on c.userid=u.userid where c.staffid=? order by c.date_of_booking ASC";  // doing a prepared statement by sending values separately, bound separately
    $stmt = $conn->prepare($sql);  // prepares sql statement with connection to database

    // binding data from form to sql statement parameter making it more secure from a sql injection attack unlikely to hijack my sql statement
    $stmt->bindparam(1,$_SESSION['staffid']);
    $stmt->execute();  // executes sql query

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);  // fetches results from sql query
    $conn=null;  // voids connection to db for security reason since it no longer needs to be accessed
    return $result;  // returns value

}

function booking_update($conn,$bookingid,$bookingtime){  // declaring function

    $sql="UPDATE bookings SET staffid=?,date_of_booking=? WHERE bookingid=?";  // doing a prepared statement by sending values separately, bound separately
    $stmt=$conn->prepare($sql);  // prepares sql statement with connection to database

    // binding data from form to sql statement parameter making it more secure from a sql injection attack unlikely to hijack my sql statement
    $stmt->bindParam(1,$_POST["staff"]);
    $stmt->bindParam(2,$bookingtime);
    $stmt->bindParam(3,$bookingid);
    $stmt->execute();  // executes sql query

    $conn=null;  // voids connection to db for security reason since it no longer needs to be accessed
    return True;  // returns value

}

function auditor($conn, $userid,$code,$long){  // declaring function

    $sql = "INSERT INTO user_audit(date,userid,code,longdesc) VALUES(?,?,?,?)";  // doing a prepared statement by sending values separately, bound separately
    $stmt = $conn->prepare($sql);  // prepares sql statement with connection to database

    $date = time();  // sets a value for the sql query

    // binding data from form to sql statement parameter making it more secure from a sql injection attack unlikely to hijack my sql statement
    $stmt->bindparam(1, $date);
    $stmt->bindparam(2, $userid);
    $stmt->bindparam(3, $code);
    $stmt->bindparam(4, $long);
    $stmt->execute();  // executes sql query

    $conn = null;  // terminates connection to database
    return true;  // returns value

}

function staffauditor($conn, $staffid,$code,$long){  // declaring function

    $sql = "INSERT INTO staff_audit(date,staffid,code,longdesc) VALUES(?,?,?,?)";  // doing a prepared statement by sending values separately, bound separately
    $stmt = $conn->prepare($sql);  // prepares sql statement with connection to database

    $date = time();  // sets a value for the sql query

    // binding data from form to sql statement parameter making it more secure from a sql injection attack unlikely to hijack my sql statement
    $stmt->bindparam(1, $date);
    $stmt->bindparam(2, $staffid);
    $stmt->bindparam(3, $code);
    $stmt->bindparam(4, $long);
    $stmt->execute();  // executes sql query

    $conn = null;  // terminates connection to database
    return true;  // returns value

}

function getnewuserid($conn,$username){  // declaring function

    $sql = "SELECT userid FROM users WHERE username=?";  // doing a prepared statement by sending values separately, bound separately
    $stmt = $conn->prepare($sql);  // prepares sql statement with connection to database

    // binding data from form to sql statement parameter making it more secure from a sql injection attack unlikely to hijack my sql statement
    $stmt->bindparam(1, $username);
    $stmt->execute();  // executes sql query

    $result = $stmt->fetch(PDO::FETCH_ASSOC);  // fetches results from sql query
    $conn = null;  // voids connection to db for security reason since it no longer needs to be accessed
    return $result["userid"];  // returns value

}

function getnewstaffid($conn,$username){  // declaring function

    $sql = "SELECT staffid FROM staffs WHERE username=?";  // doing a prepared statement by sending values separately, bound separately
    $stmt = $conn->prepare($sql);  // prepares sql statement with connection to database

    // binding data from form to sql statement parameter making it more secure from a sql injection attack unlikely to hijack my sql statement
    $stmt->bindparam(1, $username);
    $stmt->execute();  // executes sql query

    $result = $stmt->fetch(PDO::FETCH_ASSOC);  // fetches results from sql query
    $conn = null;  // voids connection to db for security reason since it no longer needs to be accessed
    return $result["staffid"];  // returns value

}

function check_password_strength($password)
{

    $strength = 0;
    $messages = [];

    if (empty($password)) {

        return [

            "strength" => 0,
            "level" => "bad",
            "messages" => ["Password is empty"]

        ];

    }

    // Length check
    if (strlen($password) >= 8) {

        $strength++;

    } else {

        $messages[] = "Must be at least 8 characters";

    }

    // Contains number
    if (preg_match('/[0-9]/', $password)) {

        $strength++;

    } else {

        $messages[] = "Must contain a number";

    }

    // Contains uppercase
    if (preg_match('/[A-Z]/', $password)) {

        $strength++;

    } else {

        $messages[] = "Must contain uppercase letter";

    }

    // Contains lowercase
    if (preg_match('/[a-z]/', $password)) {

        $strength++;

    } else {

        $messages[] = "Must contain lowercase letter";

    }

    // Contains special character
    if (preg_match('/[^a-zA-Z0-9_]/', $password)) {

        $strength++;

    } else {

        $messages[] = "Must contain special character";

    }

    // First character not special
    if (preg_match('/[a-zA-Z0-9_]/', $password[0])) {

        $strength++;

    } else {

        $messages[] = "First character cannot be special";

    }

    // Last character not special
    if (preg_match('/[a-zA-Z0-9_]/', $password[strlen($password) - 1])) {

        $strength++;

    } else {

        $messages[] = "Last character cannot be special";

    }

    // First character not number
    if (!preg_match('/[0-9]/', $password[0])) {

        $strength++;

    } else {

        $messages[] = "First character cannot be a number";

    }

    // Common password check
    $common_words = ["password", "qwerty"];

    foreach ($common_words as $word) {

        if (stripos($password, $word) !== false) {

            $messages[] = "Contains common password : $word";
            break;

        }

    }

    if (count(array_filter($common_words, fn($w) => stripos($password, $w) !== false)) === 0) {

        $strength++;

    }

    // Strength level
    if ($strength >= 8) {

        $level = "good";

    } elseif ($strength >= 4) {

        $level = "medium";

    } else {

        $level = "bad";

    }

    return [

        "strength" => $strength,
        "level" => $level,
        "messages" => $messages

    ];
}
?>