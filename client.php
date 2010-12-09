<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
   <title>Implementation of the JSON-RPC protocol in PHP</title>
   <link rel="stylesheet" href="http://yui.yahooapis.com/2.8.0r4/build/reset-fonts-grids/reset-fonts-grids.css" type="text/css">
   <link rel="stylesheet" href="http://yui.yahooapis.com/2.7.0/build/base/base.css" type="text/css">
   <style type="text/css">
    a{color: #393}
   </style>
</head>
<body>
<div id="doc2" class="yui-t7">
   <div id="hd" role="banner"><h1>Implementation of the <a href="http://json-rpc.org/wiki/specification">JSON-RPC</a> protocol in PHP</h1></div>
   <div id="bd" role="main">
	<div id="widget"><!-- start div widget -->

<?php
require_once('jsonRPCClient.php');
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
  $client  = new jsonRPCClient('http://aldovet.ro/json-rpc-php/server.php');
//$client = new jsonRPCClient('http://localhost/php-hacks/json-rpc-php/server.php');
//$client = new jsonRPCClient('http://thinkphp.ro/apps/php-hacks/json-rpc-php/server.php', true);
$arr = array(9,8,7,6,5,4,3,2,1,0);
try {
    //call this method from network
    echo$client->getTweets('codepo8',15,true);
}catch(Exception $e) {
    echo$e->getMessage(); 
}
?>
	</div><!-- end div widget -->
	</div>

<h2>Source</h2>
<pre>
/* include the client class; */
require_once('jsonRPCClient.php');
/* create an object jsonRPCClient */
$client  = new jsonRPCClient('http://aldovet.ro/json-rpc-php/server.php');
try {
    /* CALL REMOTE METHOD 'getTweets' from network and OUTPUT */
    echo$client->getTweets('codepo8',15,true);
}catch(Exception $e) {
    echo$e->getMessage(); 
}
</pre>

   <div id="ft" role="contentinfo"><p>Created by @<a href="http://twitter.com/thinkphp">thinkphp</a> | download on <a href="https://github.com/thinkphp/json-rpc-php">GitHub</a> | <a href="client.phps">client.phps</a></p></div>
</div>
</body>
</html>