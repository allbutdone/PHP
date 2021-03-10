<?php
session_start();

if(isset($_POST['email'])){

  $validation=true;
  $user=$_POST['user'];
  if((strlen($user)<3) ||(strlen($user)>20)){
    $validation=false;
    $_SESSION['err_user']="Name must have between 3 and 20 characters";
    }
  if(ctype_alnum($user)==false){
    $validation=false;
    $_SESSION['err_user']="Use only regular characters and numbers";
  }
  $email=$_POST['email'];
  $email_val=filter_var($email, FILTER_SANITIZE_EMAIL);
  if((filter_var($email_val,FILTER_VALIDATE_EMAIL)==false)||($email!=$email_val)){
    $validation=false;
    $_SESSION['err_email']="Add correct email address";
  }
  $password1=$_POST['password1'];
  if(strlen($password1)<8 || strlen($password1)>20){
    $validation=false;
    $_SESSION['err_password1']="Password must be between 8 and 20 characters";
  }
  $password2=$_POST['password2'];
  if($password1!=$password2){
    $validation=false;
    $_SESSION['err_password2']="Passwords must be the same";
  }

  $password_hash=password_hash($password1,PASSWORD_DEFAULT);
  
  if(!isset($_POST['terms'])){
    $validation=false;
    $_SESSION['err_terms']="Accept terms and conditions";
  }

  require_once "connect.php";
  mysqli_report(MYSQLI_REPORT_STRICT);
  try{
    $connection=new mysqli($host,$db_user,$db_password,$db_name);
    if($connection->connect_errno!=0){
      throw new Exception(mysqli_connect_errno());
    }
    else{
      // check if email already exists
      $result=$connection->query("SELECT id FROM users WHERE email='$email'");
      
      if(!$result) throw new Exception($connection->error);

      $email_nu=$result->num_rows;
      if($email_nu>0){
        $validation=false;
        $_SESSION['err_email']="Email already exists in database.";
         
      }
      // check if user name already exists
      $result=$connection->query("SELECT id FROM users WHERE user='$user'");
      
      if(!$result) throw new Exception($connection->error);

      $user_nu=$result->num_rows;
      if($user_nu>0){
        $validation=false;
        $_SESSION['err_user']="User name already exists in database.";
         
      }
      if($validation==true){
        //positive validation of form
        if($connection->query("INSERT INTO users VALUES(NULL,'$user','$password_hash','$email',2000,14,0,'on',now())")){
          $_SESSION['register_success']=true;
          header('Location:welcome.php');
        }
        else{
          throw new Exception($connection->error);
        }

      }
      $connection->close();  
    }
  }
  catch(Exception $e){
    echo '<div class="alert alert-danger">Server error. Please try again.</div>';
   //echo '<br>Developer info '.$e;
  }


  

  
  }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register employee</title>
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
         
        
         

        </ul>
      </div>
    </div>
  </nav>



 

    <section id="register" class="p-5">
      <div class="dark-overlay">
        <div class="row">
          <div class="offset-md-3 col-md-6 col-sm-12">
          <div class="form-outter">
              <h2 class="text-light text-center">Register</h2>
              <hr>
              <form class="form"  method="POST">
              <div class="form-group">
              <label for="user">Name</label>
              <input type="text" name="user" id="user" class="form-control">
              <?php
              if(isset($_SESSION['err_user'])){
              echo '<div class="alert alert-danger mt-1">Error: '.$_SESSION['err_user'].'</div>';
              unset($_SESSION['err_user']);
              }
              ?>
              </div>
              <div class="form-group">
              <label for="email">Email</label>
              <input type="email" name="email" id="email" class="form-control">
              <?php
              if(isset($_SESSION['err_email'])){
              echo '<div class="alert alert-danger mt-1">Error: '.$_SESSION['err_email'].'</div>';
              unset($_SESSION['err_email']);
              }
              ?>
            
              </div>
              <div class="form-group">
              <label for="password1">Password</label>
              <input type="password" name="password1" id="password1" class="form-control">
              <?php
              if(isset($_SESSION['err_password1'])){
              echo '<div class="alert alert-danger mt-1">Error: '.$_SESSION['err_password1'].'</div>';
              unset($_SESSION['err_password1']);
              }
              ?>
              
              </div>
              <div class="form-group">
              <label for="password2">Repeat Password</label>
              <input type="password" name="password2" id="password2" class="form-control">
              <?php
              if(isset($_SESSION['err_password2'])){
              echo '<div class="alert alert-danger mt-1">Error: '.$_SESSION['err_password2'].'</div>';
              unset($_SESSION['err_password2']);
              }
              ?>
              </div>
              <div class="form-group">
              <label for="terms">I accept terms and conditions.<input type="checkbox" name="terms" id="terms" class="form-control w-25"></label>
              <?php
              if(isset($_SESSION['err_terms'])){
              echo '<div class="alert alert-danger mt-1">Error: '.$_SESSION['err_terms'].'</div>';
              unset($_SESSION['err_terms']);
              }
              ?>
              <div class="form-group">
             
              <div class="form-group">
              <label for="name"></label>
              <input type="submit" name="submit" id="submit" class="form-control" value="Register">
              
            
              <?php if(isset($_SESSION['fail']))
                echo $_SESSION['fail']; 
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