<?php require_once("db/db.php");?>
<?php require_once("db/session.php");?>
<?php require_once("db/function.php");?>

<?php
if(isset($_POST["Submit"])){
  global $Connection;
  $Title=mysqli_real_escape_string($Connection,$_POST["Title"]);
  $Category=mysqli_real_escape_string($Connection,$_POST["Category"]);
  $Post=mysqli_real_escape_string($Connection,$_POST["Post"]);
  $Image=$_FILES["Image"]["name"];
  $checkSize=$_FILES["Image"]["size"];
  $Target="Upload/".basename($_FILES["Image"]["name"]);
  $imageFileType=strtolower(pathinfo($Target,PATHINFO_EXTENSION));
  $imageFileTypeOpt=strtolower(pathinfo($Target,PATHINFO_BASENAME));
 

  $CurrentDate=Date("Y-m-d D H:i:s");
  $CurrentDate;
  $Admin=$_SESSION['Username'];;
  if(empty($Title)){
    $_SESSION["ErrorMessage"]="Please fill out field Title";
    Redirect("editnewpost.php");
    
 
  }
  elseif(mb_strlen($Title)<2){
    $_SESSION["ErrorMessage"]="Title must be at-least 2 characters long";
    Redirect("editnewpost.php");
  }
  //Image validation start
  elseif($checkSize>2000000){
    $_SESSION["ErrorMessage"]="Sorry, your file is too large, max 2MB. ";
    Redirect("editnewpost.php");
  }
  elseif(!empty($Image) && file_exists($Target)){
    $_SESSION["ErrorMessage"]="Sorry, file already exists.";
    Redirect("editnewpost.php");
  }
  elseif(!empty($Image) && $imageFileType != "jpg" 
  && $imageFileType !="jpeg"
  && $imageFileType !="png"){
    $_SESSION["ErrorMessage"]="Sorry, only JPG, JPEG and PNG files are allowed.".$imageFileTypeOpt;
    Redirect("editnewpost.php");
  }
  
  else{
    $UpdateFromUrl=$_GET['postId'];
    $Query="UPDATE panel_admin SET editdate='$CurrentDate',title='$Title',catname='$Category',author='$Admin',image='$Image',post='$Post' WHERE id='$UpdateFromUrl'";
    $Execute=mysqli_query($Connection,$Query);
    move_uploaded_file($_FILES["Image"]["tmp_name"],$Target);
      if($Execute){
      $_SESSION["SuccessMessage"]="Post updated successfully";
      Redirect("dashboard.php");
      }
    else{
      $_SESSION["ErrorMessage"]="Something went wrong, please try again";
      Redirect("dashboard.php");
      
      }
    }
  
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Bootstrap</title>

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
             <h1>Edit new post</h1>
             <!-- Message validation form-->
              <?php
              
              echo Msg();
              echo SuccessMsg();
              ?>
              <?php 
              $IdFromURL=$_GET['postId'];
              $Query="SELECT * FROM panel_admin WHERE id='$IdFromURL'";
              $Execute=mysqli_query($Connection,$Query);
              while($RowPost=mysqli_fetch_array($Execute)){
                  $EditTitle=$RowPost['title'];
                  $CategoryName=$RowPost['catname'];
                  $ImageUploaded=$RowPost['image'];
                  $PostSelected=$RowPost['post'];
              }
              ?>
              <div>
            <form action="editnewpost.php?postId=<?php echo $IdFromURL;?>" method="POST" enctype="multipart/form-data">
              <fieldset>
              <div class="form-group">
              <label for="title">Title:</label>
              <input class="form-control" type="text" name="Title" id="title" value="<?php echo $EditTitle;?>">
              </div>
              <div class="form-group">
              
              <div> Category selected: "<?php echo $CategoryName ?>" </div>
              <label for="category">Category:</label>
             
              <select class="form-control" name="Category" id="category">
          
                <?php
                $LoadTable="SELECT * FROM category ORDER BY editdate DESC" ;
                $Execute=mysqli_query($Connection,$LoadTable);
                
                while($Loadcat=mysqli_fetch_array($Execute)){
                    $id=$Loadcat["id"];
                
                    $catname=$Loadcat["catname"];
                  
                  
                
                ?>
                 <option><?php echo $catname ?> </option>
                 <?php  } ?>
             
              </select>
              </div>

              <div class="form-group">
              <label for="imgselect">Image selected:</label>
              <br>
              <img src="Upload/<?php echo $ImageUploaded ?>" alt="" width="110px" height="50px">
              </div>

              <div class="form-group">
              <label for="imgselect">Select Image:</label>
              <input class="form-control" type="File" name="Image" id="imgselect">
              </div>
      
              <div class="form-group">
              <label for="postarea">Post:</label>
              <textarea class="form-control" type="text" name="Post" id="postarea"  >
              <?php echo $PostSelected ;?>
              </textarea>
              </div>

              <br>
              <input class=" btn btn-success btn-block" type="submit" name="Submit" value="Submit Edited Post">
              
              
              <br> 
              </fieldset>
              <?php  $CurrentDate=Date("Y-m-d | H:i:s");
               echo $CurrentDate;?>
               </form>
               </div>
<!--Table start-->
               
              
              
              
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