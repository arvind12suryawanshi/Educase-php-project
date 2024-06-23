<?php
include 'db.php';

$id = $_GET['id'];
$query = "SELECT * FROM student WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->execute([$id]);
$student = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$student) {
    echo "Student not found";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $class_id = $_POST['class_id'];
    $image = $student['image'];

    if (!empty($_FILES['image']['name'])) {
        $new_image = $_FILES['image']['name'];
        $allowed_extensions = ['jpg', 'jpeg', 'png'];
        $image_extension = pathinfo($new_image, PATHINFO_EXTENSION);
        if (!in_array($image_extension, $allowed_extensions)) {
            echo "Invalid image format";
            exit;
        }

        $target_directory = "uploads/";
        $target_file = $target_directory . basename($new_image);
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            $image = $new_image;
        } else {
            echo "Failed to upload image.";
            exit;
        }
    }

    $query = "UPDATE student SET name = ?, email = ?, address = ?, class_id = ?, image = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->execute([$name, $email, $address, $class_id, $image, $id]);
    header("Location: index.php");
}

$query = "SELECT * FROM classes";
$stmt = $conn->query($query);
$classes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Student</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>Edit Student</h1>
    <form method="post" enctype="multipart/form-data">
        <label>Name:</label>
        <input type="text" name="name" value="<?php echo htmlspecialchars($student['name']); ?>" required><br>
        <label>Email:</label>
        <input type="email" name="email" value="<?php echo htmlspecialchars($student['email']); ?>" required><br>
        <label>Address:</label>
        <textarea name="address"><?php echo htmlspecialchars($student['address']); ?></textarea><br>
        <label>Class:</label>
        <select name="class_id">
            <?php foreach ($classes as $class): ?>
            <option value="<?php echo $class['class_id']; ?>" <?php if ($class['class_id'] == $student['class_id']) echo 'selected'; ?>><?php echo $class['name']; ?></option>
            <?php endforeach; ?>
        </select><br>
        <label>Image:</label>
        <input type="file" name="image" accept=".jpg, .jpeg, .png"><br>
        <input type="submit" value="Update">
    </form>
</body>
</html>
