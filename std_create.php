<?php
require_once __DIR__ . "/config.php";
require_once __DIR__ . "/db.php";

// print_r($_POST);
$error = [];

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $first_name  = trim($_POST['first_name']);
    $last_name   = trim($_POST['last_name']);
    $email       = trim($_POST['email']);
    $phone       = trim($_POST['phone']);
    $roll_number = trim($_POST['roll_number']);
    $class       = trim($_POST['class']);
    $gender      = trim($_POST['gender']);
    $dob         = trim($_POST['dob']);
    $status      = trim($_POST['status']);

    if (
           empty($first_name) || empty($last_name) || empty($email)
        || empty($phone) || empty($roll_number) || empty($class)
        || empty($gender) || empty($dob) || empty($status)
    ) {
        $errors[] = "You are missing something Plzz check all fields";
    }

    // email validation
     if (filter_var($email, FILTER_VALIDATE_EMAIL) == false) {
        $errors[] = "Incorrect Email";
    }
    if (!empty($errors)){
        $_SESSION['error'] = $errors;
        header("Location: student-create.php");
        exit;
    }


    // =========== Sending data into DATA BASE ==============
    // prepare query 
    $stmt = mysqli_prepare($conn , "Insert INTO personal_info(first_name , last_name , email , phone ) VALUES (? ,? ,? ,?) ") ;
    mysqli_stmt_bind_param( $stmt , 'ssss' , $first_name , $last_name , $email , $phone);
    mysqli_stmt_execute( $stmt);

      $student_id = mysqli_insert_id($conn);

    $stmt2 = mysqli_prepare($conn , "Insert into acadamic_info(student_id , roll_number , class , gender , dob , status ) VAlUES (? ,? , ? , ? , ? , ?)");
    mysqli_stmt_bind_param($stmt2 , "iissss" , $student_id , $roll_number , $class , $gender , $dob , $status);
    mysqli_stmt_execute($stmt2);

     $_SESSION['success'] = "Student created successfully";
    header("Location: student-create.php");
    exit;

}
