<?php
/**
 * =============================================================================
 * Edit Employee Record (UPDATE) - Mobile-Optimized
 * =============================================================================
 */

require_once 'db_connect.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : (isset($_POST['id']) ? (int)$_POST['id'] : 0);

if (!$id) {
    header('Location: index.php');
    exit;
}

// Fetch existing record
$stmt = $pdo->prepare("SELECT * FROM employees WHERE id = :id LIMIT 1");
$stmt->execute([':id' => $id]);
$employee = $stmt->fetch();

if (!$employee) {
    header('Location: index.php');
    exit;
}

$error = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $employee_id = trim($_POST['employee_id'] ?? '');
    $first_name  = trim($_POST['first_name'] ?? '');
    $last_name   = trim($_POST['last_name'] ?? '');
    $email       = trim($_POST['email'] ?? '');
    $phone       = trim($_POST['phone'] ?? '');
    $department  = trim($_POST['department'] ?? '');
    $position    = trim($_POST['position'] ?? '');
    $salary      = trim($_POST['salary'] ?? '0');
    $hire_date   = trim($_POST['hire_date'] ?? '');
    $status      = trim($_POST['status'] ?? 'Active');

    // Validation
    if (empty($employee_id) || empty($first_name) || empty($last_name) || empty($email) || empty($department) || empty($position)) {
        $error = 'Please fill in all required fields.';
    } else {
        // Check if employee_id already taken by another record
        $check_stmt = $pdo->prepare("SELECT COUNT(*) FROM employees WHERE employee_id = :emp_id AND id != :id");
        $check_stmt->execute([':emp_id' => $employee_id, ':id' => $id]);
        if ($check_stmt->fetchColumn() > 0) {
            $error = "Employee ID '{$employee_id}' is already registered to another employee.";
        } else {
            // UPDATE Query
            $update_sql = "UPDATE employees SET 
                employee_id = :employee_id,
                first_name  = :first_name,
                last_name   = :last_name,
                email       = :email,
                phone       = :phone,
                department  = :department,
                position    = :position,
                salary      = :salary,
                hire_date   = :hire_date,
                status      = :status
                WHERE id = :id";
            
            $stmt = $pdo->prepare($update_sql);
            $success = $stmt->execute([
                ':employee_id' => $employee_id,
                ':first_name'  => $first_name,
                ':last_name'   => $last_name,
                ':email'       => $email,
                ':phone'       => $phone,
                ':department'  => $department,
                ':position'    => $position,
                ':salary'      => (float)$salary,
                ':hire_date'   => $hire_date,
                ':status'      => $status,
                ':id'          => $id
            ]);

            if ($success) {
                header('Location: index.php?msg=updated');
                exit;
            } else {
                $error = 'Failed to update employee record. Please try again.';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <title>Edit Employee - ISUFST HRTrack</title>
    <!-- Bootstrap 5 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome Icons CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="d-flex flex-column min-vh-100">

    <!-- Responsive Navigation Bar -->
    <nav class="navbar navbar-dark bg-primary shadow-sm py-2 py-sm-3 sticky-top">
        <div class="container px-3">
            <a class="navbar-brand fw-bold d-flex align-items-center gap-2 text-truncate me-2" href="index.php">
                <i class="fa-solid fa-users-gear fa-lg flex-shrink-0"></i>
                <span class="text-truncate">
                    <span class="d-none d-sm-inline">ISUFST </span>Employee Tracker
                </span>
            </a>
            <a href="index.php" class="btn btn-outline-light btn-sm d-inline-flex align-items-center gap-1 flex-shrink-0">
                <i class="fa-solid fa-arrow-left"></i>
                <span class="d-none d-sm-inline">Directory</span>
            </a>
        </div>
    </nav>

    <!-- Main Container -->
    <div class="container px-3 py-3 py-sm-4 flex-grow-1">
        <div class="row justify-content-center">
            <div class="col-12 col-md-10 col-lg-8">

                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger alert-dismissible fade show shadow-sm mb-3" role="alert">
                        <i class="fa-solid fa-triangle-exclamation me-2"></i> <?php echo htmlspecialchars($error); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <div class="card border-0 shadow-sm rounded-3">
                    <div class="card-header bg-white py-3 px-3 px-sm-4 border-bottom d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <h5 class="fw-bold mb-0 text-primary d-flex align-items-center gap-2">
                            <i class="fa-solid fa-pen-to-square"></i> Edit Employee Record
                        </h5>
                        <span class="badge bg-secondary font-monospace"><?php echo htmlspecialchars($employee['employee_id']); ?></span>
                    </div>

                    <div class="card-body p-3 p-sm-4">
                        <form method="POST" action="edit_employee.php">
                            <input type="hidden" name="id" value="<?php echo $employee['id']; ?>">

                            <div class="row g-3">
                                <!-- Employee ID -->
                                <div class="col-12 col-sm-6">
                                    <label class="form-label small fw-bold">Employee ID <span class="text-danger">*</span></label>
                                    <input type="text" name="employee_id" class="form-control" value="<?php echo htmlspecialchars($_POST['employee_id'] ?? $employee['employee_id']); ?>" required>
                                </div>

                                <!-- Status -->
                                <div class="col-12 col-sm-6">
                                    <label class="form-label small fw-bold">Status <span class="text-danger">*</span></label>
                                    <?php $cur_status = $_POST['status'] ?? $employee['status']; ?>
                                    <select name="status" class="form-select">
                                        <option value="Active" <?php echo ($cur_status === 'Active') ? 'selected' : ''; ?>>Active</option>
                                        <option value="On Leave" <?php echo ($cur_status === 'On Leave') ? 'selected' : ''; ?>>On Leave</option>
                                        <option value="Probationary" <?php echo ($cur_status === 'Probationary') ? 'selected' : ''; ?>>Probationary</option>
                                        <option value="Resigned" <?php echo ($cur_status === 'Resigned') ? 'selected' : ''; ?>>Resigned</option>
                                    </select>
                                </div>

                                <!-- First Name -->
                                <div class="col-12 col-sm-6">
                                    <label class="form-label small fw-bold">First Name <span class="text-danger">*</span></label>
                                    <input type="text" name="first_name" class="form-control" value="<?php echo htmlspecialchars($_POST['first_name'] ?? $employee['first_name']); ?>" required>
                                </div>

                                <!-- Last Name -->
                                <div class="col-12 col-sm-6">
                                    <label class="form-label small fw-bold">Last Name <span class="text-danger">*</span></label>
                                    <input type="text" name="last_name" class="form-control" value="<?php echo htmlspecialchars($_POST['last_name'] ?? $employee['last_name']); ?>" required>
                                </div>

                                <!-- Email -->
                                <div class="col-12 col-sm-6">
                                    <label class="form-label small fw-bold">Email Address <span class="text-danger">*</span></label>
                                    <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($_POST['email'] ?? $employee['email']); ?>" required>
                                </div>

                                <!-- Phone -->
                                <div class="col-12 col-sm-6">
                                    <label class="form-label small fw-bold">Contact Phone <span class="text-danger">*</span></label>
                                    <input type="text" name="phone" class="form-control" value="<?php echo htmlspecialchars($_POST['phone'] ?? $employee['phone']); ?>" required>
                                </div>

                                <!-- Department -->
                                <div class="col-12 col-sm-6">
                                    <label class="form-label small fw-bold">Department <span class="text-danger">*</span></label>
                                    <?php $cur_dept = $_POST['department'] ?? $employee['department']; ?>
                                    <select name="department" class="form-select" required>
                                        <option value="Information Technology" <?php echo ($cur_dept === 'Information Technology') ? 'selected' : ''; ?>>Information Technology</option>
                                        <option value="Human Resources" <?php echo ($cur_dept === 'Human Resources') ? 'selected' : ''; ?>>Human Resources</option>
                                        <option value="Finance" <?php echo ($cur_dept === 'Finance') ? 'selected' : ''; ?>>Finance</option>
                                        <option value="Marketing" <?php echo ($cur_dept === 'Marketing') ? 'selected' : ''; ?>>Marketing</option>
                                        <option value="Operations" <?php echo ($cur_dept === 'Operations') ? 'selected' : ''; ?>>Operations</option>
                                        <option value="Research" <?php echo ($cur_dept === 'Research') ? 'selected' : ''; ?>>Research</option>
                                    </select>
                                </div>

                                <!-- Position -->
                                <div class="col-12 col-sm-6">
                                    <label class="form-label small fw-bold">Job Position <span class="text-danger">*</span></label>
                                    <input type="text" name="position" class="form-control" value="<?php echo htmlspecialchars($_POST['position'] ?? $employee['position']); ?>" required>
                                </div>

                                <!-- Salary -->
                                <div class="col-12 col-sm-6">
                                    <label class="form-label small fw-bold">Monthly Salary (PHP) <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text">₱</span>
                                        <input type="number" step="0.01" name="salary" id="salaryInput" class="form-control" value="<?php echo htmlspecialchars($_POST['salary'] ?? $employee['salary']); ?>" required>
                                    </div>
                                    <div id="salaryPreview" class="salary-preview-box mt-2 d-none"></div>
                                </div>

                                <!-- Hire Date -->
                                <div class="col-12 col-sm-6">
                                    <label class="form-label small fw-bold">Hire Date <span class="text-danger">*</span></label>
                                    <input type="date" name="hire_date" class="form-control" value="<?php echo htmlspecialchars($_POST['hire_date'] ?? $employee['hire_date']); ?>" required>
                                </div>
                            </div>

                            <hr class="my-4">

                            <!-- Touch-friendly stacked or balanced buttons for phones -->
                            <div class="d-flex flex-column-reverse flex-sm-row justify-content-between gap-2">
                                <a href="index.php" class="btn btn-outline-secondary w-100 w-sm-auto">Cancel</a>
                                <button type="submit" class="btn btn-primary px-4 fw-semibold w-100 w-sm-auto">
                                    <i class="fa-solid fa-floppy-disk me-1"></i> Update Employee
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Responsive Footer -->
    <footer class="bg-dark text-white-50 py-3 mt-auto border-top">
        <div class="container text-center small px-3">
            <span class="text-light fw-semibold">ISUFST Employee Record Tracking</span> &bull; 
            Web Systems Technologies &bull; &copy; <?php echo date('Y'); ?>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JavaScript -->
    <script src="js/script.js"></script>
</body>
</html>
