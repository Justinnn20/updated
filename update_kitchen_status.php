<?php
include "db_conn.php"; // Siguraduhing tama ang path

if (isset($_POST['id']) && isset($_POST['action'])) {
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $action = $_POST['action'];
    $sql = "";

    switch ($action) {
        case 'start_prep':
            // STEP 1: Mula Pending tungong Preparing[cite: 8]
            $mins = mysqli_real_escape_string($conn, $_POST['mins']);
            $sql = "UPDATE orders SET 
                    status = 'Preparing', 
                    prep_time = '$mins', 
                    prep_start_time = NOW() 
                    WHERE id = '$id'";
            break;

        case 'extend_time':
            // Idadagdag ang extra minutes sa kasalukuyang prep_time[cite: 8]
            $extra_mins = mysqli_real_escape_string($conn, $_POST['extra_mins']);
            $sql = "UPDATE orders SET 
                    prep_time = prep_time + '$extra_mins' 
                    WHERE id = '$id'";
            break;

        case 'finish_prep':
            // STEP 2: Mula Preparing tungong Ready for Dispatch (Delivery)[cite: 8]
            $sql = "UPDATE orders SET status = 'Ready for Dispatch' WHERE id = '$id'";
            break;

        case 'complete_direct':
            // Mula Preparing derechong Completed (Pick-up/Dine-in)[cite: 8]
            $sql = "UPDATE orders SET status = 'Completed' WHERE id = '$id'";
            break;

        case 'handover':
            // STEP 3: Mula Ready for Dispatch tungong On the Way[cite: 8]
            $link = mysqli_real_escape_string($conn, $_POST['link']);
            $sql = "UPDATE orders SET 
                    status = 'On the Way', 
                    tracking_link = '$link' 
                    WHERE id = '$id'";
            break;

        default:
            echo "error: invalid_action";
            exit();
    }

    if (!empty($sql) && mysqli_query($conn, $sql)) {
        echo "success";
    } else {
        echo "error: " . mysqli_error($conn);
    }
}
?>