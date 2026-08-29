<?php
/**
 * My Orders Page — Order History & Status Pipeline
 * UnityDesignX Platform — Phase 9
 */
require_once __DIR__ . '/../includes/header.php';

if (!is_logged_in()) {
    header('Location: ' . APP_URL . '/public/login.php?redirect=orders');
    exit;
}
?>

<style>
.orders-wrap {
  max-width: 960px;
  margin: 0 auto;
  padding: 2.5rem 1.5rem 4rem;
}

.order-card {
  background: var(--bg-card);
  border: 1px solid var(--border-subtle);
  border-radius: var(--radius-lg);
  margin-bottom: 1.5rem;
  overflow: hidden;
  transition: border-color 0.2s;
}
.order-card:hover {
  border-color: rgba(212,175,55,0.3);
}

/* Card Header */
.oc-header {
  padding: 1.25rem 1.5rem;
  background: rgba(255,255,255,0.02);
  border-bottom: 1px solid var(--border-subtle);
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 1rem;
  flex-wrap: wrap;
}
.oc-num {
  font-family: var(--font-heading);
  font-size: 1.15rem;
  font-weight: 700;
  color: var(--accent-gold);
  display: flex;
  align-items: center;
  gap: 8px;
}
.oc-meta {
  font-size: 0.82rem;
  color: var(--text-muted);
  display: flex;
  align-items: center;
  gap: 12px;
}

/* Status Badges */
.badge-status {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  padding: 4px 12px;
  border-radius: 99px;
  font-size: 0.75rem;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.5px;
}
.status-pending   { background: rgba(245,158,11,0.12); color: #f59e0b; border: 1px solid rgba(245,158,11,0.3); }
.status-confirmed { background: rgba(59,130,246,0.12); color: #60a5fa; border: 1px solid rgba(59,130,246,0.3); }
.status-shipped   { background: rgba(168,85,247,0.12); color: #c084fc; border: 1px solid rgba(168,85,247,0.3); }
.status-delivered { background: rgba(16,185,129,0.12); color: #34d399; border: 1px solid rgba(16,185,129,0.3); }

/* Card Body (Items) */
.oc-body {
  padding: 1.25rem 1.5rem;
}
.oc-item {
  display: flex;
  align-items: center;
  gap: 1.25rem;
  padding: 0.85rem 0;
  border-bottom: 1px solid var(--border-subtle);
}
.oc-item:last-child { border-bottom: none; }
.oc-item img {
  width: 64px;
  height: 64px;
  object-fit: cover;
  border-radius: var(--radius-md);
  flex-shrink: 0;
}
.oc-item-details { flex: 1; min-width: 0; }
.oc-item-name { font-weight: 700; font-size: 0.95rem; margin-bottom: 2px; }
.oc-item-cat { font-size: 0.75rem; color: var(--accent-gold); font-weight: 600; text-transform: uppercase; }
.oc-item-qty { font-size: 0.82rem; color: var(--text-muted); }
.oc-item-price { font-weight: 700; font-size: 1rem; color: var(--text-primary); text-align: right; flex-shrink: 0; }

/* Card Footer */
.oc-footer {
  padding: 1rem 1.5rem;
  background: rgba(0,0,0,0.2);
  border-top: 1px solid var(--border-subtle);
  display: flex;
  align-items: center;
  justify-content: space-between;
  font-size: 0.88rem;
  flex-wrap: wrap;
  gap: 1rem;
}
.oc-total-label { color: var(--text-muted); }
.oc-total-val { font-family: var(--font-heading); font-size: 1.2rem; font-weight: 800; color: var(--accent-gold); }

/* Empty state */
.no-orders {
  text-align: center;
  padding: 4rem 1.5rem;
  background: var(--bg-card);
  border: 1px solid var(--border-subtle);
  border-radius: var(--radius-lg);
}
.no-orders i { font-size: 3.5rem; color: var(--text-muted); margin-bottom: 1.25rem; }
</style>

<main>
  <div class="orders-wrap">
    <div style="margin-bottom: 2rem;">
      <h1 style="font-size: 2.2rem; margin-bottom: 0.25rem;">
        My <span class="text-accent">Orders</span>
      </h1>
      <p style="color: var(--text-secondary);">Track your recent purchases and delivery progress.</p>
    </div>

    <div id="ordersContainer">
      <div style="text-align:center;padding:3rem 0;color:var(--text-muted);">
        <i class="fa-solid fa-circle-notch fa-spin" style="font-size:2rem;color:var(--accent-gold);"></i>
        <p style="margin-top:1rem;">Loading your order history...</p>
      </div>
    </div>
  </div>
</main>

<script>
async function loadOrders() {
  const container = document.getElementById('ordersContainer');
  try {
    const res = await fetch('<?= APP_URL ?>/api/orders/history.php');
    const data = await res.json();

    if (!data.success || !data.orders || data.orders.length === 0) {
      container.innerHTML = `
        <div class="no-orders">
          <i class="fa-solid fa-box-open"></i>
          <h3 style="margin-bottom: 0.5rem;">No Orders Found</h3>
          <p style="color: var(--text-secondary); margin-bottom: 1.5rem;">You haven't placed any orders yet. Explore our designer furniture catalog!</p>
          <a href="<?= APP_URL ?>/public/products.php" class="btn btn-primary">Browse Catalog <i class="fa-solid fa-arrow-right"></i></a>
        </div>`;
      return;
    }

    container.innerHTML = data.orders.map(order => {
      const statusClass = 'status-' + (order.status || 'pending');
      const formattedDate = new Date(order.created_at).toLocaleDateString('en-IN', {
        day: 'numeric', month: 'short', year: 'numeric', hour: '2-digit', minute: '2-digit'
      });
      const paymentText = { cod: 'Cash on Delivery', upi: 'UPI', card: 'Card' }[order.payment_method] || 'COD';

      return `
        <div class="order-card">
          <div class="oc-header">
            <div>
              <div class="oc-num"><i class="fa-solid fa-box"></i> #${esc(order.order_number)}</div>
              <div class="oc-meta" style="margin-top:4px;">
                <span>Placed on ${formattedDate}</span>
                <span>•</span>
                <span>${order.item_count} item${order.item_count > 1 ? 's' : ''}</span>
              </div>
            </div>
            <div>
              <span class="badge-status ${statusClass}">
                <i class="fa-solid fa-circle" style="font-size:0.5rem;"></i> ${esc(order.status)}
              </span>
            </div>
          </div>

          <div class="oc-body">
            ${order.items.map(item => `
              <div class="oc-item">
                <img src="<?= APP_URL ?>/${esc(item.main_image)}" alt="${esc(item.title)}" onerror="this.src='https://via.placeholder.com/64'" />
                <div class="oc-item-details">
                  <div class="oc-item-cat">${esc(item.category_name)}</div>
                  <div class="oc-item-name">${esc(item.title)}</div>
                  <div class="oc-item-qty">Qty: ${item.quantity} × ₹${parseFloat(item.unit_price).toLocaleString('en-IN', {minimumFractionDigits: 2})}</div>
                </div>
                <div class="oc-item-price">
                  ₹${parseFloat(item.subtotal).toLocaleString('en-IN', {minimumFractionDigits: 2})}
                </div>
              </div>
            `).join('')}
          </div>

          <div class="oc-footer">
            <div style="font-size:0.82rem;color:var(--text-muted);">
              Payment: <strong style="color:var(--text-primary);">${paymentText}</strong>
            </div>
            <div>
              <span class="oc-total-label">Total Amount: </span>
              <span class="oc-total-val">₹${parseFloat(order.total_amount).toLocaleString('en-IN', {minimumFractionDigits: 2})}</span>
            </div>
          </div>
        </div>
      `;
    }).join('');

  } catch (err) {
    console.error('Error loading orders:', err);
    container.innerHTML = `
      <div class="no-orders">
        <i class="fa-solid fa-circle-exclamation" style="color: #ef4444;"></i>
        <h3>Failed to Load Orders</h3>
        <p style="color: var(--text-secondary);">An error occurred while fetching your order history.</p>
      </div>`;
  }
}

function esc(str) {
  if (!str) return '';
  return str.replace(/[&<>'"]/g, tag => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', "'": '&#39;', '"': '&quot;' }[tag] || tag));
}

document.addEventListener('DOMContentLoaded', loadOrders);
</script>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
