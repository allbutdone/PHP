




<?php require_once("db/db.php");?>
<?php require_once("db/session.php");?>
<?php require_once("db/function.php");?>
<?php Login_authori();?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>HTML PHP MySQL Bootstrap</title>

  <!--Local sources -remove for online purpose-->
  <!--Local sources -remove for online purpose-->
  <!--Local sources -remove for online purpose******************************-->

  <link href="css/all.css" rel="stylesheet">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.css" />
  <link rel="stylesheet" href="main.css">
  <!-- end of local sources-->
  <!-- end of local sources-->
  <!-- end of local sources*****************************************************-->

  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css"
    integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css"
    integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.css" />
  <link rel="stylesheet" href="main.css">


</head>

<body>
 <div class="container-fluid">
     <div class="row">
     <div class="col-sm-2">
           <!-- side menu-->
           <h2 class="text-light"><i class="fa fa-user-cog"></i> <?php echo $_SESSION['Username']?></h2> 
             <ul id="menu" class="nav nav-pills flex-column">
                 <a class="nav-item nav-link active bg-secondary rounded text-light mb-2" href="dashboard.php"> <span class="fas fa-home"></span>&nbsp;Dashboard</a>
                 <a class="nav-item nav-link bg-secondary rounded text-light mb-2" href="addnew.php"><span class="fas fa-plus"></span>&nbsp;Add Post</a>
                 <a class="nav-item nav-link bg-secondary rounded text-light mb-2" href="category.php"><span class="fas fa-tags"></span>&nbsp;Categories</a>
                 <a class="nav-item nav-link bg-secondary rounded text-light mb-2" href="admin.php"><span class="fas fa-user"></span>&nbsp;Admin</a>
                 <a class="nav-item nav-link bg-secondary rounded text-light mb-2" href="comment.php"><span class="fas fa-comment"></span>&nbsp;Comments
                 <?php
                  $Query="SELECT count(*) FROM comment WHERE status='off'";
                  $Execut=mysqli_query($Connection, $Query);
                  $Total=mysqli_fetch_array($Execut);
                  $TotalComment=array_shift($Total);

                  ?>
                  <span class="badge badge-warning">
                  <?php echo $TotalComment ?></span>
                
                </a>
                <a class="nav-item nav-link bg-secondary rounded text-light mb-2" href="blog.php?page=1" target="_blank"><span class="fas fa-list"></span>&nbsp;Blog</a>
                 <a class="nav-item nav-link bg-secondary rounded text-light mb-2" href="logout.php"><span class="fa fa-sign-out-alt"></span>&nbsp;Logout</a>
             </ul>
         </div> <!-- side menu END-->
         <div class="col-sm-10">
         
             <h1>Comments not approved</h1>
             <?php 
             echo SuccessMsg();
             echo Msg();?>
             <table class="table table-sm table-striped">
               <tr>
                  <th>Id</th>
                  <th>Editdate</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Comment</th>
                  <th>Status</th>
                  <th>Preview</th>
                 
               </tr>
               <?php 
               $Query="SELECT * FROM comment WHERE status='off' ORDER BY editdate";
               $Execut=mysqli_query($Connection, $Query);
               $OrderNr=0;
               while($Row=mysqli_fetch_array($Execut)){
                $id=$Row['id'];
                $Editdate=$Row['editdate'];
                
                $Name=$Row['name'];
                $Email=$Row['email'];
                $Comment=$Row['comment'];
                $Status=$Row['status'];
                $URLid=$Row['panel_admin_relation_id'];
                $OrderNr++;
               ?>
               <tr>
                  <td><?php echo $OrderNr; ?></td>
                  <td><?php if(strlen($Editdate)>11){$Editdate=substr($Editdate,0,11).'...';}echo $Editdate; ?></td>
                  <td><?php if(strlen($Name)>12){$Name=substr($Name,0,12).'...';}echo $Name ;?></td>
                  <td><?php echo $Email ?></td>
                  <td><?php if(strlen($Comment)>70){$Comment=substr($Comment,0,70);} echo $Comment ?></td>
                  <td><a href="commentapprove.php?id=<?php echo $id ?>"><span class="btn btn-success btn-sm">Approve</span></a>
                  <a href="commentdelete.php?id=<?php echo $id ?>"><span class=" btn btn-danger btn-sm">Delete</span></a></td>
                  
                 
                  
                  
                  <td><a href="singlepost.php?id=<?php echo $URLid ?>"><span class="btn btn-info btn-sm">Preview</span></a></td>
               </tr>
               <?php  } ?>
              
             </table>

             <h3>Approved comments</h3>
             <table class="table table-sm table-striped">
               <tr>
                  <th>Id</th>
                  <th>Editdate</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Comment</th>
                  <th>Approved by</th>
                  <th>Status</th>
                  <th>Preview</th>
                 
               </tr>
               <?php 
               
               $Query="SELECT * FROM comment WHERE status='on' ORDER BY editdate";
               $Execut=mysqli_query($Connection, $Query);
               $OrderNr=0;
               while($Row=mysqli_fetch_array($Execut)){
                $id=$Row['id'];
                $Editdate=$Row['editdate'];
                
                $Name=$Row['name'];
                $Email=$Row['email'];
                $Comment=$Row['comment'];
                $approvedby=$Row['approvedby'];
                $Status=$Row['status'];
                $URLid=$Row['panel_admin_relation_id'];
                $OrderNr++;
               ?>
               <tr>
                  <td><?php echo $OrderNr; ?></td>
                  <td><?php if(strlen($Editdate)>11){$Editdate=substr($Editdate,0,11).'...';}echo $Editdate; ?></td>
                  <td><?php if(strlen($Name)>12){$Name=substr($Name,0,12).'...';}echo $Name ;?></td>
                  <td><?php echo $Email ?></td>
                  <td><?php echo $Comment ?></td>
                  <td><?php echo $approvedby ?></td>
                  
                 
                 
                  
                  
                  <td><a href="disapprove.php?id=<?php echo $id ?>"><span class="btn btn-warning btn-sm">Disapprove</span></a></td>
                  <td><a href="singlepost.php?id=<?php echo $URLid ?>"><span class="btn btn-info btn-sm">Preview</span></a></td>
               </tr>
               <?php  } ?>
              
             </table>
         </div>
        
         
     </div><!--row end-->
 </div> <!--container end-->
<div id="footer">
    <hr><p>Designed By | Janus |&copy;2020</p>
    <hr>
</div>



   
  
  <!--ONLINE accesss to script files-->
  <script src="http://code.jquery.com/jquery-3.3.1.min.js"
      integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
      integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
      crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"
      integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T"
      crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.min.js"></script>

    <script src="main.js"></script>



    <!-- remove below for online page-->
    <!-- remove below for online page-->
    <!-- remove below for online page ****************************************-->
    <script src=jquery-3.3.1.min.js></script>
    <script src=js/popper.min.js></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="main.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.min.js"></script>
    <!-- end of local sources-->
    <!-- end of local sources-->
    <!-- end of local sources *************************************************-->
</body>

</html>