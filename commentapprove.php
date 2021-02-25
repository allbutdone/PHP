
<?php require_once("db/db.php");?>
<?php require_once("db/session.php");?>
<?php require_once("db/function.php");?>

<?php

if(isset($_GET['id'])){
    $id=$_GET['id'];
    $approvedby=$_SESSION['Username'];
$Query="UPDATE comment SET approvedby='$approvedby' , status='on'  WHERE id='$id'" ;
$Execute=mysqli_query($Connection,$Query);
Redirect("comment.php");
}
?>