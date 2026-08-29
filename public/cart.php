<?php
require_once __DIR__ . '/../includes/header.php';
if (!is_logged_in()) {
    echo '
    <main class="section-padding" style="padding-top: 5rem; text-align: center;">
        <div class="container" style="max-width: 500px; background: var(--bg-card); border: 1px solid var(--border-subtle); border-radius: var(--radius-lg); padding: 3rem;">
            <i class="fa-solid fa-shopping-bag text-accent" style="font-size: 3.5rem; margin-bottom: 1.5rem;"></i>
            <h2 style="margin-bottom: 0.75rem;">Your Cart Requires Login</h2>
            <p style="color: var(--text-secondary); margin-bottom: 2rem;">Please log in to your account to view your saved cart items.</p>
            <div style="display: flex; gap: 1rem; justify-content: center;">
                <a href="' . APP_URL . '/public/login.php" class="btn btn-primary">Log In</a>
                <a href="' . APP_URL . '/public/register.php" class="btn btn-secondary">Create Account</a>
            </div>
        </div>
    </main>';
    require_once __DIR__ . '/../includes/footer.php';
    exit;
}
?>

<main class="section-padding" style="padding-top: 3rem;">
    <div class="container">
        <!-- Title Header -->
        <div style="margin-bottom: 2.5rem;">
            <h1 style="font-size: 2.5rem; margin-bottom: 0.5rem;">
                Shopping <span class="text-accent">Bag</span>
            </h1>
            <p style="color: var(--text-secondary);">Review your selected furniture items before proceeding to checkout.</p>
        </div>

        <div id="cartContentGrid" style="display: grid; grid-template-columns: 2.2fr 1fr; gap: 2.5rem; align-items: start;" class="hero-grid">
            <!-- Cart Items List Container -->
            <div id="cartItemsContainer" style="background: var(--bg-card); border: 1px solid var(--border-subtle); border-radius: var(--radius-lg); padding: 1.5rem;">
                <div style="text-align: center; padding: 3rem 0; color: var(--text-muted);">
                    <i class="fa-solid fa-circle-notch fa-spin" style="font-size: 2.5rem; margin-bottom: 1rem; color: var(--accent-gold);"></i>
                    <p>Loading your cart items...</p>
                </div>
            </div>

            <!-- Order Summary Sidebar -->
            <div style="background: var(--bg-card); border: 1px solid var(--border-subtle); border-radius: var(--radius-lg); padding: 2rem; position: sticky; top: 100px;">
                <h3 style="font-size: 1.3rem; margin-bottom: 1.5rem; padding-bottom: 1rem; border-bottom: 1px solid var(--border-subtle);">Order Summary</h3>
                
                <div style="display: flex; justify-content: space-between; margin-bottom: 1rem; font-size: 0.95rem; color: var(--text-secondary);">
                    <span>Subtotal</span>
                    <span id="summarySubtotal" style="color: var(--text-primary); font-weight: 600;">₹0.00</span>
                </div>

                <div style="display: flex; justify-content: space-between; margin-bottom: 1.5rem; font-size: 0.95rem; color: var(--text-secondary);">
                    <span>Shipping & Handling</span>
                    <span style="color: #34d399; font-weight: 600;">FREE</span>
                </div>

                <div style="display: flex; justify-content: space-between; margin-bottom: 2rem; padding-top: 1rem; border-top: 1px solid var(--border-subtle); font-size: 1.25rem; font-weight: 800;">
                    <span>Total</span>
                    <span id="summaryTotal" class="text-accent">₹0.00</span>
                </div>

                <a href="<?= APP_URL ?>/public/checkout.php" id="checkoutBtn" class="btn btn-primary" style="width: 100%; justify-content: center; padding: 0.9rem; font-size: 1.05rem;">
                    Proceed to Checkout <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>
</main>

<script>
async function loadCart() {
    const container = document.getElementById('cartItemsContainer');
    const summarySubtotal = document.getElementById('summarySubtotal');
    const summaryTotal = document.getElementById('summaryTotal');
    const checkoutBtn = document.getElementById('checkoutBtn');

    try {
        const response = await fetch('<?= APP_URL ?>/api/cart/get.php');
        const data = await response.json();

        if (data.success && data.items.length > 0) {
            container.innerHTML = data.items.map(item => `
                <div style="display: flex; align-items: center; justify-content: space-between; gap: 1.5rem; padding: 1.25rem 0; border-bottom: 1px solid var(--border-subtle);" id="cart-item-${item.cart_item_id}">
                    <div style="display: flex; align-items: center; gap: 1.25rem; flex-grow: 1;">
                        <img src="<?= APP_URL ?>/${escapeHTML(item.main_image)}" alt="${escapeHTML(item.title)}" style="width: 80px; height: 80px; object-fit: cover; border-radius: var(--radius-md);" />
                        <div>
                            <span style="font-size: 0.75rem; color: var(--accent-gold); font-weight: 600; text-transform: uppercase;">${escapeHTML(item.category_name)}</span>
                            <h4 style="font-size: 1.1rem; margin: 0.2rem 0;">${escapeHTML(item.title)}</h4>
                            <span style="font-size: 0.9rem; color: var(--text-secondary);">₹${parseFloat(item.price).toLocaleString('en-IN', {minimumFractionDigits: 2})} each</span>
                        </div>
                    </div>

                    <!-- Quantity Control -->
                    <div style="display: flex; align-items: center; background: var(--bg-primary); border: 1px solid var(--border-subtle); border-radius: var(--radius-md); padding: 0.2rem;">
                        <button onclick="updateQuantity(${item.cart_item_id}, ${item.quantity - 1})" style="background: transparent; border: none; color: var(--text-primary); width: 32px; height: 32px; cursor: pointer; font-size: 1rem;">-</button>
                        <span style="width: 36px; text-align: center; font-weight: 700;">${item.quantity}</span>
                        <button onclick="updateQuantity(${item.cart_item_id}, ${item.quantity + 1})" style="background: transparent; border: none; color: var(--text-primary); width: 32px; height: 32px; cursor: pointer; font-size: 1rem;">+</button>
                    </div>

                    <!-- Subtotal & Remove -->
                    <div style="text-align: right; min-width: 110px;">
                        <div style="font-family: var(--font-heading); font-size: 1.15rem; font-weight: 700; color: var(--accent-gold);">
                            ₹${parseFloat(item.subtotal).toLocaleString('en-IN', {minimumFractionDigits: 2})}
                        </div>
                        <button onclick="removeItem(${item.cart_item_id})" style="background: transparent; border: none; color: #ef4444; font-size: 0.85rem; cursor: pointer; margin-top: 0.25rem;">
                            <i class="fa-solid fa-trash-can"></i> Remove
                        </button>
                    </div>
                </div>
            `).join('');

            const formattedTotal = '₹' + parseFloat(data.total_amount).toLocaleString('en-IN', {minimumFractionDigits: 2});
            summarySubtotal.innerText = formattedTotal;
            summaryTotal.innerText = formattedTotal;
            checkoutBtn.style.pointerEvents = 'auto';
            checkoutBtn.style.opacity = '1';
        } else {
            container.innerHTML = `
                <div style="text-align: center; padding: 4rem 1rem;">
                    <i class="fa-solid fa-shopping-bag" style="font-size: 3.5rem; color: var(--text-muted); margin-bottom: 1.5rem;"></i>
                    <h3 style="margin-bottom: 0.5rem;">Your Shopping Bag is Empty</h3>
                    <p style="color: var(--text-secondary); margin-bottom: 2rem;">Discover luxury interior furniture items and add them to your bag.</p>
                    <a href="<?= APP_URL ?>/public/products.php" class="btn btn-primary">
                        Browse Furniture Catalog <i class="fa-solid fa-arrow-right"></i>
                    </a>
                </div>
            `;
            summarySubtotal.innerText = '₹0.00';
            summaryTotal.innerText = '₹0.00';
            checkoutBtn.style.pointerEvents = 'none';
            checkoutBtn.style.opacity = '0.5';
        }
    } catch (err) {
        console.error('Load cart error:', err);
    }
}

async function updateQuantity(cartItemId, newQty) {
    if (newQty <= 0) {
        return removeItem(cartItemId);
    }

    try {
        const response = await fetch('<?= APP_URL ?>/api/cart/update.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ cart_item_id: cartItemId, quantity: newQty })
        });
        const data = await response.json();
        if (data.success) {
            // Update Header Cart Badge dynamically
            const headerBadge = document.getElementById('headerCartBadge');
            if (headerBadge) headerBadge.innerText = data.cart_count;
            loadCart();
        }
    } catch (err) {
        console.error('Update quantity error:', err);
    }
}

async function removeItem(cartItemId) {
    if (!confirm('Are you sure you want to remove this item from your bag?')) return;

    try {
        const response = await fetch('<?= APP_URL ?>/api/cart/remove.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ cart_item_id: cartItemId })
        });
        const data = await response.json();
        if (data.success) {
            const headerBadge = document.getElementById('headerCartBadge');
            if (headerBadge) headerBadge.innerText = data.cart_count;
            loadCart();
        }
    } catch (err) {
        console.error('Remove item error:', err);
    }
}

function escapeHTML(str) {
    if (!str) return '';
    return str.replace(/[&<>'"]/g, 
        tag => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', "'": '&#39;', '"': '&quot;' }[tag] || tag)
    );
}

document.addEventListener('DOMContentLoaded', loadCart);
</script>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
