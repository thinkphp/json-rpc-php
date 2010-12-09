<?php
require_once('jsonRPCServer.php');
include('math.php');

$obj = new Math();

jsonRPCServer::handle($obj) or print('no request');

?>