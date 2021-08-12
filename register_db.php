<?php
    session_start();
    include('connection.php');

    if (isset($_POST['submit'])) {

        if ($_POST['password'] != $_POST['confirm_password']) {
            $_SESSION['err_password'] = "password ไม่ตรงกัน";
            header('location: register.php');
        }
        else {
            $firstname = mysqli_real_escape_string($conn, $_POST['firstname']);
            $lastname = mysqli_real_escape_string($conn, $_POST['lastname']);
            $email = mysqli_real_escape_string($conn, $_POST['email']);
            $password = mysqli_real_escape_string($conn, $_POST['password']);
            $hash = password_hash($password, PASSWORD_DEFAULT);

            $query = "SELECT COUNT(email) AS count_email FROM users WHERE email = '$email'";
            $result = mysqli_query($conn, $query);
            $row = mysqli_fetch_assoc($result);

            if ($row['count_email'] == 0) {
                $query = "INSERT INTO users (firstname, lastname, email, password, status) VALUES ('$firstname', '$lastname', '$email', '$hash', 'U')";
                $result = mysqli_query($conn, $query);
        
                if ($result) {
                    header('location: index.php');
                }
                else {
                    $_SESSION['err_query'] = "query ผิดพลาด";
                    header('location: register.php');
                }
            }
            else {
                $_SESSION['exist_email'] = "มีอีเมลนี้ในระบบ";
                header('location: register.php');
            }
    
            
        }
    }