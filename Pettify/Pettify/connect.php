<?php

try
{
    //Data source name.
    $dsn = 'mysql:host=172.31.22.43;dbname=Alex200454517';
    $my_username = 'Alex200454517';
    $my_password = 'rZMb5V7hNa';
//    $dsn = 'mysql:host=localhost;dbname=php_database';
//    $my_username = 'root';
//    $my_password = '';


    //Creating instance of PDO object.
    $db = new PDO($dsn, $my_username, $my_password);
    
}


catch(PDOException $e)
{
    $error_message = $e->getMessage();
    echo  'Connection was not established' .$error_message . '!';
}

?>