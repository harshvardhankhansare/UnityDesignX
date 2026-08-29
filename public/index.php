<?php
require_once __DIR__ . '/../includes/header.php';

// Fetch Featured Products from Database via PDO
$db = get_db();
$stmt = $db->query("
    SELECT p.*, c.category_name 
    FROM products p
    JOIN categories c ON p.category_id = c.category_id
    WHERE p.is_active = 1
    ORDER BY p.is_featured DESC, p.created_at DESC
    LIMIT 6
");
$featuredProducts = $stmt->fetchAll();
?>

<!-- Hero Banner Section -->
<section style="position: relative; padding: 6rem 0 5rem; overflow: hidden;">
    <div class="container" style="display: grid; grid-template-columns: 1fr 1fr; gap: 4rem; align-items: center;">
        <div>
            <div style="display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.4rem 1rem; border-radius: var(--radius-full); background: rgba(212, 175, 55, 0.1); border: 1px solid rgba(212, 175, 55, 0.3); font-size: 0.85rem; font-weight: 600; color: var(--accent-gold); margin-bottom: 1.5rem;">
                <i class="fa-solid fa-sparkles"></i> INTERIOR COLLECTION 2026
            </div>
            <h1 style="font-size: 3.5rem; letter-spacing: -1px; margin-bottom: 1.5rem; line-height: 1.1;">
                The Art of <span class="text-gradient">Fine Living</span>
            </h1>
            <p style="font-size: 1.1rem; color: var(--text-secondary); margin-bottom: 2.5rem; max-width: 520px; line-height: 1.7;">
                Architectural space planning, bespoke cabinetry, luxury furniture catalog, and interactive 3D spatial design tools tailored for modern aesthetics.
            </p>
            <div style="display: flex; gap: 1.25rem; flex-wrap: wrap;">
                <a href="<?= APP_URL ?>/public/products.php" class="btn btn-primary">
                    Explore Catalog <i class="fa-solid fa-arrow-right"></i>
                </a>
                <a href="<?= APP_URL ?>/public/designs.php" class="btn btn-secondary">
                    <i class="fa-solid fa-cube"></i> Launch 3D Planner
                </a>
            </div>

            <!-- Trust Stats -->
            <div style="display: flex; gap: 3rem; margin-top: 3.5rem; padding-top: 2rem; border-top: 1px solid var(--border-subtle);">
                <div>
                    <h3 style="font-size: 2rem; color: var(--accent-gold);">500+</h3>
                    <p style="font-size: 0.85rem; color: var(--text-secondary);">Projects Completed</p>
                </div>
                <div>
                    <h3 style="font-size: 2rem; color: var(--accent-gold);">100%</h3>
                    <p style="font-size: 0.85rem; color: var(--text-secondary);">Dynamic Catalog</p>
                </div>
                <div>
                    <h3 style="font-size: 2rem; color: var(--accent-gold);">3D</h3>
                    <p style="font-size: 0.85rem; color: var(--text-secondary);">Raycasting Engine</p>
                </div>
            </div>
        </div>

        <!-- Hero Graphic Card -->
        <div style="position: relative;">
            <div style="position: absolute; inset: -20px; background: radial-gradient(circle, rgba(212,175,55,0.15) 0%, transparent 70%); border-radius: 50%; pointer-events: none;"></div>
            <div style="background: var(--bg-card); border: 1px solid var(--border-subtle); border-radius: var(--radius-lg); padding: 1.5rem; box-shadow: var(--shadow-lg);">
                <img src="<?= APP_URL ?>/assets/images/homeimg.png" alt="Interior Design Fine Living" style="width: 100%; height: 420px; object-fit: cover; border-radius: var(--radius-md);" />
            </div>
        </div>
    </div>
</section>

<!-- Specialized Services Overview -->
<section class="section-padding" style="background: var(--bg-surface);">
    <div class="container">
        <div style="text-align: center; max-width: 600px; margin: 0 auto 3.5rem;">
            <h2 style="font-size: 2.25rem; margin-bottom: 0.75rem;">Specialized <span class="text-accent">Design Solutions</span></h2>
            <p style="color: var(--text-secondary);">Tailored interior architecture, remodeling, and acoustic spatial engineering.</p>
        </div>

        <div class="grid-3">
            <div class="product-card" style="padding: 2rem; text-align: center;">
                <div style="width: 60px; height: 60px; border-radius: var(--radius-md); background: rgba(212, 175, 55, 0.1); border: 1px solid rgba(212, 175, 55, 0.3); display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem; font-size: 1.5rem; color: var(--accent-gold);">
                    <i class="fa-solid fa-compass-drafting"></i>
                </div>
                <h3 style="font-size: 1.25rem; margin-bottom: 0.75rem;">Specialized Space Planning</h3>
                <p style="font-size: 0.9rem; color: var(--text-secondary); line-height: 1.6;">Eco-friendly materials, universal design principles, and custom furniture layouts crafted for optimal space utilization.</p>
            </div>

            <div class="product-card" style="padding: 2rem; text-align: center;">
                <div style="width: 60px; height: 60px; border-radius: var(--radius-md); background: rgba(212, 175, 55, 0.1); border: 1px solid rgba(212, 175, 55, 0.3); display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem; font-size: 1.5rem; color: var(--accent-gold);">
                    <i class="fa-solid fa-hammer"></i>
                </div>
                <h3 style="font-size: 1.25rem; margin-bottom: 0.75rem;">Renovation & Remodeling</h3>
                <p style="font-size: 0.9rem; color: var(--text-secondary); line-height: 1.6;">End-to-end project management, material sourcing, cabinetry installation, and contractor coordination.</p>
            </div>

            <div class="product-card" style="padding: 2rem; text-align: center;">
                <div style="width: 60px; height: 60px; border-radius: var(--radius-md); background: rgba(212, 175, 55, 0.1); border: 1px solid rgba(212, 175, 55, 0.3); display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem; font-size: 1.5rem; color: var(--accent-gold);">
                    <i class="fa-solid fa-cube"></i>
                </div>
                <h3 style="font-size: 1.25rem; margin-bottom: 0.75rem;">Interactive 3D Room Raycasting</h3>
                <p style="font-size: 0.9rem; color: var(--text-secondary); line-height: 1.6;">Experience interactive 3D drag & drop furniture placement directly inside your browser with Three.js engine.</p>
            </div>
        </div>
    </div>
</section>

<!-- Featured Products Showcase (Database Driven) -->
<section class="section-padding">
    <div class="container">
        <div style="display: flex; align-items: flex-end; justify-content: space-between; margin-bottom: 3rem;">
            <div>
                <h2 style="font-size: 2.25rem;">Featured <span class="text-accent">Furniture Catalog</span></h2>
                <p style="color: var(--text-secondary); margin-top: 0.5rem;">Curated collection fetched dynamically from database</p>
            </div>
            <a href="<?= APP_URL ?>/public/products.php" class="btn btn-secondary">
                View All Products <i class="fa-solid fa-chevron-right"></i>
            </a>
        </div>

        <div class="grid-3">
            <?php foreach ($featuredProducts as $product): ?>
                <div class="product-card">
                    <div class="product-img-wrapper">
                        <span class="product-category-badge"><?= e($product['category_name']) ?></span>
                        <img src="<?= APP_URL ?>/<?= e($product['main_image']) ?>" alt="<?= e($product['title']) ?>" />
                    </div>
                    <div class="product-content">
                        <h3 class="product-title"><?= e($product['title']) ?></h3>
                        <p class="product-desc"><?= e($product['description']) ?></p>
                        <div class="product-footer">
                            <span class="product-price"><?= format_price($product['price']) ?></span>
                            <a href="<?= APP_URL ?>/public/products.php?id=<?= $product['product_id'] ?>" class="btn btn-secondary" style="padding: 0.5rem 1rem; font-size: 0.85rem;">
                                View Details
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
