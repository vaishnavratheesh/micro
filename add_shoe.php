<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require_once 'config/database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle file upload
    $target_dir = "uploads/";
    // Create uploads directory if it doesn't exist
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    $image_path = "";
    if(isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {
        $allowed_types = ["image/jpeg", "image/jpg", "image/png", "image/gif"];
        if(in_array($_FILES["image"]["type"], $allowed_types)) {
            $file_name = time() . '_' . basename($_FILES["image"]["name"]);
            $target_file = $target_dir . $file_name;
            
            if(move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                $image_path = $target_file;
            } else {
                $error = "Sorry, there was an error uploading your file.";
            }
        } else {
            $error = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        }
    }

    if(empty($error)) {
        $shoe = [
            'name' => $_POST['name'],
            'brand' => $_POST['brand'],
            'price' => (float)$_POST['price'],
            'size' => (float)$_POST['size'],
            'color' => $_POST['color'],
            'description' => $_POST['description'],
            'image_path' => $image_path,
            'created_at' => time()
        ];

        try {
            $result = $collection->insertOne($shoe);
            if ($result->getInsertedCount() > 0) {
                $success = "Shoe added successfully!";
            }
        } catch (Exception $e) {
            $error = "Error: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Shoe - Shoe Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .form-container {
            max-width: 800px;
            margin: 30px auto;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            border-radius: 8px;
        }
        .header {
            background-color: #f8f9fa;
            padding: 20px 0;
            margin-bottom: 30px;
        }
        .btn-primary {
            background-color: #3d5a80;
            border-color: #3d5a80;
        }
        .btn-primary:hover {
            background-color: #2c4a6d;
            border-color: #2c4a6d;
        }
        .image-preview {
            max-width: 200px;
            max-height: 200px;
            margin-top: 10px;
            display: none;
        }
    </style>
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <div class="container">
        <div class="form-container">
            <h2 class="mb-4">Add New Shoe</h2>
            
            <?php if (isset($success)): ?>
                <div class="alert alert-success"><?php echo $success; ?></div>
            <?php endif; ?>
            
            <?php if (isset($error)): ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endif; ?>

            <form method="POST" action="add_shoe.php" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="name" class="form-label">Shoe Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="brand" class="form-label">Brand</label>
                        <input type="text" class="form-control" id="brand" name="brand" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="price" class="form-label">Price</label>
                        <input type="number" class="form-control" id="price" name="price" step="0.01" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="size" class="form-label">Size</label>
                        <input type="number" class="form-control" id="size" name="size" step="0.5" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="color" class="form-label">Color</label>
                    <input type="text" class="form-control" id="color" name="color" required>
                </div>

                <div class="mb-3">
                    <label for="image" class="form-label">Shoe Image</label>
                    <input type="file" class="form-control" id="image" name="image" accept="image/*" required onchange="previewImage(this);">
                    <img id="imagePreview" class="image-preview" alt="Image preview">
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                </div>

                <button type="submit" class="btn btn-primary">Add Shoe</button>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function previewImage(input) {
            const preview = document.getElementById('imagePreview');
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                }
                
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</body>
</html> 