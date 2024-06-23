<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $query = "INSERT INTO classes (name) VALUES (?)";
    $stmt = $conn->prepare($query);
    $stmt->execute([$name]);
}

if (isset($_GET['delete'])) {
    $class_id = $_GET['delete'];
    $query = "DELETE FROM classes WHERE class_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->execute([$class_id]);
}

$query = "SELECT * FROM classes";
$stmt = $conn->query($query);
$classes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Classes</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>Manage Classes</h1>
    <form method="post">
        <label>Class Name:</label>
        <input type="text" name="name" required>
        <input type="submit" value="Add Class">
    </form>
    <table border="1">
        <tr>
            <th>Name</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($classes as $class): ?>
        <tr>
            <td><?php echo htmlspecialchars($class['name']); ?></td>
            <td>
                <a href="classes.php?delete=<?php echo $class['class_id']; ?>">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    <a href="index.php">Back to Home</a>
</body>
</html>
