<?php
session_start();
include "db_conn.php";

// Siguraduhin na may naka-login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

$user_id = $_SESSION['user_id'];

// --- 1. LOGIC PARA SA PAGBURA NG PHOTO (REMOVE PHOTO LINK) ---
if (isset($_GET['remove_photo'])) {
    
    // Kunin muna ang pangalan ng file sa DB para mabura sa folder
    $check_old = mysqli_query($conn, "SELECT profile_pic FROM create_acc WHERE id = '$user_id'");
    $old_res = mysqli_fetch_assoc($check_old);
    
    // Buburahin lang ang file kung hindi ito URL (social pic) at existing sa folder
    if (!empty($old_res['profile_pic']) && !filter_var($old_res['profile_pic'], FILTER_VALIDATE_URL) && file_exists($old_res['profile_pic'])) {
        unlink($old_res['profile_pic']); 
    }

    // Gawing blanko ang profile_pic sa database
    $sql = "UPDATE create_acc SET profile_pic = '' WHERE id = '$user_id'";
    
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Profile picture removed!'); window.location='Profile.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
    exit();
}

// --- 2. LOGIC PARA SA PAG-SAVE NG CHANGES AT SOCIAL LINKING/SYNC ---
elseif (isset($_POST['btn_save_profile']) || isset($_POST['link_google']) || isset($_POST['link_fb']) || isset($_POST['social_pic_url'])) {
    
    $new_name = mysqli_real_escape_string($conn, $_POST['full_name'] ?? "");
    $new_contact = mysqli_real_escape_string($conn, $_POST['contact_number'] ?? "");
    $new_home = mysqli_real_escape_string($conn, $_POST['address_home'] ?? "");
    $new_work = mysqli_real_escape_string($conn, $_POST['address_work'] ?? "");
    
    // NEW: DISCOUNT FIELDS
    $new_discount_type = mysqli_real_escape_string($conn, $_POST['discount_type'] ?? "None");
    $new_discount_id = mysqli_real_escape_string($conn, $_POST['discount_id_no'] ?? "");

    $img_query = "";
    $id_pic_query = "";

    // A. PROFILE PICTURE UPLOAD LOGIC
    if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] == 0) {
        $target_dir = "uploads/";
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        
        $check_old = mysqli_query($conn, "SELECT profile_pic FROM create_acc WHERE id = '$user_id'");
        $old_res = mysqli_fetch_assoc($check_old);
        
        if (!empty($old_res['profile_pic']) && !filter_var($old_res['profile_pic'], FILTER_VALIDATE_URL) && file_exists($old_res['profile_pic'])) {
            unlink($old_res['profile_pic']);
        }

        $file_name = time() . "_profile_" . basename($_FILES["profile_pic"]["name"]);
        $target_file = $target_dir . $file_name;

        if (move_uploaded_file($_FILES["profile_pic"]["tmp_name"], $target_file)) {
            $img_query = ", profile_pic = '$target_file'";
        }
    } 
    elseif (!empty($_POST['social_pic_url'])) {
        $social_url = mysqli_real_escape_string($conn, $_POST['social_pic_url']);
        $img_query = ", profile_pic = '$social_url'";
    }

    // B. DISCOUNT ID PHOTO UPLOAD LOGIC
    if (isset($_FILES['discount_id_pic']) && $_FILES['discount_id_pic']['error'] == 0) {
        $id_target_dir = "uploads/ids/";
        if (!file_exists($id_target_dir)) {
            mkdir($id_target_dir, 0777, true);
        }

        // Burahin ang lumang ID pic kung meron man
        $check_old_id = mysqli_query($conn, "SELECT discount_id_pic FROM create_acc WHERE id = '$user_id'");
        $old_id_res = mysqli_fetch_assoc($check_old_id);
        if (!empty($old_id_res['discount_id_pic']) && file_exists($old_id_res['discount_id_pic'])) {
            unlink($old_id_res['discount_id_pic']);
        }

        $id_file_name = time() . "_id_" . basename($_FILES["discount_id_pic"]["name"]);
        $id_target_file = $id_target_dir . $id_file_name;

        if (move_uploaded_file($_FILES["discount_id_pic"]["tmp_name"], $id_target_file)) {
            $id_pic_query = ", discount_id_pic = '$id_target_file'";
        }
    }

    // --- SOCIAL LINKING LOGIC ---
    $social_query = "";
    if (!empty($_POST['link_google'])) {
        $g_id = mysqli_real_escape_string($conn, $_POST['link_google']);
        $social_query .= ", google_id = '$g_id'";
    }
    if (!empty($_POST['link_fb'])) {
        $f_id = mysqli_real_escape_string($conn, $_POST['link_fb']);
        $social_query .= ", facebook_id = '$f_id'";
    }

    // 3. I-update ang Database
    if (isset($_POST['btn_save_profile'])) {
        $sql = "UPDATE create_acc SET 
                full_name = '$new_name', 
                contact_number = '$new_contact', 
                address_home = '$new_home', 
                address_work = '$new_work',
                discount_type = '$new_discount_type',
                discount_id_no = '$new_discount_id'
                $img_query 
                $id_pic_query
                $social_query 
                WHERE id = '$user_id'";
    } else {
        // Para sa "Sync" buttons lang
        $sql = "UPDATE create_acc SET id = id $img_query $social_query WHERE id = '$user_id'";
    }

    if (mysqli_query($conn, $sql)) {
        if (!empty($new_name)) {
            $_SESSION['user_name'] = $new_name;
        }
        
        $msg = (isset($_POST['btn_save_profile'])) ? "Profile updated successfully!" : "Social account synced successfully!";
        echo "<script>alert('$msg'); window.location='Profile.php';</script>";
    } else {
        echo "Error updating profile: " . mysqli_error($conn);
    }
} else {
    header("Location: Profile.php");
    exit();
}
?>