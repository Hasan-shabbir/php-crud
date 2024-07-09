<?php
session_start();
include('connection.php');

if (!isset($_SESSION['admin'])) {
    header("location: login.php");
    die();
}

$showError = "";

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM abc WHERE id = $id";
    $result = mysqli_query($conn, $sql);
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $name = $row['name'];
        $email = $row['email'];
        $password = $row['password'];
        $address = $row['address'];
        $phone = $row['phone'];
        $image = $row['image'];
    } else {
        echo "No user found with ID: $id";
    }
}

if (isset($_POST['update'])) {
    $user_id = $_POST['user_id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];

    // Validate image upload
    if ($_FILES['image']['name']) {
        $image = $_FILES['image']['name'];
        $file_tmp = $_FILES['image']['tmp_name'];
        $file_destination = 'img/' . $image;

        // Validate image type
        $allowed_extensions = array('png', 'jpg');
        $file_extension = strtolower(pathinfo($image, PATHINFO_EXTENSION));
        if (!in_array($file_extension, $allowed_extensions)) {
            $showError = "Invalid file type. Please upload only PNG or JPG images.";
        }

        // Check if image file already exists for other users
        $imageExists = mysqli_query($conn, "SELECT * FROM abc WHERE image = '$image' AND id != '$user_id'");
        if (mysqli_num_rows($imageExists) > 0) {
            $showError = "Image file name already exists for another user. Please rename your image file.";
        }

        // Move uploaded image to destination folder
        if (!move_uploaded_file($file_tmp, $file_destination)) {
            $showError = "Error uploading image.";
        }
    }

    // Validate phone number (numeric)
    if (!ctype_digit($phone)) {
        $showError = "Phone number should contain only digits.";
    }

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $showError = "Invalid email format.";
    }

    // Check if phone number already exists for other users
    $phoneExists = mysqli_query($conn, "SELECT * FROM abc WHERE phone = '$phone' AND id != '$user_id'");
    if (mysqli_num_rows($phoneExists) > 0) {
        $showError = "Phone number already exists for another user. Please use a different one.";
    }

    // If no errors, proceed with database update
    if (empty($showError)) {
        $updateQuery = "UPDATE `abc` SET `name`='$name', `email`='$email', `password`='$password', `address`='$address', `phone`='$phone'";
        
        if (isset($image)) {
            $updateQuery .= ", `image`='$image'";
        }
        
        $updateQuery .= " WHERE `id`='$user_id'";

        // Execute update query
        $updateResult = mysqli_query($conn, $updateQuery);

        if ($updateResult) {
            echo "Data Updated Successfully!";
            header("location: read.php"); // Redirect to read.php after successful update
            exit();
        } else {
            echo "Error updating record: " . mysqli_error($conn);
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update User</title>
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
    <div class="container mt-4">
        <div class="row">
            <div class="col-6">
            <h5 class="mb-4">UPDATE USER RECORD</h5>

            <form action="edit.php?id=<?php echo $id; ?>" method="post" enctype="multipart/form-data">
                <?php
                    if (!empty($showError)) {
                        echo '
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Error:</strong> ' . $showError . '
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>';
                    }
                ?>
                <div class="row mb-3">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">Name</label>
                    <div class="col-sm-10">
                    <input type="text" class="form-control" id="inputEmail3" name="name" value="<?php echo $name ?>">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="inputPassword3" class="col-sm-2 col-form-label">Email</label>
                    <div class="col-sm-10">
                    <input type="email" class="form-control" id="inputPassword3" name="email" value="<?php echo $email ?>">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="inputPassword3" class="col-sm-2 col-form-label">Password</label>
                    <div class="col-sm-10">
                    <input type="password" class="form-control" id="inputPassword3" name="password" value="<?php echo $password ?>">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="inputPassword3" class="col-sm-2 col-form-label">Address</label>
                    <div class="col-sm-10">
                    <input type="text" class="form-control" id="inputPassword3" name="address" value="<?php echo $address ?>">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="inputPassword3" class="col-sm-2 col-form-label">Phone</label>
                    <div class="col-sm-10">
                    <input type="text" class="form-control" id="inputPassword3" name="phone" value="<?php echo $phone ?>">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="inputPassword3" class="col-sm-2 col-form-label">Image</label>
                    <div class="col-sm-10">
                    <input type="file" class="form-control" id="inputPassword3" name="image" value="<?php echo $image ?>">
                    </div>
                </div>
                <input type="hidden" name="user_id" value="<?php echo $_GET['id']; ?>">
                <button type="submit" class="btn btn-dark" name="update"><i class="bi bi-pencil-square"></i> Update user</button>
                </form>
                
            </div>
        </div>
    </div>
</body>
</html>
