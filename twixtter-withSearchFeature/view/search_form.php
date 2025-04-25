<main>
    <h1>Search</h1>

    <form action="twixitter.php" method="post">
        <fieldset>
            <legend>Search Posts</legend>
            <label>Keyword:</label>
            <input type="text" name="query" required>
            <input type="submit" name="action" value="Search Posts">
        </fieldset>
    </form>

    <form action="twixitter.php" method="post">
        <fieldset>
            <legend>Search Users</legend>
            <label>Username:</label>
            <input type="text" name="query" required>
            <input type="submit" name="action" value="Search Users">
        </fieldset>
    </form>

    <form action="twixitter.php" method="get">
        <input type="hidden" name="action" value="Search History">
        <input type="submit" value="View My Search History">
    </form>
</main>
</body>
</html>
