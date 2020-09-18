<?
// Using session
session_start(['cookie_secure' => false, 'cookie_httponly' => true]); // turn on cookie_secure if using HTTPS
// Include environment variables
require('env.php');
?>
<?
// Database connection
$conn = new mysqli($DB_HOST, $DB_USER, $DB_PASSWORD, $DB_NAME);

if ($conn->connect_error) {
	die("連線失敗: ". $conn->connect_error);
}
?>
<?
// Check if logged in
if (isset($_SESSION['username'])) {
	header('Location: forum.php');
	$conn->close();
	exit();
}
?>
<?
// Check if username and password are correct
if ($_POST['username'] && $_POST['password']) {
	$username = $_POST['username'];
	$password = $_POST['password'];
	$sql = "SELECT * FROM users WHERE username = '". $username. "' and password = '". $password. "'"; // not safe
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
		$_SESSION['username'] = $username;
		header('Location: forum.php');
		$conn->close();
		exit();
	} else {
		echo "<p>登入失敗</p>";
	}
}
?>

<!DOCTYPE html>
<html>
	<head>
		<title>登入</title>
	</head>
	<body>
		<form action="" method="POST">
			帳號：<input type="text" name="username"><br>
			密碼：<input type="password" name="password"><br>
			<input type="submit" value="登入">
		</form>
		沒有帳號嗎？<a href="signup.php"><button>註冊新帳號</button></a>
	</body>
</html>

<?
// Close the database connection
$conn->close();
?>