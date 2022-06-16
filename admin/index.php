<?php
error_reporting(0);
include('config.php');
session_start();

if(!empty($_SESSION) && $_SESSION['loggedin'] == 1 ) {
	header('location: dashboard.php');
}

if(!empty($_POST))
{
    $request_type = $_POST['request_type'];

    if($request_type == 'login') {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $sql = "SELECT count(*) as count from admin where email = '$email' and password = '$password' ";
        $execute = mysqli_query($conn, $sql);
        $execute1 = mysqli_fetch_array($execute);
        $count = $execute1['count'];
		
		if($count == 1) {
			$_SESSION['loggedin'] = 1;
			header('location: dashboard.php');
		} else {
			$_SESSION['loggedin'] = 0;
			echo '<script>alert("Invalid Credentials")</script>';
			echo '<script>location.href="index.php"</script>';
		}

    } else {
		$name = $_POST['name'];
		$email = $_POST['email'];
        $password = $_POST['password'];

		$sql = "INSERT INTO admin values('', '$name', '$email', '$password','')";
		$execute = mysqli_query($conn, $sql);
		if($execute) {
			echo '<script>alert("New user added")</script>';
			echo '<script>location.href="index.php"</script>';
		}

    }

}

?>
<!DOCTYPE html>
<html>
<head>
	<title> Login Form</title>
	<link rel="stylesheet" type="text/css" href="log.css">
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css">
</head>
<body>
	<div class="container" id="main">
		<div class="sign-up">
			<form action="" id="signup_form" method="post">
				<h1>Create Account</h1>
				<div class="social-container">
					<a href="#" class="social"><i class="fab fa-facebook-f"></i></a>
					<a href="#" class="social"><i class="fab fa-google-plus-g"></i></a>
					<a href="#" class="social"><i class="fab fa-linkedin-in"></i></a>
				</div>
				<p>or use your email for registration</p>
				<input type="text" name="name" placeholder="Name" required="">
				<input type="email" name="email" placeholder="Email" required="">
				<input type="password" name="password" placeholder="Password" required="">
				<input type="hidden" name="request_type" id="request_type" value="signup">
				<button type="submit">Sign Up</button>
			</form>
		</div>
		<div class="sign-in">
			<form action="" id="login_form" method="post">
				<h1>Sign in</h1>
				<div class="social-container">
					<a href="#" class="social"><i class="fab fa-facebook-f"></i></a>
					<a href="#" class="social"><i class="fab fa-google-plus-g"></i></a>
					<a href="#" class="social"><i class="fab fa-linkedin-in"></i></a>
				</div>
				<p>or use your account</p>
				<input type="email" name="email" id="email" placeholder="Email" required>
				<input type="password" name="password" id="password" placeholder="Password" >
				<input type="hidden" name="request_type" id="request_type" value="login">
				<a href="#">Forget your Password?</a>
				<button type="submit" id="sign-in-btn">Sign In</button>
			</form>
		</div>
		<div class="overlay-container">
			<div class="overlay">
				<div class="overlay-left">
					<h1>Wellcome Back!</h1>
					<p>To keep connected with us please login with your personal info</p>
					<button id="signIn">Sign In</button>
				</div>
				<div class="overlay-right">
					<h1>Hello, Friend</h1>
					<p>Enter your personal details and start journey with us</p>
					<button id="signUp">Sign Up</button>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		const signUpButton = document.getElementById('signUp');
		const signInButton = document.getElementById('signIn');
		const main = document.getElementById('main');

		signUpButton.addEventListener('click', () => {
			main.classList.add("right-panel-active");
		});
		signInButton.addEventListener('click', () => {
			main.classList.remove("right-panel-active");
		});
	</script>
</body>
</html>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<!-- login -->

<!-- <script>
	$('#login_form').on('submit', function(e){
        e.preventDefault();
        $('#sign-in-btn').html('Loggin in...');
        $('#sign-in-btn').attr('disabled', true);
        
        $.ajax({
            type: 'post',
            url: 'loginStatus.php',
            data: $('#login_form').serialize(),
            success: function (response) {
                // $('#login_form')[0].reset();
                // $('#sign-in-btn').attr('disabled', false);
                // $('#sign-in-btn').html('Sign In');
                if(response == 1) {
					window.location = 'dashboard.php';
				} else {
					alert('Invalid Credentials');
					$('#login_form')[0].reset();
					$('#sign-in-btn').attr('disabled', false);
					$('#sign-in-btn').html('Sign In');
				}
				console.log(response);
            }
        });
    });
</script> -->