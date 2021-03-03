<?php

try
{
    //Data source name.
    $dsn = 'mysql:host=172.31.22.43;dbname=Alex200454517';
    $username = 'Alex200454517';
    $password = 'rZMb5V7hNa';

    //Creating instance of PDO object.
    $db = new PDO($dsn, $username, $password);
    
}


catch(PDOException $e)
{
    $error_message = $e->getMessage();
    echo  'Connection was not established' .$error_message . '!';
}

?>