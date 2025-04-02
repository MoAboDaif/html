<!-- src/views/search_results.php -->
<?php include __DIR__ . '/header.php'; ?>

<form action="/index.php" method="get">
    <input type="text" name="query" placeholder="Search visitors" value="<?php echo htmlspecialchars($_GET['query'] ?? ''); ?>">
    <input type="hidden" name="action" value="search">
    <button type="submit">Search</button>
</form>

<?php if (!empty($results)): ?>
    <ul>
        <?php foreach ($results as $visitor): ?>
            <li><?php echo htmlspecialchars($visitor['name']) . " (" . htmlspecialchars($visitor['email']) . ")"; ?></li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>No visitors found.</p>
<?php endif; ?>

<p><a href="/index.php">Back to Form</a></p>

<?php include __DIR__ . '/footer.php'; ?>
