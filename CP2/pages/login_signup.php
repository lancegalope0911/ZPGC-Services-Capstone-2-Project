<?php
/*
 * FILE: login_signup.php
 * PURPOSE: Displays login and signup forms; reads one-time flash messages from session.
 */

// ── Session & flash data ──
session_start();

// SYNTAX: [ 'key' => value ] — associative array (key-value pairs).
// SYNTAX: ?? null coalescing — use left side if set, otherwise right side.
// LOGIC:  Pull error messages stored by user_mngmnt.php before redirect.
$errors = [
    'login'  => $_SESSION['login_error']  ?? '',
    'signup' => $_SESSION['signup_error'] ?? ''
];

// LOGIC: Priority — session (after failed submit) → URL param → default login.
// SYNTAX: $_GET['form'] reads query string, e.g. ?form=signup from landing page.
$activeForm = $_SESSION['active_form'] ?? ($_GET['form'] ?? 'login');

// LOGIC: Clear session after reading so errors display only once (not on refresh).
session_unset();


// ── Helper functions ──

// SYNTAX: function name($param) { return ...; } — returns a value to the caller.
function showError($error) {
    // SYNTAX: !empty($var) — false if $var is "", null, 0, etc.
    // SYNTAX: condition ? ifTrue : ifFalse — ternary operator.
    // LOGIC:  Output styled error HTML, or empty string if no error.
    return !empty($error)
        ? "<div style='padding:12px; background-color: #bd8084; color: #ff0011; border-radius:6px; text-align:center; margin-bottom:20px; color:#7e030b; font-weight:600; font-size: 14px; width:100%;'>$error</div>"
        : '';
}

function isActiveForm($formName, $activeForm) {
    // SYNTAX: === strict equality comparison.
    // LOGIC:  Returns CSS class "active" for the form that should be visible.
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

    <!-- LOGIC: White left panel — holds logo and both form boxes -->
    <div class="container">

        <div class="logo">
            <a href="../pages/landing_page.php">
                <img src="../images/ZPGC.com2.png" alt="ZPGC Services">
            </a>
        </div>

        <!-- ── LOGIN FORM ── -->
        <!-- SYNTAX: <?= expr ?> — short echo; prints PHP return value into HTML -->
        <!-- LOGIC: isActiveForm() adds "active" class so CSS shows this form on load -->
        <div class="form-box <?= isActiveForm('login', $activeForm); ?>" id="login-form">

            <!-- SYNTAX: action = destination URL; method="post" sends data in request body -->
            <form action="../logic/user_mngmnt.php" method="post">
                <h1>LOGIN</h1>

                <?= showError($errors['login']); ?>

                <h5>Enter your credentials to access, create, or track your ticket</h5>

                <!-- SYNTAX: name="email" becomes the key in $_POST['email'] on submit -->
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Password" required>

                <!-- SYNTAX: name="login" lets user_mngmnt.php detect this form via isset($_POST['login']) -->
                <button type="submit" name="login">Login</button>

                <p>Don't have an account?
                    <!-- LOGIC: showForm() switches forms without page reload -->
                    <a href="#" onclick="showForm('signup-form')"> Signup now!</a>
                </p>
            </form>
        </div>

        <!-- ── SIGNUP FORM ── -->
        <div class="form-box <?= isActiveForm('signup', $activeForm); ?>" id="signup-form">
            <form action="../logic/user_mngmnt.php" method="post">
                <h1>SIGNUP</h1>

                <?= showError($errors['signup']); ?>

                <h5>Enter your credentials to create your ZPGC account</h5>

                <input type="text" name="first_name" placeholder="First Name" required>
                <input type="text" name="last_name" placeholder="Last Name" required>
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Password" required>

                <!-- SYNTAX: <select> dropdown — selected option value sent as $_POST['role'] -->
                <select name="role" required>
                    <option value="" disabled selected>Role</option>
                    <option value="user">User</option>
                    <option value="admin">Administrator</option>
                    <option value="techn">Technician</option>
                </select>

                <button type="submit" name="signup">Signup</button>

                <p>Already have an account?
                    <a href="#" onclick="showForm('login-form')"> Login now!</a>
                </p>
            </form>
        </div>

    </div>

    <!-- LOGIC: Script at end of body — DOM exists before showForm() is called -->
    <script src="../js/script.js"></script>
</body>
</html>
