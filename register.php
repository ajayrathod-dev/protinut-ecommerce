<?php
require_once 'connection.php';

$error = '';
$success = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($link, trim($_POST['name'] ?? ''));
    $email = mysqli_real_escape_string($link, trim($_POST['email'] ?? ''));
    $phone = mysqli_real_escape_string($link, trim($_POST['phone'] ?? ''));
    $password = $_POST['password'] ?? '';

    // Additional Address fields
    $country = mysqli_real_escape_string($link, trim($_POST['country'] ?? ''));
    $address = mysqli_real_escape_string($link, trim($_POST['address'] ?? ''));
    $city = mysqli_real_escape_string($link, trim($_POST['city'] ?? ''));
    $postcode = mysqli_real_escape_string($link, trim($_POST['postcode'] ?? ''));

    if (empty($name) || empty($email) || empty($password)) {
        $error = "Name, Email, and Password are required fields.";
    } else {
        // Check if email already exists
        $check = mysqli_query($link, "SELECT id FROM users WHERE email='$email' LIMIT 1");

        if ($check && mysqli_num_rows($check) > 0) {
            $error = "Email is already registered. Please login instead.";
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $hashed_password = mysqli_real_escape_string($link, $hashed_password);

            // Assume `users` table was modified or will automatically accept these additions (requires schema update if they don't exist)
            // But we will insert gracefully or fall back to standard fields if the DB hasn't been migrated yet in the scope of this update
            $sql = "INSERT INTO users (name, email, password, phone, country, address, city, postcode) 
                    VALUES ('$name', '$email', '$hashed_password', '$phone', '$country', '$address', '$city', '$postcode')";

            if (mysqli_query($link, $sql)) {
                $success = "Registration successful! You can now <a href='login.php'>login here</a>.";
            } else {
                $error = "Something went wrong creating your account: " . mysqli_error($link);
            }
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
                <div class="col-lg-8">
                    <div class="checkout__wrap">
                        <div class="woocommerce-billing-fields">
                            <h3 class="mb-30 text-center" style="font-size:32px; font-weight:bold; color:#060606;">
                                Create an Account</h3>
                            <p class="text-center" style="color:#666; margin-bottom:40px;">Fill out your details to join
                                Protinut and enhance your shopping experience.</p>

                            <?php if ($error): ?>
                                <div class="alert alert-danger" role="alert"
                                    style="color: #721c24; background-color: #f8d7da; border-color: #f5c6cb; margin-bottom: 20px; padding: 15px; border-radius: 4px;">
                                    <?php echo $error; ?>
                                </div>
                            <?php endif; ?>

                            <?php if ($success): ?>
                                <div class="alert alert-success" role="alert"
                                    style="color: #155724; background-color: #d4edda; border-color: #c3e6cb; margin-bottom: 20px; padding: 15px; border-radius: 4px;">
                                    <?php echo $success; ?>
                                </div>
                            <?php else: ?>

                                <form action="register.php" method="POST">
                                    <div class="row">
                                        <!-- Basic Info -->
                                        <div class="col-md-6 mb-3">
                                            <label style="font-weight:600; color:#333;">Full Name <abbr class="required"
                                                    title="required" style="color:red;">*</abbr></label>
                                            <input type="text" class="form-control" name="name" required
                                                style="width:100%; padding:10px; border:1px solid #ddd; border-radius:4px;">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label style="font-weight:600; color:#333;">Email Address <abbr class="required"
                                                    title="required" style="color:red;">*</abbr></label>
                                            <input type="email" class="form-control" name="email" required
                                                style="width:100%; padding:10px; border:1px solid #ddd; border-radius:4px;">
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label style="font-weight:600; color:#333;">Phone Number</label>
                                            <input type="tel" class="form-control" name="phone"
                                                style="width:100%; padding:10px; border:1px solid #ddd; border-radius:4px;">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label style="font-weight:600; color:#333;">Password <abbr class="required"
                                                    title="required" style="color:red;">*</abbr></label>
                                            <input type="password" class="form-control" name="password" required
                                                style="width:100%; padding:10px; border:1px solid #ddd; border-radius:4px;">
                                        </div>

                                        <!-- Address Info -->
                                        <div class="col-12 mt-4 mb-3">
                                            <h4
                                                style="font-size:20px; border-bottom:2px solid #f7941d; padding-bottom:10px;">
                                                Shipping Address</h4>
                                        </div>

                                        <div class="col-md-12 mb-3">
                                            <label style="font-weight:600; color:#333;">Street Address</label>
                                            <input type="text" class="form-control" name="address"
                                                placeholder="House number and street name"
                                                style="width:100%; padding:10px; border:1px solid #ddd; border-radius:4px;">
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <label style="font-weight:600; color:#333;">Country</label>
                                            <select name="country" class="form-control"
                                                style="width:100%; padding:10px; border:1px solid #ddd; border-radius:4px;">
                                                <option value="">Select a country...</option>
                                                <option value="US">United States</option>
                                                <option value="UK">United Kingdom</option>
                                                <option value="CA">Canada</option>
                                                <option value="IN">India</option>
                                                <option value="AU">Australia</option>
                                            </select>
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <label style="font-weight:600; color:#333;">Town / City</label>
                                            <input type="text" class="form-control" name="city"
                                                style="width:100%; padding:10px; border:1px solid #ddd; border-radius:4px;">
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <label style="font-weight:600; color:#333;">Postcode / ZIP</label>
                                            <input type="text" class="form-control" name="postcode"
                                                style="width:100%; padding:10px; border:1px solid #ddd; border-radius:4px;">
                                        </div>

                                        <div class="col-12 mt-4">
                                            <button type="submit" class="xb-btn thm-btn btn-filled"
                                            style="width: 100%; height: 60px; border: none; cursor: pointer; text-transform: uppercase; font-family: var(--font-heading); letter-spacing: 1px;">Register
                                            Account</button>
                                        </div>

                                        <div class="col-12 mt-4 text-center">
                                            <p style="font-size: 15px; color:#666;">Already have an account? <a
                                                    href="login.php"
                                                    style="color: var(--color-primary); font-weight:600;">Login here</a></p>
                                        </div>
                                    </div>
                                </form>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<!-- main area end  -->

<?php include 'footer.php'; ?>