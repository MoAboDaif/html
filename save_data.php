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
	$conn = new mysqli($host, $username, $password, $dbname);
	try {
		
		$sql = "INSERT INTO visitors (first_name, last_name, gender, dob) VALUES ('$first_name', '$last_name', '$gender', '$dob')";
		
		if (($conn->query($sql) === TRUE)) {
			echo "Data saved successfully!";
		} else {
			throw new Exception("Error: " . $sql . "<br>" . $conn->error); 	
		}
			
	} catch (Exception $e) {
		$conn->rollback();
		echo "An error occurred: " . $e->getMessage();
	}
	try {
	$sql1 = "INSERT INTO comments (id, comments) VALUES (LAST_INSERT_ID(), '$comment')"; 
		
	if (($conn->query($sql1) === TRUE)) {
		echo "Comment saved successfully!";
	} else {			 
		throw new Exception("Error: " . $sql1 . "<br>" . $conn->error);
	}
			
} catch (Exception $e) {
	$conn->rollback();
	echo "An error occurred: " . $e->getMessage();
}
}
$conn->close();
?>

