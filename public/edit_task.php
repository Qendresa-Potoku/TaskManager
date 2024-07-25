<?php
include '../public/db_connection.php';

// Initialize variables
$task = [
    'id' => '',
    'task_name' => '',
    'description' => '',
    'due_date' => '',
    'priority' => '',
    'status' => ''
];

// Check if an ID is provided
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $task_id = (int)$_GET['id'];

    // Retrieve task details from the database
    $stmt = $conn->prepare("SELECT id, task_name, description, due_date, priority, status FROM tasks_table WHERE id = ?");
    $stmt->bind_param("i", $task_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $task = $result->fetch_assoc();
    }

    $stmt->close();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $task_id = $_POST['id'];
    $task_name = $_POST['task_name'];
    $description = $_POST['description'];
    $due_date = $_POST['due_date'];
    $priority = $_POST['priority'];
    $status = $_POST['status'];

    // Update task in the database
    $stmt = $conn->prepare("UPDATE tasks_table SET task_name = ?, description = ?, due_date = ?, priority = ?, status = ? WHERE id = ?");
    $stmt->bind_param("sssssi", $task_name, $description, $due_date, $priority, $status, $task_id);
    $stmt->execute();
    $stmt->close();

    // Redirect to the main page
    header("Location: index.php");
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Task</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 text-gray-900">
    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center">
        <div class="bg-white p-6 rounded-lg shadow-lg max-w-lg w-full mx-4 md:mx-0">
            <div class="flex justify-between items-center border-b pb-2 mb-4">
                <h2 class="text-xl font-semibold text-blue-700">Edit Task</h2>
                <a href="index.php" class="text-gray-500 hover:text-gray-700 text-2xl text-blue-700">&times;</a>
            </div>
            <form action="edit_task.php" method="post">
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($task['id']); ?>">

                <label for="taskName" class="block text-gray-700 mb-1 font-semibold">Task Name:</label>
                <input type="text" id="taskName" name="task_name" value="<?php echo htmlspecialchars($task['task_name']); ?>" class="w-full px-3 py-2 border border-gray-300 rounded-md mb-4" required>

                <label for="description" class="block text-gray-700 mb-1 font-semibold">Description:</label>
                <textarea id="description" name="description" class="w-full px-3 py-2 border border-gray-300 rounded-md mb-4" rows="3" required><?php echo htmlspecialchars($task['description']); ?></textarea>

                <label for="dueDate" class="block text-gray-700 mb-1 font-semibold">Due Date:</label>
                <input type="date" id="dueDate" name="due_date" value="<?php echo htmlspecialchars($task['due_date']); ?>" class="w-full px-3 py-2 border border-gray-300 rounded-md mb-4" required>

                <label for="priority" class="block text-gray-700 mb-1 font-semibold">Priority:</label>
                <select id="priority" name="priority" class="w-full px-3 py-2 border border-gray-300 rounded-md mb-4" required>
                    <option value="Low" <?php echo $task['priority'] == 'Low' ? 'selected' : ''; ?>>Low</option>
                    <option value="Medium" <?php echo $task['priority'] == 'Medium' ? 'selected' : ''; ?>>Medium</option>
                    <option value="High" <?php echo $task['priority'] == 'High' ? 'selected' : ''; ?>>High</option>
                </select>

                <label for="status" class="block text-gray-700 mb-1 font-semibold">Status:</label>
                <select id="status" name="status" class="w-full px-3 py-2 border border-gray-300 rounded-md mb-4" required>
                    <option value="Pending" <?php echo $task['status'] == 'Pending' ? 'selected' : ''; ?>>Pending</option>
                    <option value="Completed" <?php echo $task['status'] == 'Completed' ? 'selected' : ''; ?>>Completed</option>
                </select>

                <div class="flex justify-end gap-2">
                    <a href="index.php" class="py-2 px-4 bg-gray-500 text-white rounded-md hover:bg-gray-600">Cancel</a>
                    <button type="submit" class="py-2 px-4 bg-blue-500 text-white rounded-md hover:bg-blue-600">Save</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
