<?php

include('server.php');

if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $editState = true;

    $stmt = $db->prepare('SELECT * FROM articles WHERE id = :id');
    $stmt->execute(array(':id' => $id));
    $record = $stmt->fetch(PDO::FETCH_ASSOC);

    $title = $record['title'];
    $description = $record['description'];
    $id = $record['id'];
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>CMS</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php if (isset($_SESSION['message'])): ?>
    <div class="msg">
        <?php
        echo $_SESSION['message'];
        unset($_SESSION['message']);
        ?>
    </div>
<?php endif; ?>
<table>
    <thead>
    <tr>
        <th>Title</th>
        <th>Description</th>
        <th colspan="3">Action</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $stmt = $db->query('SELECT * FROM articles');
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
        <tr>
            <td><?php echo $row['title'] ?></td>
            <td><?php echo $row['description'] ?></td>
            <td>
                <a href="articles.php?id=<?php echo $row['id']; ?>">View</a>
            </td>
            <td>
                <a href="index.php?edit=<?php echo $row['id']; ?>">Edit</a>
            </td>
            <td>
                <a href="index.php?delete=<?php echo $row['id']; ?>">Delete</a>
            </td>
        </tr>
        <?php
    }
    ?>

    </tbody>
</table>

<form method="post" action="server.php">
    <input type="hidden" name="id" value="<?php echo $id; ?>">
    <input type="text" name="title" placeholder="Title" value="<?php echo $title; ?>"><br>
    <input name="description" placeholder="Description" value="<?php echo $description;?>"><br>
    <?php if ($editState == false):?>
        <button type="submit" name="save" class="btn">Save</button>
    <?php else: ?>
        <button type="submit" name="update" class="btn">Update</button>
    <?php endif ?>
</form>
</body>
</html>
