<?php
// Before we render the form let's check for form values
session_start();
$form_values = $_SESSION['form_values'] ?? null;


// Clear the form values
unset($_SESSION['form_values']);

require('header.php');
?>

<main>

    <?php require('notification.php') ?>

    <div class="divider"></div>

    <section class="image">
        <article>
            <h2>Login</h2>
        </article>
    </section>

    <div class="divider"></div>

    <section class="main-form" style="height: 325px">
        <div style="width: 60%;">
            <form action=".php" method="post">
                <div style="margin-top: 10px" class="form-floating mb-3">
                    <label for="floatingInput">Email address</label>
                    <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com">
                </div>
                <div style="margin-bottom: 30px" class="form-floating">
                    <label for="floatingPassword">Password</label>
                    <input type="password" class="form-control" id="floatingPassword" placeholder="Password">
                </div>
                <div style="text-align:center;">
                    <button style="font-size: 20px;" type="submit" value="Submit" name="submit" class="btn btn-outline-light">Create My Account</button>
                </div>
            </form>
        </div>
    </section>

    <!-- Add the recaptcha scripts -->
    <?php require('config.php') ?>
    <script src="https://www.google.com/recaptcha/api.js?render=<?= SITEKEY ?>"></script>
    <script>
        grecaptcha.ready(() => {
            grecaptcha.execute("<?= SITEKEY ?>", { action: "register" })
                .then(token => document.querySelector("#recaptchaResponse").value = token)
                .catch(error => console.error(error));
        });
    </script>

</main>

<?php require('footer.php'); ?>
