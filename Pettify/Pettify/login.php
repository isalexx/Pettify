<?php
require('header.php');
session_start();

error_reporting(0);

// If they're logged in, redirect them to profile.php
if ($_SESSION['user'])
{
    header("Location: profile.php");
    exit();
}

?>

<main>
    <div class="divider"></div>

    <section class="image">
        <article>
            <h2>Login</h2>
        </article>
    </section>

    <div class="divider"></div>

    <section class="main-form" style="height: 325px">
        <div style="width: 60%;">
            <form action="authenticate.php" method="post">

                <div class="form-group" style="padding-top: 20px">
                    <label for="exampleInputEmail1">Email address</label>
                    <input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email" required minlength="2" maxlength="35">
                </div>

                <div class="form-group" style="padding-top: 20px">
                    <label for="exampleInputPassword1">Password</label>
                    <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Password" required minlength="2" maxlength="100">
                </div>

                <!--                ReCaptcha field.-->
                <input type="hidden" name="recaptcha_response" id="recaptchaResponse">

                <div style="text-align:center; padding-top: 20px">
                    <button style="font-size: 20px;" type="submit" value="Submit" name="submit" class="btn btn-outline-light">Log In</button>
                </div>
            </form>
        </div>
    </section>

    <!-- Add the recaptcha scripts -->
    <?php require('config.php') ?>
    <script src="https://www.google.com/recaptcha/api.js?render=<?= SITEKEY ?>"></script>
    <script>
        grecaptcha.ready(() => {
            grecaptcha.execute("<?= SITEKEY ?>", { action: "authenticate" })
                .then(token => document.querySelector("#recaptchaResponse").value = token)
                .catch(error => console.error(error));
        });
    </script>

</main>

<?php require('footer.php'); ?>
