<?php
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $search_name = $_GET["search"];

   // Connect to the database (adjust credentials)
        $configs = include('config.php');
        $host = $configs['host'];
        $username = $configs['username'];
        $password = $configs['password'];
        $dbname = $configs['dbname']; 

	$conn = new mysqli($host, $username, $password, $dbname);

	 if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
	 }

	$sql = "SELECT * FROM visitors WHERE first_name LIKE '%$search_name%' OR last_name LIKE '%$search_name%' OR gender = '$search_name'";

	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
        echo "<h2>Search Results:</h2>";
	while ($row = $result->fetch_assoc()) {
            echo "ID: " . $row["id"] . "<br>";
            echo "First Name: " . $row["first_name"] . "<br>";
            echo "Last Name: " . $row["last_name"] . "<br>";
            echo "Gender: " . $row["gender"] . "<br>";
            echo "Date of Birth: " . $row["dob"] . "<br><br>";
        }
    } else {
        echo "No results found.";
    }

	$conn->close();
}
?>
