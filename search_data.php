<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visitor Data Search</title>
    <style>
       body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: auto;
            margin: 100px auto;
            padding: 10px;
            background-color: #dcdce6;
            border-radius: 50px;
            box-shadow: 5px 40px 20px rgba(255, 255, 255, 0.5);
            text-align: center;
        }
        label {
            display: block;
            margin-bottom: 10px;
        }
        input[type="text"] {
            width: 90%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 30px;
            border-radius: 3px;
            cursor: pointer;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
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
</head>
<body>
    <div class="container">
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
            $host = $configs['host'];
            $username = $configs['username'];
            $password = $configs['password'];
            $dbname = $configs['dbname'];

            $conn = new mysqli($host, $username, $password, $dbname);
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Retrieve user input for search
            $search_name = $conn->real_escape_string($_GET["search_name"]); // Sanitize input

            // Construct SQL query to search by first name, last name, or gender
            $sql = "SELECT visitors.*, comments.comments FROM visitors LEFT JOIN comments ON visitors.id = comments.id WHERE visitors.first_name LIKE '%$search_name%' OR visitors.last_name LIKE '%$search_name%' OR visitors.gender = '$search_name'";

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
    </div>
</body>
</html>
