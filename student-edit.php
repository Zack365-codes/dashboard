<?php
require_once __DIR__ . "/config.php";
require_once __DIR__ . "/db.php";
require_once __DIR__ . "/auth.php";


$errors = [];

$student_id = $_GET['id'];

if (empty($student_id)) {
    $errors[] = "student id is required";
}



if (!empty($errors)) {
    $_SESSION['errors'] = $errors;
    header("Location: students.php");
    exit;
}

// echo $student_id;
// exit();


$q = "SELECT * FROM personal_info 
	    INNER JOIN acadamic_info 
        ON personal_info.student_id = acadamic_info.student_id
        WHERE personal_info.student_id = $student_id";

$result = mysqli_query($conn, $q);
$student   = mysqli_fetch_assoc($result);

// echo "<pre>";
// print_r($student);
// echo "</pre>";

// exit;




?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student - Student Dashboard</title>
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
                            <li class="breadcrumb-item"><a href="students.html" class="text-decoration-none text-muted">Students</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Edit Student</li>
                        </ol>
                    </nav>
                </div>

                <div class="d-flex align-items-center gap-2">
                    <a href="student-detail.html" class="btn btn-sm btn-outline-secondary d-none d-sm-inline-flex align-items-center gap-1">
                        <i class="bi bi-eye"></i> View Profile
                    </a>
                    <a href="students.html" class="btn btn-sm btn-light border d-inline-flex align-items-center gap-1">
                        <i class="bi bi-arrow-left"></i> Back
                    </a>
                </div>
            </header>

            <!-- Edit Form Body -->
            <main class="content-body">
                <div class="row justify-content-center">
                    <div class="col-12 col-xl-9">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <div>
                                <h4 class="fw-bold mb-1">Edit Student: <?= $student['first_name'] . ' ' . $student['last_name'] ?></h4>
                                <p class="text-muted small mb-0">Update student enrollment records and contact details</p>
                            </div>
                            <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2">
                                <i class="bi bi-check-circle-fill me-1"></i> Currently Active
                            </span>
                        </div>

                        <form action="std_edit.php" method="POST">
                            <input type="hidden" name="student_id" value="<?=  $student_id ?>">
                            <!-- Avatar & Profile Photo Section -->
                            <div class="card-custom mb-4 p-3">
                                <div class="d-flex align-items-center gap-3">
                                    <img src="https://images.unsplash.com/photo-1539571696357-5a69c17a67c6?w=100&h=100&fit=crop&crop=faces" class="avatar-lg rounded-circle border p-1" alt="Student Photo">
                                    <div>
                                        <h6 class="fw-bold mb-1">Student Photo</h6>
                                        <p class="small text-muted mb-2">Upload or change student photo (PNG, JPG max 2MB)</p>
                                        <div class="d-flex gap-2">
                                            <button type="button" class="btn btn-sm btn-outline-primary"><i class="bi bi-upload me-1"></i>Change Photo</button>
                                            <button type="button" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Personal Information Card -->
                            <div class="card-custom mb-4">
                                <div class="card-header">
                                    <span class="text-dark fw-bold"><i class="bi bi-person me-2 text-primary"></i>Personal Information</span>
                                </div>
                                <div class="card-body">
                                    <div class="row g-3">
                                        <div class="col-12 col-md-6">
                                            <label for="firstName" class="form-label small fw-semibold text-secondary">First Name</label>
                                            <input name="first_name" type="text" class="form-control" id="firstName" value="<?= $student['first_name'] ?>" required>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label for="lastName" class="form-label small fw-semibold text-secondary">Last Name</label>
                                            <input name="last_name" type="text" class="form-control" id="lastName"  value="<?= $student['last_name'] ?>" required>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label for="studentEmail" class="form-label small fw-semibold text-secondary">Email Address</label>
                                            <input name="email" type="email" class="form-control" id="studentEmail"  value="<?= $student['email'] ?>" required>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label for="phone" class="form-label small fw-semibold text-secondary">Phone Number</label>
                                            <input name="phone" type="tel" class="form-control" id="phone" value="<?= $student['phone'] ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Academic Info Card -->
                            <div class="card-custom mb-4">
                                <div class="card-header">
                                    <span class="text-dark fw-bold"><i class="bi bi-mortarboard me-2 text-primary"></i>Academic & Class Details</span>
                                </div>
                                <div class="card-body">
                                    <div class="row g-3">
                                        <div class="col-12 col-md-4">
                                            <label for="rollNumber" class="form-label small fw-semibold text-secondary">Roll Number</label>
                                            <input name="roll_number" type="text" class="form-control" id="rollNumber" value="<?= $student['roll_number'] ?>" required>
                                        </div>
                                        <div class="col-12 col-md-4">
                                            <label for="studentClass" class="form-label small fw-semibold text-secondary">Class / Grade</label>
                                            <select name="class" class="form-select" id="studentClass" required>
                                                <option value="10-A" <?= ($student['class'] == "10-A" ? "selected" : '' ) ?>>Grade 10-A</option>
                                                <option value="10-B" <?= ($student['class'] == "10-B" ? "selected" : '' ) ?>>Grade 10-B</option>
                                                <option value="11-A" <?= ($student['class'] == "11-A" ? "selected" : '' ) ?>>Grade 11-A</option>
                                                <option value="11-B" <?= ($student['class'] == "11-B" ? "selected" : '' ) ?>>Grade 11-B</option>
                                            </select>
                                        </div>
                                        <div class="col-12 col-md-4">
                                            <label for="gender" class="form-label small fw-semibold text-secondary">Gender</label>
                                           <select name="gender" class="form-select" id="gender">
                                                <option value="male" <?php echo ($student['gender'] == "male") ? "selected" : ''  ?>>Male</option>
                                                <option value="female" <?php echo ($student['gender'] == "female") ? "selected" : ''  ?> >Female</option>
                    
                                            </select>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label for="dob" class="form-label small fw-semibold text-secondary">Date of Birth</label>
                                            <input name="dob" type="date" class="form-control" id="dob" value="2008-04-12">
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label for="status" class="form-label small fw-semibold text-secondary">Enrollment Status</label>
                                                 <select name="status" class="form-select" id="status">
                                                <option value="active" <?php echo ($student['status'] == "active") ? "selected" : ''  ?>>Active</option>
                                                <option value="pending" <?php echo ($student['status'] == "pending") ? "selected" : ''  ?> >Pending</option>
                                                <option value="inactive" <?php echo ($student['status'] == "inactive") ? "selected" : ''  ?> >Inactive</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="d-flex align-items-center justify-content-end gap-2 mb-5">
                                <a href="std_edit.php" class="btn btn-light border px-4">Cancel</a>
                                <button type="submit" class="btn btn-primary px-4 d-inline-flex align-items-center gap-2">
                                    <i class="bi bi-floppy"></i>
                                    <span>Update Student</span>
                                </button>
                            </div>
                        </form>
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