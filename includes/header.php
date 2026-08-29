<?php
require_once __DIR__ . '/functions.php';
$cartCount = get_cart_count();
$user = current_user();
$currentPage = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?= e(APP_NAME) ?> | <?= e(APP_TAGLINE) ?></title>
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <!-- Custom Design System CSS -->
    <link rel="stylesheet" href="<?= APP_URL ?>/assets/css/style.css" />
</head>
<body>
    <!-- Glassmorphic Header Navbar -->
    <header class="header-navbar">
        <div class="container navbar-container">
            <!-- Brand Logo -->
            <a href="<?= APP_URL ?>/public/index.php" class="brand-logo">
                <i class="fa-solid fa-compass-drafting"></i>
                <span>Unity<span class="text-accent">DesignX</span></span>
            </a>

            <!-- Mobile Hamburger Toggle -->
            <button class="mobile-toggle" id="mobileToggle" aria-label="Toggle Menu">
                <i class="fa-solid fa-bars" id="toggleIcon"></i>
            </button>

            <!-- Navigation Links & Actions -->
            <div class="nav-menu" id="navMenu">
                <ul class="nav-links">
                    <li><a href="<?= APP_URL ?>/public/index.php" class="nav-link <?= $currentPage === 'index.php' ? 'active' : '' ?>">Home</a></li>
                    <li><a href="<?= APP_URL ?>/public/products.php" class="nav-link <?= $currentPage === 'products.php' ? 'active' : '' ?>">Catalog</a></li>
                    <li><a href="<?= APP_URL ?>/public/designs.php" class="nav-link <?= $currentPage === 'designs.php' ? 'active' : '' ?>">3D Room Planner</a></li>
                    <li><a href="<?= APP_URL ?>/public/contact.php" class="nav-link <?= $currentPage === 'contact.php' ? 'active' : '' ?>">Contact</a></li>
                </ul>

                <div class="nav-actions">
                    <!-- Cart Icon Button -->
                    <a href="<?= APP_URL ?>/public/cart.php" class="cart-icon-btn" title="View Cart">
                        <i class="fa-solid fa-shopping-bag"></i>
                        <?php if ($cartCount > 0): ?>
                            <span class="cart-badge" id="headerCartBadge"><?= $cartCount ?></span>
                        <?php endif; ?>
                    </a>

                    <?php if ($user): ?>
                        <!-- User Profile Dropdown -->
                        <div style="display: flex; align-items: center; gap: 0.75rem; flex-wrap: wrap; justify-content: center;">
                            <?php if (is_admin()): ?>
                                <a href="<?= APP_URL ?>/admin/dashboard.php" class="btn btn-secondary" style="padding: 0.5rem 1rem; font-size: 0.85rem;">
                                    <i class="fa-solid fa-gauge-high"></i> Admin
                                </a>
                            <?php endif; ?>
                            <a href="<?= APP_URL ?>/public/orders.php" class="nav-link <?= $currentPage === 'orders.php' ? 'active' : '' ?>" title="My Orders">
                                <i class="fa-solid fa-box"></i> Orders
                            </a>
                            <a href="<?= APP_URL ?>/public/profile.php" class="nav-link" style="font-weight: 600;">
                                <i class="fa-solid fa-user-circle"></i> <?= e($user['full_name']) ?>
                            </a>
                            <a href="<?= APP_URL ?>/public/logout.php" class="btn btn-ghost" style="padding: 0.5rem;" title="Logout">
                                <i class="fa-solid fa-arrow-right-from-bracket"></i>
                            </a>
                        </div>
                    <?php else: ?>
                        <!-- Guest Login & Sign Up -->
                        <a href="<?= APP_URL ?>/public/login.php" class="btn btn-ghost">Log In</a>
                        <a href="<?= APP_URL ?>/public/register.php" class="btn btn-primary">Get Started</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </header>
    <div style="padding-top: 80px;"></div>

    <script>
    // Mobile Drawer Toggle Handler
    const mobileToggle = document.getElementById('mobileToggle');
    const navMenu = document.getElementById('navMenu');
    const toggleIcon = document.getElementById('toggleIcon');

    if (mobileToggle && navMenu) {
        mobileToggle.addEventListener('click', () => {
            navMenu.classList.toggle('active');
            if (navMenu.classList.contains('active')) {
                toggleIcon.className = 'fa-solid fa-xmark';
            } else {
                toggleIcon.className = 'fa-solid fa-bars';
            }
        });
    }
    </script>