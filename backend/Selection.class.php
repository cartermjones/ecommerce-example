<?php 

  require_once('InventoryItem.class.php');

  class Selection {

    private $inventoryItem;
    private $quantity;

    function __construct($inventoryItem, $quantity) {
       $this->inventoryItem = $inventoryItem;
       $this->quantity = $quantity;
    }

    function getInventoryItem() {
       return $this->inventoryItem;
    }

    function getQuantity() {
       return $this->quantity;
    }

    function setQuantity($quantity) {
       $this->quantity = $quantity;
    }

    function incrementQuantity() {
       $this->quantity++;
    }

  }

?>
