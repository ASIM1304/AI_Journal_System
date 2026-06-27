<?php

session_start();

include("db_connect.php");

if(isset($_POST['login']))
{
    $email = mysqli_real_escape_string(
        $conn,
        trim($_POST['email'])
    );

    $password = mysqli_real_escape_string(
        $conn,
        trim($_POST['password'])
    );

    $sql = "SELECT * FROM authors
            WHERE email='$email'";

    $result = mysqli_query($conn,$sql);

    if(!$result)
    {
        die("Database Error : ".mysqli_error($conn));
    }

    if(mysqli_num_rows($result)==1)
    {
        $row = mysqli_fetch_assoc($result);

        if($password == $row['password'])
        {
            $_SESSION['author_id'] = $row['author_id'];
            $_SESSION['author_name'] = $row['name'];

            header("Location: author_dashboard.php");
            exit();
        }
        else
        {
            $error = "Incorrect Password";
        }
    }
    else
    {
        $error = "Author Not Found";
    }
}

?>

<!DOCTYPE html>

<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1">

<title>Author Login</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
rel="stylesheet">

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
rel="stylesheet">

<style>

body{
background:#f4f6f9;
}

.navbar{
box-shadow:0 2px 10px rgba(0,0,0,.15);
}

.card{
border:none;
border-radius:15px;
box-shadow:0 0 15px rgba(0,0,0,.15);
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
padding:20px;
margin-top:60px;
text-align:center;
}

</style>

</head>

<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">

<div class="container">

<a class="navbar-brand fw-bold"
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

<div class="collapse navbar-collapse"
id="menu">

<ul class="navbar-nav ms-auto">

<li class="nav-item">
<a class="nav-link" href="index.php">Home</a>
</li>

<li class="nav-item">
<a class="nav-link" href="author.php">Register</a>
</li>

<li class="nav-item">
<a class="nav-link active" href="login.php">Login</a>
</li>

</ul>

</div>

</div>

</nav>

<div class="container mt-5">

<div class="row justify-content-center">

<div class="col-lg-5">

<div class="card">

<div class="card-header">

Author Login

</div>

<div class="card-body">

<?php

if(isset($error))
{
    echo "<div class='alert alert-danger'>$error</div>";
}

?>

<form method="POST">
<div class="mb-3">

<label class="form-label">

Email Address

</label>

<input
type="email"
name="email"
class="form-control"
placeholder="Enter your Email"
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
placeholder="Enter your Password"
required>

</div>

<div class="d-grid">

<button
type="submit"
name="login"
class="btn btn-primary">

<i class="fa-solid fa-right-to-bracket"></i>

Login

</button>

</div>

<div class="text-center mt-3">

<p>

Don't have an account?

<a href="author.php">

Register Here

</a>

</p>

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