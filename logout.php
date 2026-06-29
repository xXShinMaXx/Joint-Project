<?php
session_start();

$_SESSION = array();

session_destroy();

echo "<script> alert ('You have succesfully ログアウト.');
    window.location.href = 'login.html';
    </script>";

exit();