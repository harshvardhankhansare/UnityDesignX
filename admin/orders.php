<?php
/**
 * Admin Order Management Page
 * UnityDesignX Platform — Phase 10
 */
require_once __DIR__ . '/../includes/header.php';
require_admin();

$db = get_db();
$message = '';
$error = '';

// ── Handle Order Status Update ────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_order_status'])) {
    $orderId   = (int)($_POST['order_id'] ?? 0);
    $newStatus = sanitize_input($_POST['status'] ?? '');

    $allowedStatuses = ['pending', 'confirmed', 'shipped', 'delivered', 'cancelled'];
    if ($orderId > 0 && in_array($newStatus, $allowedStatuses)) {
        try {
            $stmt = $db->prepare("UPDATE orders SET status = :status WHERE order_id = :oid");
            $stmt->execute([':status' => $newStatus, ':oid' => $orderId]);
            $message = "Order status updated to \"{$newStatus}\".";
        } catch (PDOException $e) {
            $error = 'Failed to update order status.';
        }
    }
}

// Fetch all orders with customer details
$orders = $db->query("
    SELECT o.*, u.full_name, u.email
    FROM orders o
    JOIN users u ON o.user_id = u.user_id
    ORDER BY o.created_at DESC
")->fetchAll();

// Fetch all order items for expansion
$itemsStmt = $db->prepare("
    SELECT oi.*, p.title, p.main_image
    FROM order_items oi
    JOIN products p ON oi.product_id = p.product_id
    WHERE oi.order_id = :oid
");
?>

<style>
.admin-wrap { max-width: 1200px; margin: 0 auto; padding: 2.5rem 1.5rem 4rem; }

.table-card {
  background: var(--bg-card);
  border: 1px solid var(--border-subtle);
  border-radius: var(--radius-lg);
  padding: 1.5rem;
  margin-top: 1.5rem;
}

.order-table { width: 100%; border-collapse: collapse; font-size: 0.88rem; }
.order-table th, .order-table td { padding: 0.9rem 0.75rem; text-align: left; border-bottom: 1px solid var(--border-subtle); }
.order-table th { color: var(--text-muted); font-size: 0.75rem; text-transform: uppercase; }

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
.status-cancelled { background: rgba(239,68,68,0.12); color: #f87171; border: 1px solid rgba(239,68,68,0.3); }

.status-select {
  padding: 0.35rem 0.6rem;
  background: var(--bg-primary);
  border: 1px solid var(--border-subtle);
  border-radius: var(--radius-md);
  color: var(--text-primary);
  font-size: 0.8rem;
  outline: none;
}

.alert-msg { padding: 0.85rem 1.25rem; border-radius: var(--radius-md); font-size: 0.9rem; margin-bottom: 1.5rem; }
.alert-success { background: rgba(16,185,129,0.15); border: 1px solid rgba(16,185,129,0.3); color: #34d399; }
</style>

<main>
  <div class="admin-wrap">
    <div style="margin-bottom: 1.5rem;">
      <h1 style="font-size: 2.2rem; margin-bottom: 0.25rem;">
        Order <span class="text-accent">Fulfillment & Status</span>
      </h1>
      <p style="color: var(--text-secondary);">Manage store orders, view customer shipping details, and update statuses.</p>
    </div>

    <?php if ($message): ?>
      <div class="alert-msg alert-success"><i class="fa-solid fa-circle-check"></i> <?= e($message) ?></div>
    <?php endif; ?>

    <div class="table-card">
      <div style="overflow-x:auto;">
        <table class="order-table">
          <thead>
            <tr>
              <th>Order Number</th>
              <th>Customer</th>
              <th>Shipping Address</th>
              <th>Total</th>
              <th>Date</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($orders as $o): 
              $shipping = json_decode($o['shipping_address'], true) ?? [];
              $itemsStmt->execute([':oid' => $o['order_id']]);
              $orderItems = $itemsStmt->fetchAll();
            ?>
              <tr>
                <td style="font-weight:700;color:var(--accent-gold);"><?= e($o['order_number']) ?></td>
                <td>
                  <div style="font-weight:600;"><?= e($o['full_name']) ?></div>
                  <div style="font-size:0.75rem;color:var(--text-muted);"><?= e($o['email']) ?></div>
                </td>
                <td style="font-size:0.8rem;max-width:220px;">
                  <?= e($shipping['address'] ?? '') ?>, <?= e($shipping['city'] ?? '') ?> - <?= e($shipping['pin'] ?? '') ?>
                </td>
                <td style="font-weight:700;"><?= format_price($o['total_amount']) ?></td>
                <td style="color:var(--text-muted);font-size:0.8rem;"><?= date('d M, Y', strtotime($o['created_at'])) ?></td>
                <td>
                  <span class="badge-status status-<?= e($o['status']) ?>"><?= e($o['status']) ?></span>
                </td>
                <td>
                  <form method="POST" style="display:flex;gap:6px;align-items:center;">
                    <input type="hidden" name="update_order_status" value="1" />
                    <input type="hidden" name="order_id" value="<?= $o['order_id'] ?>" />
                    <select name="status" class="status-select">
                      <option value="pending" <?= $o['status'] === 'pending' ? 'selected' : '' ?>>Pending</option>
                      <option value="confirmed" <?= $o['status'] === 'confirmed' ? 'selected' : '' ?>>Confirmed</option>
                      <option value="shipped" <?= $o['status'] === 'shipped' ? 'selected' : '' ?>>Shipped</option>
                      <option value="delivered" <?= $o['status'] === 'delivered' ? 'selected' : '' ?>>Delivered</option>
                      <option value="cancelled" <?= $o['status'] === 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
                    </select>
                    <button type="submit" class="btn btn-secondary" style="padding:0.35rem 0.6rem;font-size:0.75rem;">Update</button>
                  </form>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</main>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
