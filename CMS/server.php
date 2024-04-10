<?php
session_start();

$title = '';
$description = '';
$id = 0;
$editState = false;

try {
    $db = new PDO('mysql:host=localhost;dbname=cms', 'root', '');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}

if (isset($_POST['save'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];

    $stmt = $db->prepare("INSERT INTO articles (title, description) VALUES (:title, :description)");
    $stmt->execute(array(':title' => $title, ':description' => $description));

    $_SESSION['message'] = 'Article added successfully';
    header('location: index.php');
}

if (isset($_POST['update'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $id = $_POST['id'];

    $stmt = $db->prepare("UPDATE articles SET title=:title, description=:description WHERE id=:id");
    $stmt->execute(array(':title' => $title, ':description' => $description, ':id' => $id));

    $_SESSION['message'] = 'Article updated successfully';
    header('location: index.php');
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $db->prepare("DELETE FROM articles WHERE id=:id");
    $stmt->execute(array(':id' => $id));

    $_SESSION['message'] = 'Article deleted successfully';
    header('location: index.php');
}

$stmt = $db->query("SELECT * FROM articles");
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

