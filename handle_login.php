<?php
require_once __DIR__ . "/config.php";
require_once __DIR__ . "/db.php";

$errors = [];
if ($_SERVER['REQUEST_METHOD']  == "POST") {
    $email              = trim($_POST['email']) ?? '';
    $password           = $_POST['password'];


    if (empty($email) ||  empty($password)) {
        $errors[] = "Email and password are required";
    }

    if (filter_var($email, FILTER_VALIDATE_EMAIL) == false) {
        $errors[] = "Email address is incorrect";
    }
    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        header("Location: register.php");
        exit;
    }
    $stmt = mysqli_prepare($conn, "SELECT * FROM users WHERE email = ?");
    mysqli_stmt_bind_param($stmt, 's', $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);




    // print_r($result);
    // exit;

    if (mysqli_num_rows($result) == 0) {
        $errors[] = "This email is not registered";
        $_SESSION['errors'] = $errors;
        header("Location: login.php");
        exit;
    }


    $user = mysqli_fetch_assoc($result);

    // print_r($user);
    // exit;


    if (password_verify($password, $user['password'])  == false) {
        $errors[] = "Wrong credentials";
        $_SESSION['errors'] = $errors;
        header("Location: login.php");
        exit;
    }


    $_SESSION['user_id'] = $user['user_id'];
    header("Location: dashboard.html");
    exit;
}
