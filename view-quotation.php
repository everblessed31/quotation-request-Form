<?php  

include_once 'functions.php';

 if (isset($_GET['ref'])) {
  $ref_no = test_input($_GET['ref']);
 }else{
  echo "Invalid reference ID";
  exit;
 }

 $stmt = $conn->prepare("SELECT requestor, company, location, request_date, required_date, item_status, model_availability FROM quotes WHERE ref_no = ?");
 $stmt->bind_param("s", $ref_no);
 $stmt->execute();
 $stmt->store_result();
 $stmt->bind_result($requestor, $company, $location, $request_date, $required_date, $item_status, $model_availability);
 if($stmt->num_rows > 0 ) {
  $stmt->fetch();

 }else{
  echo "Invalid reference number";
  exit;
 }

?>

<!DOCTYPE html>
<html lang="en">

<head>
     <base href="/quotation-request-Form/">
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Price Quote Request</title>
  <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="css/bootstrap.min.css" />
</head>

<body>
<div class="wrapper">
    <div class="main">

    <!-- <?php  include_once 'components/sidebar.php'; ?> -->

    <div class="content">

<div class="container">
   <h4 class="text-center">Price Quote Request</h4>


   <div class="table-responsive">
<table class="table table-bordered">
    <tr>
      <th>Requestor</th>
      <td colspan="3"><?php echo $requestor; ?></td>
    </tr>

    <tr class="tableRow1">
      <th>Company</th>
      <td><?php echo $company; ?></td>
      <th>Location</th>
      <td><?php echo $location; ?></td>
    </tr>

    <tr>
      <th>Request Date</th>
      <td><?php echo $request_date; ?></td>
      <th>Required date</th>
      <td><?php echo $required_date; ?></td>
    </tr>

    <tr>
      <th>Other requirements:</th>
      <td colspan="2">Item availability status
        <hr>Replacement model availability</td>

      <td><?php echo $item_status; ?>
        <hr><?php echo $model_availability; ?></td>
    </tr>

  </table>
   </div>
  

   <div class="table-responsive">
<table class="table table-bordered" id="quoteTable">
    <thead>
      <tr>
        <th>S/N</th>
        <th class="itemDes">ITEM DESCRIPTION</th>
        <th>ITEM CODE</th>
        <th>QUANTITY</th>
      </tr>
    </thead>
    <tbody id="tableBody">
      <?php 
    $stmt = $conn->prepare("SELECT description, code, quantity FROM quote_items WHERE ref_no = ?");
 $stmt->bind_param("s", $ref_no);
 $stmt->execute();
 $stmt->store_result();
 $stmt->bind_result($description, $code, $quantity);
 $total = 0;
 if($stmt->num_rows > 0 ) {
  $sn = 0;
while($stmt->fetch()){
  $sn++;
  $total += $quantity;
echo "<tr>
<td>".$sn."</td>
<td>".$description."</td>
<td>".$code."</td>
<td>".$quantity."</td>
</tr>";
  }}else{
    echo '<tr>
<td colspan="4">No quote item found!</td>';
  }

  ?>

    </tbody>
  </table>
   </div>

 

<a href="download-quotation/<?php echo $ref_no; ?>" class="btn btn-primary mb-3">Download quotation</a>
<br/>


  <script src="js/jquery-3.6.3.min.js"></script>
<script src="js/script.js"></script>
    <script src="js/bootstrap.min.js"></script>

</body>

</html>