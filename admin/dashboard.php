<?php
/**
 * Admin Panel Dashboard
 * UnityDesignX Platform — Phase 10
 */
require_once __DIR__ . '/../includes/header.php';
require_admin(); // Enforces Admin role

$db = get_db();

// ── Metrics ───────────────────────────────────────────────────
$totalSales = (float)($db->query("SELECT SUM(total_amount) FROM orders WHERE status != 'cancelled'")->fetchColumn() ?: 0);
$totalOrders = (int)$db->query("SELECT COUNT(*) FROM orders")->fetchColumn();
$totalProducts = (int)$db->query("SELECT COUNT(*) FROM products")->fetchColumn();
$totalUsers = (int)$db->query("SELECT COUNT(*) FROM users WHERE role_id = 2")->fetchColumn();

// Recent 5 Orders
$recentOrders = $db->query("
    SELECT o.*, u.full_name, u.email
    FROM orders o
    JOIN users u ON o.user_id = u.user_id
    ORDER BY o.created_at DESC
    LIMIT 5
")->fetchAll();
?>

<style>
.admin-wrap {
  max-width: 1200px;
  margin: 0 auto;
  padding: 2.5rem 1.5rem 4rem;
}

.admin-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 2.5rem;
  flex-wrap: wrap;
  gap: 1rem;
}

.stats-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
  gap: 1.5rem;
  margin-bottom: 2.5rem;
}

.stat-card {
  background: var(--bg-card);
  border: 1px solid var(--border-subtle);
  border-radius: var(--radius-lg);
  padding: 1.5rem;
  display: flex;
  align-items: center;
  gap: 1.25rem;
}
.stat-icon {
  width: 54px;
  height: 54px;
  border-radius: 14px;
  background: rgba(212,175,55,0.1);
  border: 1px solid rgba(212,175,55,0.25);
  color: var(--accent-gold);
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1.5rem;
  flex-shrink: 0;
}
.stat-val {
  font-family: var(--font-heading);
  font-size: 1.6rem;
  font-weight: 800;
  color: var(--text-primary);
  margin-top: 2px;
}
.stat-lbl {
  font-size: 0.8rem;
  color: var(--text-muted);
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 0.5px;
}

.admin-grid {
  display: grid;
  grid-template-columns: 2fr 1fr;
  gap: 2rem;
}
@media (max-width: 900px) {
  .admin-grid { grid-template-columns: 1fr; }
}

.admin-panel {
  background: var(--bg-card);
  border: 1px solid var(--border-subtle);
  border-radius: var(--radius-lg);
  padding: 1.75rem;
}
.panel-head {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 1.25rem;
  padding-bottom: 0.85rem;
  border-bottom: 1px solid var(--border-subtle);
}
.panel-title {
  font-family: var(--font-heading);
  font-size: 1.2rem;
  font-weight: 700;
}

/* Table */
.admin-table {
  width: 100%;
  border-collapse: collapse;
  font-size: 0.88rem;
}
.admin-table th, .admin-table td {
  padding: 0.85rem 0.75rem;
  text-align: left;
  border-bottom: 1px solid var(--border-subtle);
}
.admin-table th {
  color: var(--text-muted);
  font-size: 0.75rem;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  font-weight: 700;
}
.admin-table tr:last-child td { border-bottom: none; }

/* Status Badges */
.badge-status {
  display: inline-flex;
  align-items: center;
  gap: 4px;
  padding: 3px 10px;
  border-radius: 99px;
  font-size: 0.72rem;
  font-weight: 700;
  text-transform: uppercase;
}
.status-pending   { background: rgba(245,158,11,0.12); color: #f59e0b; border: 1px solid rgba(245,158,11,0.3); }
.status-confirmed { background: rgba(59,130,246,0.12); color: #60a5fa; border: 1px solid rgba(59,130,246,0.3); }
.status-shipped   { background: rgba(168,85,247,0.12); color: #c084fc; border: 1px solid rgba(168,85,247,0.3); }
.status-delivered { background: rgba(16,185,129,0.12); color: #34d399; border: 1px solid rgba(16,185,129,0.3); }

/* Quick Actions */
.quick-act-btn {
  display: flex;
  align-items: center;
  gap: 12px;
  padding: 1rem;
  background: var(--bg-primary);
  border: 1px solid var(--border-subtle);
  border-radius: var(--radius-md);
  color: var(--text-primary);
  text-decoration: none;
  font-weight: 600;
  margin-bottom: 0.75rem;
  transition: all 0.2s;
}
.quick-act-btn:hover {
  border-color: var(--accent-gold);
  color: var(--accent-gold);
  transform: translateX(4px);
}
.quick-act-btn i {
  font-size: 1.2rem;
  color: var(--accent-gold);
  width: 24px;
  text-align: center;
}
</style>

<main>
  <div class="admin-wrap">
    <div class="admin-header">
      <div>
        <h1 style="font-size: 2.2rem; margin-bottom: 0.25rem;">
          Admin <span class="text-accent">Control Center</span>
        </h1>
        <p style="color: var(--text-secondary);">Overview of catalog, orders, sales performance, and quick tools.</p>
      </div>
      <div>
        <a href="<?= APP_URL ?>/admin/products.php" class="btn btn-primary">
          <i class="fa-solid fa-plus"></i> Manage Products
        </a>
      </div>
    </div>

    <!-- Stats Grid -->
    <div class="stats-grid">
      <div class="stat-card">
        <div class="stat-icon"><i class="fa-solid fa-indian-rupee-sign"></i></div>
        <div>
          <div class="stat-lbl">Total Revenue</div>
          <div class="stat-val"><?= format_price($totalSales) ?></div>
        </div>
      </div>
      <div class="stat-card">
        <div class="stat-icon"><i class="fa-solid fa-cart-shopping"></i></div>
        <div>
          <div class="stat-lbl">Total Orders</div>
          <div class="stat-val"><?= $totalOrders ?></div>
        </div>
      </div>
      <div class="stat-card">
        <div class="stat-icon"><i class="fa-solid fa-chair"></i></div>
        <div>
          <div class="stat-lbl">Products</div>
          <div class="stat-val"><?= $totalProducts ?></div>
        </div>
      </div>
      <div class="stat-card">
        <div class="stat-icon"><i class="fa-solid fa-users"></i></div>
        <div>
          <div class="stat-lbl">Registered Customers</div>
          <div class="stat-val"><?= $totalUsers ?></div>
        </div>
      </div>
    </div>

    <!-- Admin Grid -->
    <div class="admin-grid">
      <!-- Recent Orders Panel -->
      <div class="admin-panel">
        <div class="panel-head">
          <div class="panel-title"><i class="fa-solid fa-clock-rotate-left text-accent"></i> Recent Orders</div>
          <a href="<?= APP_URL ?>/admin/orders.php" style="font-size:0.82rem;color:var(--accent-gold);font-weight:600;">View All</a>
        </div>

        <?php if (empty($recentOrders)): ?>
          <p style="color:var(--text-muted);text-align:center;padding:2rem 0;">No orders placed yet.</p>
        <?php else: ?>
          <div style="overflow-x:auto;">
            <table class="admin-table">
              <thead>
                <tr>
                  <th>Order #</th>
                  <th>Customer</th>
                  <th>Amount</th>
                  <th>Status</th>
                  <th>Date</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($recentOrders as $ord): ?>
                  <tr>
                    <td style="font-weight:700;color:var(--accent-gold);"><?= e($ord['order_number']) ?></td>
                    <td>
                      <div style="font-weight:600;"><?= e($ord['full_name']) ?></div>
                      <div style="font-size:0.75rem;color:var(--text-muted);"><?= e($ord['email']) ?></div>
                    </td>
                    <td style="font-weight:700;"><?= format_price($ord['total_amount']) ?></td>
                    <td>
                      <span class="badge-status status-<?= e($ord['status']) ?>">
                        <?= e($ord['status']) ?>
                      </span>
                    </td>
                    <td style="color:var(--text-muted);font-size:0.8rem;">
                      <?= date('d M, H:i', strtotime($ord['created_at'])) ?>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        <?php endif; ?>
      </div>

      <!-- Quick Actions Sidebar -->
      <div class="admin-panel">
        <div class="panel-head">
          <div class="panel-title"><i class="fa-solid fa-bolt text-accent"></i> Quick Actions</div>
        </div>
        <div>
          <a href="<?= APP_URL ?>/admin/products.php" class="quick-act-btn">
            <i class="fa-solid fa-box-open"></i>
            <span>Product Catalog</span>
          </a>
          <a href="<?= APP_URL ?>/admin/orders.php" class="quick-act-btn">
            <i class="fa-solid fa-truck-ramp-box"></i>
            <span>Manage Orders</span>
          </a>
          <a href="<?= APP_URL ?>/admin/messages.php" class="quick-act-btn">
            <i class="fa-solid fa-envelope-open-text"></i>
            <span>Customer Messages</span>
          </a>
          <a href="<?= APP_URL ?>/public/products.php" target="_blank" class="quick-act-btn">
            <i class="fa-solid fa-arrow-up-right-from-square"></i>
            <span>View Public Store</span>
          </a>
          <a href="<?= APP_URL ?>/public/designs.php" target="_blank" class="quick-act-btn">
            <i class="fa-solid fa-cube"></i>
            <span>Open 3D Studio</span>
          </a>
        </div>
      </div>
    </div>
  </div>
</main>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
