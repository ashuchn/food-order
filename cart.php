<?php 
session_start();
include('admin/config.php');
if(empty($_SESSION['user_login']) )
{
    echo '<script>alert("Login first")</script>';
    echo '<script>location.href="index.php"</script>';
}
// print_r($_SESSION);

$userId = $_SESSION['user_id'];


$item_count_sql = mysqli_query($conn, "SELECT count(*) as dish_count from tbl_orders where user_id = '$userId' ");
$item_count_fetch = mysqli_fetch_array($item_count_sql);
$item_count = $item_count_fetch['dish_count'];


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="cart.css">
    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

</head>
<body>
<section class="h-100 h-custom" style="background-color: #d2c9ff;">
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-12">
        <div class="card card-registration card-registration-2" style="border-radius: 15px;">
          <div class="card-body p-0">
            <div class="row g-0">
              <div class="col-lg-12">
                <div class="p-5">
                  <div class="d-flex justify-content-between align-items-center mb-5">
                    <h1 class="fw-bold mb-0 text-black">Shopping Cart</h1>
                    <h6 class="mb-0 text-muted"><?php echo $item_count.' Items';  ?></h6>
                  </div>
                  <hr class="my-4">

                  
<!-- one row starrts -->
                <?php 
                
                $order_sql = mysqli_query($conn, "select orders.*, orders.id as orderId, dish.*  from tbl_orders as orders join tbl_dish as dish on orders.dish_id = dish.id WHERE orders.user_id = '$userId'; ");
                
                while($item = mysqli_fetch_array($order_sql)) { ?>
                    <div class="row mb-4 d-flex justify-content-between align-items-center">
                        <div class="col-md-2 col-lg-2 col-xl-2">
                        <img
                            src="<?php echo $item['dish_img'] ?>"
                            class="img-fluid rounded-3" alt="">
                        </div>
                        <div class="col-md-3 col-lg-3 col-xl-3">
                        
                        <h6 class="text-black mb-0"><?php echo $item['dish_name'] ?></h6>
                        <h6 class="text-muted"><?php echo mb_strimwidth($item['dish_desc'] , 0, 40, '...'); ?></h6>
                        </div>

                        <div class="col-md-2 col-lg-2 col-xl-2 offset-lg-1">
                        <h6 class="mb-0"><?php echo "Rs. ".$item['dish_cost'] ?></h6>
                        </div>
                        <?php if($item['paid'] == 0){ ?>
                            <div class="col-md-3 col-lg-3 col-xl-3 text-end">
                            <button id="confirmBtn<?php echo $item['orderId']; ?>" class="btn btn-primary mb-2" value="<?php echo "orderId=".$item['orderId']; ?>" onclick="return confirmOrder(this)"  >
                            <!-- <img src="https://img.icons8.com/external-dreamstale-lineal-dreamstale/32/undefined/external-confirm-ui-dreamstale-lineal-dreamstale.png"/>  -->
                                Confirm Order
                            </button>
                            <button  class="btn btn-danger"><img src="https://img.icons8.com/material-outlined/24/undefined/trash--v1.png"/> Remove from Cart</button>
                            </div>
                        <?php } else { ?>
                            <div class="col-md-3 col-lg-3 col-xl-3 text-end">
                            <a class="btn btn-primary mb-2"><img src="https://img.icons8.com/external-dreamstale-lineal-dreamstale/32/undefined/external-confirm-ui-dreamstale-lineal-dreamstale.png"/> Order Placed</a>
                            <!-- <a class="btn btn-danger"><img src="https://img.icons8.com/material-outlined/24/undefined/trash--v1.png"/> Remove from Cart</a> -->
                            </div>
                        <?php } ?>
                    </div>

                    <hr class="my-4">


                <?php } ?>
                <!-- one row ends -->
                  <div class="pt-5">
                    <h6 class="mb-0"><a href="index.php" class="text-body"><i
                          class="fas fa-long-arrow-alt-left me-2"></i>Back to Home</a></h6>
                  </div>
                </div>
              </div>
              
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</body>
</html>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>
  function confirmOrder(params)
  {
    var parmValue = params.value;
    var split = parmValue.split('=');
    // console.log(split);
    orderId = split[1];

    query = "?orderId=" + orderId;
    btnId = params.id; 
    // console.log(btnId);
    //         return false;

          $('#'+btnId).html('Please wait...');
            $('#'+btnId).attr('disabled', true);
            //  console.log(query);
            // return false;
            $.ajax({
                type: 'get',
                url: 'admin/orderQuery.php'+query,
                success: function(data) {
                    $('#'+btnId).attr('disabled', true);
                    $('#'+btnId).html('Order Confirmed');
                    // alert(data);
                    // $("p").text(data);
                    console.log(data);

                }
      });


  }
</script>