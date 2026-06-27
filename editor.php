<?php

session_start();

include("db_connect.php");

if(isset($_POST['login']))
{
    $email = mysqli_real_escape_string($conn,$_POST['email']);

    $password = mysqli_real_escape_string($conn,$_POST['password']);

    $sql = "SELECT * FROM editors
            WHERE email='$email'
            AND password='$password'";

    $result = mysqli_query($conn,$sql);

    if(mysqli_num_rows($result)>0)
    {
        $row = mysqli_fetch_assoc($result);

        $_SESSION['editor_id'] = $row['editor_id'];

        $_SESSION['editor_name'] = $row['name'];

        header("Location:editor_dashboard.php");
        exit();
    }
    else
    {
        echo "<script>alert('Invalid Email or Password');</script>";
    }
}

?>

<!DOCTYPE html>

<html>

<head>

<title>Editor Login</title>

<style>

*{
margin:0;
padding:0;
box-sizing:border-box;
}

body{
font-family:Arial;
background:#f4f4f4;
}

header{
background:#003366;
color:white;
padding:15px;
display:flex;
justify-content:space-between;
align-items:center;
}

header h1{
margin-left:20px;
}

nav ul{
display:flex;
list-style:none;
}

nav ul li{
margin-right:20px;
}

nav ul li a{
color:white;
text-decoration:none;
}

.container{
width:400px;
margin:60px auto;
background:white;
padding:30px;
border-radius:10px;
box-shadow:0 0 10px lightgray;
}

h2{
text-align:center;
color:#003366;
margin-bottom:20px;
}

label{
display:block;
margin-top:15px;
margin-bottom:5px;
}

input{
width:100%;
padding:10px;
border:1px solid #ccc;
border-radius:5px;
}

button{
width:100%;
padding:12px;
background:#003366;
color:white;
border:none;
border-radius:5px;
margin-top:20px;
cursor:pointer;
}

button:hover{
background:#0055aa;
}

footer{
background:#003366;
color:white;
text-align:center;
padding:15px;
margin-top:50px;
}

</style>

</head>

<body>

<header>

<h1>AI Journal System</h1>

<nav>

<ul>

<li><a href="index.php">Home</a></li>

<li><a href="login.php">Author</a></li>

<li><a href="reviewer.php">Reviewer</a></li>

<li><a href="admin.php">Admin</a></li>

</ul>

</nav>

</header>

<div class="container">

<h2>

Editor Login

</h2>

<form method="POST">

<label>Email</label>

<input
type="email"
name="email"
required>

<label>Password</label>

<input
type="password"
name="password"
required>

<button
type="submit"
name="login">

Login

</button>

</form>

</div>

<footer>

© 2026 AI-Based Research Paper Analysis and Journal Management System

</footer>

</body>

</html>