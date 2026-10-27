<?php
require_once __DIR__ . "/config.php";
require_once __DIR__ . "/db.php";
$errors =  [];
$std_id =  $_GET['id'] ?? '';
// print_r($std_id);

if (empty($std_id)) {
    $errors[] = "student id is required";
}

$stmt = mysqli_prepare($conn, "SELECT * FROM acadamic_info WHERE student_id = ?");
mysqli_stmt_bind_param($stmt, 'i', $std_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
// print_r($result);
if (mysqli_num_rows($result) == 0) {
    $errors[] = "Student not found";
}
if (!empty($errors)) {
    $_SESSION['errors'] = $errors;
    header("Location: students.php");
    exit;
}
// print_r($result);

// if(!empty($errors)){
//     print_r($errors);
// }

$stmt2 = mysqli_prepare($conn, "Delete from personal_info WHERE student_id=? ");
mysqli_stmt_bind_param($stmt2, 'i', $std_id);
mysqli_stmt_execute($stmt2);

$stmt3 = mysqli_prepare($conn, "Delete from acadamic_info WHERE student_id=? ");
mysqli_stmt_bind_param($stmt3, 'i', $std_id);
mysqli_stmt_execute($stmt3);

$_SESSION['success'] = "Student deleted successfully";
header("Location: students.php");
exit;
