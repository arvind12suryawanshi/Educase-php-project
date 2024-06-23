<?php
include 'db.php';

$id = $_GET['id'];
$query = "SELECT student.*, classes.name AS class_name 
          FROM student 
          JOIN classes ON student.class_id = classes.class_id 
          WHERE student.id = ?";
$stmt = $conn->prepare($query);
$stmt->execute([$id]);
$student = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$student) {
    echo "Student not found";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Student</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>View Student</h1>
    <p>Name: <?php echo htmlspecialchars($student['name']); ?></p>
    <p>Email: <?php echo htmlspecialchars($student['email']); ?></p>
    <p>Address: <?php echo htmlspecialchars($student['address']); ?></p>
    <p>Class: <?php echo htmlspecialchars($student['class_name']); ?></p>
    <p>Image: <img src="uploads/<?php echo htmlspecialchars($student['image']); ?>" alt="student image" width="100"></p>
    <p>Created At: <?php echo htmlspecialchars($student['created_at']); ?></p>
    <a href="index.php">Back to list</a>
</body>
</html>
