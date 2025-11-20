<?php
session_start();
if ($_SESSION['is_admin'] == 1 || !isset($_SESSION['is_admin'])) {
    die("Access Denied: You are not admin.");
}
include("../db_con/connection.php");
$author_email = $_SESSION['user_email'];

if(!isset($_GET['user_email'])){
    die ("
    <script>
    window.location.href = '../admin/Admin_dashboard.php'
    </script>
    ");
}
else {
    $user_email = $_GET['user_email'];
    $querry = $conn->prepare("
    SELECT t.ticket_id,t.name,t.description,t.file,t.created_at,a.status,a.updated_at 
    FROM tickets t
    JOIN ticket_assignments a ON t.ticket_id = a.ticket_id
    WHERE t.created_by = ? AND a.assigned_to = ?");
    $querry->bind_param("ss",$author_email,$user_email);
    $querry->execute();
    $result = $querry->get_result();

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User-Tickets</title>
    <link rel="stylesheet" href="Admin_created.ticket.css">
</head>
<body>
    <div class="ticket_container">

    <h2>Assigned Tickets To <?= htmlspecialchars($user_email);?></h2>
    <table>
        <tr>
            <th>ticket_id</th>
            <th>Ticket Name</th>
            <th>Ticket Description</th>
            <th>File</th>
            <th>Status</th>
            <th>Update Ticket</th>
            <th>Assigned At</th>
            <th>Updated At</th>
        </tr>
        <?php  if ($result->num_rows === 0) { ?>
            <h3>No Ticket Assigned Yet</h3>
        <?php } ?>
        <?php while ($row = $result->fetch_assoc()){ ?>
            <tr>
            <td><?=$row['ticket_id']; ?></td>
            <td><?=htmlspecialchars($row['name']); ?></td>
            <td><?=htmlspecialchars($row['description']); ?></td>
            <td>
            <?php if ($row['file']) { ?>
                <a href="../uploads/<?= $row['file']; ?>" download>Download</a>
            <?php } else { echo "No File"; } ?>
            </td>

            <td><?=htmlspecialchars($row['status']); ?></td>
            <td>
                <a href="../admin/Admin_ticket.update.php?ticket_id=<?= $row['ticket_id'] ?>">Update Ticket</a>
            </td>
            <td><?=htmlspecialchars($row['created_at']); ?></td>
            <td><?=htmlspecialchars($row['updated_at']); ?></td>
        </tr>
        <?php } ?>
    </table>
    
</div>
</body>
</html>