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
    
class CreditCardPayment extends PayPalLight
{
    /**
     * Construct new Payment
     */
    public function __construct(){
        parent::__construct();
    }
    
    /**
     * Set Payer Information
     * @param type $info
     */
    public function set_payer($info = array()){
        
    }
}   
