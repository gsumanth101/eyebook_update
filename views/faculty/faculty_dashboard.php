<?php
include('sidebar.php');



require 'zoom_integration.php';

// Load configuration
$config = require 'config.php';

$zoom = new ZoomAPI($config['zoom']['client_id'], $config['zoom']['client_secret'], $config['zoom']['account_id'], $conn);
$facultyId = $_SESSION['email'];
$facultyMeetings = $zoom->getMeetingsByFaculty($facultyId);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Faculty Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            margin: auto;
            overflow: hidden;
        }
        header {
            background: #50b3a2;
            color: #fff;
            padding-top: 30px;
            min-height: 70px;
            border-bottom: #e8491d 3px solid;
        }
        header a {
            color: #fff;
            text-decoration: none;
            text-transform: uppercase;
            font-size: 16px;
        }
        header ul {
            padding: 0;
            list-style: none;
        }
        header li {
            display: inline;
            padding: 0 20px 0 20px;
        }
        header #branding {
            float: left;
        }
        header #branding h1 {
            margin: 0;
        }
        header nav {
            float: right;
            margin-top: 10px;
        }
        .content {
            padding: 20px;
            background: #fff;
            margin-top: 20px;
        }
        table {
            width: 100%;
            margin: 20px 0;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #50b3a2;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #ddd;
        }
        form {
            margin-bottom: 20px;
        }
        input[type="text"], input[type="datetime-local"], input[type="number"] {
            width: 100%;
            padding: 10px;
            margin: 5px 0 10px 0;
            border: 1px solid #ddd;
        }
        button {
            background-color: #50b3a2;
            color: white;
            padding: 10px 15px;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a089;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="content">
            <form method="POST" action="create_meeting.php">
                <input type="text" name="topic" placeholder="Meeting Topic" required>
                <input type="datetime-local" name="start_time" required>
                <input type="number" name="duration" placeholder="Duration (minutes)" required>
                <button type="submit">Create Meeting</button>
            </form>

            <h2>Your Meetings</h2>
            <table>
                <thead>
                    <tr>
                        <th>Topic</th>
                        <th>Start Time</th>
                        <th>Duration</th>
                        <th>Join URL</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($facultyMeetings as $meeting): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($meeting['topic']); ?></td>
                            <td><?php echo htmlspecialchars($meeting['start_time']); ?></td>
                            <td><?php echo htmlspecialchars($meeting['duration']); ?> minutes</td>
                            <td><a href="<?php echo htmlspecialchars($meeting['join_url']); ?>" target="_blank">Join</a></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

        </div>
        <?php include('footer.html'); ?>
    </div>
</body>
</html>

