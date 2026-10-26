<?php
require_once __DIR__ . "/config.php";
require_once __DIR__ . "/db.php";
require_once __DIR__ . "/auth.php";


$q = "SELECT * FROM personal_info 
INNER JOIN acadamic_info ON personal_info.student_id = acadamic_info.student_id 
ORDER BY personal_info.student_id ASC 
LIMIT 4;";

$result = mysqli_query($conn, $q);
$data   = mysqli_fetch_all($result, MYSQLI_ASSOC);

$result = mysqli_query($conn, $q);
$data   = mysqli_fetch_all($result, MYSQLI_ASSOC);

// query to find the total students
$q_ts = "SELECT COUNT(*) AS total_students FROM personal_info;";
$q_tsresult = mysqli_query($conn, $q_ts);
$ts_row = mysqli_fetch_all($q_tsresult, MYSQLI_ASSOC);
$total = $ts_row[0]['total_students'];
// echo $total;
// exit;

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Student Management</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap"
        rel="stylesheet">
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
                    <div class="d-none d-md-flex align-items-center position-relative">
                        <i class="bi bi-search position-absolute ms-3 text-muted"></i>
                        <input type="search" class="form-control form-control-sm ps-5 bg-light border-0"
                            placeholder="Search student, roll number..." style="width: 280px; height: 38px;">
                    </div>
                </div>

                <div class="d-flex align-items-center gap-3">
                    <button type="button" class="btn btn-light rounded-circle position-relative p-2 border">
                        <i class="bi bi-bell"></i>
                        <span
                            class="position-absolute top-0 start-100 translate-middle p-1 bg-danger border border-light rounded-circle"></span>
                    </button>

                    <div class="dropdown">
                        <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle text-dark"
                            id="userMenu" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=100&h=100&fit=crop&crop=faces"
                                class="avatar-sm me-2" alt="Teacher">
                            <span class="d-none d-sm-inline fw-semibold">Sarah J.</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0" aria-labelledby="userMenu">
                            <li><a class="dropdown-item py-2" href="#"><i class="bi bi-person me-2"></i>My Profile</a>
                            </li>
                            <li><a class="dropdown-item py-2" href="#"><i class="bi bi-sliders me-2"></i>Preferences</a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item py-2 text-danger" href="logout.php"><i
                                        class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
                        </ul>
                    </div>
                </div>
            </header>

            <!-- Dashboard Body -->
            <main class="content-body">
                <!-- Page Title & Actions -->
                <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
                    <div>
                        <h4 class="fw-bold mb-1">Classroom Overview</h4>
                        <p class="text-muted small mb-0">Overview of your class attendance, students, and key metrics
                        </p>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="student-create.html" class="btn btn-primary d-inline-flex align-items-center gap-2">
                            <i class="bi bi-plus-lg"></i>
                            <span>Add New Student</span>
                        </a>
                    </div>
                </div>

                <!-- Metric Cards -->
                <div class="row g-3 mb-4">
                    <div class="col-12 col-sm-6 col-xl-3">
                        <div class="stat-card">
                            <div class="stat-icon primary">
                                <i class="bi bi-mortarboard"></i>
                            </div>
                            <div>
                                <span class="text-muted small d-block">Total Students</span>
                                <h3 class="fw-bold mb-0"> <?php echo $total ?>  </h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-xl-3">
                        <div class="stat-card">
                            <div class="stat-icon success">
                                <i class="bi bi-check-circle"></i>
                            </div>
                            <div>
                                <span class="text-muted small d-block">Attendance Today</span>
                                <h3 class="fw-bold mb-0">96.4%</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-xl-3">
                        <div class="stat-card">
                            <div class="stat-icon warning">
                                <i class="bi bi-award"></i>
                            </div>
                            <div>
                                <span class="text-muted small d-block">Average Grade</span>
                                <h3 class="fw-bold mb-0">A- (88%)</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-xl-3">
                        <div class="stat-card">
                            <div class="stat-icon info">
                                <i class="bi bi-book"></i>
                            </div>
                            <div>
                                <span class="text-muted small d-block">Active Classes</span>
                                <h3 class="fw-bold mb-0">5</h3>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Students & Schedule Grid -->
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
                                                        <a href="student-detail.html" class="fw-semibold text-dark text-decoration-none"><?= $single_student['first_name']  . " " . $single_student['last_name']  ?></a>
                                                        <div class="small text-muted"><?= $single_student['email'] ?></div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td><span class="badge bg-light text-dark border"><?= $single_student['phone'] ?></span></td>
                                            <td><?= $single_student['class'] ?></td>
                                            <td><?= $single_student['gender'] ?></td>
                                            <td><?= $single_student['dob'] ?></td>
                                            <td><span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1"><?= $single_student['status'] ?></span></td>
                                            <td class="text-end">
                                                <div class="d-inline-flex gap-1">
                                                    <a href="student-detail.html" class="btn btn-sm btn-light border p-1 px-2" title="View Profile"><i class="bi bi-eye"></i></a>
                                                    <a href="student-edit.html" class="btn btn-sm btn-light border p-1 px-2" title="Edit Student"><i class="bi bi-pencil"></i></a>
                                                    <button class="btn btn-sm btn-light border p-1 px-2 text-danger" data-bs-toggle="modal" data-bs-target="#deleteStudentModal" title="Delete"><i class="bi bi-trash"></i></button>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php } ?>

                                <?php } ?>







                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div>
                        <small class="text-muted  p-3 border-top d-flex flex-wrap justify-content-between align-items-center"> <strong>Showing Top 4 newly added Students</strong>
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

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->
    <script src="assets/js/main.js"></script>
</body>

</html>