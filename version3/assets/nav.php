<?php
echo "<div class='navi'>";//declares class
echo "<nav>";// start nav

echo "<ul>";//declares unordered list
if (isset($_SESSION["user"])) {// checks if a user is logged in to reduce attack vectors

    echo "<li><a href='index.php'>MAIN</a></li>";  // link to different page
    echo "<li><a href='view_installations.php'>INSTALLATIONS</a></li>";  // link to different page
    echo "<li><a href='view_bookings.php'>bookingS</a></li>";  // link to different page
    echo "<li><a href='book_booking.php'>BOOK booking</a></li>";  // link to different page
    echo "<li><a href='logout.php'>LOGOUT</a></li>";  // link to different page

}
elseif (isset($_SESSION["staff"])) {

    echo "<li><a href='index.php'>MAIN</a></li>";  // link to different page
    echo "<li><a href='staff_view_bookings.php'>VIEW bookingS</a></li>";  // link to different page
    echo "<li><a href='logout.php'>LOGOUT</a></li>";  // link to different page

}
else { // if no other conditions are met it will execute the following

    echo "<li><a href='index.php'>MAIN</a></li>";  // link to different page
    echo "<li><a href='login.php'>USER LOGIN</a></li>";  // link to different page
    echo "<li><a href='login_staff.php'>staff LOGIN</a></li>";  // link to different page
    echo "<li><a href='register_user.php'>REGISTER</a></li>";  // link to different page

}
echo "</ul>";//closes list

echo "</nav>";
echo "</div>";
?>
