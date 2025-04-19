<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: admin-login.php");
    exit();
}
include 'config.php';

$msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $roll_number = $_POST['roll_number'];
    $class = $_POST['class'];

    $sql = "INSERT INTO students (name,roll_number, class) VALUES ('$name','$roll_number', '$class')";
    
    if ($conn->query($sql) === TRUE) {
        $msg = "✅ Student added successfully!";
    } else {
        $msg = "❌ Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Student</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="form-box">
        <h2>Add Student</h2>
        <form method="post">
            <input type="text" name="name" placeholder="Student Name" required>
            <input type="text" name="roll_number" placeholder="Roll Number" required>
            <input type="text" name="class" placeholder="Class" required>
            <button type="submit">➕ Add Student</button>
        </form>
        <?php if ($msg != "") echo "<div class='message'>$msg</div>"; ?>
    </div>
</body>
</html>
