<?php require_once("db/db.php");?>
<?php require_once("db/session.php");?>
<?php require_once("db/function.php");?>

<?php

if(isset($_GET['id'])){
    $id=$_GET['id'];
$Query="UPDATE comment SET status='off' WHERE id='$id'" ;
$Execute=mysqli_query($Connection,$Query);
Redirect("comment.php");
}
?>