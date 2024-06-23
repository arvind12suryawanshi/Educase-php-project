<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $class_id = $_POST['class_id'];
    $image = $_FILES['image']['name'];

    // Validate image format
    $allowed_extensions = ['jpg', 'jpeg', 'png'];
    $image_extension = pathinfo($image, PATHINFO_EXTENSION);
    if (!in_array($image_extension, $allowed_extensions)) {
        echo "Invalid image format";
        exit;
    }

    // Upload image
    $target_directory = "uploads/";
    $target_file = $target_directory . basename($image);
    if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
        $query = "INSERT INTO student (name, email, address, class_id, image) 
                  VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->execute([$name, $email, $address, $class_id, $image]);
        header("Location: index.php");
    } else {
        echo "Failed to upload image.";
    }
}

$query = "SELECT * FROM classes";
$stmt = $conn->query($query);
$classes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Create Student</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>Create Student</h1>
    <form method="post" enctype="multipart/form-data">
        <label>Name:</label>
        <input type="text" name="name" required><br>
        <label>Email:</label>
        <input type="email" name="email" required><br>
        <label>Address:</label>
        <textarea name="address"></textarea><br>
        <label>Class:</label>
        <select name="class_id">
            <?php foreach ($classes as $class): ?>
            <option value="<?php echo $class['class_id']; ?>"><?php echo $class['name']; ?></option>
            <?php endforeach; ?>
        </select><br>
        <label>Image:</label>
        <input type="file" name="image" accept=".jpg, .jpeg, .png" required><br>
        <input type="submit" value="Create">
    </form>
</body>
</html>
