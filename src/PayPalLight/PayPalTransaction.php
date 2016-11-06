<?php
/**
 * Intellectual Property of Svensk Coding Company AB - Sweden All rights reserved.
 * 
 * @copyright (c) 2016, Svensk Coding Company AB
 * @author V.A. (Victor) Angelier <victor@thecodingcompany.se>
 * @version 1.0
 * @license http://www.apache.org/licenses/GPL-compatibility.html GPL
 * 
 */
namespace CodingCompany\PayPal;

class PayPalTransaction
{
    
    public $description = "";
    public $invoice_number = "";
    public $payment_options = [];
    public $amount = [];
    
    /**
     * Construct new Transaction
     */
    public function __construct() {
        
        $this->description = "PayPal transaction";
        
        //Unique 
        $this->invoice_number = uniqid();
        
        //Set default
        $this->amount = array(
            "total" => "0.00",
            "currency" => "USD"
        );
        
        /**
         * Set default payment method options
         */
        $this->payment_options = array(
            "allowed_payment_method" => "UNRESTRICTED"
        );
    }
    
    public function get_transaction(){
        return (array)$this;
    }
    
}