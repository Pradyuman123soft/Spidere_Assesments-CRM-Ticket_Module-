<?php
session_start();

if ($_SESSION['is_admin'] == 1) {
    die("Access Denied: You are admin.");
    header ("Location :../admin/Admin_dashboard.php");
}
if(!isset($_SESSION['user_email'])){
    die("<script>
    alert('You are not Logged IN');
    window.location.href = '../authentication/index.auth.php';
    </script>");
}

include("../db_con/connection.php");
$user_email = $_SESSION['user_email'];

$result = $conn->query("
SELECT t.ticket_id,t.name, t.description, t.file, t.created_by, t.created_at, a.status 
FROM tickets t 
JOIN ticket_assignments a ON t.ticket_id = a.ticket_id
where a.assigned_to = '$user_email'
");
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
        <h2 class="logo">User Panel</h2>
        <ul>
            <li class="active">Dashboard</li>
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
            <h3>All Tickets</h3>

            <table>
                <thead>
                    <tr id="tableHead">
                        <th>Ticket Name</th>
                        <th>Author Email</th>
                        <th>Description</th>
                        <th>Ticket File</th>
                        <th>Status</th>
                        <th>Created At</th>
                        <th>Update Ticket</th>
                    </tr>
                </thead>

                <tbody>
                    <?php  if ($result->num_rows === 0) { ?>
                        <h3>No Ticket Assigned Yet</h3>
                    <?php } ?>
                    <?php while($row = $result->fetch_assoc()) { ?>
                        <tr>
                            <td><?= $row['name']; ?></td>
                            <td><?= $row['created_by']; ?></td>
                            <td><?= $row['description']; ?></td>
                            <td>
                                <?php if ($row['file']) { ?>
                                    <a href="../uploads/<?= $row['file']; ?>" download>Download</a>
                                <?php } else { echo "No File"; } ?>
                            </td>
                            <td><?= $row['status']; ?></td>
                            <td><?= $row['created_at']; ?></td>
                            <td>
                                <a href="../user_view/user_update.ticket.php?ticket_id=<?= $row['ticket_id']; ?>">update Tickets</a>

                            </td>
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
</script>
</body>
</html>
