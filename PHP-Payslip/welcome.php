<?php
session_start();

if(!isset($_SESSION['register_success'])){
  header('Location:index.php');
  exit();
}
else{
  unset($_SESSION['register_success']);
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>welcome login</title>
    <link href="css/all.css" rel="stylesheet">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/ekko-lightbox.css" />
  <link rel="stylesheet" href="css/main.css">
</head>
<body>


<nav class="navbar navbar-expand-sm sticky-top navbar-dark bg-info" id="main-nav">
    <div class="container">
      <div class="scroll-bar"></div>
      <a class="navbar-brand" href="index.html">PAYSLIP PLATFORM</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarCollapse">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item active">
            <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item active">
            <a class="nav-link" href="register.php">Register</a>
          </li>
        
         

        </ul>
      </div>
    </div>
  </nav>



 
  <h3 class="text-success text-center">Thank you for registration. Please log in</h3>
    <section id="heading" class="p-5">
      <div class="dark-overlay">
        <div class="row">
          <div class="offset-md-3 col-md-6 col-sm-12">
          <div class="form-outter">
              <h2 class="text-light text-center">Log in</h2>
              <hr>
              <form class="form" action="login.php" method="POST">
              <div class="form-group">
              <label for="name">Name</label>
              <input type="text" name="name" id="name" class="form-control">
             
              </div>
              <div class="form-group">
              <label for="password">Password</label>
              <input type="password" name="password" id="password" class="form-control">
              </div>
              <div class="form-group">
              <label for="name"></label>
              <input type="submit" name="submit" id="submit" class="form-control" value="Submit">
              <?php if(isset($_SESSION['fail'])){
                echo $_SESSION['fail']; 
                unset($_SESSION['fail']);
              }
                ?>
              </div>
             
              </form>
          
          </div>
            
            
             
            </div>
          </div>
        </div>
      </div>
    </section>


    <!--script file -->
<script src="js/jquery-3.3.1.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/ekko-lightbox.min.js"></script>
<script src="js/main.js"></script>
</body>
</html>