<?php

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
        
        
        <div class="mx-auto"><?php echo $seller; ?></div>
        
        <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        </a>
        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="seller.php">View products</a></li>
            <li><a class="dropdown-item btn disabled" href="#">Add product</a></li>
            <li><a class="dropdown-item" href="seller_make_comp.php">Make complaint</a></li>
            <li><a class="dropdown-item" href="seller_view_comp.php">view complains</a></li>
            <li><a class="dropdown-item" href="seller_orders.php">orders</a></li>
            <li><a class="dropdown-item " href="seller_delivered.php">Delivered orders</a></li>
            <li><a class="dropdown-item" href="buyer_signout.php">Sign Out</a></li>
        </ul>
        </li>
        
        </ul>
        
    </div>
    </div>
    </nav>
    <form class="container-md shadow p-3 mt-3 mb-5 bg-body rounded" method="post" action="add_product.php" enctype="multipart/form-data">
    <div class="mb-3">
    <label for="prodname" class="form-label">Product Name</label>
    <input type="text" class="form-control" id="prodname" name="prodname">
    </div>
    <div class="mb-3">
    <label for="cat" class="form-label">Category</label>
    <input type="text" class="form-control" id="cat" name="cat">
    </div>
    <div class="mb-3">
    <label for="cost" class="form-label">Cost</label>
    <input type="text" class="form-control" id="cost" name="cost">
    </div>
    <div class="mb-3">
    <label for="brand" class="form-label">Brand</label>
    <input type="text" class="form-control" id="brand" name="brand">
    </div>
    <div class="mb-3">
    <label for="prodyear" class="form-label">Product year</label>
    <input type="text" class="form-control" id="prodyear" name="prodyear">
    </div>
    <div class="mb-3">
    <label for="file1" class="form-label">Image 1</label>
    <input type="file" accept="image/*" class="form-control" id="file1" name="file1">
    </div>
    <div class="mb-3">
    <label for="file2" class="form-label">Image 2</label>
    <input type="file" accept="image/*" class="form-control" id="file2" name="file2">
    </div>
    <div class="mb-3">
    <label for="file3" class="form-label">Image 3</label>
    <input type="file" accept="image/*" class="form-control" id="file3" name="file3">
    </div>
    <div class='mb-3'>
        <input type="submit" class="btn btn-primary btn-lg btn-block" name="submit" value="Add">
    </div>
    </form>
    <?php 
        if(isset($_POST['submit']))
        {
            $servername = "localhost"; //Name of the server where database resides, ex: 127.0.0.1
            $port_no = 3306; // Port number for Windows 
            $username = "user";
            $password = "";
            $myDB= "project"; //Name of the database to access
            try {$conn = new PDO("mysql:host=$servername; port= $port_no, dbname=$myDB", $username, $password); //set the PDO error mode to exception
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                } 
            catch(PDOException $e){echo "Connection failed: " . $e->getMessage();}
            $prodId="PA".uniqid();
            $query="INSERT INTO project.product (productid,name,category,sellerid,cost,brand,prodyear) VALUES 
            (\"$prodId\",\"{$_POST['prodname']}\",\"{$_POST['cat']}\",\"$seller\",{$_POST['cost']} ,\"{$_POST['brand']}\",{$_POST['prodyear']})";
            $sql=$conn->prepare($query);
            $sql->execute();
            
            if($_FILES['file1']['error']!==4)
            {
                $filename=$_FILES['file1']['name'];
            
                $dir="uploads/$prodId/";
                if ( !is_dir( $dir ) ) {
                    $dirMode = 0777;
                    mkdir($dir, $dirMode, true);
                    chmod($dir, $dirMode);
                }
                $targetpath=$dir.$filename;
                if(move_uploaded_file($_FILES['file1']['tmp_name'],$targetpath))
                {
                    $query="UPDATE project.product SET image1=\"$targetpath\" WHERE productid=\"$prodId\"";
                    $sql=$conn->prepare($query);
                    $sql->execute();
                    
                }
            }
            if($_FILES['file2']['error']!==4)
            {
                $filename=$_FILES['file2']['name'];
            
                $dir="uploads/$prodId/";
                if ( !is_dir( $dir ) ) {
                    $dirMode = 0777;
                    mkdir($dir, $dirMode, true);
                    chmod($dir, $dirMode);
                }
                $targetpath=$dir.$filename;
                if(move_uploaded_file($_FILES['file2']['tmp_name'],$targetpath))
                {
                    $query="UPDATE project.product SET image2=\"$targetpath\" WHERE productid=\"$prodId\"";
                    $sql=$conn->prepare($query);
                    $sql->execute();
                    
                }
            }
            if($_FILES['file3']['error']!==4)
            {
                $filename=$_FILES['file3']['name'];
            
                $dir="uploads/$prodId/";
                if ( !is_dir( $dir ) ) {
                    $dirMode = 0777;
                    mkdir($dir, $dirMode, true);
                    chmod($dir, $dirMode);
                }
                $targetpath=$dir.$filename;
                if(move_uploaded_file($_FILES['file3']['tmp_name'],$targetpath))
                {
                    $query="UPDATE project.product SET image3=\"$targetpath\" WHERE productid=\"$prodId\"";
                    $sql=$conn->prepare($query);
                    $sql->execute();
                    
                }
            }
            
        }
    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    
</body>
</html>