<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Management</title>
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
        $firstName = $_POST['first_name'];
        $lastName = $_POST['last_name'];
        $identificationNumber = $_POST['identification_number'];
        $dateOfBirth = $_POST['date_of_birth'];
        $totalCredit = (int)$_POST['total_credit'];
        $streetNumber = $_POST['street_number'];
        $streetName = $_POST['street_name'];
        $aptNumber = $_POST['apt_number'];
        $city = $_POST['city'];
        $state = $_POST['state'];
        $postalCode = $_POST['postal_code'];
        $departmentId = !empty($_POST['department_id']) ? $_POST['department_id'] : null;

        if ($departmentId === null) {
            $stmt = $conn->prepare("INSERT INTO Student (first_name, last_name, identification_number, date_of_birth, total_credit, street_number, street_name, apt_number, city, state, postal_code, department_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NULL)");
            $stmt->bind_param("ssssississs", $firstName, $lastName, $identificationNumber, $dateOfBirth, $totalCredit, $streetNumber, $streetName, $aptNumber, $city, $state, $postalCode);
        } else {
            $stmt = $conn->prepare("INSERT INTO Student (first_name, last_name, identification_number, date_of_birth, total_credit, street_number, street_name, apt_number, city, state, postal_code, department_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssississsi", $firstName, $lastName, $identificationNumber, $dateOfBirth, $totalCredit, $streetNumber, $streetName, $aptNumber, $city, $state, $postalCode, $departmentId);
        }
        
        if ($stmt->execute()) {
            echo "<div class='alert alert-success'>Student added successfully.</div>";
        } else {
            echo "<div class='alert alert-danger'>Error: " . $stmt->error . "</div>";
        }
        $stmt->close();
    }
    
    // Update
    elseif ($_POST['action'] == 'update') {
        $studentId = $_POST['student_id'];
        $firstName = $_POST['first_name'];
        $lastName = $_POST['last_name'];
        $identificationNumber = $_POST['identification_number'];
        $dateOfBirth = $_POST['date_of_birth'];
        $totalCredit = (int)$_POST['total_credit'];
        $streetNumber = $_POST['street_number'];
        $streetName = $_POST['street_name'];
        $aptNumber = $_POST['apt_number'];
        $city = $_POST['city'];
        $state = $_POST['state'];
        $postalCode = $_POST['postal_code'];
        $departmentId = !empty($_POST['department_id']) ? $_POST['department_id'] : null;

        if ($departmentId === null) {
            $stmt = $conn->prepare("UPDATE Student SET first_name=?, last_name=?, identification_number=?, date_of_birth=?, total_credit=?, street_number=?, street_name=?, apt_number=?, city=?, state=?, postal_code=?, department_id=NULL WHERE student_id=?");
            $stmt->bind_param("ssssississsi", $firstName, $lastName, $identificationNumber, $dateOfBirth, $totalCredit, $streetNumber, $streetName, $aptNumber, $city, $state, $postalCode, $studentId);
        } else {
            $stmt = $conn->prepare("UPDATE Student SET first_name=?, last_name=?, identification_number=?, date_of_birth=?, total_credit=?, street_number=?, street_name=?, apt_number=?, city=?, state=?, postal_code=?, department_id=? WHERE student_id=?");
            $stmt->bind_param("ssssississsii", $firstName, $lastName, $identificationNumber, $dateOfBirth, $totalCredit, $streetNumber, $streetName, $aptNumber, $city, $state, $postalCode, $departmentId, $studentId);
        }
        
        if ($stmt->execute()) {
            echo "<div class='alert alert-success'>Student updated successfully.</div>";
        } else {
            echo "<div class='alert alert-danger'>Error: " . $stmt->error . "</div>";
        }
        $stmt->close();
    }
    
    // Delete
    elseif ($_POST['action'] == 'delete') {
        $studentId = $_POST['student_id'];
        $stmt = $conn->prepare("DELETE FROM Student WHERE student_id = ?");
        $stmt->bind_param("i", $studentId);
        
        if ($stmt->execute()) {
            echo "<div class='alert alert-success'>Student deleted successfully.</div>";
        } else {
            echo "<div class='alert alert-danger'>Error: " . $stmt->error . "</div>";
        }
        $stmt->close();
    }
}

// Read students with department information
$result = $conn->query("SELECT s.*, d.department_name FROM Student s LEFT JOIN Department d ON s.department_id = d.department_id");
?>

<div class="container mt-4">
    <h2>Student Management</h2>
    
    <!-- Add Student Button -->
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
        Add New Student
    </button>

    <!-- Students Table -->
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Identification Number</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Date of Birth</th>
                    <th>Total Credit</th>
                    <th>Address</th>
                    <th>Department</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['identification_number']; ?></td>
                    <td><?php echo $row['first_name']; ?></td>
                    <td><?php echo $row['last_name']; ?></td>
                    <td><?php echo $row['date_of_birth']; ?></td>
                    <td><?php echo $row['total_credit']; ?></td>
                    <td>
                        <?php 
                        $address = [];
                        if (!empty($row['street_number']) && !empty($row['street_name'])) {
                            $address[] = $row['street_number'] . ' ' . $row['street_name'];
                        }
                        if (!empty($row['apt_number'])) {
                            $address[] = 'Apt ' . $row['apt_number'];
                        }
                        if (!empty($row['city']) && !empty($row['state'])) {
                            $address[] = $row['city'] . ', ' . $row['state'];
                        }
                        if (!empty($row['postal_code'])) {
                            $address[] = $row['postal_code'];
                        }
                        echo !empty($address) ? implode('<br>', $address) : 'No address provided';
                        ?>
                    </td>
                    <td><?php echo $row['department_name'] ?? 'Not Assigned'; ?></td>
                    <td>
                        <button class="btn btn-sm btn-warning btn-action" onclick="editStudent(<?php echo htmlspecialchars(json_encode($row)); ?>)">Edit</button>
                        <button class="btn btn-sm btn-danger btn-action" onclick="deleteStudent(<?php echo $row['student_id']; ?>)">Delete</button>
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
                    <h5 class="modal-title">Add New Student</h5>
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
                            <label class="form-label">Last Name</label>
                            <input type="text" class="form-control" name="last_name" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Date of Birth</label>
                            <input type="date" class="form-control" name="date_of_birth" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Total Credit</label>
                            <input type="number" class="form-control" name="total_credit">
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
                            <label class="form-label">Apartment Number</label>
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
                            <label class="form-label">Department (Optional)</label>
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
                        <button type="submit" class="btn btn-primary">Add Student</button>
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
                    <h5 class="modal-title">Edit Student</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="action" value="update">
                        <input type="hidden" name="student_id" id="edit_student_id">
                        <div class="mb-3">
                            <label class="form-label">Identification Number</label>
                            <input type="text" class="form-control" name="identification_number" id="edit_identification_number" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">First Name</label>
                            <input type="text" class="form-control" name="first_name" id="edit_first_name" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Last Name</label>
                            <input type="text" class="form-control" name="last_name" id="edit_last_name" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Date of Birth</label>
                            <input type="date" class="form-control" name="date_of_birth" id="edit_date_of_birth" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Total Credit</label>
                            <input type="number" class="form-control" name="total_credit" id="edit_total_credit">
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
                            <label class="form-label">Apartment Number</label>
                            <input type="text" class="form-control" name="apt_number" id="edit_apt_number">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">City</label>
                            <input type="text" class="form-control" name="city" id="edit_city">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Province</label>
                            <input type="text" class="form-control" name="state" id="edit_state">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Postal Code</label>
                            <input type="text" class="form-control" name="postal_code" id="edit_postal_code">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Department (Optional)</label>
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
                        <button type="submit" class="btn btn-primary">Update Student</button>
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
                    <h5 class="modal-title">Delete Student</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="action" value="delete">
                        <input type="hidden" name="student_id" id="delete_student_id">
                        <p>Are you sure you want to delete this student?</p>
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
// Function to edit student
function editStudent(student) {
    document.getElementById('edit_student_id').value = student.student_id;
    document.getElementById('edit_first_name').value = student.first_name;
    document.getElementById('edit_last_name').value = student.last_name;
    document.getElementById('edit_identification_number').value = student.identification_number;
    document.getElementById('edit_date_of_birth').value = student.date_of_birth;
    document.getElementById('edit_total_credit').value = student.total_credit;
    document.getElementById('edit_street_number').value = student.street_number || '';
    document.getElementById('edit_street_name').value = student.street_name || '';
    document.getElementById('edit_apt_number').value = student.apt_number || '';
    document.getElementById('edit_city').value = student.city || '';
    document.getElementById('edit_state').value = student.state || '';
    document.getElementById('edit_postal_code').value = student.postal_code || '';
    document.getElementById('edit_department_id').value = student.department_id || '';
    
    // Show the edit modal
    var editModal = new bootstrap.Modal(document.getElementById('editModal'));
    editModal.show();
}

// Function to delete student
function deleteStudent(studentId) {
    document.getElementById('delete_student_id').value = studentId;
    
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