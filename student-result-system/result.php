<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: admin-login.php");
    exit();
}
include 'config.php';

$sort = isset($_GET['sort']) && $_GET['sort'] === 'total';

// Get students and their marks
$sql = "SELECT students.id, students.roll_number, students.name, students.class, 
               marks.subject, marks.marks
        FROM students
        LEFT JOIN marks ON students.id = marks.student_id
        ORDER BY students.name ASC, marks.subject ASC";

$result = $conn->query($sql);

// Organize marks by student
$students = [];
while ($row = $result->fetch_assoc()) {
    $id = $row['id'];
    if (!isset($students[$id])) {
        $students[$id] = [
            'roll' => $row['roll_number'],
            'name' => $row['name'],
            'class' => $row['class'],
            'subjects' => [],
            'total' => 0
        ];
    }
    if ($row['subject']) {
        $students[$id]['subjects'][] = [
            'subject' => $row['subject'],
            'marks' => $row['marks']
        ];
        $students[$id]['total'] += $row['marks'];
    }
}

// Sort if requested
if ($sort) {
    uasort($students, function($a, $b) {
        return $b['total'] - $a['total'];
    });
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>📊 Full Results with Subject-wise Marks</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .form-box { width: 90%; margin: 30px auto; }
        .rank-btn {
            background-color: #4CAF50;
            color: white;
            padding: 8px 12px;
            text-decoration: none;
            border-radius: 4px;
        }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { padding: 10px; border: 1px solid #999; text-align: center; }
        td.left-align { text-align: left; }
    </style>
</head>
<body>
    <div class="form-box">
        <h2>🧾 Complete Student Results</h2>
        <a class="rank-btn" href="?sort=total">🏆 Sort by Topper</a>

        <table>
            <tr>
                <th>Rank</th>
                <th>Roll Number</th>
                <th>Name</th>
                <th>Class</th>
                <th>Subjects & Marks</th>
                <th>Total Marks</th>
            </tr>
            <?php
            $rank = 1;
            foreach ($students as $student) {
                echo "<tr>
                        <td>" . ($sort ? $rank++ : '-') . "</td>
                        <td>{$student['roll']}</td>
                        <td>{$student['name']}</td>
                        <td>{$student['class']}</td>
                        <td class='left-align'>";
                if (!empty($student['subjects'])) {
                    foreach ($student['subjects'] as $s) {
                        echo "{$s['subject']}: {$s['marks']}<br>";
                    }
                } else {
                    echo "No marks";
                }
                echo "</td>
                      <td>{$student['total']}</td>
                    </tr>";
            }
            ?>
        </table>
    </div>
</body>
</html>
