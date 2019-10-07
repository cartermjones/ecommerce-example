<?php

    class Customer{
        private $fname;
        private $lname;
        private $paymentMethod;

        function __construct($fname, $lname, $paymentMethod){
            $this->fname = $fname;
            $this->lname = $lname;
            $this->paymentMethod = $paymentMethod;
        }

        function getFname(){
            return $this->fname;
        }

        function getLname(){
            return $this->lname;
        }

        function getPaymentMethod(){
            return $this->paymentMethod;
        }
    }