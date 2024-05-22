<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$user_name = $_POST["user_name"];
	$first_name = $_POST["first_name"];
    	$last_name = $_POST["last_name"];
    	$gender = $_POST["gender"];
    	$dob = $_POST["dob"];
	$comment = $_POST["user_comment"];

    // Connect to the database (adjust credentials)
	$configs = include('config.php');

	$host = $configs['host'];
	$username = $configs['username'];
	$password = $configs['password'];
	$dbname = $configs['dbname'];

	try {
		$conn = new mysqli($host, $username, $password, $dbname);
		$sql = "INSERT INTO visitors (user_name, first_name, last_name, gender, dob, comments) VALUES ('$user_name', '$first_name', '$last_name', '$gender', '$dob', '$comment')";
		if (($conn->query($sql) === TRUE)) {
			echo "Data & Comment saved successfully!";
		} else {
			throw new Exception("Error: " . $sql . "<br>" . $conn->error);
		}
		$conn->close();		
	} catch (Exception $e) {
		echo "An error occurred: " . $e->getMessage();
	}

}
?>

