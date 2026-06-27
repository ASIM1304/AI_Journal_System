<!DOCTYPE html>

<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1">

<title>AI Journal System</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
background:#f4f6f9;
}

.hero{
background:linear-gradient(135deg,#0d6efd,#003366);
color:white;
padding:80px 20px;
text-align:center;
}

.hero h1{
font-size:45px;
font-weight:bold;
}

.hero p{
font-size:20px;
margin-top:20px;
}

.section-title{
color:#003366;
font-weight:bold;
margin-bottom:30px;
}

.card{
border:none;
box-shadow:0px 0px 10px rgba(0,0,0,.1);
transition:.3s;
}

.card:hover{
transform:translateY(-5px);
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

<a class="navbar-brand fw-bold" href="index.php">

AI Journal System

</a>

<button
class="navbar-toggler"
type="button"
data-bs-toggle="collapse"
data-bs-target="#menu">

<span class="navbar-toggler-icon"></span>

</button>

<div class="collapse navbar-collapse" id="menu">

<ul class="navbar-nav ms-auto">

<li class="nav-item">

<a class="nav-link active" href="index.php">

Home

</a>

</li>

<li class="nav-item">

<a class="nav-link" href="author.php">

Author

</a>

</li>

<li class="nav-item">

<a class="nav-link" href="reviewer.php">

Reviewer

</a>

</li>

<li class="nav-item">

<a class="nav-link" href="editor.php">

Editor

</a>

</li>

<li class="nav-item">

<a class="nav-link" href="admin.php">

Admin

</a>

</li>

</ul>

</div>

</div>

</nav>

<section class="hero">

<div class="container">

<h1>

AI-Based Research Paper Analysis

</h1>

<p>

Upload research papers, generate AI summaries, extract keywords,
manage peer reviews, and publish research papers through a complete
Journal Management System.

</p>

<div class="mt-4">

<a
href="author.php"
class="btn btn-light btn-lg me-3">

Author Registration

</a>

<a
href="login.php"
class="btn btn-warning btn-lg">

Author Login

</a>

</div>

<div class="mt-3">

<a
href="reviewer.php"
class="btn btn-success me-2">

Reviewer Login

</a>

<a
href="editor.php"
class="btn btn-info text-white me-2">

Editor Login

</a>

<a
href="admin.php"
class="btn btn-danger">

Admin Login

</a>

</div>

</div>

</section>

<div class="container mt-5">

<h2 class="text-center section-title">

System Features

</h2>

<div class="row">
<div class="col-md-4 mb-4">

<div class="card h-100">

<div class="card-body text-center">

<h3 class="text-primary">

🤖 AI Summary

</h3>

<p>

Generate automatic summaries of uploaded research papers using Artificial Intelligence.

</p>

</div>

</div>

</div>

<div class="col-md-4 mb-4">

<div class="card h-100">

<div class="card-body text-center">

<h3 class="text-success">

🔑 Keyword Extraction

</h3>

<p>

Extract important keywords from research papers using NLP and KeyBERT.

</p>

</div>

</div>

</div>

<div class="col-md-4 mb-4">

<div class="card h-100">

<div class="card-body text-center">

<h3 class="text-danger">

📚 Journal Management

</h3>

<p>

Complete workflow for Authors, Reviewers, Editors and Administrators.

</p>

</div>

</div>

</div>

<div class="col-md-4 mb-4">

<div class="card h-100">

<div class="card-body text-center">

<h3 class="text-warning">

📄 Paper Upload

</h3>

<p>

Upload research papers securely in PDF format for AI analysis and review.

</p>

</div>

</div>

</div>

<div class="col-md-4 mb-4">

<div class="card h-100">

<div class="card-body text-center">

<h3 class="text-info">

⭐ Peer Review

</h3>

<p>

Reviewers evaluate papers, assign ratings, and recommend decisions.

</p>

</div>

</div>

</div>

<div class="col-md-4 mb-4">

<div class="card h-100">

<div class="card-body text-center">

<h3 class="text-secondary">

🚀 Publication

</h3>

<p>

Editors publish accepted papers while Admin manages the entire journal system.

</p>

</div>

</div>

</div>

</div>

</div>

<section class="container mt-5">

<div class="card">

<div class="card-body">

<h2 class="text-center text-primary mb-4">

About the Project

</h2>

<p class="text-center">

The AI-Based Research Paper Analysis and Journal Management System is a web application developed using PHP, MySQL, Python, Bootstrap 5, Hugging Face Transformers, and KeyBERT. It enables authors to upload research papers, generates AI-powered summaries and keywords, supports peer review, and provides a complete workflow for editors and administrators to manage journal publications.

</p>

</div>

</div>

</section>

<footer>

<div class="container">

<h5>

AI-Based Research Paper Analysis and Journal Management System

</h5>

<p>

Developed using PHP, MySQL, Python, Bootstrap 5, Hugging Face Transformers, and KeyBERT.

</p>

<p>

© 2026 All Rights Reserved.

</p>

</div>

</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>