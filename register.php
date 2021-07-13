<?php
 include 'conn.php';

  // an array to display response
 $response = array();
 // on below line we are checking if the parameter send is id or not.
 if($_POST['fullname']){
     // if the parameter send from the user id id then
     // we will search the item for specific id.
     $fullname = $_POST['fullname'];
     $email = $_POST['email'];
     $phone = $_POST['phone'];
     $password = md5($_POST['password']);
     $role="Member";
     $status="Inactive";
        //on below line we are selecting the course detail with below id.
     $stmt = $conn->prepare("INSERT INTO users (name,phone,email,passwd,role,status) VALUES (?,?,?,?,?,?)");
     $stmt->bind_param("ssssss",$fullname,$phone,$email,$password,$role,$status);
     $result = $stmt->execute();
   // on below line we are checking if our 
   // table is having daata with specific id. 
   if($result == TRUE){
         // if we get the respone then we are displaying it below.
         $response['error'] = false;
         $response['message'] = "Registration Successful!";
         $response['Fullname']=$fullname;
         // on below line we are getting our result. 
         $stmt->store_result();
         // on below line we are passing parameters which we want to get.
         // $stmt->bind_result($fullname,$email,$password,$role,$status);
         // on below line we are fetching the data. 
         $stmt->fetch();
         // after getting all data we are passing this data in our array.
         // $response['fullname'] = $courseName;
         // $response['courseDescription'] = $courseDescription;
         // $response['courseDuration'] = $courseDuration;
     } else{
         // if the id entered by user donot exist then 
         // we are displaying the error message
         $response['error'] = true;
         $response['message'] = "Sorry An a Error Happened ".mysqli_error($conn);
         $response['Fullname']=null;
     }
 } else{
      // if the user donot adds any paramter while making request
      // then we are displaying the error as insufficient parameters.
      $response['error'] = true;
      $response['message'] = "Insufficient Parameters Enter All Values ";
      $response['Fullname']=null;
 }
 // at last we are printing 
 // all the data on below line. 
 echo json_encode($response);
?>