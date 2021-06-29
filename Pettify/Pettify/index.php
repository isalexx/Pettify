<!-- This file is used to add new pets to the database, and edit existing ones.-->

<?php require('header.php');

// If they're not logged in, redirect them
session_start();
if (!$_SESSION['user']) {
    header("Location: account.php");
    exit();
}

// Assign the user
$user = $_SESSION['user'];


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

        <section class="main-form" style="height: 700px;">
            <div>
                <form action="process.php" method="post">
                    <input type="hidden" name="pet_id" value="<?php echo $id ?>">

                    <div class="form-group" style="padding-bottom: 10px">
                        <label for="name"> Name </label>
                        <input placeholder="My pet's name is..." type="text" name="name" id="name" class="form-control" value="<?php echo $name ?>" required maxlength="25" minlength="2">
                    </div>

                    <div class="form-group" style="padding-bottom: 10px">
                        <label for="name"> Type of Pet </label>
                        <select type="text" name="type" id="type" class="form-control">
                            <option value="<?php echo $type ?? 'none'?>"> <?php echo $type ?? 'Please Choose One'?> </option>
                            <option>Bunny</option>
                            <option>Cat</option>
                            <option>Dog</option>
                            <option>Guinea Pig</option>
                            <option>Turtle</option>
                            <option>Snake</option>
                            <option>Parrot</option>
                            <option>Monkey</option>
                            <option>Sugar Glider</option>
                            <option>Other</option>
                        </select>
                    </div>

                    <div class="form-group" style="padding-bottom: 10px">
                        <label for="age"> How old is your pet (Y)? </label>
                        <input placeholder="My pet is xx years old..." type="number" name="age" id="age" class="form-control" value="<?php echo $age ?>" required maxlength="2" min="0" max="99" >
                    </div>

                    <div class="form-group" style="padding-bottom: 10px">
                        <label for="name"> Gender </label>
                        <select  type="text" name="gender" id="gender" class="form-control">
                            <option value="<?php echo $gender ?? 'none'?>">
                                <?php
                                if ($gender === 'F')
                                    echo 'Female';

                                else if ($gender === 'M')
                                echo 'Male';

                                else
                                    echo $gender ?? 'Please Choose One';
                                ?> </option>
                            <option value="F">Female</option>
                            <option value="M">Male</option>
                        </select>
                    </div>

                    <div class="form-group" style="padding-bottom: 10px">
                        <label for="colour"> Colour </label>
                        <input placeholder="My pet's primary colour is..." type="text" name="colour" id="colour" class="form-control" value="<?php echo $colour ?>" required maxlength="10" minlength="2">
                    </div>

                    <div style="text-align:center;" style="padding-bottom: 10px">
                        <button style="font-size: 20px;" type="submit" value="Submit" name="submit" class="btn btn-outline-light">Submit</button>
                    </div>

                </form>
            </div>
        </section>
    </main>
    <?php require('footer.php'); ?>

