<!DOCTYPE html> 
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1"> 
	<title>Register Page</title> 
	<link rel="stylesheet" href="http://code.jquery.com/mobile/1.1.1/jquery.mobile-1.1.1.min.css" />
	<script src="http://code.jquery.com/jquery-1.7.1.min.js"></script>
	<script src="http://code.jquery.com/mobile/1.1.1/jquery.mobile-1.1.1.min.js"></script>
	<script src="jquery.validate.js"></script>
	<script src="main.js"></script>
</head> 

<body> 

<div data-role="page" id="registerPage">

	<div data-role="header">
		<a href="index.html" data-rel="back">Home</a>
		<h1>Register Page</h1>
	</div>

	<div data-role="content">	

		<div id="errorBox"><ul></ul></div>

		<form action="process.cfm" method="post" id="registerForm">

			<fieldset data-role="fieldcontain"> 
				<label for="username">Username:</label>
				<input type="text" name="username" id="username" class="required" minlength="5">
			</fieldset>

			<fieldset data-role="fieldcontain"> 
				<label for="password">Password:</label>
				<input type="password" name="password" id="password" class="required" minlength="5">
			</fieldset>

			<fieldset data-role="fieldcontain"> 
				<label for="password2">Confirm Password:</label>
				<input type="password" name="password2" id="password2" class="required passmatch" minlength="5">
			</fieldset>

			<fieldset data-role="fieldcontain"> 
				<label for="email">Email:</label>
				<input type="email" name="email" id="email" class="required email" minlength="5">
			</fieldset>

			<fieldset data-role="fieldcontain"> 
				<label for="favcolor">Favorite Color:</label>
				<select id="favcolor" name="favcolor" class="required">
					<option value="">Select One</option>
					<option value="green">Green</option>
					<option value="red">Red</option>
					<option value="blue">Blue</option>
					<option value="yellow">Yellow</option>
				</select>
			</fieldset>

			<fieldset data-role="fieldcontain"> 
				<label for="hometown">Home Town:</label>
				<input type="text" name="hometown" id="hometown">
			</fieldset>

			<input type="submit" value="Register">

		</form>

	</div>
	
	<div data-role="footer">
		<h4>Footer content</h4>
	</div>
	
</div>

</body>
</html>