<?php
include './db_connection.php';

//Tasks from database
$sql = "SELECT task_name, description, due_date, priority, status FROM tasks_table";
$result = $conn->query($sql);

$tasks = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $tasks[] = $row;
    }
} 

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Manager</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
</head>
<body class="bg-gray-100 text-gray-900">
    <div class="container mx-auto p-8">
        <header class="text-center mb-8">
            <h1 class="text-4xl font-bold text-blue-700">Task Manager</h1>
            
        </header>
        <div class="flex space-x-8">
            <!-- Features Section -->
            <aside class="w-1/4 bg-white rounded-lg shadow-md p-6">
                <h2 class="text-2xl font-semibold mb-4 text-blue-700">Features</h2>
                <div class="flex flex-col space-y-4">
                     <form action="add_task.php" method="get">
                        <button type="submit" class="w-full py-2 px-4 bg-blue-500 text-white rounded-md hover:bg-blue-300">Add New Task</button>
                    </form>
                    <button class="w-full py-2 px-4 bg-green-500 text-white rounded-md hover:bg-green-300">Mark as Completed</button>
                    <button class="w-full py-2 px-4 bg-yellow-500 text-white rounded-md hover:bg-yellow-300">Edit Task Details</button>
                    <button class="w-full py-2 px-4 bg-red-500 text-white rounded-md hover:bg-red-300">Delete Task</button>
                </div>
            </aside>

            <!-- Tasks Table -->
            <main class="w-3/4">
                <h2 class="text-2xl font-semibold mb-4 text-blue-700">Tasks</h2>
                <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-md ">
               <thead>
                <tr class="bg-gray-300 border-b">
                     <th class="py-2 px-4 text-left text-gray-800 font-bold">Task Name</th>
                     <th class="py-2 px-4 text-left text-gray-800 font-bold">Description</th>
                     <th class="py-2 px-4 text-left text-gray-800 font-bold">Due Date</th>
                     <th class="py-2 px-4 text-left text-gray-800 font-bold">Priority</th>
                     <th class="py-2 px-4 text-left text-gray-800 font-bold">Status</th>
                </tr>
    
</thead>
                    <tbody>
                        <!-- Putting data from databaseto table -->
                        <?php if (count($tasks) > 0): ?>
                            <?php foreach ($tasks as $task): ?>
                                <tr class="border-b">
                                    <td class="py-2 px-4"><?php echo htmlspecialchars($task['task_name']); ?></td>
                                    <td class="py-2 px-4"><?php echo htmlspecialchars($task['description']); ?></td>
                                    <td class="py-2 px-4"><?php echo htmlspecialchars($task['due_date']); ?></td>
                                    <td class="py-2 px-4"><?php echo htmlspecialchars($task['priority']); ?></td>
                                    <td class="py-2 px-4"><?php echo htmlspecialchars($task['status']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="py-2 px-4 text-center text-gray-500">No tasks available</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </main>
        </div>
    </div>
</body>
</html>
