<!-- src/views/visitor_form.php -->
<?php include __DIR__ . '/header.php'; ?>

<?php
// Start session to display flash messages if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!empty($_SESSION['msg'])) {
    echo "<p style='color: green;'>" . htmlspecialchars($_SESSION['msg']) . "</p>";
    unset($_SESSION['msg']);
}
?>

<form action="/index.php?action=save" method="post">
    <label for="name">Name:</label>
    <input type="text" name="name" id="name" required>
  
    <label for="email">Email:</label>
    <input type="email" name="email" id="email" required>
  
    <button type="submit">Submit</button>
</form>

<p>
    <a href="/index.php?action=search">Search Visitors</a>
</p>

<?php include __DIR__ . '/footer.php'; ?>
