<?php

# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"

try {
    $pdo = new PDO('mysql:host=localhost:3306;dbname=ai2', 'ai2','ai2017');
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}

include("includes/funciones.php"); 

?>