<?php

session_start();

if(!isset($_SESSION['author_id']))
{
    header("Location:login.php");
    exit();
}

include("db_connect.php");

$author_id = $_SESSION['author_id'];

$sql = "SELECT * FROM authors
WHERE author_id='$author_id'";

$result = mysqli_query($conn,$sql);

$author = mysqli_fetch_assoc($result);

?>

<!DOCTYPE html>

<html lang="en">

<head>

<meta charset="UTF-8">

<meta
name="viewport"
content="width=device-width, initial-scale=1">

<title>

Author Dashboard

</title>

<link
href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
rel="stylesheet">

<link
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
rel="stylesheet">

<style>

body{
background:#f4f6f9;
}

.navbar{
box-shadow:0 2px 10px rgba(0,0,0,.15);
}

.dashboard-title{
font-weight:bold;
color:#003366;
}

.card{
border:none;
border-radius:15px;
box-shadow:0 0 12px rgba(0,0,0,.12);
transition:.3s;
}

.card:hover{
transform:translateY(-5px);
}

.profile-card{
background:linear-gradient(135deg,#0d6efd,#003366);
color:white;
}

.icon{
font-size:40px;
margin-bottom:10px;
}

footer{
background:#003366;
color:white;
padding:20px;
margin-top:50px;
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
class="nav-link active"
href="author_dashboard.php">

Dashboard

</a>

</li>

<li class="nav-item">

<a
class="nav-link"
href="upload_paper.php">

Upload Paper

</a>

</li>

<li class="nav-item">

<a
class="nav-link"
href="my_papers.php">

My Papers

</a>

</li>

<li class="nav-item">

<a
class="nav-link"
href="logout.php">

Logout

</a>

</li>

</ul>

</div>

</div>

</nav>

<div class="container mt-5">

<h2 class="dashboard-title mb-4">

Author Dashboard

</h2>

<div class="row">

<div class="col-lg-12">

<div class="card profile-card">

<div class="card-body">

<h3>

Welcome,

<?php echo $author['name']; ?>

</h3>

<p>

<b>Email :</b>

<?php echo $author['email']; ?>

</p>

<p>

<b>Institution :</b>

<?php echo $author['institution']; ?>

</p>

</div>

</div>

</div>

</div>

<div class="row mt-4">
<div class="col-md-3 mb-4">

<div class="card text-center h-100">

<div class="card-body">

<i class="fa-solid fa-upload icon text-primary"></i>

<h4>

Upload Paper

</h4>

<p>

Upload your research paper for AI analysis.

</p>

<a
href="upload_paper.php"
class="btn btn-primary">

Upload

</a>

</div>

</div>

</div>

<div class="col-md-3 mb-4">

<div class="card text-center h-100">

<div class="card-body">

<i class="fa-solid fa-file-lines icon text-success"></i>

<h4>

My Papers

</h4>

<p>

View all uploaded research papers.

</p>

<a
href="my_papers.php"
class="btn btn-success">

View Papers

</a>

</div>

</div>

</div>

<div class="col-md-3 mb-4">

<div class="card text-center h-100">

<div class="card-body">

<i class="fa-solid fa-robot icon text-warning"></i>

<h4>

AI Analysis

</h4>

<p>

View AI summaries and extracted keywords.

</p>

<a
href="my_papers.php"
class="btn btn-warning text-dark">

View AI

</a>

</div>

</div>

</div>

<div class="col-md-3 mb-4">

<div class="card text-center h-100">

<div class="card-body">

<i class="fa-solid fa-right-from-bracket icon text-danger"></i>

<h4>

Logout

</h4>

<p>

Logout from your author account.

</p>

<a
href="logout.php"
class="btn btn-danger">

Logout

</a>

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