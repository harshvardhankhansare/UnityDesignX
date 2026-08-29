<?php
require_once __DIR__ . '/../includes/header.php';

// Initial server-side query for fallback / SEO
$db = get_db();
$catStmt = $db->query("SELECT category_id, category_name, slug FROM categories ORDER BY category_id ASC");
$categories = $catStmt->fetchAll();

$selectedCategory = sanitize_input($_GET['category'] ?? 'all');
$selectedSearch   = sanitize_input($_GET['search'] ?? '');
?>

<main class="section-padding" style="padding-top: 3rem;">
    <div class="container">
        <!-- Page Title Header -->
        <div style="text-align: center; max-width: 650px; margin: 0 auto 3rem;">
            <h1 style="font-size: 2.75rem; margin-bottom: 0.75rem;">
                Furniture & <span class="text-gradient">Decor Catalog</span>
            </h1>
            <p style="color: var(--text-secondary); font-size: 1.05rem;">
                Browse dynamic interior furniture items, architectural lighting, and storage solutions.
            </p>
        </div>

        <!-- Catalog Toolbar & Filters -->
        <div class="catalog-toolbar">
            <!-- Category Filter Tabs -->
            <div class="filter-pills" id="categoryFilterContainer">
                <button type="button" class="filter-pill <?= ($selectedCategory === 'all') ? 'active' : '' ?>" data-category="all">
                    All Products
                </button>
                <?php foreach ($categories as $cat): ?>
                    <button type="button" 
                            class="filter-pill <?= ($selectedCategory === $cat['slug']) ? 'active' : '' ?>" 
                            data-category="<?= e($cat['slug']) ?>">
                        <?= e($cat['category_name']) ?>
                    </button>
                <?php endforeach; ?>
            </div>

            <!-- Search & Sort Controls -->
            <div style="display: flex; gap: 1rem; flex-wrap: wrap; align-items: center; justify-content: flex-end; flex-grow: 1;">
                <div style="position: relative; min-width: 220px; flex-grow: 1; max-width: 320px;">
                    <i class="fa-solid fa-magnifying-glass" style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: var(--text-muted);"></i>
                    <input type="text" 
                           id="searchInput" 
                           class="form-control" 
                           placeholder="Search catalog..." 
                           value="<?= e($selectedSearch) ?>"
                           style="padding-left: 2.75rem;" />
                </div>

                <select id="sortSelect" class="form-control" style="width: auto; cursor: pointer;">
                    <option value="newest">Newest First</option>
                    <option value="price_low">Price: Low to High</option>
                    <option value="price_high">Price: High to Low</option>
                    <option value="title">Title: A-Z</option>
                </select>
            </div>
        </div>

        <!-- Dynamic Product Grid Container -->
        <div id="productsGrid" class="grid-3">
            <div style="grid-column: 1 / -1; text-align: center; padding: 4rem 0; color: var(--text-muted);">
                <i class="fa-solid fa-circle-notch fa-spin" style="font-size: 2.5rem; margin-bottom: 1rem; color: var(--accent-gold);"></i>
                <p>Loading dynamic catalog...</p>
            </div>
        </div>
    </div>
</main>

<script>
let currentCategory = '<?= e($selectedCategory) ?>';
let currentSearch = '<?= e($selectedSearch) ?>';
let currentSort = 'newest';

async function fetchProducts() {
    const grid = document.getElementById('productsGrid');
    grid.innerHTML = `
        <div style="grid-column: 1 / -1; text-align: center; padding: 4rem 0; color: var(--text-muted);">
            <i class="fa-solid fa-circle-notch fa-spin" style="font-size: 2.5rem; margin-bottom: 1rem; color: var(--accent-gold);"></i>
            <p>Loading catalog items...</p>
        </div>
    `;

    try {
        const queryParams = new URLSearchParams({
            category: currentCategory,
            search: currentSearch,
            sort: currentSort
        });

        const response = await fetch(`<?= APP_URL ?>/api/products/list.php?${queryParams.toString()}`);
        const data = await response.json();

        if (data.success && data.products.length > 0) {
            grid.innerHTML = data.products.map(p => `
                <div class="product-card">
                    <div class="product-img-wrapper">
                        <span class="product-category-badge">${escapeHTML(p.category_name)}</span>
                        <img src="<?= APP_URL ?>/${escapeHTML(p.main_image)}" alt="${escapeHTML(p.title)}" loading="lazy" />
                    </div>
                    <div class="product-content">
                        <h3 class="product-title">${escapeHTML(p.title)}</h3>
                        <p class="product-desc">${escapeHTML(p.description)}</p>
                        <div class="product-footer">
                            <span class="product-price">₹${parseFloat(p.price).toLocaleString('en-IN', {minimumFractionDigits: 2})}</span>
                            <button onclick="addToCart(${p.product_id})" class="btn btn-primary" style="padding: 0.5rem 1rem; font-size: 0.85rem;">
                                <i class="fa-solid fa-cart-plus"></i> Add to Cart
                            </button>
                        </div>
                    </div>
                </div>
            `).join('');
        } else {
            grid.innerHTML = `
                <div style="grid-column: 1 / -1; text-align: center; padding: 4rem 0; background: var(--bg-card); border-radius: var(--radius-lg); border: 1px solid var(--border-subtle);">
                    <i class="fa-solid fa-box-open" style="font-size: 3rem; color: var(--text-muted); margin-bottom: 1rem;"></i>
                    <h3 style="margin-bottom: 0.5rem;">No Products Found</h3>
                    <p style="color: var(--text-secondary);">Try adjusting your search criteria or category filter tabs.</p>
                </div>
            `;
        }
    } catch (error) {
        console.error('Fetch products error:', error);
        grid.innerHTML = `
            <div style="grid-column: 1 / -1; text-align: center; padding: 3rem 0; color: #f87171;">
                <p>Failed to load products catalog. Please refresh the page.</p>
            </div>
        `;
    }
}

function escapeHTML(str) {
    if (!str) return '';
    return str.replace(/[&<>'"]/g, 
        tag => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', "'": '&#39;', '"': '&quot;' }[tag] || tag)
    );
}

// Category Tab Clicks
document.getElementById('categoryFilterContainer').addEventListener('click', function(e) {
    const btn = e.target.closest('.filter-pill');
    if (!btn) return;
    
    document.querySelectorAll('.filter-pill').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    
    currentCategory = btn.dataset.category;
    fetchProducts();
});

// Search Debounce
let searchTimeout;
document.getElementById('searchInput').addEventListener('input', function(e) {
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(() => {
        currentSearch = e.target.value.trim();
        fetchProducts();
    }, 350);
});

// Sort Selector
document.getElementById('sortSelect').addEventListener('change', function(e) {
    currentSort = e.target.value;
    fetchProducts();
});

// Dummy Add To Cart Helper for Phase 6 (Phase 8 will connect full cart API)
function addToCart(productId) {
    alert('Product ID ' + productId + ' will be added to cart via Cart API');
}

// Initial Fetch
document.addEventListener('DOMContentLoaded', fetchProducts);
</script>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
