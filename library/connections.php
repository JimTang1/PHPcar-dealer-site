<?php

function phpmotorsConnect(){

        $server = "localhost";
        $username = "root";
        $password = "";
        $dbName = "phpmotors";

        $dsn = "mysql:host=$server;dbname=$dbName";
        $options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);

        try
        {
            
            $pdo =new PDO($dsn, $username, $password, $options);
            return $pdo;
        }
        catch(PDOException $e)
        {
            header("Location: ../view/500.php");
        }
    }
