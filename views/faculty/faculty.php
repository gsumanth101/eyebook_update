<?php

include('sidebar.php');
include('../../src/functions.php');
// Ensure the action variable is set
$action = isset($_GET['action']) ? $_GET['action'] : '';

// Handle form submission for creating an assessment
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'create_assessment') {
    $title = $_POST['title'];
    $deadline = $_POST['deadline'];

    try {
        createAssessment($title, $questions, $deadline);
        $success = "Assessment created successfully!";
    } catch (Exception $e) {
        $error = "Error creating assessment: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faculty Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-4">
        <h1 class="text-3xl font-bold mb-6">Faculty Dashboard</h1>
        <div class="mb-4">
            <!-- <a href="index.php" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Home</a> -->
            <a href="faculty.php?action=create_assessment" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Create Assessment</a>
            <a href="faculty.php?action=manage_assessments" class="bg-purple-500 text-white px-4 py-2 rounded hover:bg-purple-600">Manage Assessments</a>
        </div>

        <?php if ($action === 'create_assessment'): ?>
            <!-- Create Assessment Form -->
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-2xl font-bold mb-4">Create Assessment</h2>
                <form id="assessmentForm" method="POST" action="faculty.php?action=create_assessment">
                    <div class="mb-4">
                        <label for="title" class="block text-sm font-medium text-gray-700">Assessment Title</label>
                        <input type="text" id="title" name="title" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    </div>
                    <div class="mb-4">
                        <label for="deadline" class="block text-sm font-medium text-gray-700">Deadline</label>
                        <input type="datetime-local" id="deadline" name="deadline" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    </div>
                    <div class="mb-4">
                        <label for="questions" class="block text-sm font-medium text-gray-700">Questions</label>
                        <textarea id="questions" name="questions" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"></textarea>
                    </div>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Create</button>
                </form>
            </div>
        <?php elseif ($action === 'manage_assessments'): ?>
            <!-- Manage Assessments Section -->
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-2xl font-bold mb-4">Manage Assessments</h2>
                <!-- Add your manage assessments code here -->
            </div>
        <?php else: ?>
            <!-- Default Section -->
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-2xl font-bold mb-4">Welcome to the Faculty Dashboard</h2>
                <p>Select an option from the menu to get started.</p>
            </div>
        <?php endif; ?>
    </div>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>