<?php

require_once('nusoap/nusoap.php');
require_once('db.php');

$server = new soap_server();
$namespace = 'http://www.sec522.org/shelter/soapapi/index.php';
$server->configureWSDL("index","urn:index");

$server->register("GetDayofWeek",
array('sDate' => 'xsd:string'),
array('return' => 'xsd:string'),
$namespace,
false,
"rpc",
"encoded",
"Retrieve the day of the week for a date"
);

$server->wsdl->addComplexType(
    'User',
    'complexType',
    'array',
    '',
    array(
        'Username'=>'xsd:string',
        'UserID'=>'xsd:short',
        'Password'=>'xsd:string',
        'Role'=>'xsd:string'
    ),
    'tns:User'
);

$server->wsdl->addComplexType(
    'Animal',
    'complexType',
    'array',
    '',
    array(
        'animalname'=>'xsd:string',
        'species'=>'xsd:string',
        'catagressive'=>'xsd:int',
        'dogagressive'=>'xsd:int',
        'kidagressive'=>'xsd:int',
        'comments'=>'xsd:string'
    ),
    'tns:Animal'
);

$server->register("GetAnimal",
array('nID'=>'xsd:short',
'sAPIKey'=>'xsd:string'),
array('return'=>'tns:Animal'),
$namespace,
false,
"rpc",
"encoded",
"Retrieve details about an animal"
);

$server->register("GetUser",
array('nID' => 'xsd:short'),
array('return' => 'tns:User'),
$namespace,
false,
"rpc",
"encoded",
"Retrieve Details about a user"
);

$server->register("GetUserName",
array('nID' => 'xsd:short',
      'sAPIKey' => 'xsd:string'),
array('return' => 'xsd:string'),
$namespace,
false,
"rpc",
"encoded",
"Get the username for a user by userid"
);

$server->register("GetDayofWeek",
array('sDate' => 'xsd:string'),
array('return' => 'xsd:string'),
$namespace,
false,
"rpc",
"encoded",
"Retrieve the day of the week for a date"
);


@$server->service(file_get_contents('php://input'));



function GetDayofWeek($sDate) {
    $date = DateTime::createFromFormat('Y-m-d',$sDate);
    return $date->format('l');
}
function GetUser($nID) {
    $conn = pdoconnect();
    $oUser=pdoprepqueryhash('SELECT username, userid, password, role FROM animalshelter.users WHERE userid=?',array($nID),$conn);
    return $oUser;
}
function GetUserName($nID,$sAPIKey) {
    testapikey($sAPIKey);
    $conn = pdoconnect();
    $sUsername=pdoprepsingle('SELECT username FROM animalshelter.users WHERE userid=?',array($nID),$conn);
    return $sUsername;
}

function GetAnimal($nID,$sAPIKey) {
    $conn=pdoconnect();
    testapikey($sAPIKey);    
    $oAnimal=pdoprepqueryhash('select animalname, species, catagressive, dogagressive,kidagressive,comments from animalshelter.animals where animalid=?',array($nID),$conn);
    return $oAnimal;
}
function testapikey($sAPIKey) {
    global $server;
    if ($sAPIKey==='catsruledogsdrool' ) {
        return true;
    }
    $server->fault('AUTH','Wrong API Key');
}