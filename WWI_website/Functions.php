<?php

function DPODBConn(){
    try {
        $db = "mysql:host=localhost;dbname=wideworldimporters;port=3306";
        $user = "root";
        $pass = "";
        $pdo = new PDO($db, $user, $pass);
    } catch (PDOException $e) {
        print("ERROR!: " . $e->getMessage());
        $pdo = null;
    }
}

