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

include "auto_load.php";

$settings = parse_ini_file("settings.ini");
$p = new PayPalLight\PayPalLight($settings);

$p->set_endpoint("https://api.sandbox.paypal.com");

$tokens = $p->get_tokens();