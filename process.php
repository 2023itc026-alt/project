<?php
session_start();
require_once 'db_config.php';

// --- REGISTER LOGIC ---
if (isset($_POST['signup_submit'])) {
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Secure hashing

    $stmt = $conn->prepare("INSERT INTO users (fullname, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $fullname, $email, $password);

    if ($stmt->execute()) {
        echo "<script>alert('Account created! Please login.'); window.location='index.php';</script>";
    } else {
        echo "<script>alert('Error: Email might already exist.'); window.location='index.php';</script>";
    }
    $stmt->close();
}

// --- UPDATED LOGIN LOGIC ---
if (isset($_POST['login_submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Added profile_pic to the SELECT query
    $stmt = $conn->prepare("SELECT fullname, password, profile_pic FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($user = $result->fetch_assoc()) {
       if (password_verify($password, $user['password'])) {
    $_SESSION['user'] = $user['fullname'];
    $_SESSION['email'] = $email; // This line is required for the Gravatar icon
    header("Location: index.php");
    exit();
        }
} else {
            echo "<script>alert('Invalid password.'); window.location='index.php';</script>";
        }
    }
    $stmt->close();

// --- FORGOT PASSWORD LOGIC ---
if (isset($_POST['forgot_submit'])) {
    $email = $_POST['email'];

    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // In a real app, you'd send an email here. 
        // For your project, we will redirect to a "Set New Password" page.
        header("Location: reset_password.php?email=" . urlencode($email));
    } else {
        echo "<script>alert('Email not found.'); window.location='index.php';</script>";
    }
    $stmt->close();
}

// --- RESET PASSWORD FINAL STEP ---
if (isset($_POST['update_password_submit'])) {
    $email = $_POST['email'];
    $new_pass = password_hash($_POST['new_password'], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
    $stmt->bind_param("ss", $new_pass, $email);

    if ($stmt->execute()) {
        echo "<script>alert('Password updated successfully!'); window.location='index.php';</script>";
    } else {
        echo "<script>alert('Error updating password.'); window.location='index.php';</script>";
    }
    $stmt->close();
}
?>