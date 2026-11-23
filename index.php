<?php
/**
 * =============================================================================
 * Employee Record Tracking System - Main Directory (READ / SELECT)
 * Mobile-First Responsive Design (Bootstrap 5)
 * =============================================================================
 */

require_once 'db_connect.php';

// Handle Search Query & Department Filter
$search     = trim($_GET['search'] ?? '');
$department = trim($_GET['department'] ?? '');

// Base SQL query
$sql = "SELECT * FROM employees WHERE 1=1";
$params = [];

if (!empty($search)) {
    $sql .= " AND (first_name LIKE :search 
               OR last_name LIKE :search 
               OR employee_id LIKE :search 
               OR position LIKE :search 
               OR email LIKE :search)";
    $params[':search'] = '%' . $search . '%';
}

if (!empty($department)) {
    $sql .= " AND department = :dept";
    $params[':dept'] = $department;
}

$sql .= " ORDER BY id DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$employees = $stmt->fetchAll();

// Statistics calculation
$total_employees  = $pdo->query("SELECT COUNT(*) FROM employees")->fetchColumn();
$active_employees = $pdo->query("SELECT COUNT(*) FROM employees WHERE status = 'Active'")->fetchColumn();
$total_payroll    = $pdo->query("SELECT COALESCE(SUM(salary), 0) FROM employees")->fetchColumn();

// Departments for filter dropdown (shows existing or standard departments)
$db_depts = $pdo->query("SELECT DISTINCT department FROM employees WHERE department IS NOT NULL AND department != '' ORDER BY department ASC")->fetchAll(PDO::FETCH_COLUMN);
$default_depts = ['Information Technology', 'Human Resources', 'Finance', 'Marketing', 'Operations', 'Research'];
$departments = !empty($db_depts) ? $db_depts : $default_depts;

// Flash messages from operations
$msg = $_GET['msg'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <title>Employee Record Tracking System - ISUFST</title>
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
            <div class="ms-auto flex-shrink-0">
                <a href="add_employee.php" class="btn btn-light btn-sm fw-semibold shadow-sm d-inline-flex align-items-center gap-1">
                    <i class="fa-solid fa-user-plus text-primary"></i>
                    <span class="d-none d-sm-inline">Add Employee</span>
                    <span class="d-inline d-sm-none">Add</span>
                </a>
            </div>
        </div>
    </nav>

    <!-- Main Container -->
    <div class="container px-3 py-3 py-sm-4 flex-grow-1">

        <!-- Notification Alerts -->
        <?php if ($msg === 'added'): ?>
            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                <i class="fa-solid fa-circle-check me-2"></i> Employee record successfully created!
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php elseif ($msg === 'updated'): ?>
            <div class="alert alert-info alert-dismissible fade show shadow-sm" role="alert">
                <i class="fa-solid fa-circle-info me-2"></i> Employee record successfully updated!
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php elseif ($msg === 'deleted'): ?>
            <div class="alert alert-warning alert-dismissible fade show shadow-sm" role="alert">
                <i class="fa-solid fa-trash me-2"></i> Employee record has been removed.
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <!-- Responsive Statistics Summary Cards -->
        <div class="row g-2 g-sm-3 mb-3 mb-sm-4">
            <!-- Total Employees -->
            <div class="col-6 col-md-4">
                <div class="card stat-card border-0 shadow-sm p-3 bg-white h-100">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="text-muted small fw-bold text-uppercase d-block fs-8">Total Staff</span>
                            <h3 class="fw-bold text-primary mb-0 mt-1 stat-number"><?php echo number_format($total_employees); ?></h3>
                        </div>
                        <div class="bg-primary-subtle text-primary p-2 p-sm-3 rounded-circle">
                            <i class="fa-solid fa-users fa-lg fa-sm-xl"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Active Employees -->
            <div class="col-6 col-md-4">
                <div class="card stat-card border-0 shadow-sm p-3 bg-white h-100">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="text-muted small fw-bold text-uppercase d-block fs-8">Active Staff</span>
                            <h3 class="fw-bold text-success mb-0 mt-1 stat-number"><?php echo number_format($active_employees); ?></h3>
                        </div>
                        <div class="bg-success-subtle text-success p-2 p-sm-3 rounded-circle">
                            <i class="fa-solid fa-user-check fa-lg fa-sm-xl"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Monthly Payroll -->
            <div class="col-12 col-md-4">
                <div class="card stat-card border-0 shadow-sm p-3 bg-white h-100">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="text-muted small fw-bold text-uppercase d-block fs-8">Est. Monthly Payroll</span>
                            <h3 class="fw-bold text-dark mb-0 mt-1 stat-number">₱<?php echo number_format($total_payroll, 2); ?></h3>
                        </div>
                        <div class="bg-warning-subtle text-warning-emphasis p-2 p-sm-3 rounded-circle">
                            <i class="fa-solid fa-peso-sign fa-lg fa-sm-xl"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter & Search Toolbar (Responsive Stack) -->
        <div class="card border-0 shadow-sm mb-3 mb-sm-4">
            <div class="card-body p-3">
                <form method="GET" action="index.php" class="row g-2 align-items-center">
                    <div class="col-12 col-md-5">
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0"><i class="fa-solid fa-magnifying-glass text-muted"></i></span>
                            <input type="text" name="search" id="searchInput" class="form-control border-start-0" placeholder="Search name, ID, position (live filter)..." value="<?php echo htmlspecialchars($search); ?>">
                        </div>
                    </div>
                    <div class="col-12 col-sm-8 col-md-4">
                        <select name="department" class="form-select" onchange="this.form.submit()">
                            <option value="">All Departments</option>
                            <?php foreach ($departments as $dept): ?>
                                <option value="<?php echo htmlspecialchars($dept); ?>" <?php echo ($department === $dept) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($dept); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-12 col-sm-4 col-md-3 d-flex gap-2">
                        <button type="submit" class="btn btn-primary flex-grow-1">
                            <i class="fa-solid fa-filter me-1"></i> Filter
                        </button>
                        <?php if (!empty($search) || !empty($department)): ?>
                            <a href="index.php" class="btn btn-outline-secondary" title="Reset Filters">
                                <i class="fa-solid fa-rotate-left"></i>
                            </a>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
        </div>

        <!-- Employee Table Card (Mobile Horizontal Scrollable Table) -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3 px-3 d-flex justify-content-between align-items-center flex-wrap gap-2">
                <h5 class="fw-bold mb-0 text-dark d-flex align-items-center gap-2">
                    <i class="fa-solid fa-list text-primary"></i> 
                    <span>Employee Directory</span>
                </h5>
                <span class="badge bg-secondary-subtle text-secondary px-3 py-2 rounded-pill small">
                    <?php echo count($employees); ?> Record(s)
                </span>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="employeeTable">
                    <thead class="table-light text-nowrap">
                        <tr>
                            <th class="ps-3">Employee ID</th>
                            <th>Full Name</th>
                            <th>Contact</th>
                            <th>Department</th>
                            <th>Position</th>
                            <th>Monthly Salary</th>
                            <th>Hire Date</th>
                            <th>Status</th>
                            <th class="text-end pe-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Client-side dynamic no match indicator -->
                        <tr id="noMatchRow" class="d-none empty-row">
                            <td colspan="9" class="text-center py-4 text-muted">
                                <i class="fa-solid fa-filter-circle-xmark fa-2x mb-2 text-secondary opacity-50"></i>
                                <div>No employee records match your search filter.</div>
                            </td>
                        </tr>
                        <?php if (empty($employees)): ?>
                            <tr class="empty-row">
                                <td colspan="9" class="text-center py-5 text-muted">
                                    <i class="fa-solid fa-user-slash fa-2x mb-2 text-secondary opacity-50"></i>
                                    <div>No employee records found.</div>
                                    <a href="add_employee.php" class="btn btn-sm btn-primary mt-2">Add First Employee</a>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($employees as $emp): 
                                $status_badge = 'badge-status-resigned';
                                if ($emp['status'] === 'Active')       $status_badge = 'badge-status-active';
                                if ($emp['status'] === 'On Leave')     $status_badge = 'badge-status-onleave';
                                if ($emp['status'] === 'Probationary') $status_badge = 'badge-status-probationary';
                            ?>
                                <tr>
                                    <!-- Employee ID -->
                                    <td class="ps-3 font-monospace fw-bold text-primary text-nowrap">
                                        <?php echo htmlspecialchars($emp['employee_id']); ?>
                                    </td>

                                    <!-- Full Name -->
                                    <td class="fw-semibold text-dark text-nowrap">
                                        <?php echo htmlspecialchars($emp['first_name'] . ' ' . $emp['last_name']); ?>
                                    </td>

                                    <!-- Contact info -->
                                    <td class="small text-nowrap">
                                        <div><i class="fa-regular fa-envelope me-1 text-muted"></i><?php echo htmlspecialchars($emp['email']); ?></div>
                                        <div class="text-muted"><i class="fa-solid fa-phone me-1"></i><?php echo htmlspecialchars($emp['phone']); ?></div>
                                    </td>

                                    <!-- Department -->
                                    <td class="text-nowrap">
                                        <span class="badge bg-primary-subtle text-primary border border-primary-subtle">
                                            <?php echo htmlspecialchars($emp['department']); ?>
                                        </span>
                                    </td>

                                    <!-- Position -->
                                    <td class="small fw-medium text-secondary text-nowrap">
                                        <?php echo htmlspecialchars($emp['position']); ?>
                                    </td>

                                    <!-- Salary -->
                                    <td class="fw-bold text-success text-nowrap">
                                        ₱<?php echo number_format($emp['salary'], 2); ?>
                                    </td>

                                    <!-- Hire Date -->
                                    <td class="small text-muted text-nowrap">
                                        <?php echo date('M d, Y', strtotime($emp['hire_date'])); ?>
                                    </td>

                                    <!-- Status -->
                                    <td class="text-nowrap">
                                        <span class="badge-status <?php echo $status_badge; ?>">
                                            <?php echo htmlspecialchars($emp['status']); ?>
                                        </span>
                                    </td>

                                    <!-- Actions (Touch-friendly for phone) -->
                                    <td class="text-end pe-3 text-nowrap">
                                        <div class="btn-group" role="group">
                                            <a href="edit_employee.php?id=<?php echo $emp['id']; ?>" class="btn btn-sm btn-outline-primary btn-action" title="Edit Employee" aria-label="Edit">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                            <a href="delete_employee.php?id=<?php echo $emp['id']; ?>" class="btn btn-sm btn-outline-danger btn-action" onclick="return confirm('Are you sure you want to delete <?php echo htmlspecialchars($emp['first_name'] . ' ' . $emp['last_name'], ENT_QUOTES); ?>?');" title="Delete Employee" aria-label="Delete">
                                                <i class="fa-solid fa-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Footer note for mobile users -->
            <div class="card-footer bg-light-subtle py-2 px-3 small text-muted d-flex justify-content-between align-items-center">
                <span>Showing <?php echo count($employees); ?> employees</span>
                <span class="d-inline d-md-none"><i class="fa-solid fa-arrows-left-right me-1"></i> Swipe table</span>
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

    <!-- Bootstrap 5 Bundle JS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JavaScript -->
    <script src="js/script.js"></script>
</body>
</html>
