<?php
session_start();
require_once 'config/database.php';

try {
    $shoes = $collection->find();
} catch (Exception $e) {
    $error = "Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Shoe Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
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
    <?php include 'includes/header.php'; ?>

    <div class="container mt-4">
        <h2 class="mb-4">Welcome to Shoe Store</h2>
        
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