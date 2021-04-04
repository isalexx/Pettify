<?php require('header.php') ?>

<main>

    <div class="divider"></div>

    <section class="image">
        <article>
            <h2>Account Details</h2>
        </article>
    </section>

    <div class="divider"></div>

    <section class="main-form" style="height: 180px;">
        <div style="width: 90%; flex-direction: row; text-align: center; padding-top: 20px">
            <div style="width: 48%">
                <h3>If you have an account, go ahead and log in below.</h3>
                <a style="font-size: 20px;" href="login.php" class="btn btn-outline-primary"> Log In </a>
            </div>
            <div style="width: 48%">
                <h3>If you have yet to create an account, click below to register.</h3>
                <a style="font-size: 20px;" href="register.php" class="btn btn-outline-primary"> Register </a>
            </div>
        </div>
    </section>
</main>

<?php require('footer.php'); ?>