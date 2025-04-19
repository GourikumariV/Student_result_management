<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: admin-login.php");
    exit();
}
include 'config.php';

$msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Update marks
    if (isset($_POST['update'])) {
        $id = $_POST['update_id'] ?? '';
        $subject = $_POST['subject'] ?? '';
        $marks = $_POST['marks'] ?? '';

        if (!empty($id) && !empty($subject) && !empty($marks)) {
            $update_sql = "UPDATE marks SET subject='$subject', marks='$marks' WHERE id=$id";
            if ($conn->query($update_sql) === TRUE) {
                $msg = "✅ Marks updated!";
            } else {
                $msg = "❌ Update error: " . $conn->error;
            }
        }
    }

    // Delete marks
    if (isset($_POST['delete'])) {
        $id = $_POST['delete_id'] ?? '';
        if (!empty($id)) {
            $delete_sql = "DELETE FROM marks WHERE id=$id";
            if ($conn->query($delete_sql) === TRUE) {
                $msg = "🗑️ Record deleted!";
            } else {
                $msg = "❌ Delete error: " . $conn->error;
            }
        }
    }
}

$marks_data = $conn->query("SELECT marks.id, students.name, students.roll_number, marks.subject, marks.marks 
                            FROM marks 
                            JOIN students ON marks.student_id = students.id 
                            ORDER BY marks.id DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Marks</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f5f5f5;
            padding: 20px;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
            justify-content:center;
        }
        .message {
            text-align: center;
            margin-bottom: 10px;
            font-weight: bold;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            border-radius: 8px;
            overflow: hidden;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 12px 10px;
            text-align: center;
        }
        th {
            background-color: #e3e3e3;
        }
        .actions form {
            display: inline-block;
            margin: 2px;
        }
        .actions input[type="text"],
        .actions input[type="number"] {
            width: 100px;
            padding: 5px;
            margin-right: 5px;
        }
        button {
            padding: 5px 10px;
            border: none;
            background: #4CAF50;
            color: white;
            border-radius: 5px;
            cursor: pointer;
        }
        button[name="delete"] {
            background: #f44336;
        }
    </style>
</head>
<body>
    <h2>📋 Manage Student Marks</h2>
    <?php if ($msg != "") echo "<div class='message'>$msg</div>"; ?>

    <table>
        <tr>
            <th>#</th>
            <th>Student Name</th>
            <th>Roll Number</th>
            <th>Subject</th>
            <th>Marks</th>
            <th>Actions</th>
        </tr>
        <?php if ($marks_data->num_rows > 0): 
            $i = 1;
            while ($row = $marks_data->fetch_assoc()): ?>
            <tr>
                <td><?= $i++; ?></td>
                <td><?= htmlspecialchars($row['name']); ?></td>
                <td><?= htmlspecialchars($row['roll_number']); ?></td>
                <td class="actions">
                    <form method="post">
                        <input type="hidden" name="update_id" value="<?= $row['id']; ?>">
                        <input type="text" name="subject" value="<?= htmlspecialchars($row['subject']); ?>" required>
                        <input type="number" name="marks" value="<?= $row['marks']; ?>" required>
                        <button type="submit" name="update">✏️</button>
                    </form>
                </td>
                <td><?= $row['marks']; ?></td>
                <td class="actions">
                    <form method="post">
                        <input type="hidden" name="delete_id" value="<?= $row['id']; ?>">
                        <button type="submit" name="delete" onclick="return confirm('Are you sure to delete?')">🗑️</button>
                    </form>
                </td>
            </tr>
        <?php endwhile; else: ?>
            <tr><td colspan="6">No marks found.</td></tr>
        <?php endif; ?>
    </table>
</body>
</html>
