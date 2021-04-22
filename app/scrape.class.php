<?php

class Scrape {
  
  // Class variables and arrays
  public $url;
  public $source;
  public $baseUrl;
  private $parsedUrl = array();
  
  // Object init
  function __construct($url) {
    $this->url = $url;
    $this->source = $this->curlGet($this->url);
    $this->xPathObj = $this->returnXpathObject($this->source);
    $this->parsedUrl = parse_url($this->url);
    $this->baseUrl = $this->parsedUrl['scheme'] . '://' . $this->parsedUrl['host'];
  }
  
  // Making a GET request using cURL
  public function curlGet($url) {
    $ch = curl_init();	
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);  
    curl_setopt($ch, CURLOPT_URL, $url); 
    $results = curl_exec($ch);  
    curl_close($ch);  
    return $results;  
  }
  
  // Returning XPath object
  public function returnXPathObject($item) {
    $xmlPageDom = new DomDocument();  
    @$xmlPageDom->loadHTML($item);  
    $xmlPageXPath = new DOMXPath($xmlPageDom);  
    return $xmlPageXPath;  
  }

  
}
?>