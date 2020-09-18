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
// Delete content
if ($_GET['id']) {
	$text = mysqli_real_escape_string($conn, $_POST['text']);
	$sql = "DELETE FROM forum WHERE id = ". $_GET['id']; // not safe

	if ($conn->query($sql) === FALSE) {
		echo "錯誤：". $sql. "<br>". $conn->error;
	}
	header('Location: forum.php');
}
?>

<?
// Close the database connection
$conn->close();
?>