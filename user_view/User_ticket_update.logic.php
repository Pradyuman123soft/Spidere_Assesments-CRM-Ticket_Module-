<?php
session_start();
if ($_SESSION['is_admin'] == 1 || !isset($_SESSION['is_admin'])){
    die ("Access denied: You are Admin");
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
    $ticket_status = $_POST['ticket_status'];
    $update = $conn->prepare("
    UPDATE ticket_assignments 
    SET status = ?
    WHERE ticket_id = ?;
    ");
    $update->bind_param('si', $ticket_status, $ticket_id);
    if($update->execute()){
        echo "<script>alert('Ticket Updation successfull');
        window.location.href = '../user_view/user_dashboard.php';
        </script>";
    }
    $update->close();
}
?>