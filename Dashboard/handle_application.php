<?php
require '../config.php'; // Include database connection file

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $application_id = $_POST['application_id'] ?? null;
    $action = $_POST['action'] ?? null;
    
    if (!$application_id || !$action) {
        die("Invalid request.");
    }

    if ($action === 'review') {
        $query = "UPDATE applications SET viewed = 1, Status = 'NA' WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $application_id);
        
        if ($stmt->execute()) {
            header("Location:index.php");
        } else {
            echo "Error updating application: " . $conn->error;
        }
    } elseif ($action === 'schedule') {   
       
            header("Location: schedule_interview.php?id=$application_id");
               
    
    } elseif ($action === 'reject') {
        $query = "UPDATE applications SET viewed = 2, Status = 'Rejected' WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i",$application_id);

        if ($stmt->execute()) {
            header("Location:index.php");
        } else {
            echo "Error rejecting application: " . $conn->error;
        }
    } else {
        echo "Invalid action.";
    }

    if ($action === 'delete') {
        $query = "DELETE from applications WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $application_id);
        
        if ($stmt->execute()) {
            header("Location:index.php");
        } else {
            echo "Error deleting application: " . $conn->error;
        }
    }else if($action === 'cancel'){
        header("Location:index.php");
    }else{
        echo "Invalid action.";
    }
}
?>
