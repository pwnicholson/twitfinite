<?
unset($_SESSION['user_id']);
session_destroy();

redirect('home');
?>