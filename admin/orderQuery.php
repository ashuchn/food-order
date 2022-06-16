<?php 

include('config.php');
$baseurl = "http://" . $_SERVER['SERVER_NAME']."/food/";

if(isset($_GET))
{
    if($_GET['orderId'])
    {
        $confirmOrder = "UPDATE tbl_orders set paid = 1  where id = ".$_GET['orderId'];
        $execute = mysqli_query($conn, $confirmOrder);
        echo "Order confirmed";
    }
}


?>