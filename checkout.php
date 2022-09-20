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
    $buyer=$_COOKIE['userName'];
    $query="UPDATE project.product P SET P.status='sold' WHERE P.productid IN (SELECT productid FROM project.cart C where C.buyerid=\"$buyer\")";
    $sql=$conn->prepare($query);
    $sql->execute();

    $query="SELECT productid FROM project.cart C where C.buyerid=\"$buyer\"";
    $sql=$conn->prepare($query);
    $sql->execute();
    $r=$sql->fetchAll(PDO::FETCH_ASSOC);
    foreach($r as $prod)
    {
        $orderid="OR".uniqid();
        $query2="INSERT INTO project.orders (buyerid,orderid,productid) VALUES(\"$buyer\",\"$orderid\",\"{$prod['productid']}\")";
        
        $sql2=$conn->prepare($query2);
        $sql2->execute();
        sleep(0.01);
    }
    $query="DELETE FROM project.cart WHERE buyerid=\"$buyer\"";
    $sql=$conn->prepare($query);
    $sql->execute();
    header("Location:cart.php");
?>