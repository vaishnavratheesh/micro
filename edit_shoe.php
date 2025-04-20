<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require_once 'config/database.php';

// Check if ID is provided
if(!isset($_GET['id'])) {
    header("Location: view_shoes.php");
    exit();
}

// Get shoe data
try {
    $id = $_GET['id']; // Get the ID as string
    $shoe = $collection->findOne(['_id' => new MongoDB\BSON\ObjectId($id)]);
    if(!$shoe) {
        header("Location: view_shoes.php");
        exit();
    }
} catch(Exception $e) {
    $error = "Error: " . $e->getMessage();
}

// Handle Update
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $id = $_POST['shoe_id']; // Get the ID as string
        
        // Handle file upload if new image is provided
        $image_path = $_POST['existing_image'];
        if(isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {
            $target_dir = "uploads/";
            // Create uploads directory if it doesn't exist
            if (!file_exists($target_dir)) {
                mkdir($target_dir, 0777, true);
            }
            
            $allowed_types = ["image/jpeg", "image/jpg", "image/png", "image/gif"];
            
            if(in_array($_FILES["image"]["type"], $allowed_types)) {
                $file_name = time() . '_' . basename($_FILES["image"]["name"]);
                $target_file = $target_dir . $file_name;
                
                if(move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                    $image_path = $target_file;
                    // Delete old image if it exists and is not the default image
                    if(file_exists($_POST['existing_image']) && $_POST['existing_image'] != 'uploads/default.jpg') {
                        unlink($_POST['existing_image']);
                    }
                }
            } else {
                throw new Exception("Invalid file type. Only JPG, JPEG, PNG & GIF files are allowed.");
            }
        }

        $updateData = [
            'name' => $_POST['name'],
            'brand' => $_POST['brand'],
            'price' => (float)$_POST['price'],
            'size' => (float)$_POST['size'],
            'color' => $_POST['color'],
            'description' => $_POST['description'],
            'image_path' => $image_path
        ];

        $result = $collection->updateOne(
            ['_id' => new MongoDB\BSON\ObjectId($id)],
            ['$set' => $updateData]
        );
        
        if ($result->getModifiedCount() > 0 || $result->getMatchedCount() > 0) {
            $_SESSION['success'] = "Shoe updated successfully!";
            header("Location: view_shoes.php");
            exit();
        } else {
            throw new Exception("Failed to update shoe.");
        }
    } catch (Exception $e) {
        $error = "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Shoe - Shoe Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .form-container {
            max-width: 800px;
            margin: 30px auto;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            border-radius: 8px;
        }
        .current-image {
            max-width: 200px;
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <div class="container">
        <div class="form-container">
            <h2 class="mb-4">Edit Shoe</h2>
            
            <?php if (isset($error)): ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endif; ?>

            <?php if (isset($shoe)): ?>
                <form method="POST" action="edit_shoe.php?id=<?php echo $id; ?>" enctype="multipart/form-data">
                    <input type="hidden" name="shoe_id" value="<?php echo $id; ?>">
                    <input type="hidden" name="existing_image" value="<?php echo htmlspecialchars($shoe->image_path); ?>">

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">Shoe Name</label>
                            <input type="text" class="form-control" id="name" name="name" 
                                   value="<?php echo htmlspecialchars($shoe->name); ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="brand" class="form-label">Brand</label>
                            <input type="text" class="form-control" id="brand" name="brand" 
                                   value="<?php echo htmlspecialchars($shoe->brand); ?>" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="price" class="form-label">Price</label>
                            <input type="number" class="form-control" id="price" name="price" 
                                   value="<?php echo $shoe->price; ?>" step="0.01" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="size" class="form-label">Size</label>
                            <input type="number" class="form-control" id="size" name="size" 
                                   value="<?php echo $shoe->size; ?>" step="0.5" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="color" class="form-label">Color</label>
                        <input type="text" class="form-control" id="color" name="color" 
                               value="<?php echo htmlspecialchars($shoe->color); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label">Shoe Image</label>
                        <input type="file" class="form-control" id="image" name="image" accept="image/*">
                        <small class="text-muted">Leave empty to keep current image</small>
                        <?php if($shoe->image_path): ?>
                            <div>
                                <p>Current Image:</p>
                                <img src="<?php echo htmlspecialchars($shoe->image_path); ?>" 
                                     class="current-image" alt="Current shoe image">
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" 
                                  rows="3" required><?php echo htmlspecialchars($shoe->description); ?></textarea>
                    </div>

                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Update Shoe</button>
                        <a href="view_shoes.php" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            <?php endif; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 