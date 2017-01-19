<?php
include 'session.php';
$user_id = $_SESSION['user_id'];
session_destroy();
header('Location: .');
?>