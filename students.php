<?php
require_once __DIR__ . "/config.php";
require_once __DIR__ . "/db.php";
require_once __DIR__ . "/auth.php";

$q = "SELECT * FROM personal_info INNER JOIN
 acadamic_info ON 
 personal_info.student_id = acadamic_info.student_id";
$result = mysqli_query($conn, $q);

$data   = mysqli_fetch_all($result, MYSQLI_ASSOC);
// echo "<pre>";
// print_r($_GET);
// echo "</pre>";

// exit;
$search = $_GET['search'] ?? '';
$class = $_GET['class'] ?? '';
$status = $_GET['status'] ?? '';

// echo $search;
// exit;

if ($search != '') {
    $q .= "  WHERE (personal_info.first_name = '$search' OR personal_info.last_name = '$search' OR personal_info.email='$search' OR acadamic_info.roll_number='$search' )";
}
if ($class != '') {
    $q .= " AND class = '$class' ";
}
// echo $q;
// exit;

if ($status != '') {
    $q .= " AND status = '$status' ";
}

$result = mysqli_query($conn, $q);
$data   = mysqli_fetch_all($result, MYSQLI_ASSOC);


// echo "<pre>";
// print_r($_GET);
// echo "</pre>";
// exit;


$errors = $_SESSION['errors'] ?? [];
unset($_SESSION['errors']);

$sucess = $_SESSION['success'] ?? '';
unset($_SESSION['success']);



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Students - Student Dashboard</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="./main.css">
</head>

<body>

    <div class="app-container">
        <!-- Sidebar Navigation -->

        <?php require_once __DIR__ . "/partials/sidebar.php" ?>


        <!-- Main Content Area -->
        <div class="main-wrapper">
            <!-- Top Header Navbar -->
            <header class="top-navbar">
                <div class="d-flex align-items-center gap-3">
                    <button class="btn btn-light d-lg-none p-2 border" id="sidebarToggle">
                        <i class="bi bi-list fs-5"></i>
                    </button>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="dashboard.html" class="text-decoration-none text-muted">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Students</li>
                        </ol>
                    </nav>
                </div>

                <div class="d-flex align-items-center gap-3">
                    <button type="button" class="btn btn-light rounded-circle position-relative p-2 border">
                        <i class="bi bi-bell"></i>
                        <span class="position-absolute top-0 start-100 translate-middle p-1 bg-danger border border-light rounded-circle"></span>
                    </button>

                    <div class="dropdown">
                        <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle text-dark" id="userMenu" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=100&h=100&fit=crop&crop=faces" class="avatar-sm me-2" alt="Teacher">
                            <span class="d-none d-sm-inline fw-semibold">Sarah J.</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0" aria-labelledby="userMenu">
                            <li><a class="dropdown-item py-2" href="#"><i class="bi bi-person me-2"></i>My Profile</a></li>
                            <li><a class="dropdown-item py-2" href="#"><i class="bi bi-sliders me-2"></i>Preferences</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item py-2 text-danger" href="login.html"><i class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
                        </ul>
                    </div>
                </div>
            </header>

            <!-- Students List Page Body -->
            <main class="content-body">
                <!-- Header Title & Action -->
                <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
                    <div>
                        <h4 class="fw-bold mb-1">Students Directory</h4>
                        <p class="text-muted small mb-0">View, search, and manage all registered class students</p>
                    </div>
                    <a href="student-create.php" class="btn btn-primary d-inline-flex align-items-center gap-2">
                        <i class="bi bi-person-plus"></i>
                        <span>Add Student</span>
                    </a>
                </div>

                <!-- Filters & Search Toolbar -->
                <form method="GET">
                    <div class="card-custom p-3 mb-4">
                        <form>
                            <div class="row g-3">
                                <div class="col-12 col-md-5">
                                    <div class="input-group">
                                        <span class="input-group-text bg-white border-end-0 text-muted"><i class="bi bi-search"></i></span>
                                        <input name="search" value="<?= $search ?>" type="text" class="form-control border-start-0 ps-0" placeholder="Search by name, email or roll...">
                                    </div>
                                </div>
                                <div class="col-6 col-md-3">
                                    <select class="form-select" name="class">
                                        <option value="">All Classes</option>
                                        <option value="10-A">Grade 10-A</option>
                                        <option value="10-B">Grade 10-B</option>
                                        <option value="11-A">Grade 11-A</option>
                                    </select>
                                </div>
                                <div class="col-6 col-md-2">
                                    <select class="form-select" name="status">
                                        <option value="">All Statuses</option>
                                        <option value="active">Active</option>
                                        <option value="pending">Pending</option>
                                        <option value="inactive">Inactive</option>
                                    </select>
                                </div>
                                <div class="col-12 col-md-2 d-grid d-flex gap-4">
                                    <button type="submit" class="btn btn-outline-secondary d-flex align-items-center justify-content-center gap-1">
                                        <i class="bi bi-arrow-clockwise"></i> Search
                                    </button>
                                    <a href="students.php" class="btn btn-outline-secondary d-flex align-items-center justify-content-center gap-1 text-decoration-none">
                                        <i class="bi bi-arrow-clockwise"></i> Reset
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </form>


                <?php if (!empty($errors)) { ?>
                    <div class="alert alert-danger">
                        <ul>
                            <?php foreach ($errors as $error) { ?>
                                <li><?= $error ?></li>
                            <?php } ?>
                        </ul>

                    </div>

                <?php } ?>

                <?php if ($sucess) { ?>
                    <div class="alert alert-success">
                        <?php echo $sucess ?>
                    </div>
                <?php } ?>

                <!-- Students Table Card -->
                <div class="card-custom overflow-hidden">
                    <div class="table-responsive">
                        <table class="table table-custom align-middle">
                            <thead>
                                <tr>
                                    <th>Student</th>
                                    <th>Roll No</th>
                                    <th>Class</th>
                                    <th>Gender</th>
                                    <th>Phone</th>
                                    <th>Date of birth</th>
                                    <th>Status</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (mysqli_num_rows($result) == 0) { ?>
                                    <tr>
                                        <td>No student found</td>
                                    </tr>
                                <?php } ?>

                                <?php if (mysqli_num_rows($result) > 0) { ?>
                                    <?php foreach ($data as $single_student) { ?>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center gap-2">
                                                    <img src="https://images.unsplash.com/photo-1539571696357-5a69c17a67c6?w=100&h=100&fit=crop&crop=faces" class="avatar-sm rounded-circle" alt="Alex">
                                                    <div>
                                                        <a href="student-detail.php" class="fw-semibold text-dark text-decoration-none"><?= $single_student['first_name']  . " " . $single_student['last_name']  ?></a>
                                                        <div class="small text-muted"><?= $single_student['email'] ?></div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td><span class="badge bg-light text-dark border"><?= $single_student['roll_number'] ?></span></td>
                                            <td><?= $single_student['class'] ?></td>
                                            <td><?= $single_student['gender'] ?></td>
                                            <td><?= $single_student['phone'] ?></td>
                                            <td><?= $single_student['dob'] ?></td>
                                            <td><span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1"><?= $single_student['status'] ?></span></td>
                                            <td class="text-end">
                                                <div class="d-inline-flex gap-1">
                                                    <a href="student-detail.php" class="btn btn-sm btn-light border p-1 px-2" title="View Profile"><i class="bi bi-eye"></i></a>
                                                    <a href="student-edit.php?id=<?= $single_student['student_id'] ?>" class="btn btn-sm btn-light border p-1 px-2" title="Edit Student"><i class="bi bi-pencil"></i></a>
                                                    <a href="delete_handle.php?id=<?= $single_student['student_id'] ?>" class="btn btn-sm btn-light border p-1 px-2 text-danger" title="Delete"><i class="bi bi-trash"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php } ?>

                                <?php } ?>







                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="p-3 border-top d-flex flex-wrap justify-content-between align-items-center gap-2">
                        <small class="text-muted">Showing <strong>1 to 6</strong> of <strong>142</strong> students</small>
                        <nav aria-label="Page navigation">
                            <ul class="pagination pagination-sm mb-0">
                                <li class="page-item disabled"><a class="page-link" href="#">Previous</a></li>
                                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item"><a class="page-link" href="#">Next</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <!-- <div class="modal fade" id="deleteStudentModal" tabindex="-1" aria-labelledby="deleteStudentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold" id="deleteStudentModalLabel">Delete Student Record</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body py-3">
                    <p class="text-muted mb-0">Are you sure you want to delete this student? This action cannot be undone.</p>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Delete Record</button>
                </div>
            </div>
        </div>
    </div> -->

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->
    <script src="assets/js/main.js"></script>
</body>

</html>