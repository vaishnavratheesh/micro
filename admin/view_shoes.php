<?php
session_start();
require_once '../includes/auth.php';
requireAdmin();
require_once '../config/database.php';

// Handle Delete
if(isset($_POST['delete'])) {
    try {
        $id = $_POST['shoe_id'];
        $result = $collection->deleteOne(['_id' => new MongoDB\BSON\ObjectId($id)]);
        if($result->getDeletedCount() > 0) {
            $success = "Shoe deleted successfully!";
        }
    } catch(Exception $e) {
        $error = "Error deleting shoe: " . $e->getMessage();
    }
}

try {
    $shoes = $collection->find([], ['sort' => ['created_at' => -1]]);
} catch (Exception $e) {
    $error = "Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Shoes - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
        .shoe-card {
            margin-bottom: 20px;
        }
        .shoe-image {
            height: 200px;
            object-fit: cover;
        }
        .card {
            height: 100%;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .action-buttons {
            display: flex;
            justify-content: space-between;
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px solid #eee;
        }
    </style>
</head>
<body>
    <?php include '../includes/header.php'; ?>

    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Manage Shoes</h2>
            <a href="add_shoe.php" class="btn btn-primary">Add New Shoe</a>
        </div>

        <?php if (isset($success)): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
        <?php endif; ?>
        
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php else: ?>
            <div class="row">
                <?php foreach ($shoes as $shoe): ?>
                    <div class="col-md-4 shoe-card">
                        <div class="card">
                            <img src="<?php echo '../' . htmlspecialchars($shoe->image_path); ?>" 
                                 class="card-img-top shoe-image" 
                                 alt="<?php echo htmlspecialchars($shoe->name); ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($shoe->name); ?></h5>
                                <h6 class="card-subtitle mb-2 text-muted"><?php echo htmlspecialchars($shoe->brand); ?></h6>
                                <p class="card-text">
                                    <strong>Price:</strong> $<?php echo number_format($shoe->price, 2); ?><br>
                                    <strong>Size:</strong> <?php echo htmlspecialchars($shoe->size); ?><br>
                                    <strong>Color:</strong> <?php echo htmlspecialchars($shoe->color); ?>
                                </p>
                                <p class="card-text"><?php echo htmlspecialchars($shoe->description); ?></p>
                                
                                <div class="action-buttons">
                                    <a href="edit_shoe.php?id=<?php echo $shoe->_id; ?>" 
                                       class="btn btn-primary">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    
                                    <form method="POST" action="view_shoes.php" 
                                          style="display: inline;" 
                                          onsubmit="return confirm('Are you sure you want to delete this shoe?');">
                                        <input type="hidden" name="shoe_id" value="<?php echo $shoe->_id; ?>">
                                        <button type="submit" name="delete" class="btn btn-danger">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 