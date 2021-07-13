<?php
 include 'conn.php';

  // an array to display response
 $response = array();
 // on below line we are checking if the parameter send is id or not.
 if(isset($_POST['username'])){
     // if the parameter send from the user id id then
     // we will search the item for specific id.
     $username = $_POST['username'];
     $password = md5($_POST['password']);
     //$status="";
        //on below line we are selecting the course detail with below id.
     $stmt = mysqli_query($conn,"SELECT * FROM users WHERE username='$username' AND password='$password'");
     
   // on below line we are checking if our 
   // table is having daata with specific id. 
   if(mysqli_num_rows($stmt)>0){
         // if we get the respone then we are displaying it below.
         $results=mysqli_fetch_array($stmt);
   session_start();
   $_SESSION['login_details']=$results;
   header("Location:home.php");
     }else{
        header("Location:index.php?err=Wrong Username Or Password Entered".mysqli_error($conn));
     }
     } else{
       header("Location:index.php?err=Wrong Username Or Password Entered");
     }
 
?>