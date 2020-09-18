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
if (!isset($_SESSION['username'])) {
	header('Location: login.php');
	$conn->close();
	exit();
}
$username = $_SESSION['username'];
?>
<?
// Add content
if ($_POST['text']) {
	$text = mysqli_real_escape_string($conn, $_POST['text']);
	$sql = "INSERT INTO forum (name, text) VALUES ('". $username. "', '". $text. "')"; // not safe

	if ($conn->query($sql) === FALSE) {
		echo "錯誤：". $sql. "<br>". $conn->error;
	}
}
?>

<!DOCTYPE html>
<html>
	<head>
		<title>留言板</title>
	</head>
	<body>
		<a href="logout.php"><button>登出</button></a>
		<form action="" method="POST">
			<p>Hello <? echo $username; ?>，想說什麼呢？</p>
			<textarea name="text" cols="50" rows="7" style="margin-left: 8px;"></textarea>
			<p><input type="submit" value="送出" style="margin-left: 8px;"></p>
		</form>

		<p>留言區</p>
		<?
		// List contents
		$sql = "SELECT * FROM forum";
		$result = $conn->query($sql);

		if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				echo '<hr class="solid" align="left" width="50%">';
				echo '<p style="margin-left: 12px;">'. $row["name"]. ": ";
				echo '<a href="delete.php?id='. $row["id"]. '"><button>刪除</button></a></p>';
				echo '<p style="margin-left: 24px;">'. $row["text"]. "</p>"; // not safe
			}
		}
		?>
	</body>
</html>

<?
// Close the database connection
$conn->close();
?>