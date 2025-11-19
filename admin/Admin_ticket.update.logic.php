<?php
session_start();
if($_SESSION['is_admin']!=1){
    die ("Access denied: You are not Admin");
}
if(!isset($_SESSION['user_email'])){
    echo "<script>alert('You are Not Logged In')</script>";
    header("Location:../authentication/index.auth.php");
}

include('../db_con/connection.php');
// check that user sends the tickt id or not
if(!isset($_GET['ticket_id'])){
    echo "<script>
    alert('Ticket has expired');
    window.location.href = '../user_view/user_dashboard.php';
    </script>";
}

$ticket_id = $_GET['ticket_id'];

if($_SERVER['REQUEST_METHOD']=='POST'){
    $ticket_name = $_POST['ticket_name'];
    $ticket_desc = $_POST['ticket_desc'];
    $ticket_status = 'pending';
    $ticket_file = null;

    // FILE UPLOAD HANDLING
    $file_name = $_FILES['ticket_file']['name'];            // actual file name
    $file_tmp = $_FILES['ticket_file']['tmp_name'];        // temporary location
    $file_new_name = time() . "__" . $file_name;            // rename file
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

    $update = $conn->prepare("
    UPDATE tickets t
    JOIN ticket_assignments a ON a.ticket_id = t.ticket_id
    SET 
    t.name = ?,
    t.description=?,
    t.file=?,
    a.status=?,
    a.updated_at = NOW()
    WHERE t.ticket_id = ?;
    ");
    $update->bind_param('ssssi', $ticket_name, $ticket_desc, $ticket_file, $ticket_status, $ticket_id);
    if($update->execute()){
        echo "<script>alert('Ticket Updation successfull');
        window.location.href = '../ticket_manage/Admin_created_tickets.php';
        </script>";
    }
    $update->close();
}
?>