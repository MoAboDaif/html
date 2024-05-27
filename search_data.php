<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visitor Data Search</title>
</head>
<style>
        :root {
            --max-width-container: 500px;
        }
        body {
            font-family: Arial, sans-serif;
            background-color: #000;
            margin: 100px;
            padding: 0 auto;
        }
        .container {
            max-width: var(--max-width-container);
            margin: 0 auto;
            margin-bottom: 50px;
            padding: 10px;
            background-color: #dcdce6;
            border-radius: 50px;
            box-shadow: 5px 40px 20px rgba(255, 255, 255, 0.5);
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        label {
            display: block;
            margin-bottom: 5px;
            margin-top: 20px;
        }
        input[type="text"],
        input[type="date"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-left: 50px;
            margin-bottom: 20px;
            max-width: calc(var(--max-width-container) - 100px);
        }
        input[type="radio"] {
            margin-right: 10px;
        }
        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 30px;
            border-radius: 3px;
            cursor: pointer;
            margin-left: calc((var(--max-width-container) / 2) - 30px);
            margin-bottom: 50px;
        }
        textarea[id="user_comment"] {
            width: 100%;
            border: 1px solid #ccc;
            border-radius: 5px;
            min-width: none;
            margin-left: 50px;
            margin-bottom: 20px;
            max-width: calc(var(--max-width-container) - 85px);
            max-height: 200px;
        }
        h1.white {
            margin-top: 100px;
        }
        .column {
    float: left;
    width: 50%;
}
.row:after {
    content: "";
    display: table;
    clear: both;
}
.left {
    width: 25%;
}
.right {
    width: 75%;
}
@media screen and (max-width: 600px) {
    .column {
        width: 100%;
    }
}
body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
        }
        h2 {
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #f5f5f5;
        }
</style>
<body>
<div class="container">
    <h1>Search Visitor Data</h1>
        <label for="search_name">Search by First Name, Last Name, or Gender:</label>
        <input type="text" id="search_name" name="search_name" required>
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
        $sql = "SELECT visitors.*, comments.comments FROM visitors LEFT JOIN comments ON visitors.id = comments.visitor_id WHERE visitors.first_name LIKE '%$search_name%' OR visitors.last_name LIKE '%$search_name%' OR visitors.gender = '$search_name'";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<h2>Search Results:</h2>";
    echo "<table>";
    echo "<tr>";
    echo "<th>ID</th>";
    echo "<th>First Name</th>";
    echo "<th>Last Name</th>";
    echo "<th>Gender</th>";
    echo "<th>Date of Birth</th>";
    echo "<th>Comment</th>";
    echo "</tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["id"] . "</td>";
        echo "<td>" . $row["first_name"] . "</td>";
        echo "<td>" . $row["last_name"] . "</td>";
        echo "<td>" . $row["gender"] . "</td>";
        echo "<td>" . $row["dob"] . "</td>";
        echo "<td>" . $row["comments"] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p>No results found.</p>";
}
        $conn->close();
    }
    ?>
</body>
</html>

