<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Management</title>
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
        $courseCode = $_POST['course_code'];
        $courseName = $_POST['course_name'];
        $totalCredit = (int)$_POST['total_credit'];
        $departmentId = $_POST['department_id'];

        $stmt = $conn->prepare("INSERT INTO Course (course_code, course_name, total_credit, department_id) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssii", $courseCode, $courseName, $totalCredit, $departmentId);
        
        if ($stmt->execute()) {
            echo "<div class='alert alert-success'>Course added successfully.</div>";
        } else {
            if ($stmt->errno == 1062) { // Duplicate entry error
                echo "<div class='alert alert-danger'>Error: Course code already exists.</div>";
            } else {
                echo "<div class='alert alert-danger'>Error: " . $stmt->error . "</div>";
            }
        }
        $stmt->close();
    }
    
    // Update
    elseif ($_POST['action'] == 'update') {
        $courseId = $_POST['course_id'];
        $courseCode = $_POST['course_code'];
        $courseName = $_POST['course_name'];
        $totalCredit = (int)$_POST['total_credit'];
        $departmentId = $_POST['department_id'];

        $stmt = $conn->prepare("UPDATE Course SET course_code = ?, course_name = ?, total_credit = ?, department_id = ? WHERE course_id = ?");
        $stmt->bind_param("ssiii", $courseCode, $courseName, $totalCredit, $departmentId, $courseId);
        
        if ($stmt->execute()) {
            echo "<div class='alert alert-success'>Course updated successfully.</div>";
        } else {
            if ($stmt->errno == 1062) { // Duplicate entry error
                echo "<div class='alert alert-danger'>Error: Course code already exists.</div>";
            } else {
                echo "<div class='alert alert-danger'>Error: " . $stmt->error . "</div>";
            }
        }
        $stmt->close();
    }
    
    // Delete
    elseif ($_POST['action'] == 'delete') {
        $courseId = $_POST['course_id'];
        $stmt = $conn->prepare("DELETE FROM Course WHERE course_id = ?");
        $stmt->bind_param("i", $courseId);
        
        if ($stmt->execute()) {
            echo "<div class='alert alert-success'>Course deleted successfully.</div>";
        } else {
            echo "<div class='alert alert-danger'>Error: " . $stmt->error . "</div>";
        }
        $stmt->close();
    }
}

// Read courses with department information
$result = $conn->query("SELECT c.*, d.department_name FROM Course c LEFT JOIN Department d ON c.department_id = d.department_id");
?>

<div class="container mt-4">
    <h2>Course Management</h2>
    
    <!-- Add Course Button -->
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
        Add New Course
    </button>

    <!-- Courses Table -->
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Course Code</th>
                    <th>Name</th>
                    <th>Total Credit</th>
                    <th>Department</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['course_code']; ?></td>
                    <td><?php echo $row['course_name']; ?></td>
                    <td><?php echo $row['total_credit']; ?></td>
                    <td><?php echo $row['department_name']; ?></td>
                    <td>
                        <button class="btn btn-sm btn-warning btn-action" onclick="editCourse(<?php echo htmlspecialchars(json_encode($row)); ?>)">Edit</button>
                        <button class="btn btn-sm btn-danger btn-action" onclick="deleteCourse(<?php echo $row['course_id']; ?>)">Delete</button>
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
                    <h5 class="modal-title">Add New Course</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="action" value="create">
                        <div class="mb-3">
                            <label class="form-label">Course Code</label>
                            <input type="text" class="form-control" name="course_code" required maxlength="20" pattern="[A-Za-z0-9-]+" title="Only letters, numbers, and hyphens are allowed">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Course Name</label>
                            <input type="text" class="form-control" name="course_name" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Total Credit</label>
                            <input type="number" class="form-control" name="total_credit" required min="0">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Department</label>
                            <select class="form-control" name="department_id" required>
                                <option value="">Select Department</option>
                                <?php
                                $departments = $conn->query("SELECT department_id, department_name FROM Department");
                                while ($dept = $departments->fetch_assoc()) {
                                    echo "<option value='{$dept['department_id']}'>{$dept['department_name']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add Course</button>
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
                    <h5 class="modal-title">Edit Course</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="action" value="update">
                        <input type="hidden" name="course_id" id="edit_course_id">
                        <div class="mb-3">
                            <label class="form-label">Course Code</label>
                            <input type="text" class="form-control" name="course_code" id="edit_course_code" required maxlength="20" pattern="[A-Za-z0-9-]+" title="Only letters, numbers, and hyphens are allowed">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Course Name</label>
                            <input type="text" class="form-control" name="course_name" id="edit_course_name" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Total Credit</label>
                            <input type="number" class="form-control" name="total_credit" id="edit_total_credit" required min="0">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Department</label>
                            <select class="form-control" name="department_id" id="edit_department_id" required>
                                <option value="">Select Department</option>
                                <?php
                                $departments = $conn->query("SELECT department_id, department_name FROM Department");
                                while ($dept = $departments->fetch_assoc()) {
                                    echo "<option value='{$dept['department_id']}'>{$dept['department_name']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update Course</button>
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
                    <h5 class="modal-title">Delete Course</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="action" value="delete">
                        <input type="hidden" name="course_id" id="delete_course_id">
                        <p>Are you sure you want to delete this course?</p>
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
// Function to edit course
function editCourse(course) {
    document.getElementById('edit_course_id').value = course.course_id;
    document.getElementById('edit_course_code').value = course.course_code;
    document.getElementById('edit_course_name').value = course.course_name;
    document.getElementById('edit_total_credit').value = course.total_credit;
    document.getElementById('edit_department_id').value = course.department_id;
    
    // Show the edit modal
    var editModal = new bootstrap.Modal(document.getElementById('editModal'));
    editModal.show();
}

// Function to delete course
function deleteCourse(courseId) {
    document.getElementById('delete_course_id').value = courseId;
    
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