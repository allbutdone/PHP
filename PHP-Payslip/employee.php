<?php
session_start();
if(!isset($_SESSION['logged'])){
    header('Location:index.php');
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payslip</title>
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
          
          <?php
            if(isset($_SESSION['id']))
                echo '<li class="nav-item">
                <a class="nav-link" href="logout.php">Logout</a>
              </li>';
            
          ?>
         

        </ul>
      </div>
    </div>
  </nav>



 

    <section id="heading" class="p-5">
      <div class="dark-overlay">
        <div class="row">
          <div class="offset-md-3 col-md-6 col-sm-12">
          <div class="form-outter">
        
            
            <?php
                echo "<h4>Welcome ".$_SESSION['user'].'<hr><h5> Here you can check your payslip.</h5>'; 
                echo "<p>Salary: ".$_SESSION['salary']." £/month</p>";
                echo "<p>Holidays left: ". $_SESSION['holiday']." days</p>";
                echo "<p>Bonus: ". $_SESSION['bonus']." £</p>";
                $total=$_SESSION['salary']+$_SESSION['bonus'];
                echo "<p>Total :".$total." £</p>";
                $tax=($total*20)/100;
                echo "<p>Tax: ".$tax." £</p>";
                $netto=$total-$tax;
                echo "<p>Netto: ".$netto." £</p>";
                echo "<p>Registration date: ".$_SESSION['regDate']."<p>";

                $curTim= new DateTime();
                //$c=DateTime::createFromFormat('Y-m-d H:i:s',$curTim);

                $taxEnd= new DateTime('2021-04-06 23:59:59');
                $endOfTaxYear=$taxEnd->diff($curTim);

                if($curTim<$taxEnd){
                  echo "<p>Days left to end of tax year: ".$endOfTaxYear->format('%m months, %d days, %H hours, %i minutes, %s sec.' )."<p>";
                }
                else if($curTim>'2022-04-07 00:00:00'&&$curTim<'2023-04-06 23:59:59'){
                  $taxEnd= new DateTime('2022-04-06 23:59:59');
                  $endOfTaxYear=$taxEnd->diff($curTim);
                  echo "<p>Days left to end of tax year: ".$endOfTaxYear->format('%m months, %d days, %H hours, %i minutes, %s sec.' )."<p>";
                }
                else{
                  $taxEnd= new DateTime('2024-04-06 23:59:59');
                  $endOfTaxYear=$taxEnd->diff($curTim);
                  echo "<p>Days left to end of tax year: ".$endOfTaxYear->format('%m months, %d days, %H hours, %i minutes, %s sec.' )."<p>";

                }
               
              

            ?>
             
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