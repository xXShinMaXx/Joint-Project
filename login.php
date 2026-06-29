<?php

session_start();

// 1. Connect to XAMPP MySQL Database 
if ($_SERVER['HTTP_HOST'] ==  'localhost' || $_SERVER['SERVER_ADDR'] == '127.0.0.1') {
    $conn = new mysqli("localhost", "root", "", "user", "3306");
} else {
    //FREE LIVE HOST DATABASE
    $conn = new mysqli("sql108.infinityfree.com", "if0_42294725", "KGPh993Wf4", "if0_42294725_user");
}

// Check if connection fails
if ($conn->connect_error) {
    die("❌ Connection failed: " . $conn->connect_error);
}

// 2. Process data when a form is submitted via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // CASE A: USER SIGN UP (REGISTRATION)
    if (isset($_POST['action']) && $_POST['action'] === 'register') {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        //  Insert into table
        $sql = "INSERT INTO user (username, email, password) VALUES ('$username', '$email', '$password')";

        if ($conn->query($sql) === TRUE) {
            echo "<script>
                    alert('Registration successful! Your account is saved.');
                    window.location.href = 'auth.html';
                  </script>";
            exit();
        } else {
            echo "<script>
                    alert('Registration failed. Please try again.');
                    window.location.href = 'auth.html';
                  </script>";
        }
    }

    // CASE B: USER LOGIN
    else if (isset($_POST['action']) && $_POST['action'] === 'login') {
        $username = $_POST['username'];
        $password = $_POST['password'];

        // ⚠️ Queries your exact table name: user
        $sql = "SELECT * FROM user WHERE username = '$username' AND password = '$password'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // MATCH FOUND! Save session data
            $_SESSION['username'] = $username;

            echo "<script>
                    alert('Login successful! Welcome back, " . $username . ".(ログインに成功せいこうしました！)');
                    window.location.href = 'index.php';
                  </script>";
            exit();
        } else {
            echo "<script>
                    alert('Login failed! Incorrect username or password. (ログインに失敗しました。ユーザー名またはパスワードが間違っています。)');
                    window.location.href = 'auth.html';
                  </script>";
            exit();
        }
    }
}
$conn->close();