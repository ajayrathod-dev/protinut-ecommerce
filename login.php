<?php
require_once 'connection.php';

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($link, trim($_POST['email']));
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        $error = "Both fields are required.";
    } else {
        $sql = "SELECT id, name, password FROM users WHERE email='$email' LIMIT 1";
        $result = mysqli_query($link, $sql);

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);

            if (password_verify($password, $row['password'])) {
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['user_name'] = $row['name'];

                header("Location: index.php");
                exit();
            } else {
                $error = "Invalid password.";
            }
        } else {
            $error = "No account found with that email.";
        }
    }
}
?>

<?php include 'header.php'; ?>

<!-- main area start  -->
<main>


    <section class="checkout pt-120 pb-385">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="checkout__wrap">
                        <div class="woocommerce-billing-fields">
                            <h3 class="mb-30 text-center">Login to Your Account</h3>

                            <?php if ($error): ?>
                                <div class="alert alert-danger" role="alert"
                                    style="color: red; margin-bottom: 20px; border: 1px solid red; padding: 10px;">
                                    <?php echo $error; ?>
                                </div>
                            <?php endif; ?>

                            <form action="login.php" method="POST">
                                <div class="woocommerce-billing-fields__field-wrapper">
                                    <p class="form-row form-row-wide validate-required validate-email">
                                        <label>Email address&nbsp;<abbr class="required"
                                                title="required">*</abbr></label>
                                        <span class="woocommerce-input-wrapper">
                                            <input type="email" class="input-text" name="email" required>
                                        </span>
                                    </p>
                                    <p class="form-row form-row-wide validate-required">
                                        <label>Password&nbsp;<abbr class="required" title="required">*</abbr></label>
                                        <span class="woocommerce-input-wrapper">
                                            <input type="password" class="input-text" name="password" required>
                                        </span>
                                    </p>
                                    <p class="form-row">
                                        <button type="submit" class="thm-btn btn-filled"
                                            style="width: 100%; border: none; cursor: pointer;">Login</button>
                                    </p>
                                    <p class="form-row mt-3 text-center">
                                        Don't have an account? <a href="register.php"
                                            style="color: var(--color-primary);">Register here</a>
                                    </p>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<!-- main area end  -->

<?php include 'footer.php'; ?>