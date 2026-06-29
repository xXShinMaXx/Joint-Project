<?php
session_start();

// 1. Connect to XAMPP MySQL Database 
$conn = new mysqli("localhost", "root", "", "account", "3307");

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
                    window.location.href = 'login.html';
                  </script>";
            exit();
        } else {
            echo "<script>
                    alert('Registration failed. Please try again.');
                    window.location.href = 'login.html';
                  </script>";
            exit();
        }
    }

    // CASE B: USER LOGIN
    else {
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
                    window.location.href = 'index.html';
                  </script>";
            exit();
        } else {
            echo "<script>
                    alert('Login failed! Incorrect username or password. (ログインに失敗しました。ユーザー名またはパスワードが間違っています。)');
                    window.location.href = 'login.html';
                  </script>";
            exit();
        }
    }
}
$conn->close();