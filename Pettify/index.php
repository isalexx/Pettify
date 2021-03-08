<?php require('header.php'); 

//initialize variables, will be used if editing info 
$id = null; 
$name = null; 
$type = null; 
$age = null; 
$gender = null; 
$colour = null; 

if(!empty($_GET['id'])) 
{
    $id = filter_input(INPUT_GET, 'id'); 

    //connect to the database.
    require('connect.php'); 
    
    //set up the query 
    $sql = 'SELECT * FROM pets 
    WHERE pet_id = :pet_id;';


    // prepare 
    $statement = $db -> prepare($sql);

    
    //bind 
    $statement -> bindParam(':pet_id', $id); 


    //execute 
    $statement -> execute(); 

    //Getting all the records
    $records = $statement->fetchAll(); 

    //Looping through them all.
    foreach($records as $record) :
     $name = $record['name']; 
     $type = $record['type']; 
     $age = $record['age']; 
     $gender= $record['gender']; 
     $colour = $record['colour'];
    endforeach; 

    //close DB connection 
    $statement->closeCursor(); 

    }
?>
    <main>

        <div class="divider"></div>

        <section class="image">
            <article>
                <h2>Share Your Pet</h2>
            </article>
        </section>

        <div class="divider"></div>

        <section class="main-form">
            <div>
                <form action="process.php" method="post">
                    <input type="hidden" name="pet_id" value="<?php echo $id ?>">

                    <div class="form-group">
                        <label for="name"> Name </label>
                        <input type="text" name="name" id="name" class="form-control" value="<?php echo $name ?>">
                    </div>

                    <div class="form-group">
                        <label for="type"> Type of Animal </label>
                        <input type="text" name="type" id="type" class="form-control" value="<?php echo $type ?>">
                    </div>

                    <div class="form-group">
                        <label for="age"> How old is your pet (Y)? </label>
                        <input type="number" name="age" id="age" class="form-control" value="<?php echo $age ?>">
                    </div>

                    <div class="form-group">
                        <label for="gender"> Gender (F/M) </label>
                        <input type="text" name="gender" id="gender" class="form-control" value="<?php echo $gender ?>">
                    </div>

                    <div class="form-group">
                        <label for="colour"> Colour </label>
                        <input type="text" name="colour" id="colour" class="form-control" value="<?php echo $colour ?>">
                    </div>

                    <div style="text-align:center;">
                        <button style="font-size: 20px;" type="submit" value="Submit" name="submit" class="btn btn-outline-light">Submit</button>
                    </div>

                </form>
            </div>
        </section>
    </main>
    <?php require('footer.php'); ?>

