
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
			<form action="admin/actionPage.php" method="post">
				<h1>Create Account</h1>
				<div class="social-container">
					<a href="#" class="social"><i class="fab fa-facebook-f"></i></a>
					<a href="#" class="social"><i class="fab fa-google-plus-g"></i></a>
					<a href="#" class="social"><i class="fab fa-linkedin-in"></i></a>
				</div>
				<p>or use your email for registration</p>
				<input type="text" name="name" placeholder="Name" required="">
				<input type="email" name="email" placeholder="Email" required="">
				<input type="number" name="mobile" placeholder="Mobile" required="">
				<input type="password" name="password" placeholder="Password" required="">
				<input type="hidden" name="request_type" value="add_user">
				<input type="hidden" name="refer" value="userlogin">
				<button>Sign Up</button>
			</form>
		</div>
		<div class="sign-in">
			<form action="admin/actionPage.php" method="post">
				<h1>Sign in</h1>
				<div class="social-container">
					<a href="#" class="social"><i class="fab fa-facebook-f"></i></a>
					<a href="#" class="social"><i class="fab fa-google-plus-g"></i></a>
					<a href="#" class="social"><i class="fab fa-linkedin-in"></i></a>
				</div>
				<p>or use your account</p>
				<input type="email" name="email" placeholder="Email" required="">
				<input type="password" name="password" placeholder="Password" required="">
				<input type="hidden" name="request_type" value="user_login">
				<a href="#">Forget your Password?</a>
				<button>Sign In</button>
			</form>
		</div>
		<div class="overlay-container">
			<div class="overlay">
				<div class="overlay-left">
					<h1>Welcome Back!</h1>
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