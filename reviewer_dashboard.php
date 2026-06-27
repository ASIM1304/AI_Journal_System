<?php

session_start();

if(!isset($_SESSION['reviewer_id']))
{
    header("Location:reviewer.php");
    exit();
}

include("db_connect.php");

$reviewer_id = $_SESSION['reviewer_id'];

$search = "";

if(isset($_GET['search']))
{
    $search = mysqli_real_escape_string($conn,$_GET['search']);
}

$sql = "

SELECT

papers.paper_id,
papers.title,
papers.domain,
papers.status,
authors.name AS author_name

FROM papers

INNER JOIN authors

ON papers.author_id = authors.author_id

WHERE

papers.title LIKE '%$search%'

OR

papers.domain LIKE '%$search%'

ORDER BY papers.paper_id DESC

";

$result = mysqli_query($conn,$sql);

if(!$result)
{
    die(mysqli_error($conn));
}

?>
<!DOCTYPE html>

<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Reviewer Dashboard</title>

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
box-shadow:0 0 15px rgba(0,0,0,.1);
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

<a class="nav-link active" href="reviewer_dashboard.php">

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

<i class="fa-solid fa-user-check"></i>

Reviewer Dashboard

</h3>

</div>

<div class="card-body">

<form method="GET" class="row g-3 mb-4">

<div class="col-md-10">

<input
type="text"
name="search"
class="form-control"
placeholder="Search by Title or Domain"
value="<?php echo $search; ?>">

</div>

<div class="col-md-2">

<button
type="submit"
class="btn btn-primary w-100">

<i class="fa-solid fa-magnifying-glass"></i>

Search

</button>

</div>

</form>

<div class="table-responsive">

<table class="table table-bordered table-hover align-middle">

<thead class="table-primary">

<tr>

<th>Paper ID</th>

<th>Title</th>

<th>Author</th>

<th>Domain</th>

<th>Status</th>

<th>Action</th>

</tr>

</thead>

<tbody>
<?php

if(mysqli_num_rows($result)>0)
{
    while($row=mysqli_fetch_assoc($result))
    {

        if($row['status']=="Published")
        {
            $badge="success";
        }
        elseif($row['status']=="Accepted")
        {
            $badge="primary";
        }
        elseif($row['status']=="Rejected")
        {
            $badge="danger";
        }
        elseif($row['status']=="Minor Revision")
        {
            $badge="warning";
        }
        elseif($row['status']=="Major Revision")
        {
            $badge="secondary";
        }
        else
        {
            $badge="info";
        }

?>

<tr>

<td>

<?php echo $row['paper_id']; ?>

</td>

<td>

<?php echo $row['title']; ?>

</td>

<td>

<?php echo $row['author_name']; ?>

</td>

<td>

<?php echo $row['domain']; ?>

</td>

<td>

<span class="badge bg-<?php echo $badge; ?>">

<?php echo $row['status']; ?>

</span>

</td>

<td>

<a

href="review_paper.php?paper_id=<?php echo $row['paper_id']; ?>"

class="btn btn-primary btn-sm">

<i class="fa-solid fa-pen-to-square"></i>

Review

</a>

</td>

</tr>

<?php

    }
}
else
{

?>

<tr>

<td colspan="6" class="text-center">

No Research Papers Found

</td>

</tr>

<?php

}

?>

</tbody>

</table>

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