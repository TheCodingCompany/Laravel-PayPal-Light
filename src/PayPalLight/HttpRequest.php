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
    
/**
 * HTTP requests without the use of Curl
 * @package PayPal Light
 */
class HttpRequest
{

    /**
     * Holds our base path. In most cases this is just /, but it can be /api for example
     * @var type 
     */
    protected $base_path = "/";

    /**
     * Base URL without leading /
     * @var string
     */
    protected $base_url = "";

    /**
     * Construct new HttpRequest
     * @param string $base_path Base path like, / or /api
     * @param string $base_url Base url like http://api.website.com without leading /
     */
    public function __construct($base_path = "/", $base_url = "") {            
        $this->base_path = $base_path;
        $this->base_url = $base_url;
    }

    /**
     * HTTP POST request
     * @param type $path
     * @param type $headers
     * @param type $parameters
     */
    public function Post($path = "", $headers = array(), $parameters = array()){
        //Sen the request and return response
        return $this->http_request(
            "POST", 
            $this->base_url.$this->base_path.$path, 
            $headers,
            $parameters
        );
    }

    /**
     * HTTP GET request
     * @param type $path
     * @param type $headers
     * @param type $parameters
     */
    public function Get($path = "", $headers = array(), $parameters = array()){
        //Sen the request and return response
        return $this->http_request(
            "GET", 
            $this->base_url.$this->base_path.$path, 
            $headers,
            $parameters
        );
    }

    /**
    * HTTP request
    * @param type $method  GET|POST
    * @param type $headers
    * @param type $parameters
    * @return boolean
    */
   private function http_request($method = "GET", $url = "", $headers = array(), $parameters = array()){
       $opts = array(
           'http' => array(
               'method' => $method,
               'header' => '',
               'content' => '',
               'user_agent' => 'Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)',
               'timeout' => 30,
               'protocol_version' => 1.1
           ),
           'ssl' => array(
               'verify_peer' => false,
               'verify_host' => false,
               'ciphers' => 'HIGH'
           )
       );
       //Check if we have parameters to post
       if(count($parameters) > 0 && is_array($parameters)){
           $content = "";                
           foreach($parameters as $k => $v){
               $content .= "&{$k}=".$v;
           }
           //Strip first & sign
           $opts["http"]["content"] = substr($content, 1);
       }elseif($parameters){
           //Send as is
           $opts["http"]["content"] = $parameters;
       }

       //Check if we have headers to parse
       if(count($headers) > 0 && is_array($headers)){
           $content = "";                
           foreach($headers as $k => $v){
               $content .= "{$k}: {$v}\r\n";
           }
           //Strip first & sign
           $opts["http"]["header"] = trim($content);
       }
       if($opts["http"]["header"] === ""){
           unset($opts["http"]["header"]);
       } 

       //Debug
       echo "<pre>".print_r($opts, true)."</pre>";
       //echo $url."<br/>";

       //Setup request
       $context = stream_context_create($opts);

       /**
        * @version 1.1 Updated method
        */
       $response = @file_get_contents($url, null, $context);

       //If we have an error or not
       if($response === FALSE){
           $error = "<pre>".print_r(error_get_last(), true)."</pre>";
           $error = "<pre>".print_r($response, true)."</pre>";
           echo $error;
           return $error;
       }else{
            //Get and debug headers
            /*
            $req_headers = stream_get_meta_data($fp);        
            if(isset($req_headers["wrapper_data"])){
                echo "<pre>".print_r($req_headers["wrapper_data"], true)."</pre>";
            }else{
                echo "<pre>".print_r($req_headers, true)."</pre>";
            }           
            */
            if(($json = @json_decode($response, true)) !== NULL){
                return $json;
            }else{
                return $response;
            }
       }

   }
}