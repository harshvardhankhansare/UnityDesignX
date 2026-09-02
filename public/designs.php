<?php
require_once __DIR__ . '/../includes/header.php';
?>

<main class="section-padding" style="padding-top: 3rem;">
    <div class="container">
        <!-- Page Title Header -->
        <div style="text-align: center; max-width: 700px; margin: 0 auto 3rem;">
            <div style="display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.4rem 1rem; border-radius: var(--radius-full); background: rgba(212, 175, 55, 0.1); border: 1px solid rgba(212, 175, 55, 0.3); font-size: 0.85rem; font-weight: 600; color: var(--accent-gold); margin-bottom: 1rem;">
                <i class="fa-solid fa-cube"></i> WEBGL INTERACTIVE CANVAS
            </div>
            <h1 style="font-size: 2.75rem; margin-bottom: 0.75rem;">
                3D Spatial Room <span class="text-gradient">Planner</span>
            </h1>
            <p style="color: var(--text-secondary); font-size: 1.05rem;">
                Experience real-time 3D furniture raycasting, interactive object placement, and spatial room customization directly in your browser.
            </p>
        </div>

        <!-- 3D WebGL Raycasting Viewport Box -->
        <div style="background: var(--bg-card); border: 1px solid var(--border-subtle); border-radius: var(--radius-lg); overflow: hidden; box-shadow: var(--shadow-lg); margin-bottom: 4rem;">
            <div style="padding: 1rem 1.5rem; background: rgba(11, 13, 17, 0.9); border-bottom: 1px solid var(--border-subtle); display: flex; align-items: center; justify-content: space-between;">
                <div style="display: flex; align-items: center; gap: 0.75rem;">
                    <span style="width: 12px; height: 12px; border-radius: 50%; background: #ef4444;"></span>
                    <span style="width: 12px; height: 12px; border-radius: 50%; background: #f59e0b;"></span>
                    <span style="width: 12px; height: 12px; border-radius: 50%; background: #10b981;"></span>
                    <span style="margin-left: 0.5rem; font-family: monospace; font-size: 0.85rem; color: var(--text-secondary);">3D_RAYCASTING_CANVAS.ENGINE</span>
                </div>
                <div style="font-size: 0.85rem; color: var(--accent-gold); font-weight: 600;">
                    <i class="fa-solid fa-hand-pointer"></i> Click & Drag 3D Models
                </div>
            </div>

            <!-- Embedded 3D Canvas Frame -->
            <div style="position: relative; width: 100%; height: 600px; background: #000;">
                <iframe src="<?= APP_URL ?>/InteriorDesign/threejs-raycasting-main/src/index.html" 
                        style="width: 100%; height: 100%; border: none;" 
                        title="Interactive 3D Three.js Room Planner">
                </iframe>
            </div>
        </div>

        <!-- Design Portfolio Collections Grid -->
        <div style="text-align: center; max-width: 600px; margin: 0 auto 3rem;">
            <h2 style="font-size: 2.25rem; margin-bottom: 0.5rem;">Interior <span class="text-accent">Design Portfolio</span></h2>
            <p style="color: var(--text-secondary);">Explore curated living room, bedroom, office, and kitchen interior concepts.</p>
        </div>

        <div class="grid-3">
            <div class="product-card">
                <div class="product-img-wrapper" style="height: 280px;">
                    <span class="product-category-badge">Living Room</span>
                    <img src="<?= APP_URL ?>/Categories/product category/FURNITURE/Beds/Images/bed1.jpg" alt="Living Concept" />
                </div>
                <div class="product-content">
                    <h3 class="product-title">Modern Minimalist Living Concept</h3>
                    <p class="product-desc">Open-plan spatial architectural design featuring natural oak wood cladding and recessed warm LED channels.</p>
                </div>
            </div>

            <div class="product-card">
                <div class="product-img-wrapper" style="height: 280px;">
                    <span class="product-category-badge">Executive Office</span>
                    <img src="<?= APP_URL ?>/Categories/product category/FURNITURE/Cabinetry/Images/cabin6.jpg" alt="Executive Office" />
                </div>
                <div class="product-content">
                    <h3 class="product-title">Nordic Executive Office Workspace</h3>
                    <p class="product-desc">Acoustic paneling and custom display cabinetry built for focus, productivity, and modern ergonomics.</p>
                </div>
            </div>

            <div class="product-card">
                <div class="product-img-wrapper" style="height: 280px;">
                    <span class="product-category-badge">Master Bedroom</span>
                    <img src="<?= APP_URL ?>/Categories/product category/FURNITURE/Beds/Images/bed7.jpg" alt="Master Bedroom" />
                </div>
                <div class="product-content">
                    <h3 class="product-title">Luxury Velvet Suite Interior</h3>
                    <p class="product-desc">Bespoke upholstered headboards, brushed brass metallic accents, and ambient smart lighting fixtures.</p>
                </div>
            </div>
        </div>
    </div>
</main>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
