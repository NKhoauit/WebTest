<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div class="form-container">
            <form action ='login.php' class="form" method ='POST'>
                <h2>LOGIN</h2>
                <div class="input-group">
                    <input type="text" id="login-username" name = "username" placeholder="Username" required>
                </div>
                <div class="input-group">
                    <input type="password" id="login-password" name ="password" placeholder = "Password" required>
                </div>
                <button name = "Login" type="submit">Login</button>
                <div class ="bottom"> Create an account ? <a href="register.php"> Register</a> </div> 
            </form>
</body>
</html>

<?php
session_start();
// Kết nối tới database
$connect = mysqli_connect('localhost', 'root', '', 'user');
if (!$connect) {
    die("Kết nối thất bại: " . mysqli_connect_error());
}
if(isset($_POST["Login"])){
	$user_name = $_POST["username"];
	$password = md5($_POST["password"]);
	// Kiểm tra thông tin của User 
	$rows = mysqli_query($connect,"
		select * from user where Username = '$user_name' and Password = '$password'
	");
	$count = mysqli_num_rows($rows);
	if($count==1){
		$_SESSION['username'] = $user_name;
		echo "<script type='text/javascript'>alert('Login successfully!');</script>";
		echo "<script>window.location.href='home.php';</script>";
	}
	else 
	{
		echo "<script type='text/javascript'>alert('Login failed! Please check your Username and Password again');</script>";
		echo "<script>window.location.href='login.php';</script>";
	}
}
mysqli_close($connect);
?>