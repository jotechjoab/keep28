<?php
session_start();
require 'conn.php';
$userdetails = array();

if (!isset($_SESSION['login_details'])) {
	header("Location:index.php?err=Session Expired Login First!");
}else{
	$userdetails=$_SESSION['login_details'];
	
}
