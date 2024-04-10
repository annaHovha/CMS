<?php
try {
    $db = new PDO('mysql:host=localhost;dbname=cms', 'root', '');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $db->prepare('SELECT * FROM articles WHERE id=:id');
    $stmt->execute(array(':id' => $id));
    $article = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($article) {
        $title = $article['title'];
        $description = $article['description'];

        echo "<h1>$title</h1>";
        echo "<p>$description</p>";
    } else {
        echo 'Article not found.';
    }
} else {
    echo 'Article ID not provided.';
}

