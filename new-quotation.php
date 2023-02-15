<?php
include_once 'functions.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <link rel="stylesheet" href="css/style.css" />
  <link rel="stylesheet" href="css/bootstrap.min.css" />
  <title>Price Quote Request</title>
</head>

<body>
  <div class="wrapper">
    <div class="main">

      <!-- <?php include_once 'components/sidebar.php'; ?> -->

      <div class="content">

        <div class="container">
          <h1>Price Quote Request</h1>

          <form id="quote-form" class="row g-3 needs-validation" novalidate>
            <div class="col-12">
              Requestor: <input type="text" id="requestor" class="form-control" placeholder="Enter your full name" required>
              <div class="invalid-feedback">
                Requestor's name is required!
              </div>
            </div>

            <div class="col-md-6">
              Company: <select name="company" id="company" class="form-control" required>
                <option value="select company ">Select Company</option>
                <option value="ESRNL">ESRNL</option>
                <option value="NPRL">NPRL</option>
                <option value="PRNL">PFNL</option>
                <option value="NEW BISCO">New Bisco </option>
                <option value="PRIME BISCO">Prime Bisco</option>
              </select>
              <div class="invalid-feedback">
                Company's name is required!
              </div>
            </div>

            <div class="col-md-6">
              Location: <select name="location" id="location" class="form-control" required>
                <option value="select location">Select Your Location</option>
                <option value="FACTORY">Factory</option>
                <option value="IKOYI">Ikoyi</option>
                <option value="APAPA">Apapa</option>
              </select>
              <div class="invalid-feedback">
                Location is required
              </div>
            </div>

            <div class="col-md-6">
              Requested Date: <input type="date" value="<?php echo Date("Y-m-d") ?>" id="request_date" class="form-control" placeholder="Select date" required>
              <div class="invalid-feedback">
                Date requested is required!
              </div>
            </div>

            <div class="col-md-6">
              Required date: <input type="date" id="required_date" class="form-control" placeholder="Select date" required>
              <div class="invalid-feedback">
                Date required is required!
              </div>
            </div>

            <div class="col-md-6">
              <p>Availability Status:</p>
              <input type="radio" id="Yes" name="item_status" value="Yes">
              <label for="html">Yes</label> <br>
              <input type="radio" id="Yes" name="item_status" value="No">
              <label for="css">No</label> <br>
              <div class="invalid-feedback">
                Please select availability status!
              </div>
            </div>

            <div class="col-md-6 mb-3">
              <p>Replacement model availability:</p>
              <input type="radio" id="Yes" name="model_availability" value="Yes">
              <label for="html">Yes</label> <br>
              <input type="radio" id="Yes" name="model_availability" value="No">
              <label for="css">No</label> <br>
              <div class="invalid-feedback">
                Please select replacement model availability status!
              </div>
            </div>


            <div class="col-12">
              <button class="btn btn-primary mb-3" type="submit" id="add-quote">Proceed</button>
            </div>
          </form>
          <br />

          <div id="item-box" style="display: none;">
            <form id="item-form" class="row g-3 needs-validation" novalidate>

              <div class="col-md-3">
                <input type="text" id="description" class="form-control" placeholder="Enter item description" required>
                <div class="invalid-feedback">
                  Looks good!
                </div>
              </div>

              <div class="col-md-3">
                <input type="text" id="code" class="form-control" placeholder="Enter item code number" required>
                <div class="invalid-feedback">
                  Looks good!
                </div>
              </div>

              <div class="col-md-3">
                <input type="number" id="quantity" class="form-control" placeholder="Enter quantity" required>
                <div class="invalid-feedback">
                  Looks good!
                </div>
              </div>


              <div class="col-md-3">
                <input type="file" id="image" accept="image/png, image/gif, image/jpg" , class="form-control" placeholder="Enter item image" required autocomplete="off">
                <div class="invalid-feedback">
                  Looks good!
                </div>
              </div>

              <div class="col-12">
                <button class="btn btn-primary mb-3" type="submit" id="add-item">Add item</button>
              </div>
            </form>
            <br />

            <div class="table-responsive">
              <table class="table table-bordered" id="quoteTable">
                <thead>
                  <thead>
                    <tr>
                      <th></th>
                      <th>ITEM DESCRIPTION</th>
                      <th>ITEM CODE</th>
                      <th>QUANTITY</th>
                      <th>ITEM IMAGE</th>
                    </tr>
                  </thead>
                <tbody id="tableBody">
                </tbody>
                <tfoot>
                  <tr>
                    <td colspan="4"><button class="btn btn-primary" type="button" id="delete-row">Delete
                        Row</button></td>
                  </tr>
                </tfoot>
              </table>
            </div>

            <div class="col-12">
              <button class="btn btn-primary mb-3" id="submit-quote" type="button" name="send" disabled>Submit quotation</button>
            </div>

          </div>

        </div>
      </div>
    </div>




    <script src="js/jquery-3.6.3.min.js"></script>
    <script src="js/script.js"></script>
    <script src="js/quotation.js"></script>
    <script src="js/bootstrap.min.js"></script>

</body>

</html>