<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $_POST["first_name"];
    $last_name = $_POST["last_name"];
    $gender = $_POST["gender"];
    $dob = $_POST["dob"];

    // Connect to the database (adjust credentials)
	$configs = include('config.php');

	// Example usage:
	$host = $configs['host'];
	$username = $configs['username'];
	$password = $configs['password'];
	$dbname = $configs['dbname'];


	$conn = new mysqli($host, $username, $password, $dbname);

	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	$sql = "INSERT INTO visitors (first_name, last_name, gender, dob) VALUES ('$first_name', '$last_name', '$gender', '$dob')";

	if ($conn->query($sql) === TRUE) {
        echo "Data saved successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
   $conn->close();

}
?>

