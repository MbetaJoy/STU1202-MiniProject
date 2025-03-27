<?php
    include('database.php');
    session_start();

    if($_SERVER["REQUEST_METHOD"]=='POST'){
        $email = $_POST['email'];
        $password = $_POST['password'];

        $sql = "SELECT * FROM `users` WHERE email='$email'";
        $result = $connection->query($sql);
        $user = $result->fetch_assoc();

        if($user && password_verify($password, $user['password'])){
            $_SESSION['user_id'] = $user['id'];
            header("Location: dashboard.php");
        }else{
            echo"<div class='alert alert-danger text-center'>Invalid credentials!</div>";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Login</h2>
        <form action="" method="POST" class="p-4 shadow rounded">
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" class="form-control" required autocomplete="off">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required  autocomplete="off">
            </div>
            <button type="submit" class="btn btn-primary w-100">Login</button>
            <p class="mt-2 p-1"><a class="text-decoration-none text-warning text-center " href="register.php">Sign-up</a></p>
        </form>
    </div>

</body>
</html>
