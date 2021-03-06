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

use CodingCompany\PayPal\PayPalLight;
    
class PayPalPayment extends PayPalLight
{
    
    /**
     * Construct new PayPal payment
     * @param type $credentials
     */
    public function __construct($credentials = array()) {
        parent::__construct($credentials);
        
        /**
         * Set request info
         */
        $this->request_info = array(
            "intent" => "sale",
            "payer" => array(
                "payment_method" => "paypal"
            ),
            "note_to_payer" => "Contact us for any questions on your order."
        );
    }
    
    /**
     * Authorize the payment and redirect the user
     */
    public function authorize_payment(){
        $this->authorize_paypal($this->toJson());
    }
    
    /**
     * Execute a created payment
     * @param type $input
     */
    public function execute_paypal_payment($input = array()){
        return $this->execute_payment($input);
    }
}