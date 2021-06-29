<?php require('header.php');

  // If they're not logged in, redirect them
    session_start();
    if (!$_SESSION['user'])
    {
        header("Location: account.php");
        exit();
    }

  // Assign the user
    $user = $_SESSION['user'];

?>
<main>

    <div class="divider"></div>

    <section class="image">
        <article>
            <h2>Profile</h2>
        </article>
    </section>

    <div class="divider"></div>

    <section class="main-form" style="height: 200px;">
        <div style="height: 100px">
            <h5> Welcome <?php echo "{$user['username']}!"?> </h5>
        </div>
        <article style="margin: auto">
            <a style="font-size: 20px;" href="logout.php" class="btn btn-outline-primary"> Log Out </a>
            <a style="font-size: 20px;" href="deleteAccount.php" class="btn btn-outline-primary" onclick="return confirm('Are you sure?')"> Delete Account </a>
            <a style="font-size: 20px;" href="view.php" class="btn btn-outline-primary"> View Pets </a>
            <a style="font-size: 20px;" href="index.php" class="btn btn-outline-primary"> Add a Pet </a>
        </article>
    </section>
</main>
<?php require('footer.php'); ?>


