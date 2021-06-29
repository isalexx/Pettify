<?php
// If they're not logged in, redirect them

session_start();
if (!$_SESSION['user'])
{
    header("Location: account.php");
    exit();
}

// Logging out means just destroying the session variable 'user'
unset($_SESSION['user']);

// Then redirect back to login page.

header("Location: ./login.php");
exit();
