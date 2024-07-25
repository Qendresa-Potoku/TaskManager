<?php
include '../public/db_connection.php';

// Check if an ID is provided
if (isset($_POST['task_id']) && is_numeric($_POST['task_id'])) {
    $task_id = (int)$_POST['task_id'];

    // Prepare and execute the delete statement
    $stmt = $conn->prepare("DELETE FROM tasks_table WHERE id = ?");
    $stmt->bind_param("i", $task_id);
    $stmt->execute();
    $stmt->close();
}

// Redirect to the main page
header("Location: index.php");
exit();
