<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Shoe Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .hero {
            background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('https://images.unsplash.com/photo-1460353581641-37baddab0fa2?ixlib=rb-1.2.1');
            background-size: cover;
            background-position: center;
            height: 60vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-align: center;
        }
        .feature-card {
            transition: transform 0.3s;
            margin: 20px 0;
        }
        .feature-card:hover {
            transform: translateY(-10px);
        }
    </style>
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <div class="hero">
        <div class="container">
            <h1 class="display-3">Welcome to Shoe Management System</h1>
            <p class="lead">Manage your shoe inventory with ease</p>
            <a href="register.php" class="btn btn-primary btn-lg me-3">Register Now</a>
            <a href="login.php" class="btn btn-outline-light btn-lg">Login</a>
        </div>
    </div>

    <div class="container my-5">
        <div class="row">
            <div class="col-md-4">
                <div class="card feature-card">
                    <div class="card-body text-center">
                        <h3>Add Shoes</h3>
                        <p>Easily add new shoes to your inventory with detailed information.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card feature-card">
                    <div class="card-body text-center">
                        <h3>View Collection</h3>
                        <p>Browse through your shoe collection with our organized display system.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card feature-card">
                    <div class="card-body text-center">
                        <h3>Manage Inventory</h3>
                        <p>Keep track of your shoe inventory efficiently and securely.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 