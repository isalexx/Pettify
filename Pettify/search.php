<?php

require('header.php'); ?>

    <div class="divider"></div>

    <!--  This is the HTML for the search field and buttons.  -->
    <section class="main-form-view">
        <h5> Search Pets </h5>
        <form action="search.php" method="get">
            <div class="row">
                <div class="col">
                    <input style="width: 50%; margin: auto;" type="text" name="search" placeholder="I'm looking for an animal named..." class="form-control">
                </div>
            </div>
            <p></p>
        <div style="text-align:center;">
            <button style="font-size: 20px;" type="submit" name="submit" value="Search" class="btn btn-outline-light">Search</button>
            <a style="font-size: 20px;" href="view.php" class="btn btn-outline-primary"> Return To All </a>
        </div>
            <p></p>
        </form>
    </section>

    <div class="divider"></div>

<?php
// grab the search term and display results


$submit = filter_input(INPUT_GET, 'submit');
$search_term = filter_input(INPUT_GET, 'search');

require('connect.php');


//If the search field is not empty, we do the query.

if (!empty($search_term))
{
    $query = "SELECT * FROM pets
    WHERE name LIKE :search_term;";

    $statement = $db -> prepare($query);

    //Bind value instead of Param for %%.
    $statement -> bindValue(':search_term', '%'.$search_term.'%');

    $statement -> execute();

    echo '<div class="divider"></div>';
    echo "<section class='main-form-view'>";
    echo "<div>";

    if ($statement -> rowCount() >= 1)
    {
        echo "<h5> We found the following friends named " . $search_term . "! </h5>";
        echo "<table style='color: #e2e2e2;' class='table table-dark table-striped'><tboby>";
        //FetchAll gets an array, Fetch gets first result
        //if we have a result, we display it.

        //These are the titles for each column.
        echo "<thead class='thead-dark'>
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
        while ($results = $statement -> fetch())
        {
            echo
                "<tr>
        
        <td>"
                . $results['name']. "</td><td>"
                . $results['type'] . "</td><td>"
                . $results['age'] . "</td><td>"
                . $results['gender'] . "</td><td>"
                . $results['colour'] . "</td><td>
        
        <a style='color: #af4644;' href='delete.php? id=" . $results['pet_id'] . "'> Delete Pet </a> </td><td>
        
        <a href='index.php? id=" . $results['pet_id'] . "'> Edit Pet </a> </td>

        </tr>";
        }

        echo "</tbody></table>";
    }

    //If there are no matches, we display this message.
    else
    {
        echo "<section class='main-form-view'>";
        echo "<div>";
        echo "<h5> We were not able to find any fury friends by that name :( </h5>";
        echo "</div>";
        echo "</section>";
    }
}

//If nothing was entered in the search bar, we display this message.

else
{
    echo "<section class='main-form-view'>";
    echo "<div>";
    echo "<h5 style='color: #af4644;'> Please enter a name into the search field! </h5>";
    echo "</div>";
    echo "</section>";
}

echo "</div>";
echo "</section>";

require('footer.php');
?>





