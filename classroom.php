<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Classroom Management</title>
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
        $roomNumber = $_POST['room_number'];
        $building = $_POST['building'];
        $capacity = $_POST['capacity'];

        $stmt = $conn->prepare("INSERT INTO Classroom (room_number, building, capacity) VALUES (?, ?, ?)");
        $stmt->bind_param("ssi", $roomNumber, $building, $capacity);
        
        if ($stmt->execute()) {
            echo "<div class='alert alert-success'>Classroom added successfully.</div>";
        } else {
            echo "<div class='alert alert-danger'>Error: " . $stmt->error . "</div>";
        }
        $stmt->close();
    }
    
    // Update
    elseif ($_POST['action'] == 'update') {
        $classroomId = $_POST['classroom_id'];
        $roomNumber = $_POST['room_number'];
        $building = $_POST['building'];
        $capacity = $_POST['capacity'];

        $stmt = $conn->prepare("UPDATE Classroom SET room_number = ?, building = ?, capacity = ? WHERE classroom_id = ?");
        $stmt->bind_param("ssii", $roomNumber, $building, $capacity, $classroomId);
        
        if ($stmt->execute()) {
            echo "<div class='alert alert-success'>Classroom updated successfully.</div>";
        } else {
            echo "<div class='alert alert-danger'>Error: " . $stmt->error . "</div>";
        }
        $stmt->close();
    }
    
    // Delete
    elseif ($_POST['action'] == 'delete') {
        $classroomId = $_POST['classroom_id'];
        $stmt = $conn->prepare("DELETE FROM Classroom WHERE classroom_id = ?");
        $stmt->bind_param("i", $classroomId);
        
        if ($stmt->execute()) {
            echo "<div class='alert alert-success'>Classroom deleted successfully.</div>";
        } else {
            echo "<div class='alert alert-danger'>Error: " . $stmt->error . "</div>";
        }
        $stmt->close();
    }
}

// Read classrooms
$result = $conn->query("SELECT * FROM Classroom");
?>

<div class="container mt-4">
    <h2>Classroom Management</h2>
    
    <!-- Add Classroom Button -->
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
        Add New Classroom
    </button>

    <!-- Classrooms Table -->
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Room Number</th>
                    <th>Building</th>
                    <th>Capacity</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    
                    <td><?php echo $row['room_number']; ?></td>
                    <td><?php echo $row['building']; ?></td>
                    <td><?php echo $row['capacity']; ?></td>
                    <td>
                        <button class="btn btn-sm btn-warning btn-action" onclick="editClassroom(<?php echo htmlspecialchars(json_encode($row)); ?>)">Edit</button>
                        <button class="btn btn-sm btn-danger btn-action" onclick="deleteClassroom(<?php echo $row['classroom_id']; ?>)">Delete</button>
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
                    <h5 class="modal-title">Add New Classroom</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="action" value="create">
                        <div class="mb-3">
                            <label class="form-label">Room Number</label>
                            <input type="text" class="form-control" name="room_number" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Building</label>
                            <input type="text" class="form-control" name="building" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Capacity</label>
                            <input type="number" class="form-control" name="capacity" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add Classroom</button>
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
                    <h5 class="modal-title">Edit Classroom</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="action" value="update">
                        <input type="hidden" name="classroom_id" id="edit_classroom_id">
                        <div class="mb-3">
                            <label class="form-label">Room Number</label>
                            <input type="text" class="form-control" name="room_number" id="edit_room_number" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Building</label>
                            <input type="text" class="form-control" name="building" id="edit_building" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Capacity</label>
                            <input type="number" class="form-control" name="capacity" id="edit_capacity" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update Classroom</button>
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
                    <h5 class="modal-title">Delete Classroom</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="action" value="delete">
                        <input type="hidden" name="classroom_id" id="delete_classroom_id">
                        <p>Are you sure you want to delete this classroom?</p>
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
// Function to edit classroom
function editClassroom(classroom) {
    document.getElementById('edit_classroom_id').value = classroom.classroom_id;
    document.getElementById('edit_room_number').value = classroom.room_number;
    document.getElementById('edit_building').value = classroom.building;
    document.getElementById('edit_capacity').value = classroom.capacity;
    
    // Show the edit modal
    var editModal = new bootstrap.Modal(document.getElementById('editModal'));
    editModal.show();
}

// Function to delete classroom
function deleteClassroom(classroomId) {
    document.getElementById('delete_classroom_id').value = classroomId;
    
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