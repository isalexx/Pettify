<?php require('header.php'); ?>


    <?php

    //connect to DB
    require('connect.php');

    //set up the query
    $sql = "SELECT * FROM pets";

    //prepare the query
    $statement = $db -> prepare($sql);

    //execute the query
    $statement -> execute();

    //This is used to store results.
    $records = $statement -> fetchAll();

    //Echo out top of table
    echo "<table class='table table-striped'><tboby>";
    
    //here i make the text above the variables to show what they are.
    echo 
        "<tr>
        
        <td>"
        . '<b> Name </b>' . "</td><td>"
        . '<b> Type </b>' . "</td><td>"
        . '<b> Age (Y) </b>' . "</td><td>"
        . '<b> Gender </b>' . "</td><td>"
        . '<b> Colour </b>' . "</td><td>"
        . '' . "</td><td>
        </tr>";

    foreach($records as $record)
    {
        echo 
        "<tr>
        
        <td>"
        . $record['name']. "</td><td>"
        . $record['type'] . "</td><td>"
        . $record['age'] . "</td><td>"
        . $record['gender'] . "</td><td>"
        . $record['colour'] . "</td><td>
        
        <a href='delete.php? id=" . $record['pet_id'] . "'> Delete Pet </a> </td><td>
        
        <a href='index.php? id=" . $record['pet_id'] . "'> Edit Pet </a> </td>

        </tr>";

    }

    echo "</tbody></table>";

    //Close the connection
    $statement -> closeCursor();

    
    ?>

<?php require('footer.php'); ?>