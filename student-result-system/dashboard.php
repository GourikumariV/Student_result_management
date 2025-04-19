<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: admin-login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            margin: 0;
            padding: 0;
            background: linear-gradient(to right, #83a4d4, #b6fbff);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .dashboard-container {
            width: 400px;
            margin: 80px auto;
            background-color: white;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0,0,0,0.2);
            padding: 30px;
            text-align: center;
        }

        .dashboard-container h2 {
            margin-bottom: 30px;
            color: #333;
        }

        .dashboard-container ul {
            list-style: none;
            padding: 0;
        }

        .dashboard-container li {
            margin: 20px 0;
        }

        .dashboard-container a {
            text-decoration: none;
            background-color: #4CAF50;
            color: white;
            padding: 12px 25px;
            border-radius: 8px;
            transition: background-color 0.3s ease;
            display: inline-block;
        }

        .dashboard-container a:hover {
            background-color: #388e3c;
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <h2>Welcome, <?php echo $_SESSION['admin']; ?> 👋</h2>
        <ul>
            <li><a href="add-student.php">➕ Add Student</a></li>
            <li><a href="add-marks.php">➕ Add Marks</a></li>
            <li><a href="view-results.php">📃 View All Results</a></li>
            <li><a href="logout.php">🔓 Logout</a></li>
        </ul>
    </div>
</body>
</html>
