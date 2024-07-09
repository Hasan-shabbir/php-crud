<?php
include('connection.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $deleteQuery = "DELETE FROM `abc` WHERE `id` = $id";
    $deleteResult = mysqli_query($conn, $deleteQuery);

    if ($deleteResult) {
        header("Location: read.php"); // Redirect back to read.php after successful deletion
        exit();
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }
} else {
    echo "No ID provided for deletion.";
}
?>
