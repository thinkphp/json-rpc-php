JSON-RPC-PHP
-------------------------

This is a couple of classes written in PHP implementing respectively client and server functionalities of the [JSON-RPC](http://json-rpc.org/) protocol.
The goal of the project is the full incapsulation of the JSON-RPC approach inside a PHP application. Via these classes, it becomes possible to offer the network the methods of each one's own classes as RPC services and enjoy RPC services exactly as if they were local objects.
The JSON-RPC-PHP classes usage is extremely simple and preserve the JSON spirit.

## Introduction

``Interoperability`` is a property referring to the ability of diverse systems and organizations to work together (inter-operate).Alors, the term
iteroperability is used to describe the capability of different programs to exchange data via a common set of exchange formats, to
read and write the same file formats, and  to use the same protocols. According to ISO/IEC 2382, interoperability is defined as follows: 
"The capability to communicate, execute programs, or transfer data among various functional units in a manner that requires the user to have little or no knowledge of the unique characteristics of those unites".

``Remote procedure call (RPC)`` is a technology that allows a computer program to cause a subroutine or procedure to execute in 
another address space (commonly on another computer on a shared network) without the programmer explicitly coding the details
for this remote interaction.

Traditionally, the most common tools to implement RPC techniques are or have been: [ONC-RPC](http://en.wikipedia.org/wiki/ONC_RPC), [Corba](http://en.wikipedia.org/wiki/CORBA), [Java RMI](http://en.wikipedia.org/wiki/Java_Remote_Method_Invocation), [XML-RPC](http://en.wikipedia.org/wiki/XML-RPC), [SOAP](http://en.wikipedia.org/wiki/SOAP).
However, none of these seems to be enough general to be used easly in different environements. The packaging appear hard to read for humans because the complex
encapsulations and the ``strong typing`` makes the protocols hard for the ``weak typing`` programming languages, like PHP.

In the latest years, a new technology evolved and become stable, very interesting for encapsulation of complex data in a light logic and a simple format: (JSON](http://json.org/).

``JSON (JavaScript Object Notation) is a lightweight data-interchange format. It is easy for humans to read and write. It is easy for machines to parse and generate``.

Besides being easy to read for both humans and machines, JSON doesn't need to specify the type of the variables involved. This fact makes JSON the structured format more portable on the interoperatability scene.

Next to the JSON success, an RPC technique has born, following the XML-RPC idea and taking the name [JSON-RPC](http://json-rpc.org/).

``JSON-RPC is lightweight remote procedure call protocol similar to XML-RPC. It's designed to be simple! ``

