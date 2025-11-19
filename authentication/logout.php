<?php
session_start();

session_unset();
session_destroy();

header("Location: ../authentication/index.auth.php");
exit();
?>