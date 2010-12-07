<?php

class jsonRPCServer {

    /*
     * @param $object Object
     * @return Boolean
     */
     public static function handle($object) {

         /* checks whether we have an AJAX request JSON-RPC client */
         if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
         
             if($_SERVER['CONTENT_TYPE'] != 'application/x-www-form-urlencoded; charset=UTF-8' &&
                                 $_SERVER['HTTP_ACCEPT'] != 'applicatin/json' &&
                                        $_SERVER['HTTP_X_REQUEST'] != 'JSON') {

                  return false;  
             }

         /* otherwise, the request is made through PHP client */
         } else { 

           if($_SERVER['REQUEST_METHOD'] != 'POST' || 
                 $_SERVER['CONTENT_TYPE'] != 'application/json' || 
                                        empty($_SERVER['CONTENT_TYPE'])) {
                return false;
           }
         }
         
         /* 
          * Reads the input data 
          * decodes a JSON string - takes a JSON encoded string and converts in into a PHP variable.
          * Syntax: mixed decode_json(string $json [, bool $assoc = false [, int $depth = 512 [, int $options = 0]]] );
          * 
          * @param $json - the json string being decoded.
          * @param $assoc - when TRUE, returned objects will be converted into associative arrays.
          * @param $depth - user specified recursion depth.
          * @param $options - bitmask of JSON decode options. currently only JSON_BIGINT_AS_STRING is supported.     
          */
         $request = json_decode(file_get_contents("php://input"), true); 

         /* executes the task in local object */
         try {
             /* 
              * Call a user function given with an array of parameters.
              *
              * Syntax: mixed call_user_func_array(callback function, array $param_arr).
              *
              * @param function - function to be called.
              * @param param_arr - the parameters to be passed to the function, as an indexed array. 
              * @return returns the function result or FALSE on error.
              */
             if($result = @call_user_func_array(array($object, $request['method']), $request['params'])) {

               $response = array(
                                'id' => $request['id'],
                                'result' => $result,
                                'error' => NULL
                                );           
             } else {
               $response = array(
                              'id' => $request['id'],
                              'result' => NULL,
                              'error' => 'Unknown method or parameters'
                             ); 
             } 
                      
         }catch(Exception $e) {
               $response = array(
                              'id' => $request['id'],
                              'result' => NULL,
                              'error' => $e->getMessage()
                             );
         }  
          
         //output the response
         if(!empty($request['id'])) {

             header('content-type: text/javascript');
             /*
              * Returns the JSON represenation of a value.
              * Syntax: string json_encode(mixed $value [,int $options = 0 ]);
              *
              * @param $value - the value being encoded. can be any type except a resource. 
              *                 the function only works with UTF-8 encoded data.
              * @param $options - Bitmask consisting of JSON_HEX_QUOT, JSON_HEX_TAG, JSON_HEX_AMP, JSON_HEX_APOS       
              * @return - returns a JSON encoded string on success.
              */
              echo json_encode($response);
         }

       /* finish */
       return true;
     }
}
?>