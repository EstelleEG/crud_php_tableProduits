<?php

//step1
//if try echoue, le catch va display un error msg
try{
    //connect to db 
    $db = new PDO("mysql:host=localhost;dbname=crud", "root", ""); // on fait une new instance de l objet PDO // le server is localhost // db est le nom de la db
    $db->exec('SET NAMES "UTF8"'); //ts les echanges de la db se feront via la table de caractere UTF8
} catch (PDOException $e){ //we catch l error and store in in var e
    echo 'ERROR: bad'. $e->getMessage(); //display l error
    die();
}