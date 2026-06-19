<?php
/*
 * FILE: user_mngmnt.php
 * PURPOSE: Processes login and signup form POST requests.
 * OUTPUT:  Redirects only — no HTML is rendered here.
 */

// ── Initialization ──
// SYNTAX: session_start() must run before any output; resumes the visitor's session.
session_start();

// SYNTAX: require_once loads a file once; prevents duplicate $conn if included twice.
require_once '../logic/config.php';


// ══════════════════════════════════════
// SIGNUP HANDLER
// ══════════════════════════════════════

// SYNTAX: isset($_POST['key']) — true when the form included that field in the POST body.
// LOGIC:  The signup button has name="signup", so only signup submissions enter this block.
if (isset($_POST['signup'])) {

    // SYNTAX: $_POST['name'] reads values from the submitted form (method="post").
    $first_name = $_POST['first_name'];
    $last_name  = $_POST['last_name'];
    $email      = $_POST['email'];
    $role       = $_POST['role'];

    // SYNTAX: password_hash(plain, PASSWORD_DEFAULT) returns a bcrypt hash string.
    // LOGIC:  Store the hash in the database — never the raw password.
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // SYNTAX: $conn->query("SQL") sends a SQL string to MySQL and returns a result object.
    $checkEmail = $conn->query("SELECT email FROM users WHERE email = '$email'");

    // SYNTAX: num_rows counts matching rows in the result set.
    // LOGIC:  Reject registration if the email already exists.
    if ($checkEmail->num_rows > 0) {
        // SYNTAX: $_SESSION['key'] = value stores data for the next request.
        $_SESSION['signup_error'] = "Email is already registered.";
        $_SESSION['active_form']  = 'signup';  // LOGIC: Re-open signup form after redirect.

        // SYNTAX: header("Location: url") sends an HTTP redirect response.
        header("Location: ../pages/login_signup.php");
        exit();  // SYNTAX: exit() stops PHP so no code runs after the redirect.
    }

    // LOGIC: Email is available — insert the new user record.
    $conn->query("INSERT INTO users (first_name, last_name, email, password, role)
                  VALUES ('$first_name', '$last_name', '$email', '$password', '$role')");

    // LOGIC: Redirect to login page so the user can sign in with the new account.
    header("Location: ../pages/login_signup.php");
    exit();
}


// ══════════════════════════════════════
// LOGIN HANDLER
// ══════════════════════════════════════

// LOGIC: The login button has name="login", distinguishing it from signup.
if (isset($_POST['login'])) {

    $email    = $_POST['email'];
    $password = $_POST['password'];  // LOGIC: Plain text — verified against hash below.

    $result = $conn->query("SELECT * FROM users WHERE email = '$email'");

    if ($result->num_rows > 0) {
        // SYNTAX: fetch_assoc() returns one row as an associative array (column => value).
        $user = $result->fetch_assoc();

        // SYNTAX: password_verify(plain, hash) returns true if they match.
        if (password_verify($password, $user['password'])) {

            // LOGIC: Persist identity in session so dashboard pages know who is logged in.
            $_SESSION['first_name'] = $user['first_name'];
            $_SESSION['last_name']  = $user['last_name'];
            $_SESSION['email']      = $user['email'];
            $_SESSION['role']       = $user['role'];

            // SYNTAX: === strict equality — value and type must both match.
            // LOGIC:  Route each role to its dedicated dashboard page.
            if ($user['role'] === 'admin') {
                header("Location: ../pages/admin.php");
            } elseif ($user['role'] === 'techn') {
                header("Location: ../pages/techn.php");
            } else {
                header("Location: ../pages/user.php");
            }
            exit();
        }
    }

    // LOGIC: Reached when email not found OR password wrong — same message for both.
    $_SESSION['login_error'] = 'Incorrect credentials. Please input your correct email or password.';
    $_SESSION['active_form']  = 'login';
    header("Location: ../pages/login_signup.php");
    exit();
}
?>
