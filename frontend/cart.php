<?php

  require_once('../backend/ShoppingUtilities.class.php');
  require_once('../backend/Cart.class.php');

  session_start();

  if (!isset($_SESSION['cart'])) { 
    $newCart = new Cart();
    $_SESSION['cart'] = $newCart;
  }

  if(isset($_POST['quantity'])) {
    $quantityArray = $_POST['quantity'];
    $index = 0;
    foreach($_SESSION['cart']->getSelectionList() as $selection) {
      $_SESSION['cart']->changeQuantity($selection, $quantityArray[$index]);
      $index++;
    }
  }
  
  $cart_empty = $_SESSION['cart']->getTotalQuantity() == 0 ? true : false; 

?>
<!DOCTYPE html>
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
	       <a class="nav-link" href="cart.php">Cart <span class="badge badge-primary"><i class="fa fa-shopping-cart"></i> <?php echo $_SESSION['cart']->getTotalQuantity(); ?></span></a>
            </li>
	    <li class="nav-item">
	       <a class="nav-link<?php if ($cart_empty) { echo ' disabled'; }?>" href="checkout.php">Checkout</a>
            </li>
          </ul>
	  <!-- Include Left Navigation Panel -->
	</div>
        <div class="col-md-10">
          <div class="panel panel-danger spaceabove"> <!-- Inventory Panel -->
	     <div class="panel-heading"><h4>Your Shopping Cart</h4></div>
             <form method="post" action="cart.php">
             <table class="table">
	       <tr>
                  <th class="text-center" >Image</th> <!-- Hmm... -->
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
		     echo '<td><input required type="number" style="width:50px;" min=0 name="quantity[]" value="'.$selection->getQuantity().'" /></td>';
		     echo '</tr>';

                   }
                  ?>
	     </table> 
             <?php
                   $subtotal = number_format($_SESSION['cart']->getSubtotal(), 2);
		     echo "<h6>Subtotal: $$subtotal</h6>";
                     echo "<h6>Shipping: FREE</h6>";
                   $salestax = number_format($_SESSION['cart']->getSalesTax(), 2);
		     echo "<h6>Sales Tax: $$salestax</h6>";
                   $overalltotal = number_format($_SESSION['cart']->getOverallTotal(), 2);
		     echo "<h6>Overall Total: $$overalltotal</h6>";
             ?>
		 <div class="float-right">
                   <button class="btn btn-secondary">Update Cart</button>
		   <button class="btn btn-primary<?php if ($cart_empty) { echo ' disabled" disabled="disabled'; } ?>" formaction="checkout.php" >Checkout</button> 
                 </div>
             </form>
          </div> <!-- End panel for Inventory -->
        </div> <!-- End col-md-10 -->
      </div> <!-- End row -->
    </div> <!-- End container -->
  </body>
</html>
