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
    $seller=$_COOKIE['userName'];
?>
<!doctype html>
<html lang="en">
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>Seller</title>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
    <div class="navbar-brand" >IITGbazaar</div>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse " id="navbarSupportedContent">
        
        <ul class="navbar-nav mb-2 mb-lg-0 container-fluid">
        
        <?php 
            
            echo "<div class=\"mx-auto\">$seller</div>";
        ?>
        
        <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        </a>
        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="seller.php">View product</a></li>
            <li><a class="dropdown-item" href="add_product.php">Add product</a></li>
            <li><a class="dropdown-item" href="seller_make_comp.php">Make complaint</a></li>
            <li><a class="dropdown-item" href="seller_view_comp.php">view complains</a></li>
            <li><a class="dropdown-item btn disabled" href="#">orders</a></li>
            <li><a class="dropdown-item " href="seller_delivered.php">Delivered orders</a></li>
            <li><a class="dropdown-item" href="buyer_signout.php">Sign Out</a></li>
        </ul>
        </li>
        
        </ul>
        
    </div>
    </div>
</nav>

<?php
        $query="Select O.*,B.name,B.phoneno ,P.name AS prodname FROM project.orders O, project.buyer B , project.product P WHERE P.sellerid=\"$seller\"and O.productid=P.productid and B.buyerid=O.buyerid and B.subid=\"PRE\" and O.status='pending'"; 
        $sql=$conn->prepare($query);
        $sql->execute();
        $cnt=0;
        echo "<div class=\"container-md mt-5 \">";
            if($sql->rowCount())
            {   $cnt+=$sql->rowCount(); 
                $r=$sql->fetchAll(PDO::FETCH_ASSOC);
                foreach($r as $item)
                {
                    echo "<div class='shadow-sm p-3 mb-5 bg-body rounded'>
                        <section>Subscription : <strong> Premimum </strong></section>
                        <section>Buyer Name : {$item['name']}</section>
                        <section>Buyer Phone No. : {$item['phoneno']}</section>
                        <section>Product Id : {$item['productid']}</section>
                        <section>Product Name : {$item['prodname']}</section>";
                    echo "<form method='post' action='delivered.php'>
                        <input type=\"hidden\" name=\"id\" value='{$item['productid']}'/>
                        <input type='submit' name='submit' class='btn btn-primary btn-lg btn-block mt-2' value='Delivered'/>
                    </form>";
                    echo "</div>";
                }
            }
            
            $query="Select O.*,B.name,B.phoneno, P.name AS prodname FROM project.orders O, project.buyer B , project.product P WHERE P.sellerid=\"$seller\"and O.productid=P.productid and B.buyerid=O.buyerid and B.subid=\"BA\" and O.status='pending'"; 
        $sql=$conn->prepare($query);
        $sql->execute();
        if($sql->rowCount())
            {   $cnt+=$sql->rowCount(); 
                $r=$sql->fetchAll(PDO::FETCH_ASSOC);
                foreach($r as $item)
                {
                    echo "<div class='shadow-sm p-3 mb-5 bg-body rounded'>
                        <section>Subscription : <strong> Basic </strong></section>
                        <section>Buyer Name : {$item['name']}</section>
                        <section>Buyer Phone No. : {$item['phoneno']}</section>
                        <section>Product Id : {$item['productid']}</section>
                        <section>Product Name : {$item['prodname']}</section>
                        ";
                echo "<form method='post' action='delivered.php'>
                            <input type=\"hidden\" name=\"id\" value='{$item['productid']}'/>
                            <input type='submit' name='submit' class='btn btn-primary btn-lg btn-block mt-2' value='Delivered'/>
                        </form>";
                echo "</div>";
                }
            }
        if($cnt===0)
        {
            echo "<div class='shadow-sm p-3 mb-5 bg-body rounded'>No orders to display!!</div>";
        }
        echo "</div>";
    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    
</body>
</html>