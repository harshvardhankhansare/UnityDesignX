<?php
/**
 * Admin Product Management Page (CRUD)
 * UnityDesignX Platform — Phase 10
 */
require_once __DIR__ . '/../includes/header.php';
require_admin();

$db = get_db();
$message = '';
$error = '';

// ── Handle Product Save (Create / Update) ─────────────────────
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_product'])) {
    $productId    = isset($_POST['product_id']) && !empty($_POST['product_id']) ? (int)$_POST['product_id'] : null;
    $title        = sanitize_input($_POST['title'] ?? '');
    $categoryId   = (int)($_POST['category_id'] ?? 0);
    $price        = (float)($_POST['price'] ?? 0);
    $stockQty     = (int)($_POST['stock_quantity'] ?? 0);
    $mainImage    = sanitize_input($_POST['main_image'] ?? '');
    $description = sanitize_input($_POST['description'] ?? '');

    if (!$title || !$categoryId || $price <= 0) {
        $error = 'Title, Category, and a valid Price are required.';
    } else {
        try {
            if ($productId) {
                // Update
                $stmt = $db->prepare("
                    UPDATE products 
                    SET title = :title, category_id = :cat, price = :price, stock_quantity = :stock, main_image = :img, description = :desc
                    WHERE product_id = :pid
                ");
                $stmt->execute([
                    ':title' => $title, ':cat' => $categoryId, ':price' => $price,
                    ':stock' => $stockQty, ':img' => $mainImage, ':desc' => $description,
                    ':pid'   => $productId
                ]);
                $message = "Product \"{$title}\" updated successfully.";
            } else {
                // Insert
                $stmt = $db->prepare("
                    INSERT INTO products (title, category_id, price, stock_quantity, main_image, description, created_at)
                    VALUES (:title, :cat, :price, :stock, :img, :desc, NOW())
                ");
                $stmt->execute([
                    ':title' => $title, ':cat' => $categoryId, ':price' => $price,
                    ':stock' => $stockQty, ':img' => $mainImage, ':desc' => $description
                ]);
                $message = "Product \"{$title}\" created successfully.";
            }
        } catch (PDOException $e) {
            $error = 'Database error: ' . $e->getMessage();
        }
    }
}

// ── Handle Product Delete ─────────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_product'])) {
    $delId = (int)($_POST['delete_product_id'] ?? 0);
    if ($delId > 0) {
        try {
            $stmt = $db->prepare("DELETE FROM products WHERE product_id = :pid");
            $stmt->execute([':pid' => $delId]);
            $message = "Product deleted successfully.";
        } catch (PDOException $e) {
            $error = "Cannot delete product (it may be linked to existing orders).";
        }
    }
}

// Fetch all products & categories
$categories = $db->query("SELECT * FROM categories ORDER BY category_name ASC")->fetchAll();
$products = $db->query("
    SELECT p.*, c.category_name 
    FROM products p 
    JOIN categories c ON p.category_id = c.category_id 
    ORDER BY p.product_id DESC
")->fetchAll();
?>

<style>
.admin-wrap { max-width: 1200px; margin: 0 auto; padding: 2.5rem 1.5rem 4rem; }

.modal-backdrop {
  display: none;
  position: fixed;
  inset: 0;
  background: rgba(0,0,0,0.7);
  backdrop-filter: blur(4px);
  z-index: 999;
  align-items: center;
  justify-content: center;
}
.modal-backdrop.active { display: flex; }

.modal-card {
  background: var(--bg-card);
  border: 1px solid var(--border-subtle);
  border-radius: var(--radius-lg);
  width: 100%;
  max-width: 580px;
  padding: 2rem;
  box-shadow: 0 20px 40px rgba(0,0,0,0.5);
}

.table-card {
  background: var(--bg-card);
  border: 1px solid var(--border-subtle);
  border-radius: var(--radius-lg);
  padding: 1.5rem;
  margin-top: 1.5rem;
}

.prod-table { width: 100%; border-collapse: collapse; font-size: 0.88rem; }
.prod-table th, .prod-table td { padding: 0.9rem 0.75rem; text-align: left; border-bottom: 1px solid var(--border-subtle); }
.prod-table th { color: var(--text-muted); font-size: 0.75rem; text-transform: uppercase; }

.form-group { display: flex; flex-direction: column; gap: 5px; margin-bottom: 1rem; }
.form-group label { font-size: 0.8rem; font-weight: 600; color: var(--text-secondary); }
.form-group input, .form-group select, .form-group textarea {
  padding: 0.7rem 1rem;
  background: var(--bg-primary);
  border: 1px solid var(--border-subtle);
  border-radius: var(--radius-md);
  color: var(--text-primary);
  font-family: var(--font-body);
}

.alert-msg { padding: 0.85rem 1.25rem; border-radius: var(--radius-md); font-size: 0.9rem; margin-bottom: 1.5rem; }
.alert-success { background: rgba(16,185,129,0.15); border: 1px solid rgba(16,185,129,0.3); color: #34d399; }
.alert-danger { background: rgba(239,68,68,0.15); border: 1px solid rgba(239,68,68,0.3); color: #f87171; }
</style>

<main>
  <div class="admin-wrap">
    <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:1rem; margin-bottom: 1.5rem;">
      <div>
        <h1 style="font-size: 2.2rem; margin-bottom: 0.25rem;">
          Product <span class="text-accent">Catalog Management</span>
        </h1>
        <p style="color: var(--text-secondary);">Create, update, or remove furniture items from the store.</p>
      </div>
      <div>
        <button class="btn btn-primary" onclick="openModal()"><i class="fa-solid fa-plus"></i> Add New Product</button>
      </div>
    </div>

    <?php if ($message): ?>
      <div class="alert-msg alert-success"><i class="fa-solid fa-circle-check"></i> <?= e($message) ?></div>
    <?php endif; ?>
    <?php if ($error): ?>
      <div class="alert-msg alert-danger"><i class="fa-solid fa-circle-exclamation"></i> <?= e($error) ?></div>
    <?php endif; ?>

    <!-- Product Table -->
    <div class="table-card">
      <div style="overflow-x:auto;">
        <table class="prod-table">
          <thead>
            <tr>
              <th>Image</th>
              <th>Product Title</th>
              <th>Category</th>
              <th>Price</th>
              <th>Stock</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($products as $p): ?>
              <tr>
                <td>
                  <img src="<?= APP_URL ?>/<?= e($p['main_image']) ?>" alt="<?= e($p['title']) ?>" 
                       style="width:48px;height:48px;object-fit:cover;border-radius:var(--radius-md);" 
                       onerror="this.src='https://via.placeholder.com/48'" />
                </td>
                <td style="font-weight:700;"><?= e($p['title']) ?></td>
                <td><span style="font-size:0.78rem;color:var(--accent-gold);font-weight:600;"><?= e($p['category_name']) ?></span></td>
                <td style="font-weight:700;"><?= format_price($p['price']) ?></td>
                <td>
                  <?php if ($p['stock_quantity'] > 0): ?>
                    <span style="color:#10b981;font-weight:600;"><?= $p['stock_quantity'] ?> in stock</span>
                  <?php else: ?>
                    <span style="color:#ef4444;font-weight:600;">Out of Stock</span>
                  <?php endif; ?>
                </td>
                <td>
                  <div style="display:flex;gap:8px;">
                    <button class="btn btn-secondary" style="padding:0.4rem 0.75rem;font-size:0.8rem;" 
                            onclick='editProduct(<?= json_encode($p) ?>)'>
                      <i class="fa-solid fa-pen-to-square"></i> Edit
                    </button>
                    <form method="POST" onsubmit="return confirm('Delete this product?');" style="display:inline;">
                      <input type="hidden" name="delete_product_id" value="<?= $p['product_id'] ?>" />
                      <button type="submit" name="delete_product" class="btn btn-ghost" style="padding:0.4rem 0.75rem;font-size:0.8rem;color:#ef4444;">
                        <i class="fa-solid fa-trash"></i>
                      </button>
                    </form>
                  </div>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</main>

<!-- Create / Edit Modal -->
<div class="modal-backdrop" id="productModal">
  <div class="modal-card">
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1.25rem;">
      <h3 id="modalTitle" style="font-size:1.25rem;font-weight:700;">Add New Product</h3>
      <button onclick="closeModal()" style="background:transparent;border:none;color:var(--text-muted);font-size:1.2rem;cursor:pointer;">
        <i class="fa-solid fa-xmark"></i>
      </button>
    </div>

    <form method="POST">
      <input type="hidden" name="save_product" value="1" />
      <input type="hidden" name="product_id" id="formProdId" value="" />

      <div class="form-group">
        <label>Product Title *</label>
        <input type="text" name="title" id="formTitle" required placeholder="Modern Velvet Armchair" />
      </div>

      <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
        <div class="form-group">
          <label>Category *</label>
          <select name="category_id" id="formCat" required>
            <?php foreach ($categories as $c): ?>
              <option value="<?= $c['category_id'] ?>"><?= e($c['category_name']) ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="form-group">
          <label>Price (₹) *</label>
          <input type="number" step="0.01" name="price" id="formPrice" required placeholder="12500" />
        </div>
      </div>

      <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
        <div class="form-group">
          <label>Stock Quantity</label>
          <input type="number" name="stock_quantity" id="formStock" value="10" />
        </div>
        <div class="form-group">
          <label>Image Path</label>
          <input type="text" name="main_image" id="formImg" placeholder="Categories/product category/FURNITURE/Beds/Images/bed1.jpg" />
        </div>
      </div>

      <div class="form-group">
        <label>Description</label>
        <textarea name="description" id="formDesc" rows="3" placeholder="Detailed product description..."></textarea>
      </div>

      <div style="display:flex;justify-content:flex-end;gap:10px;margin-top:1.5rem;">
        <button type="button" class="btn btn-ghost" onclick="closeModal()">Cancel</button>
        <button type="submit" class="btn btn-primary">Save Product</button>
      </div>
    </form>
  </div>
</div>

<script>
function openModal() {
  document.getElementById('modalTitle').innerText = 'Add New Product';
  document.getElementById('formProdId').value = '';
  document.getElementById('formTitle').value = '';
  document.getElementById('formPrice').value = '';
  document.getElementById('formStock').value = '10';
  document.getElementById('formImg').value = '';
  document.getElementById('formDesc').value = '';
  document.getElementById('productModal').classList.add('active');
}

function closeModal() {
  document.getElementById('productModal').classList.remove('active');
}

function editProduct(p) {
  document.getElementById('modalTitle').innerText = 'Edit Product #' + p.product_id;
  document.getElementById('formProdId').value = p.product_id;
  document.getElementById('formTitle').value = p.title;
  document.getElementById('formCat').value = p.category_id;
  document.getElementById('formPrice').value = p.price;
  document.getElementById('formStock').value = p.stock_quantity;
  document.getElementById('formImg').value = p.main_image;
  document.getElementById('formDesc').value = p.description || '';
  document.getElementById('productModal').classList.add('active');
}
</script>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
