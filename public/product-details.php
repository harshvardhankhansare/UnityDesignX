<?php
require_once __DIR__ . '/../includes/header.php';

$productId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($productId <= 0) {
    header('Location: ' . APP_URL . '/public/products.php');
    exit;
}

$db = get_db();
$stmt = $db->prepare("
    SELECT p.*, c.category_name, c.slug AS category_slug
    FROM products p
    JOIN categories c ON p.category_id = c.category_id
    WHERE p.product_id = :id AND p.is_active = 1
");
$stmt->execute([':id' => $productId]);
$product = $stmt->fetch();

if (!$product) {
    echo '<div class="container section-padding text-center"><h2>Product Not Found</h2><a href="' . APP_URL . '/public/products.php" class="btn btn-primary mt-3">Back to Catalog</a></div>';
    require_once __DIR__ . '/../includes/footer.php';
    exit;
}

// Fetch related items
$relStmt = $db->prepare("
    SELECT p.*, c.category_name
    FROM products p
    JOIN categories c ON p.category_id = c.category_id
    WHERE p.category_id = :cat_id AND p.product_id != :prod_id AND p.is_active = 1
    LIMIT 3
");
$relStmt->execute([':cat_id' => $product['category_id'], ':prod_id' => $product['product_id']]);
$related = $relStmt->fetchAll();
?>

<main class="section-padding" style="padding-top: 3rem;">
    <div class="container">
        <!-- Breadcrumb Navigation -->
        <div style="margin-bottom: 2rem; font-size: 0.9rem; color: var(--text-secondary);">
            <a href="<?= APP_URL ?>/public/index.php">Home</a> &nbsp;/&nbsp;
            <a href="<?= APP_URL ?>/public/products.php">Catalog</a> &nbsp;/&nbsp;
            <a href="<?= APP_URL ?>/public/products.php?category=<?= e($product['category_slug']) ?>"><?= e($product['category_name']) ?></a> &nbsp;/&nbsp;
            <span class="text-accent"><?= e($product['title']) ?></span>
        </div>

        <!-- Product Main Showcase Grid -->
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 3.5rem; margin-bottom: 5rem;" class="hero-grid">
            <!-- Product Image Showcase -->
            <div style="background: var(--bg-card); border: 1px solid var(--border-subtle); border-radius: var(--radius-lg); padding: 1.5rem; position: relative;">
                <span class="product-category-badge" style="top: 2rem; left: 2rem;"><?= e($product['category_name']) ?></span>
                <img src="<?= APP_URL ?>/<?= e($product['main_image']) ?>" alt="<?= e($product['title']) ?>" style="width: 100%; height: 440px; object-fit: cover; border-radius: var(--radius-md);" />
            </div>

            <!-- Product Information & Actions -->
            <div style="display: flex; flex-direction: column; justify-content: center;">
                <h1 style="font-size: 2.75rem; margin-bottom: 1rem; line-height: 1.15;"><?= e($product['title']) ?></h1>
                
                <div style="display: flex; align-items: center; gap: 1.5rem; margin-bottom: 1.5rem;">
                    <span style="font-family: var(--font-heading); font-size: 2rem; font-weight: 800; color: var(--accent-gold);">
                        <?= format_price($product['price']) ?>
                    </span>
                    <span style="padding: 0.35rem 0.85rem; border-radius: var(--radius-full); font-size: 0.8rem; font-weight: 600; background: rgba(16, 185, 129, 0.15); color: #34d399; border: 1px solid rgba(16, 185, 129, 0.3);">
                        <i class="fa-solid fa-circle-check"></i> In Stock (<?= $product['stock_quantity'] ?> available)
                    </span>
                </div>

                <p style="color: var(--text-secondary); font-size: 1.05rem; line-height: 1.7; margin-bottom: 2.5rem; padding-bottom: 2rem; border-bottom: 1px solid var(--border-subtle);">
                    <?= e($product['description']) ?>
                </p>

                <!-- Add to Cart Form -->
                <form id="addToCartForm" style="display: flex; gap: 1rem; align-items: center; flex-wrap: wrap;">
                    <input type="hidden" name="product_id" value="<?= $product['product_id'] ?>" />
                    
                    <div style="display: flex; align-items: center; background: var(--bg-primary); border: 1px solid var(--border-subtle); border-radius: var(--radius-md); padding: 0.25rem;">
                        <button type="button" onclick="adjustQty(-1)" style="background: transparent; border: none; color: var(--text-primary); width: 36px; height: 36px; cursor: pointer; font-size: 1.1rem;">-</button>
                        <input type="number" id="qtyInput" name="quantity" value="1" min="1" max="<?= $product['stock_quantity'] ?>" style="width: 50px; text-align: center; background: transparent; border: none; color: var(--text-primary); font-weight: 700; font-size: 1rem;" readonly />
                        <button type="button" onclick="adjustQty(1)" style="background: transparent; border: none; color: var(--text-primary); width: 36px; height: 36px; cursor: pointer; font-size: 1.1rem;">+</button>
                    </div>

                    <button type="submit" id="addCartBtn" class="btn btn-primary" style="flex-grow: 1; padding: 0.9rem 2rem; font-size: 1.05rem;">
                        <i class="fa-solid fa-cart-plus"></i> Add to Cart
                    </button>
                </form>

                <div id="cartAlert" class="alert-banner" style="margin-top: 1.5rem;"></div>
            </div>
        </div>

        <!-- Related Products Section -->
        <?php if (!empty($related)): ?>
            <div style="padding-top: 3rem; border-top: 1px solid var(--border-subtle);">
                <h2 style="font-size: 2rem; margin-bottom: 2rem;">Related <span class="text-accent">Products</span></h2>
                <div class="grid-3">
                    <?php foreach ($related as $rel): ?>
                        <div class="product-card">
                            <div class="product-img-wrapper">
                                <span class="product-category-badge"><?= e($rel['category_name']) ?></span>
                                <img src="<?= APP_URL ?>/<?= e($rel['main_image']) ?>" alt="<?= e($rel['title']) ?>" />
                            </div>
                            <div class="product-content">
                                <h3 class="product-title"><?= e($rel['title']) ?></h3>
                                <div class="product-footer">
                                    <span class="product-price"><?= format_price($rel['price']) ?></span>
                                    <a href="<?= APP_URL ?>/public/product-details.php?id=<?= $rel['product_id'] ?>" class="btn btn-secondary" style="padding: 0.5rem 1rem; font-size: 0.85rem;">
                                        View Details
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</main>

<script>
function adjustQty(delta) {
    const qtyInput = document.getElementById('qtyInput');
    let val = parseInt(qtyInput.value) + delta;
    if (val < 1) val = 1;
    if (val > <?= $product['stock_quantity'] ?>) val = <?= $product['stock_quantity'] ?>;
    qtyInput.value = val;
}

document.getElementById('addToCartForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    const alertBox = document.getElementById('cartAlert');
    const btn = document.getElementById('addCartBtn');
    
    alertBox.style.display = 'none';
    btn.disabled = true;
    btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Adding...';

    const productId = <?= $product['product_id'] ?>;
    const quantity = parseInt(document.getElementById('qtyInput').value);

    try {
        const response = await fetch('<?= APP_URL ?>/api/cart/add.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ product_id: productId, quantity: quantity })
        });

        const data = await response.json();

        if (data.success) {
            alertBox.className = 'alert-banner alert-success';
            alertBox.innerText = data.message;
            alertBox.style.display = 'block';
            
            // Update Header Cart Badge dynamically
            const headerBadge = document.getElementById('headerCartBadge');
            if (headerBadge) {
                headerBadge.innerText = data.cart_count;
            }
        } else {
            alertBox.className = 'alert-banner alert-error';
            alertBox.innerText = data.error || 'Failed to add item to cart';
            alertBox.style.display = 'block';
        }
    } catch (err) {
        alertBox.className = 'alert-banner alert-error';
        alertBox.innerText = 'Please log in to add items to your shopping cart.';
        alertBox.style.display = 'block';
    } finally {
        btn.disabled = false;
        btn.innerHTML = '<i class="fa-solid fa-cart-plus"></i> Add to Cart';
    }
});
</script>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
