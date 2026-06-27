<?php

session_start();

include("db_connect.php");

if(isset($_POST['login']))
{
    $username = mysqli_real_escape_string($conn,$_POST['username']);

    $password = mysqli_real_escape_string($conn,$_POST['password']);

    $sql = "SELECT * FROM admins
            WHERE username='$username'
            AND password='$password'";

    $result = mysqli_query($conn,$sql);

    if(mysqli_num_rows($result)>0)
    {
        $row = mysqli_fetch_assoc($result);

        $_SESSION['admin_id'] = $row['admin_id'];

        $_SESSION['admin_username'] = $row['username'];

        header("Location:admin_dashboard.php");

        exit();
    }
    else
    {
        echo "<script>alert('Invalid Username or Password');</script>";
    }
}

?>

<!DOCTYPE html>

<html>

<head>

<title>Admin Login</title>

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
font-weight:bold;
}

.container{
width:400px;
margin:60px auto;
background:white;
padding:30px;
border-radius:10px;
box-shadow:0 0 10px #ccc;
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

<li><a href="editor.php">Editor</a></li>

</ul>

</nav>

</header>

<div class="container">

<h2>

Admin Login

</h2>

<form method="POST">

<label>Username</label>

<input
type="text"
name="username"
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

<p>

© 2026 AI-Based Research Paper Analysis and Journal Management System

</p>

</footer>

</body>

</html>