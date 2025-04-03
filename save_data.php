<?php
// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Load configuration
$config = include('./config.php');

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

// Set character set
// Replace line 24 with:
if (isset($config['charset'])) {
    $conn->set_charset($config['charset']);
} else {
    $conn->set_charset('utf8mb4'); // Fallback
}

// Add error checking
if ($conn->error) {
    die("Charset error: " . $conn->error);
}

try {
    // Start transaction
    $conn->begin_transaction();

    // Validate and sanitize input
    $requiredFields = ['username', 'first_name', 'last_name', 'gender', 'dob'];
    foreach ($requiredFields as $field) {
        if (empty($_POST[$field])) {
            throw new Exception("Missing required field: $field");
        }
    }

    // Prepare and bind visitors insert
    $stmt = $conn->prepare("INSERT INTO visitors 
        (user_name, first_name, last_name, gender, dob) 
        VALUES (?, ?, ?, ?, ?)");
    
    $stmt->bind_param("sssss", 
        $_POST['username'],
        $_POST['first_name'],
        $_POST['last_name'],
        $_POST['gender'],
        $_POST['dob']
    );

    if (!$stmt->execute()) {
        throw new Exception("Visitor insert failed: " . $stmt->error);
    }

    // Get inserted visitor ID
    $visitor_id = $stmt->insert_id;

    // Insert comment if exists
    if (!empty($_POST['comments'])) {
        $comment_stmt = $conn->prepare("INSERT INTO comments 
            (visitor_id, comments) 
            VALUES (?, ?)");
        
        $comment_stmt->bind_param("is", 
            $visitor_id,
            $_POST['comments']
        );

        if (!$comment_stmt->execute()) {
            throw new Exception("Comment insert failed: " . $comment_stmt->error);
        }
    }

    // Commit transaction
    $conn->commit();
    
    // Redirect to prevent form resubmission
    header("Location: index.html?success=1");
    exit();

} catch (Exception $e) {
    $conn->rollback();
    die("Error: " . $e->getMessage());
} finally {
    $conn->close();
}
?>
