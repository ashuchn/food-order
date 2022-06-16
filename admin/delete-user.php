<?php 

include('config.php');

if(!isset($_GET['id'])) {
    echo '<script>alert("Invalid User id")</script>';
	echo '<script>location.href="users.php"</script>';
}

$id = $_GET['id'];
$sql = "DELETE FROM tbl_users where id = '$id' ";
$exe = mysqli_query($conn, $sql);

if($exe) {
    echo '<script>alert("User Deleted")</script>';
	echo '<script>location.href="users.php"</script>';
} else {
    echo '<script>alert("Some error occured")</script>';
	echo '<script>location.href="users.php"</script>';
}


?>