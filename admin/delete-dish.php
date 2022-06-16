<?php 

include('config.php');

$id = $_GET['id'];
$sql = "DELETE FROM tbl_dish where id = '$id' ";
$exe = mysqli_query($conn, $sql);

if($exe) {
    echo '<script>alert("Dish Deleted")</script>';
	echo '<script>location.href="dish.php"</script>';
}


?>