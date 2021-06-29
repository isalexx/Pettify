<?php
// Before we render the form let's check for form values
session_start();
$form_values = $_SESSION['form_values'] ?? null;


// Clear the form values
unset($_SESSION['form_values']);

require('header.php');
?>

    <main>

        <div class="divider"></div>

        <section class="image">
            <article>
                <h2>Create An Account</h2>
            </article>
        </section>

        <div class="divider"></div>

        <section class="main-form" style="height: 400px">
            <div style="width: 60%;">
                <form action="insert.php" method="post">
                    <div class="form-group">
                        <label for="username"> Username </label>
                        <input class="form-control" type="text" name="username" required placeholder="Username" value="<?= $form_values['username'] ?? null ?>">
                    </div>

                    <div class="form-group">
                        <label for="password"> Password </label>
                        <div class="input-group mb-3">
                            <input type="password" class="form-control" name="password" placeholder="Password" required>
                            <span class="input-group-text"></span>
                            <input type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="email"> Email Address </label>
                        <div class="input-group mb-3">
                            <input type="email" class="form-control" name="email" placeholder="myemail@example.com" required value="<?= $form_values['email'] ?? null ?>">
                            <span class="input-group-text"></span>
                            <input type="email" class="form-control" name="email_confirmation" placeholder="Confirm Email" required value="<?= $form_values['email_confirmation'] ?? null ?>">
                        </div>
                    </div>

<!--                    This is the recaptcha field.-->
                    <input type="hidden" name="recaptcha_response" id="recaptchaResponse">

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