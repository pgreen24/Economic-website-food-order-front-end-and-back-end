<?php include('partials-front/menu.php'); ?>
<?php
// Start session

// Include database connection file
require_once 'config/constants.php';

// Check if submit button is clicked
if (isset($_POST['submit'])) {
    // Validate user input
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

    // Check if email already exists
    $stmt = $mysqli->prepare("SELECT * FROM tbl_registration WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['message'] = 'User with this email already exists!';
        header("Location: error.php");
        exit;
    } else {
        // Hash password
        $passwordHash = password_hash($password, PASSWORD_ARGON2ID);

        // Generate verification hash
        $hash = md5(rand(0, 1000));

        // Insert user data into database
        $stmt = $mysqli->prepare("INSERT INTO tbl_registration (username, email, password, hash) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $username, $email, $password, $hash);
        $stmt->execute();

        // Send verification email
        $to = $email;
        $subject = 'Account Verification';
        $messageBody = '
        Hello ' . $username . ',

        Thank you for signing up!

        Kindly click this link to activate your account:

        http://localhost/CTC/Login_Register/verify.php?email=' . $email . '&hash=' . $hash;

        // Use PHPMailer to send email
        require_once 'PHPMailer/PHPMailer.php';
        $mail = new PHPMailer();
        $mail->setFrom('your_email@example.com', 'Your Name');
        $mail->addAddress($to, $username);
        $mail->Subject = $subject;
        $mail->Body = $messageBody;
        $mail->send();

        $_SESSION['message'] = 'Great! you\'re almost done. A confirmation link has been sent to ' . $email . ', please verify your account by clicking on the link in the message!';
        header("Location: index.php");
        exit;
    }
}
?>
<!-- HTML code -->
<!DOCTYPE html>
<html>
<head>
    <title>Sign up</title>
    <link rel="stylesheet" href="../food-order/css/sty.css">
</head>
<body>
    <form class="signup-form">
        <h1>Sign up</h1>
        <p class="lim">Please fill this form to register</p>

        <label for="username">Username</label>
        <input type="text" id="username" name="username" placeholder="Username">

        <label for="email">Email Address</label>
        <input type="email" id="email" name="email" placeholder="Email Address">

        <label for="password">Password</label>
        <input type="password" id="password" name="password" placeholder="Password">

        <button type="submit" name="submit">Sign Up</button>
        <p class="sim">Already have an account? <a href="../food-order/login.php">Log In</a></p>
    </form>
    <?php include('partials-front/footer.php'); ?>
</body>
</html>


