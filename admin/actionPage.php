<?php 

include('config.php');
$baseurl = "http://" . $_SERVER['SERVER_NAME']."/food/";
// print_r($_POST);
// exit;
session_start();

if(isset($_POST) && !empty($_POST))
{
    $request_type = $_POST['request_type'];
    // print_r($_POST);
    // exit;
    
    if($request_type == 'add_dish')
    {
        $dish_name = $_POST['dish_name'];
        $dish_cost = $_POST['dish_cost'];
        $dish_desc = $_POST['dish_desc'];

        $filename = $_FILES["dish_pics"]["name"];
        $random_name = rand(100,9999).$filename;
        // $filename = rand(1000,99999);
        // $ext = pathinfo($filename, PATHINFO_EXTENSION);
        $tempname = $_FILES["dish_pics"]["tmp_name"];     
        $folder = "../images/dish_img/".$random_name;   
        
        if (move_uploaded_file($tempname, $folder)) {
            $msg = "Image uploaded successfully";
        }else{

            $msg = "Failed to upload image";

        }
        $path = $baseurl."images/dish_img/".$random_name;

        $sql = "INSERT INTO tbl_dish (id,dish_name,dish_cost,dish_desc,dish_img) values('','$dish_name', '$dish_cost','$dish_desc','$path')";
        $execute = mysqli_query($conn, $sql);
        if($execute) {
            echo '<script>alert("Dish Added")</script>';
			echo '<script>location.href="dish.php"</script>';
        } else {
            echo "error: add dish";
        }

    } else if($request_type == 'update_dish') {

        $dish_id = mysqli_real_escape_string($conn, $_POST['dish_id']);
        $dish_name = mysqli_real_escape_string($conn, $_POST['dish_name']);
        $dish_cost = mysqli_real_escape_string($conn, $_POST['dish_cost']);
        $dish_desc = mysqli_real_escape_string($conn, $_POST['dish_desc']);
        $clean_dish_desc = str_replace("\\r\\n","",$dish_desc);

        $filename = $_FILES["dish_pics"]["name"];
        $random_name = rand(100,9999).$filename;
        // $ext = pathinfo($filename, PATHINFO_EXTENSION);
        $tempname = $_FILES["dish_pics"]["tmp_name"];     
        $folder = "../images/dish_img/".$random_name;   
        
        $path = $baseurl."images/dish_img/".$random_name;
        
        if (move_uploaded_file($tempname, $folder)) {

            $msg = "Image uploaded successfully";
            $concat_sql = ", dish_img = '$path'";

        }else{

            $msg = "Failed to upload image";
            $concat_sql = '';

        }


        $update_sql = "UPDATE tbl_dish set dish_name = '$dish_name' , dish_cost = '$dish_cost' , dish_desc = '$clean_dish_desc' $concat_sql where id = '$dish_id' ";
        $execute = mysqli_query($conn, $update_sql);
        if($execute) {
            echo '<script>alert("Dish updated")</script>';
			echo '<script>location.href="dish.php"</script>';
        } else {
            echo '<script>alert("Some error occured")</script>';
			echo '<script>location.href="dish.php"</script>';
        }
        // echo $update_sql;exit();

    } else if($request_type == 'add_images') { 
        $section_name = $_POST['section_name'];
        $image_array = $_FILES["images"]["name"];
        //  print_r($image_array);exit;
        $insert_sql = '';

        if(!empty($image_array)) {
            $i=1;
            foreach($_FILES['images']['name'] as $key=>$val) 
            { 
                // File upload path 
                $fileName = basename($_FILES['images']['name'][$key]);
                $random_name = rand(100,9999).$fileName;
                $targetFilePath = "../images/dish_img/".$random_name; 
                 
                // Check whether file type is valid 
                // if(in_array($fileType, $allowTypes)){ 
                    // Upload file to server 
                    if(move_uploaded_file($_FILES["images"]["tmp_name"][$key], $targetFilePath)){ 
                        // Image db insert sql 
                        $msg[] = $i."th pic inserted";
                        $path = $baseurl."images/dish_img/".$random_name;
                        $execute = mysqli_query($conn, "INSERT into tbl_images values ('','$section_name','$path',NOW() ) ");
                    }else{ 
                        $msg = "error while uploading". $i ."th pic"  ; 
                    } 
                $i++;
            } 
            
            
                   
           
        }
        echo '<script>alert("Section Images Added")</script>';
	    echo '<script>location.href="images.php"</script>';

    } else if($request_type == 'add_user') {
       
        $name = $_POST['name']; 
        $email = $_POST['email']; 

        if(isset($_POST['mobile'])) {
            $phone = $_POST['mobile'];
        } else {
            $phone = '';
        }
         
        if(isset($_POST['address'])) {
            $address = $_POST['address'];
        } else {
            $address = '';
        }        

        $check = mysqli_query($conn, "SELECT count(*) as count from tbl_users where email = '$email' OR phone = '$phone' ");
        $check_fetch = mysqli_fetch_array($check);
        $count =  $check_fetch['count'];

        if($count > 0) {
            if($_POST['refer']) {
                echo '<script>alert("Email or Mobile already exists")</script>';
                echo '<script>location.href="../userlogin.php"</script>';
            } else {
                echo '<script>alert("Email or Mobile already exists")</script>';
                echo '<script>location.href="addUser.php"</script>';
            }
        }
        
        if($_POST['password']) {
            $password = $_POST['password'];
        } else {
            $chars = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcefghijklmnopqrstuvwxyz';
            // $chars = trim($name).$phone.$address;
            $password = substr(str_shuffle($chars), 0, 8);
        }
        if($count == 0) {
            $insert_sql = "INSERT into tbl_users values ('','$name','$email','$password', '$phone', '$address', NOW())";
            $execute = mysqli_query($conn, $insert_sql);
        }
        

        if($execute) {

            if($_POST['refer']) {
                echo '<script>alert("User Added")</script>';
	            echo '<script>location.href="../userlogin.php"</script>';
            } else {
                echo '<script>alert("User Added")</script>';
                echo '<script>location.href="users.php"</script>';
            }

        }

    } else if($request_type == 'edit_user') {

        $user_id = $_POST['user_id'];
        $name = $_POST['name']; 
        $email = $_POST['email']; 
        $phone = $_POST['mobile']; 
        $address = $_POST['address'];
        
        


        $insert_sql = "UPDATE tbl_users set name = '$name', email = '$email', phone = '$phone', address = '$address' where id = '$user_id'";
        $execute = mysqli_query($conn, $insert_sql);

        if($execute) {
        echo '<script>alert("User details Updated")</script>';
	    echo '<script>location.href="users.php"</script>';
        } else {
            echo '<script>alert("Some Error occured")</script>';
	        echo '<script>location.href="users.php"</script>';
        }
    } else if($request_type == 'user_login') {
        // print_r($_POST);
        $email = $_POST['email'];
        $password = $_POST['password'];

        $sql = mysqli_query($conn, "SELECT * from tbl_users where email = '$email' AND password = '$password' ");
        $fetch_sql = mysqli_fetch_array($sql);
        $exist = mysqli_num_rows($sql);
        
        if($exist == 0) {
            echo '<script>alert("User not found")</script>';
            echo '<script>location.href="../userlogin.php"</script>';        
        } else {
            $_SESSION['user_id'] = $fetch_sql['id'];
            $_SESSION['user_name'] = $fetch_sql['name'];
            $_SESSION['user_login'] = 1 ;
            header('location: ../index.php');
        }
    } else if ($request_type == 'decline_order') {
        $order_id = $_POST['orderId'];
        
        $statusChangeSql = mysqli_query($conn, "UPDATE tbl_orders set decline = '1' where id = '$order_id'");
        if($statusChangeSql){
            echo "Order Declined";
            exit;
        }

    }
    



} else {
    echo '<script>alert("Permission Denied")</script>';
	echo '<script>location.href="dashboard.php"</script>';
} 



?>