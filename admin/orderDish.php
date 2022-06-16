<?php 
include('config.php');
session_start();

if(isset($_SESSION) && $_SESSION['user_login'] == 1 && isset($_SESSION['user_id']) && isset($_GET['dish_id']) && isset($_GET['user_id']))
{
    sleep(2);
// print_r($_GET);exit;
$dish_id =$_GET['dish_id'];
$user_id =$_GET['user_id'];

$checkSql = mysqli_query($conn, "SELECT count(*) as count from tbl_orders where user_id ='$user_id' AND dish_id = '$dish_id' ");
$fetchSql = mysqli_fetch_array($checkSql);
$count = $fetchSql['count'];

if($count > 0) {
    // echo '<script>alert("Already Added to Cart")</script>';
    // echo '<script>location.href="../index.php"</script>';
    echo "Dish Already added to cart";
    exit();
}


$orderSql = mysqli_query($conn, "INSERT INTO tbl_orders values ('','$user_id', '$dish_id', '0','0', NOW() )");
if($orderSql) {
    echo "Dish Added to cart";exit();
    // echo '<script>alert("Added to Cart")</script>';
    // echo '<script>location.href="../index.php"</script>';
} else {
    // echo '<script>alert("Error while adding to cart")</script>';
    // echo '<script>location.href="../index.php"</script>';
    echo "Error while adding to cart";exit();
}



} else {
    echo "unauthorized access";exit();
    // echo '<script>alert("Unauthorized access")</script>';
    // echo '<script>location.href="../index.php"</script>';
}



?>