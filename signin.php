<?php
$servername = "localhost"; //Name of the server where database resides, ex: 127.0.0.1
$port_no = 3306; // Port number for Windows 
$username = "user";
$password = "";
$myDB= "project"; //Name of the database to access
try {$conn = new PDO("mysql:host=$servername; port= $port_no, dbname=$myDB", $username, $password); //set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); } 
catch(PDOException $e){echo "Connection failed: " . $e->getMessage();}
?>
<!doctype html>
<html lang="en">
  <head>
    
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>SignIn</title>
    </head>
    <body>
   

    <section class="vh-100">
  <div class="container py-5 h-100">
    <div class="row d-flex align-items-center justify-content-center h-100">
      <div class="col-md-8 col-lg-7 col-xl-6">
        <img src="https://mdbootstrap.com/img/Photos/new-templates/bootstrap-login-form/draw2.svg" class="img-fluid" alt="Phone image">
      </div>
      <div class="col-md-7 col-lg-5 col-xl-5 offset-xl-1">
        <form  method="post" action="signin.php" >
          <!-- Email input -->
          <div class="form-outline mb-4">
            <input type="email" id="form1Example13" class="form-control form-control-lg" , name = "email" />
            <label class="form-label" for="form1Example13">Email address</label>
          </div>

          <!-- Password input -->
          <div class="form-outline mb-4">
            <input type="password" id="form1Example23" class="form-control form-control-lg" , name = "pass" />
            <label class="form-label" for="form1Example23">Password</label>
          </div>
          <div class='mb-3'>
          <select class="form-select mb-5" name="userType">
          
          <option value="buyer" selected>buyer</option>
          <option value="seller">seller</option>
          
          </select>
          <input type="submit" class="btn btn-primary btn-lg btn-block" name="submit" value="Log in">
          <a href="signup.php" class="btn btn-primary btn-lg btn-block" >Sign Up</a>
          <a href="home.php" class="btn btn-primary btn-lg btn-block" >Home</a>
        </div>
          
        </form>
      </div>
    </div>
  </div>
</section>

    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    
    </body>
</html>



<?php
      if(isset($_POST['submit']))
      {
        if($_POST['userType']==='buyer')
        {
          $email = $_POST['email'];
      
          $count  = $conn->query("Select a.*  from project.buyer  a where a.buyerid = \"$email\"");
          $pass = "";
          while ($row=$count->fetch(PDO::FETCH_ASSOC)) {
            
            foreach($row as $k => $val)
            {
                  if($k=="pass")
                  $pass = $val;
            }
  
          }
          if($pass=="")
          {
            echo "<script>alert('Invalid User ID ')</script>";
          }
          else if($pass!=$_POST['pass'])
          {
            echo "<script>alert('Invalid password ')</script>";
          }
          else
          {
            $cookie_name = "userName";
            $cookie_value =  $_POST["email"];
  
            setcookie($cookie_name, $cookie_value); 
            header("Location:home.php");
            exit;
  
          }
        }
        else {
          $email = $_POST['email'];
      
        $count  = $conn->query("Select a.*  from project.seller  a where a.sellerid = \"$email\"");
        $pass = "";
        while ($row=$count->fetch(PDO::FETCH_ASSOC)) {
          
          foreach($row as $k => $val)
          {
                if($k=="pass")
                $pass = $val;
          }

        }
        if($pass=="")
        {
          echo "<script>alert('Invalid User ID ')</script>";
        }
        else if($pass!=$_POST['pass'])
        {
          echo "<script>alert('Invalid password ')</script>";
        }
        else
        {
          $cookie_name = "userName";
          $cookie_value =  $_POST["email"];

          setcookie($cookie_name, $cookie_value); 
          header("Location:seller.php");
          exit;

        }
        }
        

      }
    ?>