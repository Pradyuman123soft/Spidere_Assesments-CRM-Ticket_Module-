<?php
include("../db_con/connection.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRM-Ticket Module</title>
    <link rel="stylesheet" href="../authentication/auth.style.css">
</head>
<body>
    <div class = "main">
    <header class="heading">
        <h2>CRM -Ticket Module</h2>
        <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Asperiores a ipsam.</p>
    </header>
    <main class="SignupForm">
        <section>
        <form action = "../authentication/auth.php" method="post" id="LoginForm" class="formRegister view">
            <input type="hidden" name="action" value="login">
            <label for="email">Enter you email</label>
            <input type="email" name="email" id="logemail" placeholder="example@gmail.com" required>
            <label for="password">Enter you password</label>
            <input type="password" name="password" id="logpassword" placeholder ="enter you placeholder" required>
            <button type="submit">Login</button>
            <p>Don't have an account? <a href="#" class="color registerToggle">Register Here</a></p>
        </form>
        </section>
        <section>
        <form action = "../authentication/auth.php" method="post" id="RegisterForm" class="formRegister hidden">
            <input type="hidden" name="action" value="register">
            <label for="name">Enter User name</label>
            <input type="text" name="Name" id="regname" placeholder = "Enter your name here..." required>
            <label for="email">Enter you email</label>
            <input type="email" name="email" id="regemail" placeholder="example@gmail.com" required>
            <label for="password">Enter you password</label>
            <input type="password" name="password" id="regpassword" placeholder ="enter you placeholder" required>
            <button type="submit">Register</button>
            <p>have an account?<a href="#" class="color loginToggle">Login Here</a></p>
        </form>
        </section>
    </main>
    </div>
    <script src="../authentication/auth.script.js"></script>
</body>
</html>