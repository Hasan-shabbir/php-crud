<?php
    session_start();
    include('connection.php');
    if(!isset($_SESSION['admin'])){
        header("location: login.php");
        die();
    }

$read = "SELECT * FROM `abc`";
$result = mysqli_query($conn, $read); // Use $conn instead of $this->conn

$sno = 0; // Initialize sno outside the loop
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users Data</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-s/fT8RbQx9ZkIadC0ZD3bp5QQ5ogB8g4+IUO61rYAPpAMeIKrO8qo05ZI4iWc/8AnhZrEBYrfqdBbBPL0fzqNw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .btn{
            float: right;
        }
        a{
            text-decoration: none;
        }
        </style>
        
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
                        <a class="nav-link active text-white" aria-current="page" href="add.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="#">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="read.php">Users</a>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link text-white" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container">
        <div class="row mt-4">
            <div class="col-6">
            <h3>All Users Data</h3>
                
            </div>
            <div class="col-6 btn">
            <button class="btn btn-dark"><a href="add.php" class="text-white a"><i class="bi bi-person-plus-fill"></i> Add user</a></button>
            </div>
        </div>
    
        <div class="row mt-3">
            <div class="col-12">
                <table class="table table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">User</th>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Password</th>
                            <th scope="col">Address</th>
                            <th scope="col">Phone</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                $sno++; // Increment sno for each row
                                ?>
                                <tr>
                                    <td><?php echo $sno; ?></td>
                                    <td><img src="img/<?php echo $row['image']; ?>" class="rounded-circle" style="width: 30px; height: 30px;" alt=""></td>
                                    <td><?php echo $row['name']; ?></td>
                                    <td><?php echo $row['email']; ?></td>
                                    <td><?php echo $row['password']; ?></td>
                                    <td><?php echo $row['address']; ?></td>
                                    <td><?php echo $row['phone']; ?></td>
                                    <td>
                                        <a href="edit.php?id=<?php echo $row['id']; ?>" class="text-dark"><i class="bi bi-pencil-square"></i></a> <!-- Edit Icon -->
                                        <a href="delete.php?id=<?php echo $row['id']; ?>" class="text-danger"><i class="bi bi-trash3"></i></a> <!-- Delete Icon -->
                                    </td>
                                </tr>
                            <?php
                            }
                        } else {
                            echo "<tr><td colspan='7'>No users found</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
