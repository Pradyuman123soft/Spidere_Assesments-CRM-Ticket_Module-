<?php
// include('../ticket_manage/ticket.logic.php')
session_start();
if($_SESSION['is_admin'] != 1 || !isset($_SESSION['is_admin'])){
    die ("Access Denied:That's Not Your Page, You are not Admin");
}
include("../db_con/connection.php");
$user_email = $_SESSION['user_email'];
if(!isset($_GET['ticket_id'])){
    die ("<script>
    window.location.href='../ticket_manage/Admin_created_tickets.php';
    </script>");
}
$ticket_id = $_GET['ticket_id'];
$ticket = $conn->prepare("
SELECT t.name,t.description,t.file,t.created_by,a.status
FROM tickets t
JOIN ticket_assignments a ON t.ticket_id = a.ticket_id
WHERE t.ticket_id = ? AND a.ticket_id = ?
");
$ticket->bind_param('ii',$ticket_id,$ticket_id);
$ticket->execute();
$ticket->store_result();
if ($ticket->num_rows == 1) {
    $ticket->bind_result($ticket_name, $ticket_desc, $ticket_file, $ticket_created, $ticket_status);
    $ticket->fetch();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket Management</title>
    <link rel="stylesheet" href="../ticket_manage/ticket.style.css">
    <style>
        #download{
            padding-bottom: 10px;
        }
    </style>
</head>

<body>
<div class="ticket-container">

    <h2>Create a New Ticket</h2>

    <form action="Admin_ticket.update.logic.php?ticket_id=<?= $ticket_id ?>" method="POST" enctype="multipart/form-data">

        <label for="ticket_name">Ticket Name</label>
        <input type="text" name="ticket_name" id="ticket_name" value = <?= $ticket_name?>>

        <label for="asignee_email">Author (Email)</label>
        <input type="email" name="asignee_email" id="asignee_email"  value = <?= $ticket_created?> disabled>

        <label for="ticket_desc">Description</label>
        <textarea name="ticket_desc" id="ticket_desc"><?= htmlspecialchars($ticket_desc) ?></textarea>

        <label for="ticket_status">Status</label>
        <select name="ticket_status" id="ticket_status">
            <option value="pending" selected disabled>Pending</option>
        </select>
        <label for="ticket_file">Attach File</label>
        <input type="file" name="ticket_file" id="ticket_file" value = <?= $ticket_file?>>

        <button type="submit" name="submit">Update Ticket</button>

    </form>

</div>

</body>

</html>