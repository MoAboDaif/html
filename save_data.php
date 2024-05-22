<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $_POST["first_name"];
    $last_name = $_POST["last_name"];
    $gender = $_POST["gender"];
    $dob = $_POST["dob"];
	$comment = $_POST["user_comment"];

    // Connect to the database (adjust credentials)
	$configs = include('config.php');

	// Example usage:
	$host = $configs['host'];
	$username = $configs['username'];
	$password = $configs['password'];
	$dbname = $configs['dbname'];

	try {
		$conn = new mysqli($host, $username, $password, $dbname);
		$sql = "INSERT INTO visitors (first_name, last_name, gender, dob) VALUES ('$first_name', '$last_name', '$gender', '$dob')";
		$sql1 = "INSERT INTO comments (comments) VALUES ('$comment')"; 
		
		if (($conn->query($sql) === TRUE) && ($conn->query($sql) === TRUE)) {
			echo "Data & Comment saved successfully!";
		} else {
			throw new Exception("Error: " . $sql . "<br>" . $conn->error);
			throw new Exception("Error: " . $sql1 . "<br>" . $conn->error);
		}
		$conn->close();		
	} catch (Exception $e) {
		echo "An error occurred: " . $e->getMessage();
	}

}
?>

