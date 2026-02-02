<?php
echo "<div class='navi'>";//declares class
echo "<nav>";// start nav

echo "<ul>";//declares unordered list
if (isset($_SESSION["user"])) {// checks if a user is logged in to reduce attack vectors

    echo "<li><a href='index.php'>MAIN</a></li>";  // link to different page
    echo "<li><a href='view_bookings.php'>BOOKINGS</a></li>";  // link to different page
    echo "<li><a href='book_booking.php'>BOOK BOOKING</a></li>";  // link to different page
    echo "<li><a href='logout.php'>LOGOUT</a></li>";  // link to different page

}
elseif (isset($_SESSION["staff"])) {// checks if a staff member is logged in to reduce attack vectors

    echo "<li><a href='index.php'>MAIN</a></li>";  // link to different page
    echo "<li><a href='staff_view_bookings.php'>VIEW BOOKINGS</a></li>";  // link to different page
    echo "<li><a href='logout.php'>LOGOUT</a></li>";  // link to different page

}
else { // if no user types are logged in it will execute the following

    echo "<li><a href='index.php'>MAIN</a></li>";  // link to different page
    echo "<li><a href='login.php'>USER LOGIN</a></li>";  // link to different page
    echo "<li><a href='login_staff.php'>STAFF LOGIN</a></li>";  // link to different page
    echo "<li><a href='register_user.php'>REGISTER</a></li>";  // link to different page

}
echo "</ul>";//closes list

echo "</nav>";
echo "</div>";
?>
