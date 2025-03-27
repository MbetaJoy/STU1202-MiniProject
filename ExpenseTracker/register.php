<?php
    include ('database.php');
    session_start();


    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

        $sql = "INSERT INTO `users`( `name`, `email`, `password`) VALUES ('$name','$email','$password')";
        if($connection->query($sql)=== TRUE){
            header("Location: index.php");
        }else{
            echo "alert('Error')".$connection->error;
            header("Location: register.php");
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Register</h2>
        <form action="" method="POST" class="p-4 shadow rounded">
            <div class="mb-3">
                <label for="name" class="form-label">name</label>
                <input type="text" name='name' class="form-control" required autocomplete="off">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name='email' class="form-control" required autocomplete="off">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name='password' class="form-control" required autocomplete="off">
            </div>
            <button type="submit" class="btn btn-primary w-100">Register</button>
        </form>
    </div>

</body>
</html>
