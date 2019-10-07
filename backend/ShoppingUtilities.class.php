<?php

   require_once('Selection.class.php');

   class ShoppingUtilities {
 
     static function getSubtotal($selectionList) {
       $sum = 0;
       foreach ($selectionList as $currentSelection) {
          $sum += $currentSelection->getInventoryItem()->getAmount() * $currentSelection->getQuantity();
       }
       return $sum;
     }

     static function getSalesTax($subtotal) {
       return $subtotal * 0.065;
     }
 
     static function getOverallTotal($subtotal) {
       return $subtotal + ShoppingUtilities::getSalesTax($subtotal);
     }

     public function readInventoryList($filename) {
       $inventoryArray = file($filename);

       $inventoryList = array();

       foreach ($inventoryArray as $line) {
         $delimiter = ',';

         $inventoryObject = new InventoryItem($line, $delimiter);

         $inventoryList[$inventoryObject->getID()] = $inventoryObject;
       }

       return $inventoryList;
     }

   }

?>
