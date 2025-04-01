<?php
// Load configuration
$config = include('/etc/website_config/config.php');

// Create database connection
$conn = new mysqli(
    $config['host'],
    $config['username'],
    $config['password'],
    $config['dbname']
);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Replace charset setting with:
if (isset($config['charset'])) {
    $conn->set_charset($config['charset']);
} else {
    $conn->set_charset('utf8mb4');
}

// Verify
if ($conn->error) {
    die("Charset error: " . $conn->error);
}
try {
    // Validate search query
    if (empty($_GET['query'])) {
        throw new Exception("Please enter a search term");
    }

    $searchTerm = "%{$_GET['query']}%";

    // Prepare search statement
    $stmt = $conn->prepare("
        SELECT v.*, c.comments 
        FROM visitors v
        LEFT JOIN comments c ON v.id = c.visitor_id
        WHERE v.first_name LIKE ? 
           OR v.last_name LIKE ? 
           OR c.comments LIKE ?
        ORDER BY v.id DESC
    ");
    
    $stmt->bind_param("sss", $searchTerm, $searchTerm, $searchTerm);
    $stmt->execute();
    $result = $stmt->get_result();

    // Display results
    echo "<!DOCTYPE html>
    <html>
    <head>
        <title>Search Results</title>
        <link rel='stylesheet' type='text/css' href='styles.css'>
    </head>
    <body>
        <div class='container'>
            <h2>Search Results for '".htmlspecialchars($_GET['query'])."'</h2>
            <a href='index.html'>Back to Form</a>";

    if ($result->num_rows > 0) {
        echo "<table>
                <tr>
                    <th>Username</th>
                    <th>Name</th>
                    <th>Gender</th>
                    <th>Date of Birth</th>
                    <th>Comments</th>
                </tr>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>".htmlspecialchars($row['user_name'])."</td>
                    <td>".htmlspecialchars($row['first_name']." ".$row['last_name'])."</td>
                    <td>".htmlspecialchars($row['gender'])."</td>
                    <td>".htmlspecialchars($row['dob'])."</td>
                    <td>".htmlspecialchars($row['comments'] ?? '')."</td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No results found</p>";
    }

    echo "</div></body></html>";

} catch (Exception $e) {
    die("Error: " . $e->getMessage());
} finally {
    $conn->close();
}
?>
