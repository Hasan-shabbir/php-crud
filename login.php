<?php
session_start();
include('connection.php'); // Include your database connection file
$error_message= "";
if(isset($_SESSION['admin'])){
  header("location: read.php");
  die();
}
//checking for registered admin
if(isset($_POST['login'])){
    $email = $_POST['email'];
    $password = $_POST['password'];
    $sql = mysqli_query($conn,"select * from admin where email='$email' && password='$password'");
    $num=mysqli_num_rows($sql);

    if($num>0){
    $admin=mysqli_fetch_assoc($sql);
    // capture data of currently login users.
    $_SESSION['admin'] = $admin;
    header("location: read.php");
    }
    else{
    $error_message = 'Credentials Invalid!';
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-s/fT8RbQx9ZkIadC0ZD3bp5QQ5ogB8g4+IUO61rYAPpAMeIKrO8qo05ZI4iWc/8AnhZrEBYrfqdBbBPL0fzqNw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-dark">
        <div class="container">
            <a class="navbar-brand text-white fs-4" href="index.php"><i class="bi bi-door-open text-danger"></i></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active text-white" aria-current="page" href="#">Portal Management System</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
    <div class="row">
                <div class="col-12">
                    <form class=" w-50 mx-auto  py-5 shadow p-4 lform" action="" method="post">
                    <h4 data-aos="fade-up" data-aos-offset="200" class="logo text-center lg-label">LogIn</h4>
                        <hr / class="w-25 m-auto text-danger">
                          <?php if(!empty($error_message)) { ?>
                          <div id="errorMessage" style="background-color: #fff; color: red; text-align: center; font-size: 18px; padding: 4px; border-radius: 15px;">
                              <strong>Error:</strong><p><?php echo $error_message ?></p>
                          </div>
                          <?php } ?> 
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Email address</label>
                            <input type="email" name= "email" class="form-control" id="exampleInputEmail1"
                                placeholder="Enter Your Email...">
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Password</label>
                            <input type="password" name= "password" class="form-control" id="exampleInputPassword1"
                                placeholder="Enter Your Password...">
                        </div>
                        <div class="d-grid gap-2">
                          <input name= "login" class="btn btn-outline-danger text-dark" type="submit" value="Login">
                        </div>
                    </form>
                </div>
            </div>
    </div>
    
</body>
</html>