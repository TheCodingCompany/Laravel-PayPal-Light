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

use CodingCompany\HttpRequest;

namespace CodingCompany
{
    /**
     * PayPal light class that does work on Google App Engine
     * @package PayPal Light
     */
    class PayPalLight
    {
        /**
         * Holds our HTTP request
         * @var type 
         */
        protected $http = null;
        
        /**
         * Construct new PayPal class
         */
        public function __construct() {
            $this->http = new HttpRequest();
        }
        
        
    }
}