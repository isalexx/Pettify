<!--This file deletes a pet data entry from the database.-->

<?php

ob_start(); 

$pet_id = filter_input(INPUT_GET,'id');
try 
{
    //connect to db 
    require('connect.php'); 

    //create the query where we delete.
    $sql = "DELETE FROM pets 
    WHERE pet_id = :pet_id;"; 

    //prepare the query
    $statement = $db -> prepare($sql); 

    //bind the parameters
    $statement -> bindParam(':pet_id', $pet_id); 

    //execute the query
    $statement -> execute(); 

    //close the connection 
    $statement->closeCursor(); 
    header('location:view.php'); 
}

catch(PDOException $e) 
{
    header('location:error.php'); 
}

ob_flush();
?>