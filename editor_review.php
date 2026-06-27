<?php

session_start();

if(!isset($_SESSION['editor_id']))
{
    header("Location:editor.php");
    exit();
}

include("db_connect.php");

/* --------------------------
   Publish / Reject Paper
--------------------------- */

if(isset($_GET['action']) && isset($_GET['paper_id']))
{
    $paper_id = intval($_GET['paper_id']);

    if($_GET['action']=="publish")
    {
        mysqli_query(
        $conn,
        "UPDATE papers
        SET status='Published'
        WHERE paper_id='$paper_id'"
        );

        header("Location:editor_dashboard.php");
        exit();
    }

    if($_GET['action']=="reject")
    {
        mysqli_query(
        $conn,
        "UPDATE papers
        SET status='Rejected'
        WHERE paper_id='$paper_id'"
        );

        header("Location:editor_dashboard.php");
        exit();
    }
}

/* --------------------------
   Check Paper ID
--------------------------- */

if(!isset($_GET['paper_id']))
{
    die("Paper ID Missing");
}

$paper_id = intval($_GET['paper_id']);

?>
$sql = "

SELECT

papers.paper_id,
papers.title,
papers.domain,
papers.abstract,
papers.pdf_file,
papers.status,

authors.name AS author_name,
authors.email,

reviews.comments,
reviews.rating,
reviews.decision,
reviews.review_date

FROM papers

INNER JOIN authors

ON papers.author_id = authors.author_id

LEFT JOIN reviews

ON papers.paper_id = reviews.paper_id

WHERE papers.paper_id='$paper_id'

";

$result = mysqli_query($conn,$sql);

if(!$result)
{
    die(mysqli_error($conn));
}

if(mysqli_num_rows($result)==0)
{
    die("Paper Not Found");
}

$row = mysqli_fetch_assoc($result);

?>
<!DOCTYPE html>

<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Editor Review</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">

<style>

body{
background:#f4f6f9;
}

.navbar{
box-shadow:0 2px 10px rgba(0,0,0,.15);
}

.card{
border:none;
border-radius:12px;
box-shadow:0 0 15px rgba(0,0,0,.10);
margin-bottom:20px;
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

<a class="navbar-brand fw-bold" href="editor_dashboard.php">

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

<a class="nav-link" href="editor_dashboard.php">

Dashboard

</a>

</li>

<li class="nav-item">

<a class="nav-link" href="logout.php">

Logout

</a>

</li>

</ul>

</div>

</div>

</nav>

<div class="container mt-5">

<div class="card">

<div class="card-header bg-primary text-white">

<h3>

<i class="fa-solid fa-file-circle-check"></i>

Paper Details

</h3>

</div>

<div class="card-body">

<div class="row">

<div class="col-md-6">

<p>

<strong>Paper Title</strong>

</p>

<p>

<?php echo $row['title']; ?>

</p>

</div>

<div class="col-md-6">

<p>

<strong>Research Domain</strong>

</p>

<p>

<?php echo $row['domain']; ?>

</p>

</div>

<div class="col-md-6">

<p>

<strong>Author Name</strong>

</p>

<p>

<?php echo $row['author_name']; ?>

</p>

</div>

<div class="col-md-6">

<p>

<strong>Author Email</strong>

</p>

<p>

<?php echo $row['email']; ?>

</p>

</div>

<div class="col-12">

<p>

<strong>Abstract</strong>

</p>

<div class="border rounded p-3 bg-light">

<?php echo nl2br($row['abstract']); ?>

</div>

</div>

<div class="col-12 mt-4">

<a

href="uploads/<?php echo $row['pdf_file']; ?>"

target="_blank"

class="btn btn-success">

<i class="fa-solid fa-file-pdf"></i>

Open PDF

</a>

</div>

</div>

</div>

</div>
<div class="card">

<div class="card-header bg-success text-white">

<h3>

<i class="fa-solid fa-comments"></i>

Reviewer Details

</h3>

</div>

<div class="card-body">

<div class="row">

<div class="col-md-12">

<p>

<strong>Reviewer Comments</strong>

</p>

<div class="border rounded p-3 bg-light">

<?php

if(empty($row['comments']))
{
    echo "No review submitted yet.";
}
else
{
    echo nl2br($row['comments']);
}

?>

</div>

</div>

<div class="col-md-4 mt-4">

<p>

<strong>Rating</strong>

</p>

<?php

if(empty($row['rating']))
{
    echo "<span class='badge bg-secondary'>Not Rated</span>";
}
else
{
    echo "<span class='badge bg-warning text-dark'>".$row['rating']." / 5</span>";
}

?>

</div>

<div class="col-md-4 mt-4">

<p>

<strong>Decision</strong>

</p>

<?php

if(empty($row['decision']))
{
    echo "<span class='badge bg-secondary'>Pending</span>";
}
elseif($row['decision']=="Accepted")
{
    echo "<span class='badge bg-success'>Accepted</span>";
}
elseif($row['decision']=="Rejected")
{
    echo "<span class='badge bg-danger'>Rejected</span>";
}
elseif($row['decision']=="Minor Revision")
{
    echo "<span class='badge bg-warning text-dark'>Minor Revision</span>";
}
else
{
    echo "<span class='badge bg-info'>Major Revision</span>";
}

?>

</div>

<div class="col-md-4 mt-4">

<p>

<strong>Review Date</strong>

</p>

<p>

<?php

if(empty($row['review_date']))
{
    echo "Not Available";
}
else
{
    echo $row['review_date'];
}

?>

</p>

</div>

</div>

<hr>

<div class="d-flex flex-wrap gap-2">

<a

href="editor_review.php?action=publish&paper_id=<?php echo $row['paper_id']; ?>"

class="btn btn-success"

onclick="return confirm('Publish this paper?');">

<i class="fa-solid fa-check"></i>

Publish Paper

</a>

<a

href="editor_review.php?action=reject&paper_id=<?php echo $row['paper_id']; ?>"

class="btn btn-danger"

onclick="return confirm('Reject this paper?');">

<i class="fa-solid fa-xmark"></i>

Reject Paper

</a>

<a

href="editor_dashboard.php"

class="btn btn-secondary">

<i class="fa-solid fa-arrow-left"></i>

Back

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