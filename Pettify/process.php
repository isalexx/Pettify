<?php require('header.php'); ?>
    <?php

    ob_start();

    //Assigning variables from the input form.
    $name = filter_input(INPUT_POST, 'name');
    $type = filter_input(INPUT_POST, 'type');
    $age = filter_input(INPUT_POST, 'age', FILTER_VALIDATE_INT);
    $gender = filter_input(INPUT_POST, 'gender');
    $colour = filter_input(INPUT_POST, 'colour');


    //Making the strings look nice by making 1st letter uppercase. For this we first make the whole string a lowercase, and then make it upper.
    $name = ucfirst(strtolower($name));
    $type = ucfirst(strtolower($type));
    $gender = ucfirst(strtolower($gender));
    $colour = ucfirst(strtolower($colour));


    //iniaitalize the ID
    $id = null;
    $id = filter_input(INPUT_POST, 'pet_id'); 

    //Set up a flag variable for debugging.
    $ok = true;

    if (!(strlen($name) > 1) || !(strlen($type) > 1) || !(strlen($colour) > 1))
    {
        // This is the error message if the name, type, or colour of the animal is only 1 letter or less.
        echo "<div class='divider'></div>";
        echo "<section class='main-form-view'>";
        echo "<div>";
        echo "<h5 style='color: #af4644';> Please make sure the name, type, and colour are all at least 2 characters in length. </h5>";
        echo '<a style="font-size: 20px; width: 20%; margin: auto;" href="index.php" class="btn btn-outline-primary"> Back to Home </a>';
        echo "<div class='divider'></div>";
        echo "</div>";
        echo "</section>";
        $ok = false;
    }

    else if ($age === false)
    {
        // This is the error message if the age is not an int.
        echo "<div class='divider'></div>";
        echo "<section class='main-form-view'>";
        echo "<div>";
        echo "<h5 style='color: #af4644';> Please enter the pet's age as a number. </h5>";
        echo '<a style="font-size: 20px; width: 20%; margin: auto;" href="index.php" class="btn btn-outline-primary"> Back to Home </a>';
        echo "<div class='divider'></div>";
        echo "</div>";
        echo "</section>";
        $ok = false;
    }

    else if ($gender != 'M' && $gender != 'F')
    {
        // This is the error message if the gender is not M or F.
        echo "<div class='divider'></div>";
        echo "<section class='main-form-view'>";
        echo "<div>";
        echo "<h5 style='color: #af4644';> Please make sure the gender is either male (M) or female (F). </h5>";
        echo '<a style="font-size: 20px; width: 20%; margin: auto;" href="index.php" class="btn btn-outline-primary"> Back to Home </a>';
        echo "<div class='divider'></div>";
        echo "</div>";
        echo "</section>";
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

    ob_flush();
    ?>

<?php require('footer.php'); ?>