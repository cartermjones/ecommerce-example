<?php

  require_once('../backend/ShoppingUtilities.class.php');
  require_once('../backend/Cart.class.php');

  session_start();

  if (!isset($_SESSION['cart'])) { 
    $newCart = new Cart();
    $_SESSION['cart'] = $newCart;
  } 

  if (isset($_POST['invId'])) {
    $inventoryList = ShoppingUtilities::readInventoryList('../inventory/inventory.txt');
    $inventoryItem = $inventoryList[$_POST['invId']];

    $key_exists = array_key_exists($inventoryItem->getID(), $_SESSION['cart']->getSelectionList());

    if ($key_exists) {
      $selection = $_SESSION['cart']->getSelectionList()[$inventoryItem->getID()];
      $selection->incrementQuantity(); 
    } else {
      $selection = new Selection($inventoryItem, 1);
    }
    $_SESSION['cart']->addSelection($selection);
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
             <div class="panel-heading"><h4>Our Classics</h4></div>
             <table class="table">
	       <tr>
                  <th class="text-center" >Image</th> <!-- Hmm... -->
                  <th>Book</th>
                  <th>Description</th>
                  <th>Price</th>
                  <th>Actions</th>
	       </tr>
               <?php
                   $inventoryList = ShoppingUtilities::readInventoryList('../inventory/inventory.txt');
                   foreach ($inventoryList as $inventoryItem) {
                     echo '<tr>';
		     echo '<td class="text-center"><img height="218px" src="../inventory/images/'.$inventoryItem->getImagePath().'" /></td>';
		     echo '<td>'.$inventoryItem->getName().'</td>';
		     echo '<td>'.$inventoryItem->getDescription().'</td>';
		     echo '<td>$'.number_format($inventoryItem->getAmount(), 2).'</td>';
		     echo '<td><form method="post" action="shopping.php">
			         <input type="hidden" name="invId" id="invId" value="'.$inventoryItem->getId().'"/>
				 <button class="btn btn-link">Add to Cart</button>
                               </form>
                           </td>';
		     echo '</tr>';
		   }
               ?>
             </table> 
          </div> <!-- End panel for Inventory -->
        </div> <!-- End col-md-10 -->
      </div> <!-- End row -->
    </div> <!-- End container -->
  </body>
</html>
