<?php
session_start();

if($_SESSION['is_admin'] != 1 || !isset($_SESSION['is_admin'])){
    die("Access Denied: You are not admin.");
}

include("../db_con/connection.php");

$result = $conn->query("SELECT username, email FROM user WHERE is_admin = 0");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../admin/admin.style.css">
</head>
<body>

<div class="container">

    <!-- sidebar -->
    <aside class="sidebar">
        <h2 class="logo">Admin Panel</h2>
        <ul>
            <li class="active">Dashboard</li>
            <li id="Create_ticket">Create Ticket</li>
            <li id="logout">Logout</li>
        </ul>
    </aside>

    <!-- Main Content -->
    <main class="main-content">

        <header class="topbar">
            <h2>Dashboard</h2>
            <p>Welcome, <?= $_SESSION['user_name'] ?> 👋</p>
        </header>

        <section class="table-section">
            <h3>All Registered Users</h3>

            <table>
                <thead>
                    <tr id="tableHead">
                        <th>Name</th>
                        <th>Email</th>
                        <th>All Tickets</th>
                    </tr>
                </thead>

                <tbody>
                    <?php while($row = $result->fetch_assoc()) { ?>
                        <tr>
                            <td><?= $row['username'] ?></td>
                            <td><?= $row['email'] ?></td>
                            <?php 
                            $created_by = $_SESSION['user_email'];
                            $assign_to = $row['email'];
                            $ticket = $conn->query("
                            SELECT t.ticket_id, a.ticket_id 
                            FROM tickets t 
                            JOIN ticket_assignments a ON t.ticket_id = a.ticket_id 
                            WHERE t.created_by= '$created_by' AND a.assigned_to = '$assign_to'
                            "); ?>
                            <?php  if($ticket->num_rows === 0) { ?>
                                <td>No Ticket</td>
                            <?php } else { ?>
                                <td>
                                    <a href="../ticket_manage/Admin_created_tickets.php?user_email=<?= $row['email'] ?>">View Tickets</a>
                                </td>
                            <?php } ?>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>

        </section>
    </main>

</div>
<script>
    document.querySelector("#logout").addEventListener("click",()=>{
    window.location.href = "../authentication/logout.php";
})
    document.querySelector("#Create_ticket").addEventListener("click",()=>{
        window.location.href = '../ticket_manage/Admin_ticket.create.php';
    })
</script>
</body>
</html>
