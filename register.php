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
            <form action ='register.php' class="form" method ="POST" onsubmit="return checkInputPassword()">
                <h2>REGISTER</h2>
                <div class="input-group">
                    <input type="text" id="login-username" name ="username" placeholder="Username" required>
                </div>
                <div class="input-group">
                    <input type="password" id="login-password" name ="password" 
					placeholder = "Password (least 8 characters contain uppercase and lowercase letters)" required>
                </div>
                <div class="input-group">
                    <input type="password" id="login-password" name ="confirm-password" placeholder = "Confirm password" required>
                </div>
                <button name ="Register" type="submit">Register</button>
                <div class ="bottom"> Do you have an account ? <a href="login.php">Login</a> </div> 
            </form>
</body>
</html>

<script>
function checkPassword(password) {
    const regex = /^(?=.*[A-Z])(?=.*[a-z])(?=.{8,})/;
    return regex.test(password);
}
function checkInputPassword()
{
	let ipasswork = document.getElementById("login-password").value;
	if(checkPassword(ipasswork))
	{
		return true;
	}
	else 
	{
		window.alert("Invalid Password!. Password must contain at least 8 characters, including uppercase letters and lowercase letters.");
		return false; 
	}
}
</script>

<?php
$connect = mysqli_connect('localhost', 'root', '', 'user');
if (!$connect) {
    die("Kết nối thất bại: " . mysqli_connect_error());
}
// Xử lý thông tin form đăng ký 
if(isset($_POST["Register"])){
	$user_name = $_POST["username"];
	// Kiểm tra tên người dùng đã được đăng kí hay chưa
	$rows = mysqli_query($connect,"
	select * from user where Username = '$user_name'");
	$count = mysqli_num_rows($rows);
	if ($count != 0)
	{
		echo "<script type='text/javascript'>alert('Registration failed! Username already exists');</script>";
		echo "<script>window.location.href='register.php';</script>";
	}
	$pass1 = $_POST["password"];
	$pass2 = $_POST["confirm-password"];
	//Kiểm tra xem 2 mật khẩu có giống nhau hay không:
	if($pass1 != $pass2)
	{
		echo "<script type='text/javascript'>alert('Registration failed! Please check your password again');</script>";
		echo "<script>window.location.href='register.php';</script>";
	}

	else{
		$pass = md5($pass1);
		mysqli_query($connect,"
			insert into user (Username,Password)
			values ('$user_name','$pass')
		");
		echo "<script type='text/javascript'>alert('Registered successfully!');</script>";
		echo "<script>window.location.href='login.php';</script>";
	}
	mysqli_close($connect);
}
