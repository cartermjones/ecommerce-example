<?php

  require_once('../backend/ShoppingUtilities.class.php');
  require_once('../backend/Cart.class.php');
  require_once('../backend/Customer.class.php');
  require_once('../backend/Address.class.php');

  session_start();

  $order_placed = false;
  if (isset($_POST['my_submit'])) {
    $order_placed = true;
  }

  $subtotal = number_format($_SESSION['cart']->getSubtotal(), 2);
  $salestax = number_format($_SESSION['cart']->getSalesTax(), 2);
  $overalltotal = number_format($_SESSION['cart']->getOverallTotal(), 2);

?>
<!doctype html>
<html lang="en">
  <head>
    <title>The Classics.COM</title>
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css?family=Cookie" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
  </head>
  <body>
    <div class="container">
      <div class="row">
	<div class="col-md-12">
          <h1 class="text-center" style="font-family: Cookie">The Classics</h1>
          <h5 class="text-center" style="font-family: Cookie">&copy; David Blackburn &amp; Carter Jones</h5>
        </div>
      </div>
      <div class="row">
	<div class="col-md-2">
	  <ul class="nav nav-pills">
	    <li class="nav-item">
               <a class="nav-link" href="shopping.php">Home</a>
            </li>
	    <li class="nav-item">
	       <a class="nav-link" href="cart.php">Cart <span class="badge badge-primary"><i class="fa fa-shopping-cart"></i> <?php echo $order_placed ? 0 : $_SESSION['cart']->getTotalQuantity(); ?></span></a>
            </li>
	    <li class="nav-item">
	       <a class="nav-link<?php if ($order_placed) { echo ' disabled'; }?>" href="checkout.php">Checkout</a>
            </li>
          </ul>
	  <!-- Include Left Navigation Panel -->
	</div>
        <div class="col-md-10">
          <div class="panel panel-danger spaceabove"> <!-- Inventory Panel -->
             <?php if(!$order_placed) { ?>
	     <div class="panel-heading"><h4>Checkout</h4></div>
             <table class="table">
	       <tr>
                  <th class="text-center">Image</th> <!-- Hmm... -->
                  <th>Book</th>
		  <th>Price</th>
                  <th>Quantity</th>
                  
	       </tr>
                  <?php
                   $selections = $_SESSION['cart']->getSelectionList();
                   foreach ($selections as $selection) {
                     echo '<tr>';
		     echo '<td class="text-center"><img height="218px" src="../inventory/images/'.$selection->getInventoryItem()->getImagePath().'" /></td>';
		     echo '<td>'.$selection->getInventoryItem()->getName().'</td>';
		     echo '<td>$'.number_format($selection->getInventoryItem()->getAmount(), 2).'</td>';
		     echo '<td>'.$selection->getQuantity().'</td>';
		     echo '</tr>';

                   }
                  ?>
	     </table> 
             <?php
		 echo "<h6>Subtotal: $$subtotal</h6>";
                 echo "<h6>Shipping: FREE</h6>";
		 echo "<h6>Sales Tax: $$salestax</h6>";
		 echo "<h6>Overall Total: $$overalltotal</h6>";
             ?>
             <br>
             <form method="post" action="checkout.php"><!-- Form for submitting customer information -->
                <!--<div class="col-md-10">-->
                    <div class="panel spaceabove"><!--Checkout Panel--> 
                        <div class="panel-heading"><h4>Customer & Payment Information</h4></div>         
			<div class="row">
                          <div class="form-group col-sm-5">
                              <label for="fname">First Name:</label> 
                              <input name="fname" type="text" class="form-control" id="fname" required>
                          </div>
                          <div class="form-group col-sm-5">
                              <label for="lname">Last Name:</label>
                              <input name="lname" type="text" class="form-control" id="lname" required>
			  </div>
			</div>
                        <div class="row">
                          <div class="form-group col-sm-10">
                              <label for="addressLine">Shipping Address:</label>
                              <input name="addressLine" type="text" class="form-control" id="address-line" required>
		  	  </div>
                        </div>
                        <div class="row">
                          <div class="form-group col-sm-4">
                              <label for="city">City:</label>
                              <input name="city" type="text" class="form-control" id="city" required>
                          </div>
                          <div class="form-group col-sm-3">
                              <label for="state">State:</label>
                              <input name="state" type="text" class="form-control" id="state" required>
                          </div>
                          <div class="form-group col-sm-3">
                              <label for="zipcode">ZIP Code:</label>
                              <input name="zipcode" type="txt" class="form-control" id="zipcode" required>
		  	  </div>
			</div>
                        <div class="row">
                          <div class="form-group col-sm-10">
                              <label for="select-1">Payment Method (Select One):</label>
                              <select name="paymentMethod" class="form-control" id="select-1" required>
                                  <option>Credit</option>
                                  <option>Debit</option>
                                  <option>Check</option>
                                  <option>Money Order</option>
                                  <option>Barter (no livestock, please)</option>
                              </select>
                          </div>
                        </div>
                    </div><!-- End Checkout Panel -->
                    <input type="submit" value="Place Order" name="my_submit" class="btn btn-primary">
              <!--  </div> --> <!-- End col-md-10 -->
             </form> <!--End customer information form -->
             <?php
                $newCustomer = new Customer(null, null, null);
                $_SESSION['customer'] = $newCustomer;
              }
              //Once we have our customer, we fetch the necessary information and display our sales information.
               else{
                $fname = $_POST['fname'];
                $lname = $_POST['lname'];
                $paymentMethod = $_POST['paymentMethod'];
                $customer = new Customer($fname, $lname, $paymentMethod);
                $_SESSION['customer'] = $customer;
		$newAddress = new Address($_POST['addressLine'], $_POST['city'], $_POST['state'], $_POST['zipcode']);
		$_SESSION['cart']->emptyCart();
             ?>
             <h3 style="font-family: Cookie"><?php echo $_SESSION['customer']->getFname() . " " . $_SESSION['customer']->getLname()?>!</h3> 
             <p>Thank you so much for your business! It really means a lot to us.</p>
             <p>The above item(s) will be shipped to the following address: </p>
             <p><?php echo $_SESSION['customer']->getFname() . " " . $_SESSION['customer']->getLname()?><br>
             <?php echo $newAddress->getAddressLine()?><br>
             <?php echo $newAddress->getCity()?>, <?php echo $newAddress->getState()?>, <?php echo $newAddress->getZipcode()?></p>
             <p>The amount of $<?php echo $overalltotal?> will be charged to you via your payment method: <?php echo $_SESSION['customer']->getPaymentMethod()?>.</p>
             <p>A confirmation email won't be sent to you (our developers don't get paid enough for that), but rest assured your order will be to you in no time!</p>
             <h5><strong>Thanks again for shopping with The Classics.COM!</strong></h5>
	     <?php
	      }
             ?>
          </div> <!-- End panel for Inventory -->
        </div> <!-- End col-md-10 -->
      </div> <!-- End row -->
    </div> <!-- End container -->
  </body>
</html>
