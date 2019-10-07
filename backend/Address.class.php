<?php

   class Address {

     private $addressLine;
     private $city;
     private $state;
     private $zipcode;

     function __construct($addressLine,
                          $city,
                          $state,
                          $zipcode) {

        $this->addressLine = $addressLine;
        $this->city = $city;
        $this->state = $state;
        $this->zipcode = $zipcode;
     }

     function getAddressLine() {
       return $this->addressLine;
     }

     function getCity() {
       return $this->city;
     }

     function getState() {
       return $this->state;
     }
   
     function getZipcode() {
       return $this->zipcode;
     }

   }


?>
