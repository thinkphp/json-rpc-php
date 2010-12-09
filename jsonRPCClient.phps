<?php
class jsonRPCClient {
    /* 
     * Debug state
     * @var boolean
     */
    public $debug;
    /* 
     * Server URL
     * @var String
     */
    private $uri;
    /* 
     * The request ID
     * @var String
     */
    private $id;
    /* 
     * If true, notifications are performed instead of requests
     * @var Boolean
     */
    private $notification = false;
    /* 
     *  Constructor of class
     *  Takes the connection parameters
     *
     *  @param String $url
     *  @param Boolean $debug
     */
    public function __construct($uri, $debug = false) {
        $this->uri = $uri;
        empty($proxy) ? $this->proxy = '' : $this->proxy = $proxy;
        empty($debug) ? $this->debug = false : $this->debug = true;
        $this->debugclone = $debug;        
    }

    /*
     * Performs a jsonRPCRequest and gets the results as an array;
     * 
     * @param $method (String) 
     * @param $params (Array)
     * @return Array
     */
    public function __call($method, $params) {

         /* finds whether $method is a scalar or not */
         if(!is_scalar($method)) {
            throw new Exception("Method name has no scalar value.");   
         }

         /* checks if the $params is vector or not */
         if(is_array($params)) {
            $params = array_values($params);
         } else {
            throw new Exception("Params must be given as array.");
         }

         $this->id = rand(0,99999); 

         if($this->notification) {
           $currentId = NULL; 
         } else {
           $currentId = $this->id;
         }

         /* prepares the request */
         $request = array(
                          'method' => $method,
                          'params' => $params,
                          'id' => $currentId
                         );

         $request = json_encode($request);

         $this->debug && $this->debug .= "\n".'**** Client Request ******'."\n".$request."\n".'**** End of Client Request *****'."\n";

         /* Performs the HTTP POST */
         $opts = array('http' => array(
                                       'method' => 'POST',
                                       'header' => 'Content-type: application/json',
                                       'content' => $request
                                       )); 

         $context = stream_context_create($opts);

         if($fp = fopen($this->uri, 'r', false, $context)) {

            $response = '';

            while($row=fgets($fp)) {

                $response .= trim($row)."\n"; 
            } 

            $this->debug && $this->debug .= '**** Server response ****'."\n".$response."\n".'**** End of server response *****'."\n\n";

            $response = json_decode($response, true);    
             
         } else {

           throw new Exception('Unable to connect to'. $this->uri);
         } 
         
         /*
          * inserts HTML line breaks before all newlines in a string
          * @param $debug (String) 
          * @return String returns string with '<br/>' or '<br>' inserted before al newlines.
          */
         if($this->debug) {
            echo nl2br($this->debug);
         }

         /* Final checks and return */
         if(!$this->notification) {

           if($response['id'] != $currentId) {
               throw new Exception('Incorrect response ID (request ID: '. $currentId . ', response ID: '. $response['id'].')');
           }

           if(!is_null($response['error'])) {
               throw new Exception('Request error: '. $response['error']);     
           }   

           $this->debug = $this->debugclone;
          
           return $response['result'];

         } else {

           return true;
         }
    }

    /* 
     * Sets the notifications state of the object.
     * In this state, notifications are performed, instead of requests.
     *
     * Syntax: String nl2br(String $string, [bool $is_html = true]) 
     *
     * @param $notification (Boolean)
     * @return true;
     */
      public function setRPCNotification($notification) {
             empty($notification) ? $this->notification = false : $this->notification = true;
         return true;  
      } 

}
?>