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

<!DOCTYPE html>
<html>
	<head>
		<title>首頁</title>
	</head>
	<body>
		<a href="login.php"><button>登入</button></a>
		<a href="signup.php"><button>註冊</button></a>
	</body>
</html>

<?
// Close the database connection
$conn->close();
?>