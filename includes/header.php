<?php if (!isset($_SESSION)) { session_start(); } ?>
<?php require_once dirname(__FILE__) . '/auth.php'; ?>


<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <?php if(strpos($_SERVER['PHP_SELF'], '/admin/') !== false): ?>
            <a class="navbar-brand" href="../index.php">Shoe Store</a>
        <?php else: ?>
            <a class="navbar-brand" href="index.php">Shoe Store</a>
        <?php endif; ?>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <?php if(strpos($_SERVER['PHP_SELF'], '/admin/') !== false): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="../index.php">Home</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                <?php endif; ?>

                <?php if (isset($_SESSION['user_id'])): ?>
                    <?php if (isAdmin()): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="/micro/admin/dashboard.php">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/micro/admin/add_shoe.php">Add Shoe</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/micro/admin/view_shoes.php">Manage Shoes</a>
                        </li>
                    <?php endif; ?>
                    
                    <?php if(strpos($_SERVER['PHP_SELF'], '/admin/') !== false): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="../logout.php">Logout</a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="logout.php">Logout</a>
                        </li>
                    <?php endif; ?>
                <?php else: ?>
                    <?php if(strpos($_SERVER['PHP_SELF'], '/admin/') !== false): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="../login.php">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../register.php">Register</a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="login.php">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="register.php">Register</a>
                        </li>
                    <?php endif; ?>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav> 
</nav> 