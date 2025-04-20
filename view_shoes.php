<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>
<?php
require_once 'config/database.php';

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
    <title>View Shoes - Shoe Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .header {
            background-color: #f8f9fa;
            padding: 20px 0;
            margin-bottom: 30px;
        }
        .shoe-card {
            transition: transform 0.3s;
            margin-bottom: 20px;
        }
        .shoe-card:hover {
            transform: translateY(-5px);
        }
        .shoe-image {
            height: 200px;
            object-fit: cover;
        }
        .card {
            height: 100%;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="container">
            <h1 class="text-center">Shoe Management System</h1>
            <nav class="mt-3">
                <ul class="nav justify-content-center">
                    <li class="nav-item">
                        <a class="nav-link" href="add_shoe.php">Add New Shoe</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="view_shoes.php">View All Shoes</a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>

    <div class="container">
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php else: ?>
            <div class="row">
                <?php foreach ($shoes as $shoe): ?>
                    <div class="col-md-4 shoe-card">
                        <div class="card">
                            <img src="<?php echo htmlspecialchars($shoe->image_path); ?>" 
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