<main>
    <h1>Search History</h1>

    <?php if (empty($history)): ?>
        <p>You haven't searched for anything yet.</p>
    <?php else: ?>
        <ul>
        <?php foreach ($history as $entry): ?>
            <li>
                <b><?php echo htmlspecialchars($entry['search_type']); ?></b>:
                "<?php echo htmlspecialchars($entry['search_term']); ?>" –
                <?php echo $entry['searched_at']; ?>
            </li>
        <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</main>
</body>
</html>
