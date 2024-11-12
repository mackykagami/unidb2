<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instructor Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
  /* Page Styling */
body {
    background-color: #14191F; /* Dark metallic background */
    font-family: 'Roboto', sans-serif;
    color: black; /* Light text color */
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
$conn = new mysqli('localhost', 'root', '', 'universitydb');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] == 'create') {
        $identificationNumber = $_POST['identification_number'];
        $firstName = $_POST['first_name'];
        $middleInitial = $_POST['middle_initial'];
        $lastName = $_POST['last_name'];
        $streetNumber = $_POST['street_number'];
        $streetName = $_POST['street_name'];
        $aptNumber = $_POST['apt_number'];
        $city = $_POST['city'];
        $state = $_POST['state'];
        $postalCode = $_POST['postal_code'];
        $dateOfBirth = $_POST['date_of_birth'];
        $departmentId = !empty($_POST['department_id']) ? $_POST['department_id'] : null;
        $salary = !empty($_POST['salary']) ? $_POST['salary'] : null;

        $stmt = $conn->prepare("INSERT INTO Instructor (identification_number, first_name, middle_initial, last_name, street_number, street_name, apt_number, city, state, postal_code, date_of_birth, department_id, salary) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssssssssii", $identificationNumber, $firstName, $middleInitial, $lastName, $streetNumber, $streetName, $aptNumber, $city, $state, $postalCode, $dateOfBirth, $departmentId, $salary);
        
        if ($stmt->execute()) {
            echo "<div class='alert alert-success'>Instructor added successfully.</div>";
        } else {
            echo "<div class='alert alert-danger'>Error: " . $stmt->error . "</div>";
        }
        $stmt->close();
    }
    
    // Update
    elseif ($_POST['action'] == 'update') {
        $instructorId = $_POST['instructor_id'];
        $identificationNumber = $_POST['identification_number'];
        $firstName = $_POST['first_name'];
        $middleInitial = $_POST['middle_initial'];
        $lastName = $_POST['last_name'];
        $streetNumber = $_POST['street_number'];
        $streetName = $_POST['street_name'];
        $aptNumber = $_POST['apt_number'];
        $city = $_POST['city'];
        $state = $_POST['state'];
        $postalCode = $_POST['postal_code'];
        $dateOfBirth = $_POST['date_of_birth'];
        $departmentId = !empty($_POST['department_id']) ? $_POST['department_id'] : null;
        $salary = !empty($_POST['salary']) ? $_POST['salary'] : null;

        $stmt = $conn->prepare("UPDATE Instructor SET identification_number=?, first_name=?, middle_initial=?, last_name=?, street_number=?, street_name=?, apt_number=?, city=?, state=?, postal_code=?, date_of_birth=?, department_id=?, salary=? WHERE instructor_id=?");
        $stmt->bind_param("ssssssssssssii", $identificationNumber, $firstName, $middleInitial, $lastName, $streetNumber, $streetName, $aptNumber, $city, $state, $postalCode, $dateOfBirth, $departmentId, $salary, $instructorId);
        
        if ($stmt->execute()) {
            echo "<div class='alert alert-success'>Instructor updated successfully.</div>";
        } else {
            echo "<div class='alert alert-danger'>Error: " . $stmt->error . "</div>";
        }
        $stmt->close();
    }
    
    // Delete (unchanged)
    elseif ($_POST['action'] == 'delete') {
        $instructorId = $_POST['instructor_id'];
        $stmt = $conn->prepare("DELETE FROM Instructor WHERE instructor_id = ?");
        $stmt->bind_param("i", $instructorId);
        
        if ($stmt->execute()) {
            echo "<div class='alert alert-success'>Instructor deleted successfully.</div>";
        } else {
            echo "<div class='alert alert-danger'>Error: " . $stmt->error . "</div>";
        }
        $stmt->close();
    }
}

$result = $conn->query("SELECT i.*, d.department_name FROM Instructor i LEFT JOIN Department d ON i.department_id = d.department_id");
?>

<div class="container">
    <h2>Instructors Management</h2>
    
    <!-- Add Instructor Button -->
    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addModal">
        + Add New Instructor
    </button>

    <!-- Instructors Table -->
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Identification Number</th>
                    <th>Name</th>
                    <th>Address</th>
                    <th>City</th>
                    <th>Province</th>
                    <th>Postal Code</th>
                    <th>Date of Birth</th>
                    <th>Department</th>
                    <th>Salary</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['identification_number']; ?></td>
                    <td><?php echo $row['first_name'] . ' ' . $row['middle_initial'] . ' ' . $row['last_name']; ?></td>
                    <td><?php echo $row['street_number'] . ' ' . $row['street_name'] . ' ' . $row['apt_number']; ?></td>
                    <td><?php echo $row['city']; ?></td>
                    <td><?php echo $row['state']; ?></td>
                    <td><?php echo $row['postal_code']; ?></td>
                    <td><?php echo $row['date_of_birth']; ?></td>
                    <td><?php echo $row['department_name'] ?? 'Not Assigned'; ?></td>
                    <td><?php echo $row['salary'] ? '$' . number_format($row['salary'], 2) : 'Not Set'; ?></td>
                    <td class="text-center">
                        <button class="btn btn-sm btn-warning btn-action" onclick="editInstructor(<?php echo htmlspecialchars(json_encode($row)); ?>)">Edit</button>
                        <button class="btn btn-sm btn-danger btn-action" onclick="deleteInstructor(<?php echo $row['instructor_id']; ?>)">Delete</button>
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
                    <h5 class="modal-title">Add New Instructor</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="action" value="create">
                        <div class="mb-3">
                            <label class="form-label">Identification Number</label>
                            <input type="text" class="form-control" name="identification_number" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">First Name</label>
                            <input type="text" class="form-control" name="first_name" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Middle Initial</label>
                            <input type="text" class="form-control" name="middle_initial">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Last Name</label>
                            <input type="text" class="form-control" name="last_name" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Street Number</label>
                            <input type="text" class="form-control" name="street_number">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Street Name</label>
                            <input type="text" class="form-control" name="street_name">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Apt Number</label>
                            <input type="text" class="form-control" name="apt_number">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">City</label>
                            <input type="text" class="form-control" name="city">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Province</label>
                            <input type="text" class="form-control" name="state">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Postal Code</label>
                            <input type="text" class="form-control" name="postal_code">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Date of Birth</label>
                            <input type="date" class="form-control" name="date_of_birth" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Salary</label>
                            <input type="number" class="form-control" name="salary" min="0" step="1">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Department</label>
                            <select class="form-control" name="department_id">
                                <option value="">No Department</option>
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
                        <button type="submit" class="btn btn-primary">Add Instructor</button>
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
                    <h5 class="modal-title">Edit Instructor</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="action" value="update">
                        <input type="hidden" name="instructor_id" id="edit_instructor_id">
                        <div class="mb-3">
                            <label class="form-label">Identification Number</label>
                            <input type="text" class="form-control" name="identification_number" id="edit_identification_number" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">First Name</label>
                            <input type="text" class="form-control" name="first_name" id="edit_first_name" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Middle Initial</label>
                            <input type="text" class="form-control" name="middle_initial" id="edit_middle_initial">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Last Name</label>
                            <input type="text" class="form-control" name="last_name" id="edit_last_name" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Street Number</label>
                            <input type="text" class="form-control" name="street_number" id="edit_street_number">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Street Name</label>
                            <input type="text" class="form-control" name="street_name" id="edit_street_name">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Apt Number</label>
                            <input type="text" class="form-control" name="apt_number" id="edit_apt_number">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">City</label>
                            <input type="text" class="form-control" name="city" id="edit_city">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">State</label>
                            <input type="text" class="form-control" name="state" id="edit_state">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Postal Code</label>
                            <input type="text" class="form-control" name="postal_code" id="edit_postal_code">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Date of Birth</label>
                            <input type="date" class="form-control" name="date_of_birth" id="edit_date_of_birth" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Salary</label>
                            <input type="number" class="form-control" name="salary" id="edit_salary" min="0" step="1">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Department</label>
                            <select class="form-control" name="department_id" id="edit_department_id">
                                <option value="">No Department</option>
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
                        <button type="submit" class="btn btn-primary">Update Instructor</button>
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
                    <h5 class="modal-title">Delete Instructor</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="action" value="delete">
                        <input type="hidden" name="instructor_id" id="delete_instructor_id">
                        <p>Are you sure you want to delete this instructor?</p>
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
// Function to edit instructor
function editInstructor(instructor) {
    document.getElementById('edit_instructor_id').value = instructor.instructor_id;
    document.getElementById('edit_identification_number').value = instructor.identification_number;
    document.getElementById('edit_first_name').value = instructor.first_name;
    document.getElementById('edit_middle_initial').value = instructor.middle_initial;
    document.getElementById('edit_last_name').value = instructor.last_name;
    document.getElementById('edit_street_number').value = instructor.street_number;
    document.getElementById('edit_street_name').value = instructor.street_name;
    document.getElementById('edit_apt_number').value = instructor.apt_number;
    document.getElementById('edit_city').value = instructor.city;
    document.getElementById('edit_state').value = instructor.state;
    document.getElementById('edit_postal_code').value = instructor.postal_code;
    document.getElementById('edit_date_of_birth').value = instructor.date_of_birth;
    document.getElementById('edit_department_id').value = instructor.department_id;
    document.getElementById('edit_salary').value = instructor.salary;
    
    // Show the edit modal
    var editModal = new bootstrap.Modal(document.getElementById('editModal'));
    editModal.show();
}

// Function to delete instructor
function deleteInstructor(instructorId) {
    document.getElementById('delete_instructor_id').value = instructorId;
    
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