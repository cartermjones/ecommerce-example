<?php

  class InventoryItem {

    private $ID;
    private $name;
    private $description;
    private $ISBN;
    private $amount;
    private $imagePath;

    function __construct($line, $delimiter) {

       $splits = explode($delimiter, $line);

       $this->ID = $splits[0];
       $this->name = $splits[1];
       $this->description = $splits[2];
       $this->ISBN = $splits[3];
       $this->amount = $splits[4];
       $this->imagePath = $splits[5];
      
    }

    function getID() {
      return $this->ID;
    }

    function getName() {
      return $this->name;
    }

    function getDescription() {
      return $this->description;
    }

    function getISBN() {
      return $this->ISBN;
    }

    function getAmount() {
      return $this->amount;
    }

    function getImagePath() {
      return $this->imagePath;
    }
  }

?>
