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
    <title>Home - Luxury Shoe Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #2c3e50;
            --accent-color: #e74c3c;
            --bg-light: #f8f9fa;
            --text-dark: #2c3e50;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--bg-light);
        }

        .hero-section {
            background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)),
                        url('https://images.unsplash.com/photo-1549298916-b41d501d3772?auto=format&fit=crop&w=1600');
            background-size: cover;
            background-position: center;
            color: white;
            padding: 100px 0;
            margin-bottom: 40px;
            text-align: center;
        }

        .hero-section h1 {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 20px;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .hero-section p {
            font-size: 1.2rem;
            max-width: 600px;
            margin: 0 auto;
            line-height: 1.6;
        }

        .shoe-card {
            transition: all 0.3s ease;
            margin-bottom: 30px;
        }

        .shoe-card:hover {
            transform: translateY(-10px);
        }

        .card {
            border: none;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            height: 100%;
            background: white;
        }

        .shoe-image {
            height: 250px;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .card:hover .shoe-image {
            transform: scale(1.05);
        }

        .card-body {
            padding: 1.5rem;
        }

        .card-title {
            font-size: 1.4rem;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 0.5rem;
        }

        .brand-badge {
            background-color: var(--accent-color);
            color: white;
            padding: 0.3rem 0.8rem;
            border-radius: 20px;
            font-size: 0.9rem;
            display: inline-block;
            margin-bottom: 1rem;
        }

        .price-tag {
            font-size: 1.3rem;
            color: var(--accent-color);
            font-weight: bold;
            margin: 0.5rem 0;
        }

        .shoe-details {
            margin: 1rem 0;
            color: #666;
        }

        .shoe-details i {
            width: 20px;
            color: var(--primary-color);
            margin-right: 5px;
        }

        .filters {
            background: white;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 30px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }

        .btn-view-details {
            background-color: var(--primary-color);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 25px;
            transition: all 0.3s ease;
            width: 100%;
            margin-top: 1rem;
        }

        .btn-view-details:hover {
            background-color: var(--accent-color);
            transform: translateY(-2px);
        }
    </style>
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <div class="hero-section">
        <div class="container">
            <h1>Step into Luxury</h1>
            <p>Discover our exclusive collection of premium footwear that combines style, comfort, and quality</p>
        </div>
    </div>

    <div class="container">
        <div class="filters">
            <div class="row align-items-center">
                <div class="col-md-3">
                    <h5 class="mb-0">Filter Collection</h5>
                </div>
                <div class="col-md-9">
                    <div class="d-flex gap-3">
                        <select class="form-select">
                            <option>All Brands</option>
                        </select>
                        <select class="form-select">
                            <option>Price Range</option>
                        </select>
                        <select class="form-select">
                            <option>Size</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

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
                                <span class="brand-badge">
                                    <?php echo htmlspecialchars($shoe->brand); ?>
                                </span>
                                <h5 class="card-title"><?php echo htmlspecialchars($shoe->name); ?></h5>
                                <div class="price-tag">
                                    $<?php echo number_format($shoe->price, 2); ?>
                                </div>
                                <div class="shoe-details">
                                    <p><i class="fas fa-ruler"></i> Size: <?php echo htmlspecialchars($shoe->size); ?></p>
                                    <p><i class="fas fa-palette"></i> Color: <?php echo htmlspecialchars($shoe->color); ?></p>
                                </div>
                                <p class="card-text text-muted"><?php echo htmlspecialchars($shoe->description); ?></p>
                                <button class="btn btn-view-details">
                                    View Details <i class="fas fa-arrow-right ms-2"></i>
                                </button>
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