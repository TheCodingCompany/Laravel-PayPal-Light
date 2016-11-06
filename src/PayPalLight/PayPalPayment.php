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
    public function execute_payment($input = array()){
        $tokens = $this->get_tokens();
        if(is_array($tokens)){
            $response = $this->Post("v1/payments/payment/{$input["paymentId"]}/execute", 
                array(
                    "Content-Type"      => "application/json",
                    "Authorization"     => "Bearer ".$this->token_info["access_token"]
                ),
                json_encode(array(
                    "payer_id" => $input["PayerID"]
                ))
            );
            if(isset($response["state"]) && $response["state"] === "approved"){
                return $response;
            }else{
                echo "<pre>".print_r($response, true)."</pre>";
                return false;
            }
        }
        echo "<pre>".print_r($tokens, true)."</pre>";
    }
}