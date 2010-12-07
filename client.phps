<?php
require_once('jsonRPCClient.php');
//require_once('math.php');

/* JSON-RPC Protocol for PHP using JSON for transport
 * client side;
 * class Math
 * #methods:
 * - cmmdc($a,$b);
 * - submult($n); 
 * - eratosthenes($n);
 * - toBin($n);
 * - bubblesort($arr);
 * - produit_cartesien($arr);
 * - --------------------------------------- 
 * - deliciousbadge($username,$amount,$tag);
 * - getTweets($username,$amount,$linkify);
 */

//$client = new jsonRPCClient('http://localhost/php-hacks/json-rpc-php/server.php');
//$client = new jsonRPCClient('http://thinkphp.ro/apps/php-hacks/json-rpc-php/server.php', true);
//$client = new Math();

  $client  = new jsonRPCClient('http://aldovet.ro/json-rpc-php/server.php');
$arr = array(99,22,33,44,11,55,77);
try {
    //echo($client->deliciousbadge('codepo8',10,'4ydn'));
    //echo($client->produit_cartesien(2,4,2));
      echo$client->getTweets('codepo8',10,true); 
}catch(Exception $e) {
    echo$e->getMessage(); 
}
?>