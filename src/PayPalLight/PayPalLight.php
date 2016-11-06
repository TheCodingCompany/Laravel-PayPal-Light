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

use CodingCompany\PayPal\HttpRequest;

/**
 * PayPal light class that does work on Google App Engine
 * @package PayPal Light
 */
class PayPalLight extends HttpRequest
{

    /**
     * Set to LIVE for live payments
     * @var type 
     */
    protected $mode = "sandbox";

    /**
     * Client ID and Secret
     * @var type 
     */
    protected $credentials = null;

    /**
     * Holds our Token Info
     * @var type 
     */
    protected $token_info = null;
    
    /**
     * Request info
     * @var type 
     */
    protected $request_info = array();
    
    /**
     * Personal experience profile
     * @var type 
     */
    protected $experience_profile = "";

    /**
     * Construct new PayPal class
     * @param array $credentials Hold our client ID en secret
     */
    public function __construct($credentials = array()) {
        parent::__construct();

        $this->credentials = $credentials;
    }

    /**
     * Set our endpoint
     * @param type $endpoint
     */
    public function set_endpoint($endpoint){
        $this->base_url = $endpoint;
    }

    /**
     * Get PayPal oAuth2 tokens
     * @return string
     */
    public function get_tokens(){
        //Send a request
        $tokens = $this->Post("v1/oauth2/token", 
            array(
                "Content-Type"      => "application/x-www-form-urlencoded",
                "Authorization"     => "Basic ".base64_encode($this->credentials["client_id"].":".$this->credentials["client_secret"]),
                "Accept"            => "application/json",
                "Accept-Language"   => "en-US"
            ),
            array(
                "grant_type" => "client_credentials"
            )
        );
        if(is_array($tokens)){
            $this->token_info = $tokens;
        }else{
            //Error
            $this->token_info = null;
        }
        return $this->token_info;
    }
    
    /**
     * Set the amount to pay
     * @param type $amount
     * @param type $currency USD
     */
    public function set_transaction(PayPalTransaction $transaction){
        if(!isset($this->request_info["transactions"])){
            $this->request_info["transactions"] = array();
        }
        array_push($this->request_info["transactions"], $transaction);
    }
    
    /**
     * Create the JSON value for the request
     * @return type
     */
    public function toJson(){
        return json_encode($this->request_info);
    }
    
    /**
     * Get the Approval URL from the create Payment response
     * @param type $links
     */
    public function get_approval_url($links = array()){
        foreach($links as $l){
            if($l["rel"] === "approval_url"){
                return $l["href"];
            }
        }
        return false;
    }
    
    /**
     * Get the Execute URL from the create Payment response
     * @param type $links
     */
    public function get_execute_url($links = array()){
        foreach($links as $l){
            if($l["rel"] === "execute"){
                return $l["href"];
            }
        }
        return false;
    }
    
    /**
     * Set Return url
     * @param type $url
     */
    public function set_return_url($url){
        if(!isset($this->request_info["redirect_urls"])){
            $this->request_info["redirect_urls"] = array();
        }
        $this->request_info["redirect_urls"]["return_url"] = $url;
    }
    /**
     * Set Cancel url
     * @param type $url
     */
    public function set_cancel_url($url){
        if(!isset($this->request_info["redirect_urls"])){
            $this->request_info["redirect_urls"] = array();
        }
        $this->request_info["redirect_urls"]["cancel_url"] = $url;
    }
    
    /**
     * Set Payer information
     * @param type $info
     */
    public function set_payer_info($info = array()){
        $this->request_info["payer"]["payer_info"] = $info;
    }
    
    /**
     * Authorize a PayPal payment
     * @param JSON $payment_info JSON payment info
     */
    public function authorize_paypal($payment_info = null){
        $this->get_tokens();
        if(is_array($this->token_info)){
            //Send a request
            $response = $this->Post("v1/payments/payment", 
                array(
                    "Content-Type"      => "application/json",
                    "Authorization"     => "Bearer ".$this->token_info["access_token"]
                ),
                $payment_info
            );

            if($response["state"] === "created"){
                header("Location: ".$this->get_approval_url($response["links"]), true);
                die();
            }
        }else{
            return false;
        }
    }
    
    /**
     * Execute and 'approved' payment
     * @param type $payment_info
     */
    public function execute_payment($payment_info = null){
        $this->get_tokens();
        if(is_array($this->token_info)){
            $response = $this->Post("v1/payments/payment/{$payment_info["paymentId"]}/execute", 
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
                return false;
            }
        }
    }
}
