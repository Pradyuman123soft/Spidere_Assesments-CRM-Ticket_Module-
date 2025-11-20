<?php
session_start();

if ($_SESSION['is_admin'] != 1 || !isset($_SESSION['is_admin'])) {
    die("Access Denied: You are not admin.");
}
$created_by = $_SESSION['user_email'];
include("../db_con/connection.php");

if ($_SERVER['REQUEST_METHOD']=='POST') {
    $ticket_name = $_POST['ticket_name'];
    $asignee_email = $_POST['asignee_email'];
    $ticket_desc = $_POST['ticket_desc'];
    $ticket_file = null;

    // FILE UPLOAD HANDLING
    $file_name = $_FILES['ticket_file']['name'];            // actual file name
    $file_tmp = $_FILES['ticket_file']['tmp_name'];        // temporary location
    $file_new_name = time() . "_" . $file_name;            // rename file
    $upload_path = "../uploads/" . $file_new_name;         // folder path

    // Make sure folder exists
    if (!is_dir("../uploads")) {
        mkdir("../uploads", 0777, true);
    }

    // Move file to uploads folder
    if (move_uploaded_file($file_tmp, $upload_path)) {
        $ticket_file = $file_new_name;
    } else {
        die("File Upload Failed!" . $_FILES['ticket_file']['error']);
    }
    // check the asignee is available or not
    $check = $conn->prepare("SELECT email FROM user where email = ?");
    $check->bind_param("s",$asignee_email);
    $check->execute();
    $check->store_result();
    if ($check->num_rows != 1) {
        echo "
        <script>
        alert('User Not Avaliable In database');
        window.location.href = '../ticket_manage/Admin_ticket.create.php';
        </script>
        ";
        exit();
    }
    
    else {
        $ticket = $conn->prepare("INSERT INTO tickets (name, description, file, created_by ) VALUES (?,?,?,?)");
        $ticket->bind_param("ssss",$ticket_name, $ticket_desc, $ticket_file, $created_by);
        if($ticket->execute()){
            $ticket_id = $ticket->insert_id;

            // now lets assign this ticket to user
            $asigne = $conn->prepare("INSERT INTO ticket_assignments (ticket_id, assigned_to) VALUES (?,?)");
            $asigne->bind_param("is",$ticket_id, $asignee_email);
            $asigne->execute();

            echo "<script>
            alert('Ticket Created successfully!!');
            window.location.href = '../admin/Admin_dashboard.php';
            </script>";
        };
        $ticket->close();
    }
    $check->close();
}
?>