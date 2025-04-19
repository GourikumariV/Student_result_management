<?php
include 'config.php';
$msg = "";
$student = null;
$marks = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $roll = $_POST['roll_number'];

    $student_result = $conn->query("SELECT * FROM students WHERE roll_number = '$roll'");
    if ($student_result->num_rows > 0) {
        $student = $student_result->fetch_assoc();
        $student_id = $student['id'];

        $marks_result = $conn->query("SELECT * FROM marks WHERE student_id = '$student_id'");
        while ($row = $marks_result->fetch_assoc()) {
            $marks[] = $row;
        }
    } else {
        $msg = "❌ Student not found!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Result</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="form-box">
        <h2>📄 View Student Result</h2>
        <form method="post">
            <input type="text" name="roll_number" placeholder="Enter Roll Number" required>
            <button type="submit">🔍 View Result</button>
        </form>

        <?php if ($msg) echo "<div class='message'>$msg</div>"; ?>

        <?php if ($student): ?>
            <h3>👤 Name: <?= $student['name'] ?> | 🎓 Class: <?= $student['class'] ?></h3>
            <table border="1" cellpadding="8">
                <tr>
                    <th>Subject</th>
                    <th>Marks</th>
                </tr>
                <?php foreach ($marks as $m): ?>
                    <tr>
                        <td><?= $m['subject'] ?></td>
                        <td><?= $m['marks'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php endif; ?>
    </div>
</body>
</html>
