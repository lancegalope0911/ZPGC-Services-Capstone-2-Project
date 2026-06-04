<?php

session_start();

$errors = [
    'login' => $_SESSION['login_error'] ?? '',
    'signup' => $_SESSION['signup_error'] ?? ''
];

$activeForm = $_SESSION['active_form'] ?? ($_GET['form'] ?? 'login');

session_unset();

function showError($error) {
    return !empty($error) ? "<div style='padding:12px; background-color: #bd8084; color: #ff0011; border-radius:6px; text-align:center; margin-bottom:20px; color:#7e030b; font-weight:600; font-size: 14px; width:100%;'>$error</div>" : '';
}

function isActiveForm($formName, $activeForm) {
    return $formName === $activeForm ? 'active' : '';
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/login_signup.css">
    <title>ZPGC Services | Login/Signup</title>
</head>
<body>
    <div class="container">
        <div class="logo">
            <a href="../pages/landing_page.php">
                <img src="../images/ZPGC.com2.png" alt="ZPGC Services">
            </a>
        </div>

        <div class="form-box <?= isActiveForm('login', $activeForm); ?>" id="login-form">
            <form action="../logic/user_mngmnt.php" method="post">
                <h1>LOGIN</h1>
                <?= showError($errors['login']); ?>
                <h5>Enter your credentials to access, create, or track your ticket</h5>

                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit" name="login">Login</button>
                <p>Don't have an account?<a href="#" onclick="showForm('signup-form')"> Signup now!</a></p>
            </form>
        </div>

        <div class="form-box <?= isActiveForm('signup', $activeForm); ?>" id="signup-form">
            <form action="../logic/user_mngmnt.php" method="post">
                <h1>SIGNUP</h1>
                <?= showError($errors['signup']); ?>
                <h5>Enter your credentials to create your ZPGC account</h5>

                <input type="text" name="first_name" placeholder="First Name" required>
                <input type="text" name="last_name" placeholder="Last Name" required>
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Password" required>
                <select name="role" required>
                    <option value="" disabled selected>Role</option>
                    <option value="user">User</option>
                    <option value="admin">Administrator</option>
                    <option value="techn">Technician</option>
                </select>
                <button type="submit" name="signup">Signup</button>
                <p>Already have an account?<a href="#" onclick="showForm('login-form')"> Login now!</a></p>
            </form>
        </div>
    </div>

    <script src="../js/script.js"></script>
</body>
</html>