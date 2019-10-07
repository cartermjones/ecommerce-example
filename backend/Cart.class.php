<?php

   require_once ('ShoppingUtilities.class.php');
   require_once ('Selection.class.php');

   class Cart {
      private $selectionList;

      function __construct() {
        $this->selectionList = array();
      }

      function getSelectionList() {
        return $this->selectionList;
      }
      
      function emptyCart() {
        $this->selectionList = array();
      }

      function addSelection($currentSelection) {
        $this->selectionList[$currentSelection->getInventoryItem()->getID()] = $currentSelection;
      }

      function changeQuantity($selectionToChange, $newQuantity) {
	if ($newQuantity == 0) {
          unset($this->selectionList[$selectionToChange->getInventoryItem()->getID()]);
	}
	else {
          $this->selectionList[$selectionToChange->getInventoryItem()->getID()]->setQuantity($newQuantity);
	}
      }

      function getSubtotal() {
        return ShoppingUtilities::getSubtotal($this->selectionList);
      }

      function getSalesTax() {
        return ShoppingUtilities::getSalesTax($this->getSubtotal());
      }

      function getOverallTotal() {
        return ShoppingUtilities::getOverallTotal($this->getSubtotal());
      }

      function getTotalQuantity() {
        $sum = 0;
        foreach ($this->selectionList as $currentSelection)  {
          $sum += $currentSelection->getQuantity();
        }
        return $sum;
      }

   }

?>
