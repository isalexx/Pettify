<?php require('header.php'); ?>
    <?php

    error_reporting(0);
    ob_start();

    //Assigning variables from the input form. We also sanitize them.
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $type = filter_input(INPUT_POST, 'type', FILTER_SANITIZE_STRING);
    $age = filter_input(INPUT_POST, 'age', FILTER_SANITIZE_NUMBER_INT);
    $gender = filter_input(INPUT_POST, 'gender', FILTER_SANITIZE_STRING);
    $colour = filter_input(INPUT_POST, 'colour', FILTER_SANITIZE_STRING);
    $id = null;
    $id = filter_input(INPUT_POST, 'pet_id');


    //Normalization
    $name = ucfirst(strtolower($name));
    $gender = ucfirst(strtolower($gender));
    $colour = ucfirst(strtolower($colour));

    //Set up a flag variable for debugging.
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

    //Server side validation for name.
    if (!(strlen($name) >= 2 && strlen($name) <= 25))
    {
        array_push($errors, "Please make sure the name is between 2 and 25 characters in length.");
        $ok = false;
    }

    //Server side validation for type.
    if (!(strlen($type) >= 2 && strlen($type) <= 25))
    {
        array_push($errors, "Please make sure the type is between 2 and 25 characters in length.");
        $ok = false;
    }

    if ($type === "None")
    {
        array_push($errors, "Please select a pet type from the selection given.");
        $ok = false;
    }

    //Server side validation for the age.
    if (!($age >= 0 && age <= 99))
    {
        // This is the error message if the age is not an int.
        array_push($errors, "Please enter the pet's age as a numeric value that is between 0 and 99.");
        $ok = false;
    }

    //Server side validation for gender.
    if ($gender != 'M' && $gender != 'F')
    {
        // This is the error message if the gender is not M or F.
        array_push($errors, "Please make sure the gender is either male (M) or female (F).");
        $ok = false;
    }

    //Server side validation for colour.
    if (!(strlen($colour) >= 2 && strlen($type) <= 25))
    {
        array_push($errors, "Please make sure the colour is between 2 and 25 characters in length.");
        $ok = false;
    }

    if ($ok === true)
    {
        try
        {
            //Connect to the database.
            require('connect.php');

            //Checking if the ID is there or not, basically if we are in edit mode.
            if(!empty($id)) 
            {
                //If we are, we update.
                $sql = "UPDATE pets 
                SET name = :name, type = :type, age = :age, gender = :gender, colour = :colour 
                WHERE pet_id = :pet_id;"; 
            }
            else 
            {
                //If we are not, we do not update.
                $sql = "INSERT INTO pets (name, type, age, gender, colour) 
                VALUES (:name, :type, :age, :gender, :colour);";
            }

            //call the prepared method of the PDO object
            $statement = $db -> prepare($sql);

            // bind parameters using the bindParam method of the PDO statement object.
            $statement -> bindParam(':name', $name);
            $statement -> bindParam(':type', $type);
            $statement -> bindParam(':age', $age);
            $statement -> bindParam(':gender', $gender);
            $statement -> bindParam(':colour', $colour);


            if(!empty($id)) 
            {
                $statement->bindParam(':pet_id', $id); 
            } 

            //executeing the query
            $statement -> execute();

            echo "<div class='divider'></div>";
            echo "<section class='main-form-view'>";
            echo "<div>";
            echo "<h5 style='color: #009c22';> Success! </h5>";
            echo '<a style="font-size: 20px; width: 20%; margin: auto;" href="view.php" class="btn btn-outline-primary"> View All Pets </a>';
            echo "<div class='divider'></div>";
            echo "</div>";
            echo "</section>";


            //closing DB Connection.
            $statement -> closeCursor();
        }

        catch(PDOException $e)
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
        echo '<a style="font-size: 20px; width: 20%; margin: auto;" href="index.php" class="btn btn-outline-primary"> Back to Home </a>';
        echo "<div class='divider'></div>";
        echo "</div>";
        echo "</section>";
    }

    ob_flush();
    ?>

<?php require('footer.php'); ?>