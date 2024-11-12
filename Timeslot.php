<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Time Slot Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
   /* Page Styling */
body {
    background-color: #14191F; /* Dark metallic background */
    font-family: 'Roboto', sans-serif;
    color: #E4E6EB; /* Light text color */
}

.container {
    margin-top: 40px;
    background-color: #ffffff;
    border-radius: 12px;
    padding: 40px;
    box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15); /* Slightly stronger shadow */
}

h2 {
    color: #E74C3C; /* Stark red for headers */
    font-weight: 700;
    text-align: center;
    margin-bottom: 25px;
    font-size: 1.7rem;
    text-transform: uppercase;
    letter-spacing: 1.2px;
    text-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
}

/* Table Styling */
.table-responsive {
    margin: 25px 0;
}

table {
    width: 100%;
    border-collapse: collapse;
    overflow: hidden;
    background-color: #ffffff;
    border-radius: 10px;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2); /* Enhanced shadow */
}

.table th {
    background: linear-gradient(135deg, #C0392B, #8E44AD); /* Iron Man red and metallic gradient */
    color: #FFFFFF;
    font-weight: 600;
    text-align: center;
    padding: 12px;
}

.table-striped tbody tr:nth-of-type(odd) {
    background-color: #F4F6F7; /* Light metallic silver */
}

.table-striped tbody tr:nth-of-type(even) {
    background-color: #D5DBDB; /* Darker silver */
}

/* Buttons */
.btn-primary {
    background-color: #E74C3C; /* Iron Man red */
    border: none;
    color: #FFFFFF;
    padding: 10px 20px;
    border-radius: 6px;
    font-weight: 600;
    transition: background-color 0.3s ease, transform 0.2s ease;
    box-shadow: 0 4px 12px rgba(231, 76, 60, 0.3); /* Red glow effect */
}

.btn-primary:hover {
    background-color: #C0392B; /* Darker red on hover */
    transform: translateY(-2px); /* Lift effect */
    box-shadow: 0 6px 18px rgba(231, 76, 60, 0.5);
}

.btn-action {
    margin: 5px;
    border: none;
    padding: 8px 16px;
    border-radius: 6px;
    color: #FFFFFF;
    font-weight: bold;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.btn-warning {
    background-color: #F39C12; /* Gold color */
}

.btn-danger {
    background-color: #E74C3C;
}

.btn-action:hover {
    transform: scale(1.05);
    box-shadow: 0 4px 12px rgba(243, 156, 18, 0.4); /* Gold glow effect */
}

/* Modals */
.modal-header {
    background: linear-gradient(135deg, #E74C3C, #8E44AD); /* Red and dark metallic gradient */
    color: black;
    border-top-left-radius: 8px;
    border-top-right-radius: 8px;
    box-shadow: 0 5px 15px rgba(231, 76, 60, 0.5); /* Iron Man red shadow */
}

.modal-title {
    font-weight: 700;
    font-size: 1.3rem;
    text-transform: uppercase;
}

.form-label {
    font-weight: 500;
    color: black; /* Light text */
}

.modal-footer .btn {
    border-radius: 6px;
    padding: 10px 20px;
    transition: background-color 0.3s ease, transform 0.2s ease;
}

.modal-footer .btn:hover {
    transform: scale(1.05);
    box-shadow: 0 4px 12px rgba(231, 76, 60, 0.4);
}

h2 {
    animation: glow 3s ease-in-out infinite;
}

</style>
</head>
<body>

<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'universitydb');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
    // Create
    if ($_POST['action'] == 'create') {
        $day = $_POST['day'];
        $startTime = $_POST['start_time'];
        $endTime = $_POST['end_time'];

        $stmt = $conn->prepare("INSERT INTO TimeSlot (day, start_time, end_time) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $day, $startTime, $endTime);
        
        if ($stmt->execute()) {
            echo "<div class='alert alert-success'>Time slot added successfully.</div>";
        } else {
            echo "<div class='alert alert-danger'>Error: " . $stmt->error . "</div>";
        }
        $stmt->close();
    }
    
    // Update
    elseif ($_POST['action'] == 'update') {
        $timeSlotId = $_POST['time_slot_id'];
        $day = $_POST['day'];
        $startTime = $_POST['start_time'];
        $endTime = $_POST['end_time'];

        $stmt = $conn->prepare("UPDATE TimeSlot SET day = ?, start_time = ?, end_time = ? WHERE time_slot_id = ?");
        $stmt->bind_param("sssi", $day, $startTime, $endTime, $timeSlotId);
        
        if ($stmt->execute()) {
            echo "<div class='alert alert-success'>Time slot updated successfully.</div>";
        } else {
            echo "<div class='alert alert-danger'>Error: " . $stmt->error . "</div>";
        }
        $stmt->close();
    }
    
    // Delete
    elseif ($_POST['action'] == 'delete') {
        $timeSlotId = $_POST['time_slot_id'];
        $stmt = $conn->prepare("DELETE FROM TimeSlot WHERE time_slot_id = ?");
        $stmt->bind_param("i", $timeSlotId);
        
        if ($stmt->execute()) {
            echo "<div class='alert alert-success'>Time slot deleted successfully.</div>";
        } else {
            echo "<div class='alert alert-danger'>Error: " . $stmt->error . "</div>";
        }
        $stmt->close();
    }
}

// Read time slots
$result = $conn->query("SELECT * FROM TimeSlot ORDER BY FIELD(day, 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'), start_time");
?>

<div class="container mt-4">
    <h2>Time Slot Management</h2>
    
    <!-- Add Time Slot Button -->
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
        Add New Time Slot
    </button>

    <!-- Time Slots Table -->
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Day</th>
                    <th>Start Time</th>
                    <th>End Time</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['day']; ?></td>
                    <td><?php echo date('h:i A', strtotime($row['start_time'])); ?></td>
                    <td><?php echo date('h:i A', strtotime($row['end_time'])); ?></td>
                    <td>
                        <button class="btn btn-sm btn-warning btn-action" onclick="editTimeSlot(<?php echo htmlspecialchars(json_encode($row)); ?>)">Edit</button>
                        <button class="btn btn-sm btn-danger btn-action" onclick="deleteTimeSlot(<?php echo $row['time_slot_id']; ?>)">Delete</button>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <!-- Add Modal -->
    <div class="modal fade" id="addModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Time Slot</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="action" value="create">
                        <div class="mb-3">
                            <label class="form-label">Day</label>
                            <select class="form-select" name="day" required>
                                <option value="">Select a day</option>
                                <option value="Monday">Monday</option>
                                <option value="Tuesday">Tuesday</option>
                                <option value="Wednesday">Wednesday</option>
                                <option value="Thursday">Thursday</option>
                                <option value="Friday">Friday</option>
                                <option value="Saturday">Saturday</option>
                                <option value="Sunday">Sunday</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Start Time</label>
                            <input type="time" class="form-control" name="start_time" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">End Time</label>
                            <input type="time" class="form-control" name="end_time" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add Time Slot</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Time Slot</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="action" value="update">
                        <input type="hidden" name="time_slot_id" id="edit_time_slot_id">
                        <div class="mb-3">
                            <label class="form-label">Day</label>
                            <select class="form-select" name="day" id="edit_day" required>
                                <option value="Monday">Monday</option>
                                <option value="Tuesday">Tuesday</option>
                                <option value="Wednesday">Wednesday</option>
                                <option value="Thursday">Thursday</option>
                                <option value="Friday">Friday</option>
                                <option value="Saturday">Saturday</option>
                                <option value="Sunday">Sunday</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Start Time</label>
                            <input type="time" class="form-control" name="start_time" id="edit_start_time" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">End Time</label>
                            <input type="time" class="form-control" name="end_time" id="edit_end_time" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update Time Slot</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete Time Slot</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="action" value="delete">
                        <input type="hidden" name="time_slot_id" id="delete_time_slot_id">
                        <p>Are you sure you want to delete this time slot?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Back button -->
    <button class="btn btn-secondary mt-3" onclick="window.location.href='index.php';">Back</button>
</div>

<!-- Add Bootstrap JS and its dependencies -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
// Function to edit time slot
function editTimeSlot(timeSlot) {
    document.getElementById('edit_time_slot_id').value = timeSlot.time_slot_id;
    document.getElementById('edit_day').value = timeSlot.day;
    document.getElementById('edit_start_time').value = timeSlot.start_time;
    document.getElementById('edit_end_time').value = timeSlot.end_time;
    
    // Show the edit modal
    var editModal = new bootstrap.Modal(document.getElementById('editModal'));
    editModal.show();
}

// Function to delete time slot
function deleteTimeSlot(timeSlotId) {
    document.getElementById('delete_time_slot_id').value = timeSlotId;
    
    // Show the delete modal
    var deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
    deleteModal.show();
}

// Add success message auto-hide
document.addEventListener('DOMContentLoaded', function() {
    // Auto hide alerts after 3 seconds
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(function(alert) {
        setTimeout(function() {
            alert.style.display = 'none';
        }, 3000);
    });
});
</script>

<?php
// Close the connection
$conn->close();
?>

</body>
</html>