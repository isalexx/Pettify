<?php require('header.php'); ?>

    <div class="divider"></div>
    <section class="image">
        <article>
            <h2>View Pets</h2>
        </article>
    </section>
    <div class="divider"></div>

<!--    This adds us the search functionality. -->
    <section class="main-form-view">
        <h5> Search Pets </h5>
        <form action="search.php" method="get">
            <div class="row">
                <div class="col">
                    <input style="width: 50%; margin: auto;" type="text" name="search" placeholder="I'm looking for an animal named..." class="form-control" required>
                </div>
            </div>
            <p></p>
        <div style="text-align:center;">
            <button style="font-size: 20px;" type="submit" name="submit" value="Search" class="btn btn-outline-light">Search</button>
        </div>
            <p></p>
        </form>
    </section>

    <div class="divider"></div>


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

    echo "<section class='main-form-view'>";
    echo "<div>";

    echo '<h5> Stored Pets </h5>';
    //Echo out top of table
    echo "<table style='color: #e2e2e2;' class='table table-dark table-striped'><tboby>";


    //here i make the text above the columns to show what they are.
    echo
    "<thead class='thead-dark'>
        <tr>
          <th scope='col'>Name</th>
          <th scope='col'>Type</th>
          <th scope='col'>Age (Y)</th>
          <th scope='col'>Gender</th>
          <th scope='col'>Colour</th>
          <th scope='col'>Delete</th>
          <th scope='col'>Edit</th>
        </tr>
      </thead>";

    //Displaying each pet.
    foreach($records as $record)
        echo
        "<tr>
        
        <td>"
        . $record['name']. "</td><td>"
        . $record['type'] . "</td><td>"
        . $record['age'] . "</td><td>"
        . $record['gender'] . "</td><td>"
        . $record['colour'] . "</td><td>
        
        <a style='color: #af4644;' href='delete.php? id=" . $record['pet_id'] . "'> Delete Pet </a> </td><td>
        
        <a href='index.php? id=" . $record['pet_id'] . "'> Edit Pet </a> </td>

        </tr>";

    echo "</tbody></table>";
    echo "</div>";
    echo "</section>";


    //Close the connection
    $statement -> closeCursor();
    ?>

<?php require('footer.php'); ?>