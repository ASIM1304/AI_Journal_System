<?php

session_start();

if(!isset($_SESSION['author_id']))
{
    header("Location:login.php");
    exit();
}

include("db_connect.php");

if(!isset($_GET['paper_id']))
{
    die("Paper ID Missing");
}

$paper_id = intval($_GET['paper_id']);

$sql = "
SELECT
papers.title,
papers.domain,
papers.abstract,
ai_analysis.summary,
ai_analysis.keywords,
ai_analysis.predicted_domain,
ai_analysis.reading_time,
ai_analysis.ai_score
FROM papers
INNER JOIN ai_analysis
ON papers.paper_id = ai_analysis.paper_id
WHERE papers.paper_id='$paper_id'
";

$result = mysqli_query($conn,$sql);

if(!$result)
{
    die(mysqli_error($conn));
}

if(mysqli_num_rows($result)==0)
{
    die("AI Analysis Not Found");
}

$row = mysqli_fetch_assoc($result);

?>

<!DOCTYPE html>

<html>

<head>

<title>AI Research Paper Analysis</title>

<style>

*{
margin:0;
padding:0;
box-sizing:border-box;
}

body{
font-family:Arial,sans-serif;
background:#f4f4f4;
}

header{
background:#003366;
color:white;
padding:15px;
text-align:center;
}

.container{
width:90%;
max-width:900px;
margin:40px auto;
background:white;
padding:30px;
border-radius:10px;
box-shadow:0 0 10px lightgray;
}

h2{
color:#003366;
margin-bottom:20px;
}

.card{
background:#f9f9f9;
padding:20px;
margin-bottom:20px;
border-left:5px solid #003366;
border-radius:5px;
}

.card h3{
color:#003366;
margin-bottom:10px;
}

.card p{
line-height:28px;
text-align:justify;
}

.button{
display:inline-block;
padding:12px 20px;
background:#003366;
color:white;
text-decoration:none;
border-radius:5px;
margin-top:20px;
}

.button:hover{
background:#0055aa;
}

footer{
background:#003366;
color:white;
text-align:center;
padding:15px;
margin-top:40px;
}

</style>

</head>

<body>

<header>

<h1>

AI Research Paper Analysis

</h1>

</header>

<div class="container">

<h2>

<?php echo $row['title']; ?>

</h2>

<div class="card">

<h3>

Research Domain

</h3>

<p>

<?php echo $row['domain']; ?>

</p>

</div>

<div class="card">

<h3>

Abstract

</h3>

<p>

<?php echo $row['abstract']; ?>

</p>

</div>
<div class="card">

<h3>

AI Generated Summary

</h3>

<p>

<?php echo nl2br($row['summary']); ?>

</p>

</div>

<div class="card">

<h3>

Keywords

</h3>

<p>

<?php echo $row['keywords']; ?>

</p>

</div>

<div class="card">

<h3>

Predicted Domain

</h3>

<p>

<?php echo $row['predicted_domain']; ?>

</p>

</div>

<div class="card">

<h3>

Estimated Reading Time

</h3>

<p>

<?php echo $row['reading_time']; ?>

</p>

</div>

<div class="card">

<h3>

AI Score

</h3>

<p>

<?php echo $row['ai_score']; ?>/100

</p>

</div>

<a
href="my_papers.php"
class="button">

Back to My Papers

</a>

</div>

<footer>

<p>

© 2026 AI-Based Research Paper Analysis and Journal Management System

</p>

</footer>

</body>

</html>