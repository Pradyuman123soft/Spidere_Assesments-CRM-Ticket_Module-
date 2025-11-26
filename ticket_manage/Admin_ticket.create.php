<?php
include('../ticket_manage/Admin_ticket.logic.php');
if(!isset($_GET['user_email'])){
    echo "<script>
    alert('ticket expired');
    window.location.href = '../admin/Admin_dashboard.php';
    </script>";
}
$agent_email = $_GET['user_email'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket Management</title>
    <link rel="stylesheet" href="ticket.style.css">
</head>

<body>
<div class="ticket-container">

    <h2>Create a New Ticket</h2>

    <form action="Admin_ticket.logic.php" method="POST" enctype="multipart/form-data">

        <label for="ticket_name">Ticket Name</label>
        <input type="text" name="ticket_name" id="ticket_name" placeholder="Ticket title..." required>

        <label for="asignee_email">Assign To (Email)</label>
        <input type="email" name="asignee_email" id="asignee_email" value = <?= $agent_email; ?> disabled required>

        <label for="ticket_desc">Description</label>
        <textarea name="ticket_desc" id="ticket_desc" placeholder="Describe the issue..." required></textarea>

        <label for="ticket_status">Status</label>
        <select name="ticket_status" id="ticket_status" disabled>
            <option value="pending" selected>Pending</option>
        </select>

        <label for="ticket_file">Attach File</label>
        <input type="file" name="ticket_file" id="ticket_file">

        <button type="submit" name="submit">Create Ticket</button>

    </form>

</div>

</body>

</html>