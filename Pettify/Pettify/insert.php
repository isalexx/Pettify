<!-- This file is used to insert new accounts that the user creates into the database.-->

<?php

require('header.php');

// Including the recaptcha config files.
include_once("config.php");

// Collect our fields, validating them.
$username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
$password = filter_input(INPUT_POST, 'password');
$password_confirmation = filter_input(INPUT_POST, 'password_confirmation');
$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
$email_confirmation = filter_input(INPUT_POST, 'email_confirmation', FILTER_VALIDATE_EMAIL);

$ok = true;
$errors = [];

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



// Validate the necessary fields are not empty
$required_fields = [
    'username',
    'email',
    'email_confirmation',
    'password',
    'password_confirmation'];

//This loop goes through each field and adds an error if it is empty.
foreach ($required_fields as $field)
{
    if (empty($$field))
    {
        $human_field = str_replace("_", " ", $field);
        $errors[] = "You cannot leave the {$human_field} blank.";
        $ok = false;
    }

    else
    {
//        Skip the password fields to not sanitize them.
        if ($field === "password" || $field === "password_confirmation") continue;
        $$field = filter_var($$field, FILTER_SANITIZE_STRING);
    }
}

// Validate the email is in the correct format
if (!$email)
{
    $errors[] = "The email isn't in a valid format.";
    $ok = false;
}

// Validate the email matches the email_confirmation
if ($email !== $email_confirmation)
{
    $errors[] = "The email doesn't match the email confirmation field.";
    $ok = false;
}

// Validate the password matches the password_confirmation
if ($password !== $password_confirmation)
{
    $errors[] = "The password doesn't match the password confirmation field.";
    $ok = false;
}

// Lowercase the email
$email = strtolower($email);

// Hash the password
$password = password_hash($password, PASSWORD_DEFAULT);


//If no errors came up, run the query.
if ($ok === true)
{

    require_once('connect.php');

    $sql = "INSERT INTO pettify_users (username, password, email) 
    VALUES (:username, :password, :email);";

    $statement = $db -> prepare($sql);

    // Sanitize using the binding, as well as attach the values.
    $statement -> bindParam(':username', $username);
    $statement -> bindParam(':password', $password);
    $statement -> bindParam(':email', $email);


// Insert our row
    try
    {
        $statement -> execute();

        echo "<div class='divider'></div>";
        echo "<section class='main-form-view'>";
        echo "<div>";
        echo "<h5 style='color: #009c22';> Success! Your account has been registered You can successfully log in below. </h5>";
        echo '<a style="font-size: 20px; width: 20%; margin: auto;" href="login.php" class="btn btn-outline-primary"> Login Page </a>';
        echo "<div class='divider'></div>";
        echo "</div>";
        echo "</section>";
    }

    catch (PDOException $e)
    {
        header('location:error.php');
    }
}

else
{
    // This is the error message if the gender is not M or F.
    echo "<div class='divider'></div>";
    echo "<section class='main-form-view'>";
    echo "<div>";
    if (count($errors) > 0)
    {
        foreach ($errors as $error)
        {
            echo "<h5 style='color: #af4644';>{$error}</h5>";
        }
    }
    echo '<a style="font-size: 20px; width: 20%; margin: auto;" href="register.php" class="btn btn-outline-primary"> Back to Registration </a>';
    echo "<div class='divider'></div>";
    echo "</div>";
    echo "</section>";
}

require('footer.php');
