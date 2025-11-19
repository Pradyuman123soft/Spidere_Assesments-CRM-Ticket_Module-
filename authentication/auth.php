<?php
include("../db_con/connection.php");
if($_SERVER["REQUEST_METHOD"]=="POST"){
    $action = $_POST['action'];

    // login logic
    if($action == "login"){
    $email = $_POST['email'];
    $password = $_POST['password'];;

    // using prepare
    $stmt = $conn->prepare("SELECT username,email,password, is_admin FROM user WHERE email = ?");
    $stmt->bind_param("s",$email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 1) {
        $stmt->bind_result($username, $mail, $hashed, $is_admin);
        $stmt->fetch();
        if(password_verify($password,$hashed)){
            session_start();
            $_SESSION['user_loggedIn'] = true;
            $_SESSION['user_name'] = $username;
            $_SESSION['user_email'] = $mail;
            $_SESSION['is_admin'] = $is_admin;
            echo "<script>
            alert('user logged in succesfully');
        </script>";
            if ($is_admin === 1) {
                echo "<script>window.location.href = '../admin/Admin_dashboard.php'</script>";
            }
            else{
                echo "<script>window.location.href = '../user_view/user_dashboard.php'</script>";
            }
        }else {
            echo "<script>
            alert('wrong Password');
            window.location.href = '../authentication/index.auth.php';
        </script>";
        }
    }else{
        echo "<script>
            alert('Email not found');
            window.location.href = '../authentication/index.auth.php';
        </script>";
    }
    $stmt->close();
    }

    // registeration logic
    if($action == "register"){
        $username = $_POST['Name'];
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        // check if user exists
        $check = $conn->prepare("SELECT * FROM user WHERE email = ?");
        $check->bind_param("s",$email);
        $check->execute();
        $check->store_result();

        if ($check->num_rows > 0) {
            echo "<script>alert('user already exists!! please use another email')</script>";
        }
        else {
            $reg = $conn->prepare("INSERT INTO user (username, email, password) VALUES (?,?,?)");
            $reg->bind_param("sss",$username,$email,$password);
            if($reg->execute()){
                session_start();

                $_SESSION['user_loggedIn'] = true;
                $_SESSION['user_name'] = $username;
                $_SESSION['user_email'] = $email;
                $_SESSION['is_admin'] = 0;

                echo "<script>alert('user registered successfully');
                window.location.href = '../user_view/user_dashboard.php';
                </script>";
            }
            else{
                echo "<script>alert('Error user registering');
                window.location.href = '../authentication/index.auth.php';
                </script>";
            }
        }
        $check->close();
    }
}
?>