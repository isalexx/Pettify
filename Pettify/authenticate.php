<?php

require("header.php");
require("config.php");


// Connect to the database
require('connect.php');

// Bind the value to the placeholder (incidentally this will also sanitize the value)
$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
$password = filter_input(INPUT_POST, 'password');

$email = strtolower($email);

$ok = true;
$errors = [];
$auth = false;

// Validate the recaptcha
if (!empty($_POST['recaptcha_response']))
{
    $secret = SECRETKEY;
    $verify_response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret={$secret}&response={$_POST['recaptcha_response']}");

    $response_data = json_decode($verify_response);
    if (!$response_data -> success)
    {
        $errors[] = "Google reCaptcha failed: " . ($response_data->{'error-codes'})[0];
        $ok = false;
    }
}

$required_fields = ['email', 'password'];

foreach ($required_fields as $field)
{
    if (empty($$field))
    {
        $errors[] = "Please fill in the {$field} field.";
        $ok = false;
    }
    else
    {
        if ($field === 'password') continue;
        $$field = filter_var($$field, FILTER_SANITIZE_EMAIL);
    }
}

if ($ok === true)
{
    if (!(strlen($email) >= 2 && strlen($email) <= 35))
    {
        array_push($errors, "Please make sure the email is between 2 and 35 characters in length.");
        $ok = false;
    }

    if (!(strlen($password) >= 2 && strlen($password) <= 100))
    {
        {
            array_push($errors, "Please make sure the password is between 2 and 100 characters long.");
            $ok = false;
        }
    }
}

if ($ok === true)
{
    // Create our SQL statement with an email placeholder
    $sql = "SELECT * FROM pettify_users WHERE email = :email;";

    // Prepare the SQL query
    $statement = $db -> prepare($sql);

    // Here I bind the email to the email value.
    $statement -> bindParam(":email", $email, PDO::PARAM_STR);

    // Execute the mysql statement
    $statement -> execute();

    // Check for errors in the query
    $user = $statement -> fetch(PDO::FETCH_ASSOC);

    session_start();
    $_SESSION['user'] = $user;

    // Checking if the user exists.
    if (!$user)
        $auth = false;
    else
        $auth = password_verify($password, $user['password']);

    if (!$auth)
    {
        array_push($errors, "Your email or password is incorrect.");
        $_SESSION['form_values'] = $_POST;

        $_SESSION['user'] = $user;
    }
}

if (count($errors) > 0)
{
    echo "<div class='divider'></div>";
    echo "<section class='main-form-view'>";
    echo "<div>";
    foreach ($errors as $error)
    {
        echo "<h5 style='color: #af4644';>{$error}</h5>";
    }
    echo '<a style="font-size: 20px; width: 20%; margin: auto;" href="login.php" class="btn btn-outline-primary"> Back to Log In Page </a>';
    echo "<div class='divider'></div>";
    echo "</div>";
    echo "</section>";
}

else
{
    header('Location: profile.php');
    exit();
}


require("footer.php");