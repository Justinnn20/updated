<?php
session_start();
include "db_conn.php";

/**
 * --- 1. FACEBOOK LOGIN LOGIC ---
 * Sinisigurado nito na ang 'facebook_id' ay mase-save sa DB.
 */
if (isset($_POST['fb_login'])) {
    // Kunin ang data mula sa hidden inputs ng iyong Facebook form
    $email = mysqli_real_escape_string($conn, $_POST['fb_email']);
    $name  = mysqli_real_escape_string($conn, $_POST['fb_name']);
    $fb_id = mysqli_real_escape_string($conn, $_POST['fb_id']); // Unique ID mula sa FB

    // I-check kung existing na ang email sa database
    $check_query = "SELECT * FROM create_acc WHERE email='$email' LIMIT 1";
    $result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($result) > 0) {
        // EXISTING USER: I-update ang facebook_id para maging "Connected" sa Profile
        $update_sql = "UPDATE create_acc SET facebook_id='$fb_id' WHERE email='$email'";
        mysqli_query($conn, $update_sql);
        
        // Kunin ang updated na user data
        $result = mysqli_query($conn, $check_query);
        $user = mysqli_fetch_assoc($result);
    } else {
        // NEW USER: I-save pati ang facebook_id sa registration
        $sql = "INSERT INTO create_acc (full_name, email, facebook_id, role, password) 
                VALUES ('$name', '$email', '$fb_id', 'customer', 'FACEBOOK_AUTH_NO_PASS')";
        mysqli_query($conn, $sql);
        
        $new_id = mysqli_insert_id($conn);
        $user = ['id' => $new_id, 'full_name' => $name, 'role' => 'customer'];
    }

    // SET SESSIONS
    $_SESSION['user_id']   = $user['id'];
    $_SESSION['user_name'] = $user['full_name'];
    $_SESSION['role']      = $user['role'];
    $_SESSION['logged_in'] = true;

    // REDIRECT
    header("Location: " . ($user['role'] == 'admin' ? "admin_dashboard.php" : "homepage.php"));
    exit();
}

/**
 * --- 2. GOOGLE LOGIN LOGIC ---
 * Dinedecode ang JWT credential para makuha ang 'sub' (Google ID).
 */
elseif (isset($_POST['google_login'])) {
    $jwt = $_POST['credential']; // JWT Token mula sa Google Button
    
    // Decode Google JWT
    $parts = explode(".", $jwt);
    if(count($parts) == 3) {
        $payload = json_decode(base64_decode($parts[1]), true);
        
        $email = mysqli_real_escape_string($conn, $payload['email']);
        $name  = mysqli_real_escape_string($conn, $payload['name']);
        $g_id  = mysqli_real_escape_string($conn, $payload['sub']); // Unique Google ID ('sub')

        // I-check kung existing ang email
        $check_query = "SELECT * FROM create_acc WHERE email='$email' LIMIT 1";
        $result = mysqli_query($conn, $check_query);

        if (mysqli_num_rows($result) > 0) {
            $user = mysqli_fetch_assoc($result);
            
            // ETO ANG FIX: I-update ang google_id sa DB para ma-detect ng Profile page
            mysqli_query($conn, "UPDATE create_acc SET google_id='$g_id' WHERE email='$email'");
        } else {
            // NEW GOOGLE USER: I-save kasama ang google_id
            $sql = "INSERT INTO create_acc (full_name, email, google_id, role, password) 
                    VALUES ('$name', '$email', '$g_id', 'customer', 'GOOGLE_AUTH_NO_PASS')";
            mysqli_query($conn, $sql);
            
            $new_id = mysqli_insert_id($conn);
            $user = ['id' => $new_id, 'full_name' => $name, 'role' => 'customer'];
        }

        // SET SESSIONS
        $_SESSION['user_id']   = $user['id'];
        $_SESSION['user_name'] = $user['full_name'];
        $_SESSION['role']      = $user['role'];
        $_SESSION['logged_in'] = true;

        header("Location: " . ($user['role'] == 'admin' ? "admin_dashboard.php" : "homepage.php"));
        exit();
    }
}

/**
 * --- 3. MANUAL LOGIN (EMAIL & PASSWORD) ---
 */
elseif (isset($_POST['login_btn'])) {
    $email    = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    $query  = "SELECT * FROM create_acc WHERE email='$email' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        
        // Verify hashed password
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id']   = $user['id'];
            $_SESSION['user_name'] = $user['full_name'];
            $_SESSION['role']      = $user['role'];
            $_SESSION['logged_in'] = true;

            header("Location: " . ($user['role'] == 'admin' ? "admin_dashboard.php" : "homepage.php"));
            exit();
        } else {
            echo "<script>alert('Maling Password!'); window.location='login.html';</script>";
        }
    } else {
        echo "<script>alert('Email not found!'); window.location='login.html';</script>";
    }
}

else {
    header("Location: login.html");
    exit();
}
?>