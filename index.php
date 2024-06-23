<?php
include 'db.php';

$query = "SELECT student.*, classes.name AS class_name 
          FROM student 
          JOIN classes ON student.class_id = classes.class_id";
$stmt = $conn->query($query);
$students = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>School Demo</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>Student List</h1>
    <a href="create.php">Add New Student</a>
    <table border="1">
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Class</th>
            <th>Image</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($students as $student): ?>
        <tr>
            <td><?php echo htmlspecialchars($student['name']); ?></td>
            <td><?php echo htmlspecialchars($student['email']); ?></td>
            <td><?php echo htmlspecialchars($student['class_name']); ?></td>
            <td><img src="uploads/<?php echo htmlspecialchars($student['image']); ?>" alt="student image" width="50"></td>
            <td>
                <a href="view.php?id=<?php echo $student['id']; ?>">View</a>
                <a href="edit.php?id=<?php echo $student['id']; ?>">Edit</a>
                <a href="delete.php?id=<?php echo $student['id']; ?>">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
