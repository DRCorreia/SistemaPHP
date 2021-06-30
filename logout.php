<?php
    unset($_SESSION['login']);
	unset($_SESSION['senha']);
	unset($_SESSION['permissao']);
	header('location:login.php');
?>