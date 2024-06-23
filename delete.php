<?php
include 'db.php';

$id = $_GET['id'];
$query = "SELECT image FROM student WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->execute([$id]);
$student = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$student) {
    echo "Student not found";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $query = "DELETE FROM student WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->execute([$id]);
    if ($student['image']) {
        unlink('uploads/' . $student['image']);
    }
    header("Location: index.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Delete Student</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>Delete Student</h1>
    <p>Are you sure you want to delete this student?</p>
    <form method="post">
        <input type="submit" value="Delete">
    </form>
    <a href="index.php">Cancel</a>
</body>
</html>
