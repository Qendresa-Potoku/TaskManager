<?php

include '../public/db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $task_name = $_POST['task_name'];
    $description = $_POST['description'];
    $due_date = $_POST['due_date'];
    $priority = $_POST['priority'];
    $status = $_POST['status'];

    // Insert a new task into Database
    $stmt = $conn->prepare("INSERT INTO tasks_table (task_name, description, due_date, priority, status) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $task_name, $description, $due_date, $priority, $status);
    $stmt->execute();
    $stmt->close();

    // Redirect to the main page
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Task</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 text-gray-900">
    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center">
        <div class="bg-white p-6 rounded-lg shadow-lg max-w-lg w-full mx-4 md:mx-0">
            <div class="flex justify-between items-center border-b pb-2 mb-4">
                <h2 class="text-xl font-semibold text-blue-700">Add New Task</h2>
                <a href="index.php" class="text-gray-500 hover:text-gray-700 text-2xl text-blue-700 ">&times;</a>
            </div>
            <form action="add_task.php" method="post">
                <label for="taskName" class="block text-gray-700 mb-1 font-semibold">Task Name:</label>
                <input type="text" id="taskName" name="task_name" class="w-full px-3 py-2 border border-gray-300 rounded-md mb-4" required>

                <label for="description" class="block text-gray-700 mb-1 font-semibold">Description:</label>
                <textarea id="description" name="description" class="w-full px-3 py-2 border border-gray-300 rounded-md mb-4" rows="3" required></textarea>

                <label for="dueDate" class="block text-gray-700 mb-1 font-semibold">Due Date:</label>
                <input type="date" id="dueDate" name="due_date" class="w-full px-3 py-2 border border-gray-300 rounded-md mb-4" required>

                <label for="priority" class="block text-gray-700 mb-1 font-semibold">Priority:</label>
                <select id="priority" name="priority" class="w-full px-3 py-2 border border-gray-300 rounded-md mb-4" required>
                    <option value="Low">Low</option>
                    <option value="Medium">Medium</option>
                    <option value="High">High</option>
                </select>

                <label for="status" class="block text-gray-700 mb-1 font-semibold">Status:</label>
                <select id="status" name="status" class="w-full px-3 py-2 border border-gray-300 rounded-md mb-4" required>
                    <option value="Pending">Pending</option>
                    <option value="Completed">Completed</option>
                </select>

                <div class="flex justify-end gap-2">
                    <a href="index.php" class="py-2 px-4 bg-gray-500 text-white rounded-md hover:bg-gray-600">Cancel</a>
                    <button type="submit" class="py-2 px-4 bg-blue-500 text-white rounded-md hover:bg-blue-600">Add</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
