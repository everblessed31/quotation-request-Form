<?php

include_once 'functions.php';

$request = 0;

if(isset($_POST['request'])){
    $request =preg_replace('#[^0-9]#','',$_POST['request']);
}

//Add Quote
if ($request == 1) {
  
  $requestor = test_input($_POST['requestor']);
  $company = test_input($_POST['company']);
  $location = test_input($_POST['location']); 
  $request_date = test_input($_POST['request_date']);
  $required_date = test_input($_POST['required_date']);
  $item_status = test_input($_POST['item_status']);
   $model_availability = test_input($_POST['model_availability']);
   $ref_no = rand(100000000, 999999999);
   $description = explode(",",$_POST['description']);
   $code = explode(",",$_POST['code']);
   $quantity = explode(",",$_POST['quantity']);  
   $user_id = $_SESSION["user_id"];

   $stmt = $conn->prepare("SELECT name, email FROM users WHERE id = ?");
   $stmt->bind_param("i", $user_id);
   $stmt->execute();
   $stmt->store_result();
   $stmt->bind_result($name, $email);
    $stmt->fetch();
   
   if($requestor !== '' && $company !== '' && $location !== '' && $request_date !== '' && $required_date !== '' && $item_status !== '' && $model_availability !== ''
   && $ref_no !== '' && $description !== '' && $code !== '' && $quantity !== ''){
   
        $stmt = $conn->prepare("INSERT INTO quotes (requestor, company, location, request_date, required_date, item_status, model_availability, ref_no) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssss", $requestor, $company, $location, $request_date, $required_date, $item_status, $model_availability, $ref_no);
        if($stmt->execute()){       

          foreach ($description as $key => $desc) {
            $stmt = $conn->prepare("INSERT INTO quote_items (ref_no, description, code, quantity) VALUES (?, ?, ?, ?)");
          $stmt->bind_param("ssss", $ref_no, $description[$key], $code[$key], $quantity[$key]);
          $stmt->execute(); 
          }

           //Send Email 1
         $to = $email; 
         $subject= "Password Reset Successfully";
         $message = "<p><b>Hello admin,</b></p><p>".$name." submitted a quotation.<br/>View submitted quotation <a href='/quotations/".$ref_no."'>here</a></p><p>Cheers!</p><hr><p>All the best,<br>Support Team</p>";
          $header = "From:noreply@quotation.org.ng \r\n";
          $header .= "MIME-Version: 1.0\r\n";
          $header .= "Content-type: text/html\r\n";                             
         $result = @mail($to, $subject, $message, $header);

         //Send Email 2
         $to2 = $email; 
         $subject2= "Password Reset Successfully";
         $message2 = "<p><b>Hello ".$name.",</b></p><p>Your quotation was well received. You will be contacted in due time<br/>View submitted quotation <a href='/quotations/".$ref_no."'>here</a>.</p><p>Cheers!</p><hr><p>All the best,<br>Support Team</p>";
          $header2 = "From:noreply@quotation.org.ng \r\n";
          $header2 .= "MIME-Version: 1.0\r\n";
          $header2 .= "Content-type: text/html\r\n";                             
         $result2 = @mail($to2, $subject2, $message2, $header2);
          
          echo json_encode( array("status" => 1, "message" => "Success", "ref_no" => $ref_no ) );
          exit;
        }else{
         echo json_encode( array("status" => 0, "message" => "Ooops! SOmething went wrong" ) );
         exit;
        }
  }

}

//Login
if ($request == 2) {

  $email = test_input($_POST["email"]);
  $password = test_input($_POST["password"]);


 if ($email != "" && $password != "") {

   $stmt = $conn->prepare("SELECT id, password FROM users WHERE email = ?");
   $stmt->bind_param("s", $email);
   $stmt->execute();
   $stmt->store_result();
   $stmt->bind_result($user_id, $hash);
  if($stmt->num_rows > 0 ) {
   $stmt->fetch();

     if (password_verify($password, $hash)) {       
        $_SESSION["user_id"] = $user_id;

        echo json_encode( array("status" => 1, "message" => 'Logged in successfully') );
        exit();
      }else{
   echo json_encode( array("status" => 0, "message" => 'Invalid login credentials!') );
   exit;
 } 
 }else{
  echo json_encode( array("status" => 0, "message" => 'User not found!') );
  exit;
} 
}else{
   echo json_encode( array("status" => 0, "message" => 'Please fill all fields.') );
   exit;
 }

}


//Signup
if ($request == 3) {

  $name = test_input($_POST["name"]);
  $email = test_input($_POST["email"]);
  $password = test_input($_POST["password"]);


 if ($name != "" && $email != "" && $password != "") {

  $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $stmt->store_result();
 if($stmt->num_rows == 0 ) {

  $password = password_hash($password, PASSWORD_DEFAULT);

  $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
  $stmt->bind_param("sss", $name, $email, $password);
  if($stmt->execute()){
   echo json_encode( array("status" => 1, "message" => 'Signed up successfully!') );
   exit;
 } 
 }else{
   echo json_encode( array("status" => 0, "message" => 'User already exist. Please login') );
   exit;
 }
}else{
  echo json_encode( array("status" => 0, "message" => 'Please fill all fields.') );
  exit;
}
}



?>