<?php
    setcookie('userName',"",time()-360);
    header("Location:home.php");
?>