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

include "TheCodingCompany".DIRECTORY_SEPARATOR."auto_load.php";

$p = new PayPalLight\PayPalLight(array(
    
));

$p->set_endpoint("https://api.sandbox.paypal.com");

$tokens = $p->get_tokens();