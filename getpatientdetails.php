<?php

require 'conn.php';

$id=$_POST['id'];
//$row = array();
$get=mysqli_query($conn,"SELECT * FROM patient_details WHERE id='$id'");

$row=mysqli_fetch_array($get);

echo json_encode($row);