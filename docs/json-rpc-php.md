JSON-RPC-PHP
------------

The trated themes require the knowledge of the [specification of the JSON-RPC 1.0 protocolor](http://json-rpc.org/wiki/specification).

## class jsonRPCServer

The ``jsonRPCServer`` class contains only one static method ``public static function handle($obj)``, responding to the JSON-RPC requests.

### Syntax:

    <?php
    boolean jsonRPCServer::handle(object $object)
    ?>

Collect a valid JSON-RPC request and search the appropriate method in object, using the request's parameters as method parameters. The response is given as JSON-RPC response.
The request is valid if it is a POST request and if it has a ``content-type: applicatin/json``. Either if the request if invalid or if it a notification, no response will be given to the JSON-RPC client.

#### Arguments:

* ``$object`` (*Object*) - the object whom the JSON-RPC request will be forwarded to.

#### Returns:

* ``boolean`` returns ``TRUE`` if the ``JSON-RPC`` request is well-formated (i.e. a POST request with ``content-type: application/json``). Otherwise, returns  ``FALSE`` to the main program and don't give a response to the JSON-RPC client.

#### Example: 

    <?php
    require_once('jsonRPCServer.php');
    include('math.php');
    $obj = new Math();
    jsonRPCServer::handle($obj) or print('no request');
    ?>

#### Note

If a request is valid (i.e. a POST request with ``content-type: application/json``) but contains some errors (e.g. the requested method doesn't exist in ``$object`` or the parameters structure is not valid) static method return ``TRUE`` to the calling program, but returns an error message to the JSON-RPC client.
This happens because informing the server side about a wrong client request doesn't make sense, while the client must be informed about the bad quality of message.
The JSON-RPC protocol contains a simple and full management system rightly to this proposal.

## class jsonRPCClient

The ``jsonRPCClient`` contains three public methods:

* ``jsonRPCClient::__construct($url,$bool)`` - the constructor of client class.
* ``jsonRPCClient::__call($method,$params)`` - forwarding the requests to the JSON-RPC server
* ``jsonRPCClient::setRPCNotification($bool)`` - to establish whether the requests are normal requests or notifications.


### method public jsonRPCClient::__construct($url) 

Constructor of class. Creates a new jsonRPCClient object binding it to a JSON-RPC server.

#### Description:
      
     <?php
     class jsonRPCClient {
           public function __construct($url [, boolean $debug]);
     }
     ?>

#### Parameters:

``$url`` (*String*) - the JSON-RPC service's URL
``$debug`` (*boolean*, default to 'false') - if 'true' then output on the stdout the dialog between client and server.

#### Return values:

Returns a jsonRPCClient object.

#### Example:

     <?php
     require_once('jsonRPCClient.php');
     $client  = new jsonRPCClient('http://aldovet.ro/json-rpc-php/server.php');
     ?>


### method public jsonRPCClient::__call($method, $params) 

In PHP this is triggered  when invoking inaccessible methods in a object context. Loads any called method in the appropiate method of the ``JSON-RPC`` server, forwarding the given parameters. Whatever be the called method for the ``jsonRPCClient`` object, 
``__call()`` converts it in the JSON-RPC method with same name. The parameters also are forwarded in a fully transparent way. ``__call()`` is a magic method, it must NOT be called with its own name. It collect every method called, converting them in the ``JSON-RPC`` form.

#### Syntax:
      
     <?php
     class jsonRPCClient {
           mixed function __call(String $method, array $params);
     }
     ?>

##### Arguments:

* ``$method`` (*String*) - the name of the remote required method.
* ``$params`` (*Array*) - the parameters set packaged as an array for remote method.

#### Return values:

Returns the structured value given by the called method. If the method is called as a notification then return TRUE.

#### Example:

     <?php
     require_once('jsonRPCClient.php');
     $client  = new jsonRPCClient('http://aldovet.ro/json-rpc-php/server.php');
     try {
       echo$client->getTweets('thinkphp', 18, true); 
     }catch(Exception $e) {
       echo$e->getMessage(); 
     } 
     ?>

#### Note:

Keep in mind the example: the ``__call()`` method isn't called explicitely. Instead, methods that aren't between the explicitely declared methods of the class are called. These are the JSON-RPC server's methods. ``__call()`` method collect  every method
request not coresponding to any explicitely declared method of the class and manage it as JSON-RPC request. The parameters too are given as the JSON-RPC method requires, where ``__call()`` will package them in an array.
In this way, the magic method ``__call()`` charges on itself the requests and acts as a proxy to the JSON-RPC server.


### method public jsonRPCClient::setRPCNotification($bool)

Sets the internal state of the object, to determine whether the requests are sent as normal requests or notifications.

#### Description: 

     <?php
        class jsonRPCClient {
              boolean setRPCNotification(boolean $notification)  
        }
     ?>

#### Parameters:

* ``$notification`` (*boolean*) - a boolean value that should be TRUE if the request must be notification, else FALSE if the request must have a response.

#### Return values:

* return ``true``.

#### Example:

     <?php
     require_once('jsonRPCClient.php');
     $client  = new jsonRPCClient('http://aldovet.ro/json-rpc-php/server.php');
     try {
          $client->setRPCNotification(true);
          echo$client->getTweets('thinkphp',5,true); 
          $client->setRPCNotification(false);
          echo($client->deliciousbadge('thinkphp',10,'javascript'));
     }catch(Exception $e) {
          echo$e->getMessage(); 
     } 
     ?>

Note: 

  In the method's requests there isn't a parameter indicating if the request must be of  the notification form, i.e. with no response. As default, every request is a request expecting a response.
  For these reasons, ``setRPCNotification`` method has been prepared as a separated switch, to be intended as a state modifier.

