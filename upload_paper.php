<?php

session_start();

if(!isset($_SESSION['author_id']))
{
    header("Location:login.php");
    exit();
}

include("db_connect.php");

if(isset($_POST['submit']))
{
    $author_id = $_SESSION['author_id'];

    $title = mysqli_real_escape_string(
        $conn,
        $_POST['title']
    );

    $domain = mysqli_real_escape_string(
        $conn,
        $_POST['domain']
    );

    $abstract = mysqli_real_escape_string(
        $conn,
        $_POST['abstract']
    );

    if(!is_dir("uploads"))
    {
        mkdir("uploads",0777,true);
    }

    $pdf_name = basename($_FILES['pdf']['name']);

    $extension = strtolower(
        pathinfo($pdf_name,PATHINFO_EXTENSION)
    );

    if($extension!="pdf")
    {
        echo "<script>

        alert('Only PDF files are allowed.');

        </script>";

        exit();
    }

    $new_name = time()."_".$pdf_name;

    $target = "uploads/".$new_name;

    if(move_uploaded_file($_FILES['pdf']['tmp_name'],$target))
    {

        $sql = "INSERT INTO papers
        (
        author_id,
        title,
        domain,
        abstract,
        pdf_file,
        status
        )
        VALUES
        (
        '$author_id',
        '$title',
        '$domain',
        '$abstract',
        '$new_name',
        'Submitted'
        )";

        if(mysqli_query($conn,$sql))
        {

            $python = "C:\\Users\\mdasi\\AppData\\Local\\Programs\\Python\\Python312\\python.exe";

            $script = "C:\\xampp\\htdocs\\AI_Journal_System\\python\\analyze_paper.py";

            shell_exec("\"$python\" \"$script\"");

            echo "<script>

            alert('Research Paper Uploaded Successfully. AI Analysis Completed.');

            window.location='my_papers.php';

            </script>";

            exit();

        }
        else
        {
            echo "<script>

            alert('Database Error');

            </script>";
        }

    }
    else
    {
        echo "<script>

        alert('File Upload Failed');

        </script>";
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

Upload Research Paper

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

.card{
border:none;
border-radius:15px;
box-shadow:0 0 15px rgba(0,0,0,.12);
}

.card-header{
background:#0d6efd;
color:white;
font-size:24px;
font-weight:bold;
text-align:center;
}

.form-label{
font-weight:bold;
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
href="author_dashboard.php">

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
href="author_dashboard.php">

Dashboard

</a>

</li>

<li class="nav-item">

<a
class="nav-link active"
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

<div class="row justify-content-center">

<div class="col-lg-8">

<div class="card">

<div class="card-header">

<i class="fa-solid fa-file-arrow-up"></i>

Upload Research Paper

</div>

<div class="card-body">

<form
method="POST"
enctype="multipart/form-data">
<div class="mb-3">

<label class="form-label">

Paper Title

</label>

<input
type="text"
name="title"
class="form-control"
placeholder="Enter Research Paper Title"
required>

</div>

<div class="mb-3">

<label class="form-label">

Research Domain

</label>

<select
name="domain"
class="form-select"
required>

<option value="">

Select Domain

</option>

<option>

Artificial Intelligence

</option>

<option>

Machine Learning

</option>

<option>

Deep Learning

</option>

<option>

Computer Vision

</option>

<option>

Natural Language Processing

</option>

<option>

Data Science

</option>

<option>

Cloud Computing

</option>

<option>

Cyber Security

</option>

<option>

Internet of Things

</option>

<option>

Blockchain

</option>

</select>

</div>

<div class="mb-3">

<label class="form-label">

Abstract

</label>

<textarea

name="abstract"

class="form-control"

rows="6"

placeholder="Enter Research Paper Abstract"

required>

</textarea>

</div>

<div class="mb-3">

<label class="form-label">

Upload PDF

</label>

<input

type="file"

name="pdf"

class="form-control"

accept=".pdf"

required>

<div class="form-text">

Only PDF files are allowed.

</div>

</div>

<button

type="submit"

name="submit"

class="btn btn-primary w-100">

<i class="fa-solid fa-upload"></i>

Upload Research Paper

</button>

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