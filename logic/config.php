<?php
/*
 * FILE: config.php
 * PURPOSE: Establishes the MySQL database connection used by backend logic.
 * USAGE:   require_once '../logic/config.php';  →  provides $conn
 */

// ── Database credentials ──
// SYNTAX: Variable assignment ($name = value) stores connection settings.
$host     = "localhost";  // LOGIC: Database server on the same machine as Apache (XAMPP).
$user     = "root";       // LOGIC: MySQL default admin account.
$password = "";           // LOGIC: Empty default for local XAMPP installs.
$database = "users_db";   // LOGIC: Target database containing the users table.

// ── Connection object ──
// SYNTAX: new ClassName(args) creates an object instance.
// SYNTAX: -> is the object operator; accesses methods/properties on $conn.
$conn = new mysqli($host, $user, $password, $database);

// ── Error handling ──
// SYNTAX: if (condition) { } — executes block only when condition is true.
// SYNTAX: . concatenates strings.
// LOGIC: Stop execution immediately if the database is unreachable.
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SYNTAX: No closing ?> tag — prevents accidental whitespace before HTTP headers.
