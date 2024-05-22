<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visitor Data Search</title>
</head>
<body>
    <h1>Search Visitor Data</h1>
    <form action="search_data.php" method="get">
        <label for="search_name">Search by First Name, Last Name, or Gender:</label>
        <input type="text" id="search_name" name="search_name" required>
        <input type="submit" value="Search">
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "GET") {
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

        // Retrieve user input for search
        $search_name = $_GET["search_name"];

        // Construct SQL query to search by first name, last name, or gender
        $sql = "SELECT visitors.*, comments.comments FROM visitors LEFT JOIN comments ON visitors.id = comments.id WHERE visitors.first_name LIKE '%$search_name%' OR visitors.last_name LIKE '%$search_name%' OR visitors.gender = '$search_name'";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<h2>Search Results:</h2>";
    while ($row = $result->fetch_assoc()) {
        echo "ID: " . $row["id"] . "<br>";
        echo "First Name: " . $row["first_name"] . "<br>";
        echo "Last Name: " . $row["last_name"] . "<br>";
        echo "Gender: " . $row["gender"] . "<br>";
        echo "Date of Birth: " . $row["dob"] . "<br>";
        echo "Comment: " . $row["comments"] . "<br><br>";
    }
} else {
    echo "No results found.";
}

        $conn->close();
    }
    ?>
</body>
</html>

