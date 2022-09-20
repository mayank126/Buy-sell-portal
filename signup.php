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

?>
<!doctype html>
<html lang="en">
  <head>
    
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">



    <title>Sign Up</title>
    </head>
    <body>
    <?php
      if(isset($_POST['submit']))
      {
        $pass=$_POST['pass'] ;
        $confirm=$_POST['confirm'] ;

        if($pass!==$confirm)
        {
          echo "<script>alert('enter same password in \"Confirm password\"')</script>";
        }
        if($_POST['userType']==='buyer')
        {

            $email = $_POST['email'];
            $count  = $conn->query("Select *  from project.buyer  a where a.buyerid =\"$email\"");
            $exist = false;
    
            while ($row=$count->fetch(PDO::FETCH_ASSOC)) {
              
              foreach($row as $k => $val)
              {
                    if($k=="pass")
                    $exist = true;
              }
    
            }
            if($exist)    
            {
              echo "<script>alert('email id already exist ')</script>";
    
            }
            try{
              $sql="INSERT INTO project.buyer(buyerid,pass,name,phoneno,address) 
              VALUES (:email, :pass, :name, :phoneno,:address)";
              $stmt=$conn->prepare($sql);
              $stmt->execute(array(
                ':email' =>$_POST['email'],
                ':name' =>$_POST['name'],
                ':pass' =>$_POST['pass'],
                ':phoneno' =>$_POST['phoneno'],
                ':address' =>$_POST['address']
              ));
              if($_POST['sub']=='pre')
            {
              $query="UPDATE project.buyer SET subid='PRE' where buyerid='{$_POST['email']}'";
              $sql=$conn->prepare($query);
              $sql->execute();
            }
            $cookie_name = "userName";
            $cookie_value =  $_POST["email"];
  
            setcookie($cookie_name, $cookie_value); 
            header("Location:home.php");
            exit;
            }catch(PDOException $e){
              echo $e;
            }
        }
        else
        {
          $email = $_POST['email'];
          $count  = $conn->query("Select *  from project.seller  a where a.sellerid =\"$email\"");
          $exist = false;
  
          while ($row=$count->fetch(PDO::FETCH_ASSOC)) {
            
            foreach($row as $k => $val)
            {
                  if($k=="pass")
                  $exist = true;
            }
  
          }
          if($exist)    
          {
            echo "<script>alert('email id already exist ')</script>";
  
          }
          try{
            $sql="INSERT INTO project.seller(sellerid,pass,name,phoneno,address) 
            VALUES (:email, :pass, :name, :phoneno,:address)";
            $stmt=$conn->prepare($sql);
            $stmt->execute(array(
              ':email' =>$_POST['email'],
              ':name' =>$_POST['name'],
              ':pass' =>$_POST['pass'],
              ':phoneno' =>$_POST['phoneno'],
              ':address' =>$_POST['address']
            ));
            
            if($_POST['sub']==='pre')
            {
              $query="UPDATE project.seller SET subid='PRE' where sellerid='{$_POST['email']}'";
              $sql=$conn->prepare($query);
              $sql->execute();
            }
            
          
            $cookie_name = "userName";
            $cookie_value =  $_POST["email"];
  
            setcookie($cookie_name, $cookie_value); 
            header("Location:seller.php");
            exit;
          }catch(PDOException $e){
            echo $e;
          }
        }
      }
    ?>


    <div class="container">
      <div class="column text-center"><h1>IITGbazaar</h1></div>
    </div>
    
    <form class="container-md shadow p-3 mb-5 bg-body rounded" method="post" action="signup.php">
      <div class="mb3">
        <label for="name" class="form-label">Name</label>
        <input id="name" type="text" class="form-control" name="name" required>
      </div>
      <div class="mb-3">
      <label for="email" class="form-label">Email address</label>
      <input type="email" class="form-control" id="email" placeholder="name@iitg.ac.in" name="email" required>
      </div>
      <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" id="password" name="pass" required>
      </div>
      <div class="mb-3">
        <label for="confirm" class="form-label"> Confirm Password</label>
        <input type="password" class="form-control" id="confirm" name="confirm" required>
      </div>
      <div class="mb-3">
        <label for="phone" class="form-label">PhoneNo</label>
        <input type="text" class="form-control" id="phone" name="phoneno" required>
      </div>
      <div class="mb-3">
        <label for="address" class="form-label">Address</label>
        <input type="text" class="form-control" id="address" name="address" required>
      </div>
      <select class="form-select mb-5" name="userType">
          
          <option value="buyer" selected>Buyer</option>
          <option value="seller">Seller</option>
          
      </select>
      <select class="form-select mb-5" name="sub">
          
          <option value="basic" selected>Basic</option>
          <option value="pre">Premimum</option>
          
          </select>
      <div class='mb-3 '>
      <input type="submit" class="btn btn-primary btn-lg btn-block" name="submit">
      </div>
    </form>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    </body>
</html>