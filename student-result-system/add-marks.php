<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: admin-login.php");
    exit();
}
include 'config.php';

$msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $roll_number = $_POST['roll_number'];
    // $name = $_POST['name'];
    $subject = $_POST['subject'];
    $marks = $_POST['marks'];

    // Step 1: Match student by roll number AND name
    $query = "SELECT id FROM students WHERE roll_number = '$roll_number'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $student_id = $row['id'];

        // Step 2: Insert marks (duplicate allowed now)
        $sql = "INSERT INTO marks (student_id, subject, marks) VALUES ('$student_id', '$subject', '$marks')";
        if ($conn->query($sql) === TRUE) {
            $msg = "✅ Marks added successfully!";
        } else {
            $msg = "❌ Error: " . $conn->error;
        }
    } else {
        $msg = "❌ No matching student found with this roll number and name.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Marks</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="form-box">
        <h2>Add Marks</h2>
        <form method="post">
            <input type="text" name="roll_number" placeholder="Student Roll Number" required>
            <input type="text" name="subject" placeholder="Subject" required>
            <input type="number" name="marks" placeholder="Marks" required>
            <button type="submit">➕ Add Marks</button>
        </form>
        <?php if ($msg != "") echo "<div class='message'>$msg</div>"; ?>
    </div>
</body>
</html>
