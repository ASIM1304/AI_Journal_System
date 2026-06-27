<?php

include("db_connect.php");

if(isset($_POST['register']))
{
    $name = mysqli_real_escape_string($conn,$_POST['name']);

    $email = mysqli_real_escape_string($conn,$_POST['email']);

    $password = mysqli_real_escape_string($conn,$_POST['password']);

    $institution = mysqli_real_escape_string($conn,$_POST['institution']);

    $check = mysqli_query(
        $conn,
        "SELECT * FROM authors WHERE email='$email'"
    );

    if(mysqli_num_rows($check)>0)
    {
        echo "<script>alert('Email Already Registered');</script>";
    }
    else
    {
        $sql = "INSERT INTO authors
        (
        name,
        email,
        password,
        institution
        )
        VALUES
        (
        '$name',
        '$email',
        '$password',
        '$institution'
        )";

        if(mysqli_query($conn,$sql))
        {
            echo "<script>

            alert('Registration Successful');

            window.location='login.php';

            </script>";

            exit();
        }
        else
        {
            die(mysqli_error($conn));
        }
    }
}

?>

<!DOCTYPE html>

<html lang="en">

<head>

<meta charset="UTF-8">

<meta
name="viewport"
content="width=device-width, initial-scale=1">

<title>

Author Registration

</title>

<link
href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
rel="stylesheet">

<style>

body{
background:#f4f6f9;
}

.navbar{
box-shadow:0 2px 10px rgba(0,0,0,.2);
}

.card{
border:none;
border-radius:12px;
box-shadow:0 0 15px rgba(0,0,0,.1);
}

.card-header{
background:#0d6efd;
color:white;
font-size:24px;
font-weight:bold;
text-align:center;
}

footer{
background:#003366;
color:white;
margin-top:50px;
padding:20px;
text-align:center;
}

</style>

</head>

<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">

<div class="container">

<a
class="navbar-brand fw-bold"
href="index.php">

AI Journal System

</a>

<button
class="navbar-toggler"
type="button"
data-bs-toggle="collapse"
data-bs-target="#menu">

<span class="navbar-toggler-icon"></span>

</button>

<div
class="collapse navbar-collapse"
id="menu">

<ul class="navbar-nav ms-auto">

<li class="nav-item">

<a
class="nav-link"
href="index.php">

Home

</a>

</li>

<li class="nav-item">

<a
class="nav-link active"
href="author.php">

Author

</a>

</li>

<li class="nav-item">

<a
class="nav-link"
href="login.php">

Login

</a>

</li>

</ul>

</div>

</div>

</nav>

<div class="container mt-5">

<div class="row justify-content-center">

<div class="col-lg-6">

<div class="card">

<div class="card-header">

Author Registration

</div>

<div class="card-body">

<form method="POST">
<div class="mb-3">

<label class="form-label">

Full Name

</label>

<input
type="text"
name="name"
class="form-control"
placeholder="Enter your full name"
required>

</div>

<div class="mb-3">

<label class="form-label">

Email Address

</label>

<input
type="email"
name="email"
class="form-control"
placeholder="Enter your email"
required>

</div>

<div class="mb-3">

<label class="form-label">

Password

</label>

<input
type="password"
name="password"
class="form-control"
placeholder="Enter your password"
required>

</div>

<div class="mb-3">

<label class="form-label">

Institution

</label>

<input
type="text"
name="institution"
class="form-control"
placeholder="Enter your institution"
required>

</div>
<button
type="submit"
name="register"
class="btn btn-primary w-100">

Register

</button>

<div class="text-center mt-4">

<p>

Already have an account?

</p>

<a
href="login.php"
class="btn btn-success">

Login Here

</a>

</div>

</form>

</div>

</div>

</div>

</div>

</div>

<footer>

<div class="container">

<h5>

AI-Based Research Paper Analysis and Journal Management System

</h5>

<p>

Developed using PHP, MySQL, Python, Bootstrap 5, Hugging Face Transformers and KeyBERT.

</p>

<p>

© 2026 All Rights Reserved.

</p>

</div>

</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>