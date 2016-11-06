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

namespace PayPalLight
{
    /**
     * PayPal light class that does work on Google App Engine
     * @package PayPal Light
     */
    class PayPalLight extends PayPalLight\HttpRequest
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
                echo "<pre>".print_r($tokens, true)."</pre>";
            }else{
                //Error
                echo $tokens;
            }
        }
    }
}