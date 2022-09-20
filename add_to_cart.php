<?php
    $servername = "localhost"; //Name of the server where database resides, ex: 127.0.0.1
    $port_no = 3306; // Port number for Windows 
    $username = "user";
    $password = "";
    $myDB= "project"; //Name of the database to access
    try {$conn = new PDO("mysql:host=$servername; port= $port_no, dbname=$myDB", $username, $password); //set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } 
    catch(PDOException $e){echo "Connection failed: " . $e->getMessage();}
    $prodid=$_POST['id'];
    $query="INSERT INTO project.cart (buyerid,productid) VALUES ('{$_COOKIE['userName']}','$prodid')";
    $sql=$conn->prepare($query);
    $sql->execute();
    header("Location:home.php");
?>