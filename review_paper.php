<?php

session_start();

if(!isset($_SESSION['reviewer_id']))
{
    header("Location:reviewer.php");
    exit();
}

include("db_connect.php");

if(!isset($_GET['paper_id']))
{
    die("Paper ID Missing");
}

$paper_id = intval($_GET['paper_id']);

$reviewer_id = $_SESSION['reviewer_id'];

$sql = "

SELECT

papers.paper_id,
papers.title,
papers.domain,
papers.abstract,
papers.pdf_file,
papers.status,

authors.name AS author_name,
authors.email

FROM papers

INNER JOIN authors

ON papers.author_id=authors.author_id

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

$paper = mysqli_fetch_assoc($result);

$check = mysqli_query(

$conn,

"

SELECT *

FROM reviews

WHERE

paper_id='$paper_id'

AND

reviewer_id='$reviewer_id'

"

);

$alreadyReviewed = false;

if(mysqli_num_rows($check)>0)
{
    $alreadyReviewed = true;
}

?>
<?php

if(isset($_POST['submit']))
{

    if($alreadyReviewed)
    {
        echo "<script>

        alert('You have already reviewed this paper.');

        window.location='reviewer_dashboard.php';

        </script>";

        exit();
    }

    $comments = mysqli_real_escape_string(
        $conn,
        $_POST['comments']
    );

    $rating = intval($_POST['rating']);

    $decision = mysqli_real_escape_string(
        $conn,
        $_POST['decision']
    );

    $insert = "

    INSERT INTO reviews

    (

    paper_id,
    reviewer_id,
    comments,
    rating,
    decision

    )

    VALUES

    (

    '$paper_id',
    '$reviewer_id',
    '$comments',
    '$rating',
    '$decision'

    )

    ";

    if(mysqli_query($conn,$insert))
    {

        mysqli_query(

        $conn,

        "

        UPDATE papers

        SET status='$decision'

        WHERE paper_id='$paper_id'

        "

        );

        echo "<script>

        alert('Review Submitted Successfully');

        window.location='reviewer_dashboard.php';

        </script>";

        exit();

    }
    else
    {
        die(mysqli_error($conn));
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

Review Research Paper

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
border-radius:12px;
box-shadow:0 0 15px rgba(0,0,0,.12);
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

<a class="navbar-brand fw-bold" href="reviewer_dashboard.php">

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

<a class="nav-link" href="reviewer_dashboard.php">

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

Review Research Paper

</h3>

</div>

<div class="card-body">

<div class="row">

<div class="col-md-6">

<p>

<strong>Paper Title</strong>

</p>

<p>

<?php echo $paper['title']; ?>

</p>

</div>

<div class="col-md-6">

<p>

<strong>Author</strong>

</p>

<p>

<?php echo $paper['author_name']; ?>

</p>

</div>

<div class="col-md-6">

<p>

<strong>Email</strong>

</p>

<p>

<?php echo $paper['email']; ?>

</p>

</div>

<div class="col-md-6">

<p>

<strong>Domain</strong>

</p>

<p>

<?php echo $paper['domain']; ?>

</p>

</div>

<div class="col-12">

<p>

<strong>Abstract</strong>

</p>

<div class="border rounded p-3 bg-light">

<?php echo nl2br($paper['abstract']); ?>

</div>

</div>

<div class="col-12 mt-4">

<a

href="uploads/<?php echo $paper['pdf_file']; ?>"

target="_blank"

class="btn btn-success">

<i class="fa-solid fa-file-pdf"></i>

Open PDF

</a>

</div>

</div>

<hr>

<form method="POST">
<?php

if($alreadyReviewed)
{

?>

<div class="alert alert-warning">

<i class="fa-solid fa-circle-exclamation"></i>

You have already reviewed this paper.

</div>

<a
href="reviewer_dashboard.php"
class="btn btn-secondary">

Back to Dashboard

</a>

<?php

}
else
{

?>

<div class="mb-3">

<label class="form-label">

Reviewer Comments

</label>

<textarea

name="comments"

class="form-control"

rows="6"

placeholder="Enter your review comments"

required>

</textarea>

</div>

<div class="mb-3">

<label class="form-label">

Rating

</label>

<select

name="rating"

class="form-select"

required>

<option value="">

Select Rating

</option>

<option value="5">

⭐⭐⭐⭐⭐ Excellent

</option>

<option value="4">

⭐⭐⭐⭐ Very Good

</option>

<option value="3">

⭐⭐⭐ Good

</option>

<option value="2">

⭐⭐ Fair

</option>

<option value="1">

⭐ Poor

</option>

</select>

</div>

<div class="mb-3">

<label class="form-label">

Decision

</label>

<select

name="decision"

class="form-select"

required>

<option value="">

Select Decision

</option>

<option value="Accepted">

Accepted

</option>

<option value="Rejected">

Rejected

</option>

<option value="Minor Revision">

Minor Revision

</option>

<option value="Major Revision">

Major Revision

</option>

</select>

</div>

<div class="d-grid gap-2">

<button

type="submit"

name="submit"

class="btn btn-primary">

<i class="fa-solid fa-paper-plane"></i>

Submit Review

</button>

<a

href="reviewer_dashboard.php"

class="btn btn-secondary">

<i class="fa-solid fa-arrow-left"></i>

Back

</a>

</div>

<?php

}

?>

</form>

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