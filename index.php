<?php  
include_once 'functions.php';

if (isset($_SESSION['user_id'])) {   
  $user_id = $_SESSION['user_id'];
  }else{
    header('location: ./login');
    exit();
  }


?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <title>Home Page</title>
  </head>
  <body>
  <div class="wrapper">
    <div class="main">

    <?php  include_once 'components/sidebar.php'; ?>

    <div class="content">

<div class="container">

<h4 class="text-center mb-3">All Price Quote Request</h4>

<a href="new-quotation" class="btn btn-primary mb-3">Make a quote request</a>

  <div class="table-responsive">
<table class="table table-bordered">
  <thead>
    <tr>
      <th>S/N</th>
      <th>Company</th>
      <th>Quantty</th>
      <th>Reference</th>
      <th>Required Date</th>
      <th>Date Requested</th>
    </tr>
  </thead>
  <tbody>
  <?php 
  $stmt = $conn->prepare("SELECT company, request_date, required_date, ref_no FROM quotes");
  $stmt->execute();
  $stmt->store_result();
  $stmt->bind_result($company, $request_date, $required_date, $ref_no);
  if($stmt->num_rows > 0 ) {     
$sn = 0;
$total = 0;
while($stmt->fetch()){
$sn++;

$stmt1 = $conn->prepare("SELECT quantity FROM quote_items WHERE ref_no = ?");
$stmt1->bind_param("s", $ref_no);
$stmt1->execute();
$stmt1->store_result();
$stmt1->bind_result($quantity);
if($stmt1->num_rows > 0 ) {
while($stmt1->fetch()){
 $total += $quantity;
}}

  echo '<tr>
    <td>'.$sn.'</td>
    <td><a href="quotations/'.$ref_no.'">'.$company.'</a></td>
    <td>'.$total.'</td>
    <td><a href="quotations/'.$ref_no.'">'.$ref_no.'</a></td>
    <td>'.$required_date.'</td>
    <td>'.$request_date.'</td>
  </tr>';

  } }else{
    echo '<tr>
    <td colspan="6">No quotation found!</td>
    </tr>';
  }
  ?>
</tbody>
</table>
  </div>

    </div>
  </div>

    <script src="js/script.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>
