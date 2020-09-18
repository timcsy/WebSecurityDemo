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
// Signed up
if ($_POST['username'] && $_POST['password'] && $_POST['confirm']) {
	if ($_POST['password'] == $_POST['confirm']) {
		$username = $_POST['username'];
		// Check if user has existed
		$sql = "SELECT username FROM users WHERE username = '". $username. "'";
		if ($conn->query($sql)->num_rows == 0) {
			$password = $_POST['password'];
			// Create new user
			$sql = "INSERT INTO users (username, password) VALUES ('". $username. "', '". $password. "')";
			if ($conn->query($sql) === FALSE) {
				echo "錯誤：". $sql. "<br>". $conn->error;
			} else {
				header('Location: login.php');
				$conn->close();
				exit();
			}
		}
	}
}
?>

<!DOCTYPE html>
<html>
	<head>
		<title>註冊</title>
	</head>
	<body>
		<form action="" method="POST">
			帳號：<input type="text" name="username"><br>
			密碼：<input type="password" name="password"><br>
			確認密碼：<input type="password" name="confirm"><br>
			<input type="submit" value="註冊">
		</form>
	</body>
</html>

<?
// Close the database connection
$conn->close();
?>