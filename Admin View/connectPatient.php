<?php
/* CREATE A CONNECTION TO THE SERVER */
    $dsn = 'mysql:host=localhost;dbname=lbarinea_OrthoSC';
    $username = 'lbarinea_user';
    $password = 'passwordo1';
try{
    $db = new PDO($dsn, $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
}
catch (PDOException $e)
{
    echo 'ERROR connecting to database!' . $e->getMessage();
    exit();
}
?>