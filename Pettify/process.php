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

    if ($age === false)
    {
        // This is the error message if the age is not an int.
        echo '<p> Please use a numeric value for the age. </p>';
        echo '<a href="index.php" class="btn btn-primary"> Back to home </a>';
        echo '<p></p>';
        $ok = false;
    }

    else if ($gender != 'M' && $gender != 'F')
    {
        // This is the error message if the gender is not M or F.
        echo '<p> Please make sure the gender is either male (M) or female (F). </p>';
        echo '<a href="index.php" class="btn btn-primary"> Back to home </a>';
        echo '<p></p>';
        $ok = false;
    }

    else if (!(strlen($name) > 1) || !(strlen($type) > 1) || !(strlen($colour) > 1))
    {
        // This is the error message if the name, type, or colour of the animal is only 1 letter or less.
        echo '<p> Please make sure the name, type, and colour of the animals are valid. Must be more then one letter in length. </p>';
        echo '<a href="index.php" class="btn btn-primary"> Back to home </a>';
        echo '<p></p>';
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

            echo '<p> Success, your pet is in! </p>';
            echo "<a href='view.php'> View All Pets </a>";

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