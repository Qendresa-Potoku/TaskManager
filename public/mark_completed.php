<?php
include './db_connection.php';

// Check if request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize task ID
    $task_id = isset($_POST['task_id']) ? (int) $_POST['task_id'] : 0;

    // Prepare the SQL statement
    $stmt = $conn->prepare("UPDATE tasks_table SET status = 'Completed' WHERE id = ?");
    if (!$stmt) {
        die('Prepare failed: ' . htmlspecialchars($conn->error));
    }

    // Bind parameters and execute
    $stmt->bind_param("i", $task_id);
    if ($stmt->execute()) {
        header("Location: index.php");
        exit();
    } else {
        echo "Execute failed: " . htmlspecialchars($stmt->error);
    }

    // Close statement
    $stmt->close();
}

// Close connection
$conn->close();
?>
