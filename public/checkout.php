<?php
/**
 * Checkout Page — Multi-Step Wizard
 * UnityDesignX Platform — Phase 9
 */
require_once __DIR__ . '/../includes/header.php';

if (!is_logged_in()) {
    header('Location: ' . APP_URL . '/public/login.php?redirect=checkout');
    exit;
}

$csrfToken = generate_csrf_token();
?>

<style>
/* ── Checkout Page ──────────────────────────────────────────── */
.checkout-wrap {
  max-width: 1050px;
  margin: 0 auto;
  padding: 2.5rem 1.5rem 4rem;
}

/* Step Indicator */
.step-bar {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 0;
  margin-bottom: 3rem;
}
.step-item {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 6px;
  position: relative;
  flex: 1;
  max-width: 160px;
}
.step-circle {
  width: 42px;
  height: 42px;
  border-radius: 50%;
  background: var(--bg-card);
  border: 2px solid var(--border-subtle);
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1rem;
  color: var(--text-muted);
  font-weight: 700;
  transition: all 0.3s;
  position: relative;
  z-index: 2;
}
.step-label {
  font-size: 0.72rem;
  font-weight: 600;
  color: var(--text-muted);
  letter-spacing: 0.5px;
  text-transform: uppercase;
  white-space: nowrap;
  transition: color 0.3s;
}
.step-line {
  flex: 1;
  height: 2px;
  background: var(--border-subtle);
  margin: 0 -2px;
  position: relative;
  top: -18px;
  max-width: 120px;
  transition: background 0.4s;
}
/* Active step */
.step-item.active   .step-circle { background: var(--accent-gold); border-color: var(--accent-gold); color: #000; box-shadow: 0 0 18px rgba(212,175,55,0.4); }
.step-item.active   .step-label  { color: var(--accent-gold); }
/* Completed step */
.step-item.done     .step-circle { background: #10b981; border-color: #10b981; color: #fff; }
.step-item.done     .step-label  { color: #10b981; }
.step-line.done     { background: #10b981; }

/* Step Panels */
.step-panel { display: none; }
.step-panel.active { display: block; animation: fadeInUp 0.35s ease; }
@keyframes fadeInUp {
  from { opacity: 0; transform: translateY(12px); }
  to   { opacity: 1; transform: translateY(0); }
}

/* Checkout Grid */
.checkout-grid {
  display: grid;
  grid-template-columns: 1fr 380px;
  gap: 2rem;
  align-items: start;
}
@media (max-width: 820px) {
  .checkout-grid { grid-template-columns: 1fr; }
}

/* Card */
.co-card {
  background: var(--bg-card);
  border: 1px solid var(--border-subtle);
  border-radius: var(--radius-lg);
  padding: 2rem;
}
.co-card-title {
  font-family: var(--font-heading);
  font-size: 1.25rem;
  font-weight: 700;
  margin-bottom: 1.5rem;
  padding-bottom: 1rem;
  border-bottom: 1px solid var(--border-subtle);
  display: flex;
  align-items: center;
  gap: 10px;
}
.co-card-title i { color: var(--accent-gold); }

/* Form Fields */
.form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem; }
.form-row.single { grid-template-columns: 1fr; }
@media (max-width: 600px) { .form-row { grid-template-columns: 1fr; } }

.form-group { display: flex; flex-direction: column; gap: 5px; }
.form-group label { font-size: 0.8rem; font-weight: 600; color: var(--text-secondary); letter-spacing: 0.4px; }
.form-group input, .form-group select {
  padding: 0.7rem 1rem;
  background: var(--bg-primary);
  border: 1px solid var(--border-subtle);
  border-radius: var(--radius-md);
  color: var(--text-primary);
  font-size: 0.92rem;
  font-family: var(--font-body);
  outline: none;
  transition: border-color 0.2s;
}
.form-group input:focus, .form-group select:focus {
  border-color: var(--accent-gold);
  box-shadow: 0 0 0 3px rgba(212,175,55,0.12);
}
.form-group input::placeholder { color: var(--text-muted); }

/* Payment Methods */
.payment-options { display: flex; flex-direction: column; gap: 12px; }
.pay-opt {
  display: flex;
  align-items: center;
  gap: 14px;
  padding: 1rem 1.25rem;
  background: var(--bg-primary);
  border: 2px solid var(--border-subtle);
  border-radius: var(--radius-md);
  cursor: pointer;
  transition: all 0.2s;
}
.pay-opt:hover { border-color: var(--accent-gold); }
.pay-opt.selected { border-color: var(--accent-gold); background: rgba(212,175,55,0.06); }
.pay-opt input[type="radio"] { accent-color: var(--accent-gold); width: 18px; height: 18px; }
.pay-opt-icon { font-size: 1.6rem; width: 36px; text-align: center; }
.pay-opt-info { flex: 1; }
.pay-opt-name { font-weight: 700; font-size: 0.95rem; }
.pay-opt-sub { font-size: 0.78rem; color: var(--text-muted); margin-top: 2px; }

/* Order Summary Sidebar */
.summary-line {
  display: flex;
  justify-content: space-between;
  font-size: 0.9rem;
  color: var(--text-secondary);
  margin-bottom: 0.75rem;
}
.summary-line.total {
  font-size: 1.2rem;
  font-weight: 800;
  color: var(--text-primary);
  padding-top: 1rem;
  margin-top: 0.5rem;
  border-top: 1px solid var(--border-subtle);
}
.summary-line.total span:last-child { color: var(--accent-gold); }

/* Cart Items in Summary */
.summary-item {
  display: flex;
  align-items: center;
  gap: 10px;
  padding: 10px 0;
  border-bottom: 1px solid var(--border-subtle);
}
.summary-item img {
  width: 52px;
  height: 52px;
  object-fit: cover;
  border-radius: var(--radius-md);
  flex-shrink: 0;
}
.summary-item-info { flex: 1; min-width: 0; }
.summary-item-name { font-size: 0.82rem; font-weight: 600; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.summary-item-qty  { font-size: 0.75rem; color: var(--text-muted); }
.summary-item-price { font-size: 0.88rem; font-weight: 700; color: var(--accent-gold); flex-shrink: 0; }

/* Nav Buttons */
.step-nav {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-top: 2rem;
  gap: 1rem;
}
.step-nav .btn-ghost { background: transparent; border: 1px solid var(--border-subtle); color: var(--text-secondary); }
.step-nav .btn-ghost:hover { border-color: var(--accent-gold); color: var(--accent-gold); }

/* Confirmation panel */
.confirm-panel {
  text-align: center;
  padding: 3rem 2rem;
}
.confirm-check {
  width: 80px;
  height: 80px;
  border-radius: 50%;
  background: linear-gradient(135deg, #10b981, #059669);
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 2.2rem;
  color: #fff;
  margin: 0 auto 1.5rem;
  box-shadow: 0 0 30px rgba(16,185,129,0.4);
  animation: popIn 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275) both;
}
@keyframes popIn {
  from { transform: scale(0); opacity: 0; }
  to   { transform: scale(1); opacity: 1; }
}
.confirm-order-num {
  font-family: var(--font-heading);
  font-size: 1.5rem;
  color: var(--accent-gold);
  margin-bottom: 0.5rem;
}
.confirm-sub { color: var(--text-muted); font-size: 0.92rem; margin-bottom: 2rem; }
.confirm-details {
  background: var(--bg-primary);
  border: 1px solid var(--border-subtle);
  border-radius: var(--radius-md);
  padding: 1.25rem;
  text-align: left;
  margin-bottom: 2rem;
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 0.75rem 1.5rem;
  font-size: 0.88rem;
}
.cd-label { color: var(--text-muted); font-size: 0.75rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; }
.cd-value { color: var(--text-primary); font-weight: 600; margin-top: 2px; }

/* Loading spinner overlay */
.placing-overlay {
  display: none;
  position: fixed;
  inset: 0;
  background: rgba(0,0,0,0.65);
  backdrop-filter: blur(4px);
  z-index: 9999;
  align-items: center;
  justify-content: center;
  flex-direction: column;
  gap: 1rem;
  color: #fff;
  font-size: 1.1rem;
  font-weight: 600;
}
.placing-overlay.show { display: flex; }
.placing-spinner {
  width: 56px;
  height: 56px;
  border: 4px solid rgba(212,175,55,0.25);
  border-top-color: var(--accent-gold);
  border-radius: 50%;
  animation: spin 0.8s linear infinite;
}
@keyframes spin { to { transform: rotate(360deg); } }
</style>

<!-- Placing Overlay -->
<div class="placing-overlay" id="placingOverlay">
  <div class="placing-spinner"></div>
  <span>Placing your order…</span>
</div>

<main>
  <div class="checkout-wrap">

    <!-- Page Title -->
    <div style="margin-bottom: 2rem;">
      <h1 style="font-size: 2.2rem; margin-bottom: 0.25rem;">
        Secure <span class="text-accent">Checkout</span>
      </h1>
      <p style="color: var(--text-secondary);">Complete your order in a few easy steps.</p>
    </div>

    <!-- Step Progress Bar -->
    <div class="step-bar" id="stepBar">
      <div class="step-item active" id="si-1">
        <div class="step-circle"><i class="fa-solid fa-bag-shopping"></i></div>
        <div class="step-label">Review</div>
      </div>
      <div class="step-line" id="sl-1"></div>
      <div class="step-item" id="si-2">
        <div class="step-circle"><i class="fa-solid fa-truck"></i></div>
        <div class="step-label">Delivery</div>
      </div>
      <div class="step-line" id="sl-2"></div>
      <div class="step-item" id="si-3">
        <div class="step-circle"><i class="fa-solid fa-credit-card"></i></div>
        <div class="step-label">Payment</div>
      </div>
      <div class="step-line" id="sl-3"></div>
      <div class="step-item" id="si-4">
        <div class="step-circle"><i class="fa-solid fa-check"></i></div>
        <div class="step-label">Confirm</div>
      </div>
    </div>

    <!-- ── STEP 1: Review Cart ── -->
    <div class="step-panel active" id="step-1">
      <div class="checkout-grid">
        <div class="co-card">
          <div class="co-card-title"><i class="fa-solid fa-bag-shopping"></i> Your Cart Items</div>
          <div id="reviewCartItems">
            <div style="text-align:center;padding:2rem;color:var(--text-muted);">
              <i class="fa-solid fa-circle-notch fa-spin" style="font-size:1.8rem;"></i>
            </div>
          </div>
        </div>
        <div>
          <div class="co-card" style="position:sticky;top:100px;">
            <div class="co-card-title"><i class="fa-solid fa-receipt"></i> Order Summary</div>
            <div id="reviewSummaryItems"></div>
            <div class="summary-line" style="margin-top:1rem;">
              <span>Subtotal</span><span id="sumSubtotal">₹0.00</span>
            </div>
            <div class="summary-line">
              <span>Shipping</span><span style="color:#10b981;font-weight:700;">FREE</span>
            </div>
            <div class="summary-line total">
              <span>Total</span><span id="sumTotal">₹0.00</span>
            </div>
            <div class="step-nav" style="margin-top:1.5rem;">
              <a href="<?= APP_URL ?>/public/cart.php" class="btn btn-ghost" style="font-size:0.88rem;">
                <i class="fa-solid fa-arrow-left"></i> Back to Cart
              </a>
              <button class="btn btn-primary" onclick="goStep(2)" id="step1Next">
                Continue <i class="fa-solid fa-arrow-right"></i>
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- ── STEP 2: Delivery Details ── -->
    <div class="step-panel" id="step-2">
      <div class="checkout-grid">
        <div class="co-card">
          <div class="co-card-title"><i class="fa-solid fa-truck"></i> Delivery Address</div>
          <form id="deliveryForm" novalidate>
            <div class="form-row">
              <div class="form-group">
                <label>Full Name *</label>
                <input type="text" id="shipName" placeholder="Aryan Sharma" required autocomplete="name" />
              </div>
              <div class="form-group">
                <label>Phone Number *</label>
                <input type="tel" id="shipPhone" placeholder="+91 98765 43210" required autocomplete="tel" />
              </div>
            </div>
            <div class="form-row single">
              <div class="form-group">
                <label>Street Address *</label>
                <input type="text" id="shipAddress" placeholder="Flat 4B, Prestige Tower, MG Road" required autocomplete="street-address" />
              </div>
            </div>
            <div class="form-row">
              <div class="form-group">
                <label>City *</label>
                <input type="text" id="shipCity" placeholder="Bengaluru" required autocomplete="address-level2" />
              </div>
              <div class="form-group">
                <label>State *</label>
                <input type="text" id="shipState" placeholder="Karnataka" required autocomplete="address-level1" />
              </div>
            </div>
            <div class="form-row">
              <div class="form-group">
                <label>PIN Code *</label>
                <input type="text" id="shipPin" placeholder="560001" maxlength="6" pattern="\d{6}" required autocomplete="postal-code" />
              </div>
              <div class="form-group">
                <label>Landmark (Optional)</label>
                <input type="text" id="shipLandmark" placeholder="Near Metro Station" />
              </div>
            </div>
          </form>
          <div class="step-nav">
            <button class="btn btn-ghost" onclick="goStep(1)"><i class="fa-solid fa-arrow-left"></i> Back</button>
            <button class="btn btn-primary" onclick="validateDelivery()">Continue <i class="fa-solid fa-arrow-right"></i></button>
          </div>
        </div>
        <div>
          <div class="co-card" style="position:sticky;top:100px;">
            <div class="co-card-title"><i class="fa-solid fa-receipt"></i> Order Summary</div>
            <div id="deliverySummaryItems"></div>
            <div class="summary-line total"><span>Total</span><span id="sumTotal2">₹0.00</span></div>
          </div>
        </div>
      </div>
    </div>

    <!-- ── STEP 3: Payment ── -->
    <div class="step-panel" id="step-3">
      <div class="checkout-grid">
        <div class="co-card">
          <div class="co-card-title"><i class="fa-solid fa-credit-card"></i> Payment Method</div>
          <div class="payment-options">
            <label class="pay-opt selected" id="pay-cod">
              <input type="radio" name="payment" value="cod" checked onchange="selectPayment(this)" />
              <div class="pay-opt-icon">💵</div>
              <div class="pay-opt-info">
                <div class="pay-opt-name">Cash on Delivery</div>
                <div class="pay-opt-sub">Pay when your order arrives. No extra charges.</div>
              </div>
              <i class="fa-solid fa-check text-accent" style="font-size:1.1rem;"></i>
            </label>
            <label class="pay-opt" id="pay-upi">
              <input type="radio" name="payment" value="upi" onchange="selectPayment(this)" />
              <div class="pay-opt-icon">📱</div>
              <div class="pay-opt-info">
                <div class="pay-opt-name">UPI / QR Code</div>
                <div class="pay-opt-sub">Pay instantly with any UPI app — GPay, PhonePe, Paytm.</div>
              </div>
            </label>
            <label class="pay-opt" id="pay-card">
              <input type="radio" name="payment" value="card" onchange="selectPayment(this)" />
              <div class="pay-opt-icon">💳</div>
              <div class="pay-opt-info">
                <div class="pay-opt-name">Credit / Debit Card</div>
                <div class="pay-opt-sub">Visa, Mastercard, Rupay — all major cards accepted.</div>
              </div>
            </label>
          </div>

          <!-- UPI Details (conditional) -->
          <div id="upiFields" style="display:none;margin-top:1.25rem;">
            <div class="form-group">
              <label>UPI ID</label>
              <input type="text" id="upiId" placeholder="yourname@upi" />
            </div>
          </div>

          <!-- Card Details (conditional) -->
          <div id="cardFields" style="display:none;margin-top:1.25rem;">
            <div class="form-row single">
              <div class="form-group">
                <label>Card Number</label>
                <input type="text" id="cardNum" placeholder="•••• •••• •••• ••••" maxlength="19" />
              </div>
            </div>
            <div class="form-row">
              <div class="form-group">
                <label>Expiry (MM/YY)</label>
                <input type="text" id="cardExp" placeholder="08/27" maxlength="5" />
              </div>
              <div class="form-group">
                <label>CVV</label>
                <input type="text" id="cardCvv" placeholder="•••" maxlength="3" />
              </div>
            </div>
          </div>

          <div class="step-nav">
            <button class="btn btn-ghost" onclick="goStep(2)"><i class="fa-solid fa-arrow-left"></i> Back</button>
            <button class="btn btn-primary" onclick="placeOrder()" id="placeOrderBtn">
              <i class="fa-solid fa-bag-shopping"></i> Place Order
            </button>
          </div>
        </div>
        <div>
          <div class="co-card" style="position:sticky;top:100px;">
            <div class="co-card-title"><i class="fa-solid fa-receipt"></i> Final Order Summary</div>
            <div id="paymentSummaryItems"></div>
            <div class="summary-line"><span>Subtotal</span><span id="sumTotal3">₹0.00</span></div>
            <div class="summary-line"><span>Shipping</span><span style="color:#10b981;font-weight:700;">FREE</span></div>
            <div class="summary-line total"><span>Total Payable</span><span id="sumTotal3b">₹0.00</span></div>
            <div style="margin-top:1rem;padding:0.75rem;background:rgba(16,185,129,0.08);border:1px solid rgba(16,185,129,0.25);border-radius:var(--radius-md);font-size:0.78rem;color:#10b981;display:flex;align-items:center;gap:8px;">
              <i class="fa-solid fa-shield-halved"></i> 256-bit SSL encrypted. Your data is safe.
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- ── STEP 4: Confirmation ── -->
    <div class="step-panel" id="step-4">
      <div style="max-width:640px;margin:0 auto;">
        <div class="co-card confirm-panel">
          <div class="confirm-check"><i class="fa-solid fa-check"></i></div>
          <h2 class="confirm-order-num" id="confirmOrderNum">#UDX-XXXXXX</h2>
          <p class="confirm-sub">Your order has been placed successfully!<br>You'll receive a confirmation shortly.</p>

          <div class="confirm-details" id="confirmDetails">
            <div>
              <div class="cd-label">Order Number</div>
              <div class="cd-value" id="cdOrderNum">—</div>
            </div>
            <div>
              <div class="cd-label">Total Paid</div>
              <div class="cd-value" id="cdTotal">—</div>
            </div>
            <div>
              <div class="cd-label">Payment Method</div>
              <div class="cd-value" id="cdPayment">—</div>
            </div>
            <div>
              <div class="cd-label">Estimated Delivery</div>
              <div class="cd-value" id="cdDelivery">5–8 Business Days</div>
            </div>
            <div style="grid-column: 1/-1;">
              <div class="cd-label">Delivery Address</div>
              <div class="cd-value" id="cdAddress">—</div>
            </div>
          </div>

          <div style="display:flex;gap:1rem;justify-content:center;flex-wrap:wrap;">
            <a href="<?= APP_URL ?>/public/orders.php" class="btn btn-secondary">
              <i class="fa-solid fa-box"></i> My Orders
            </a>
            <a href="<?= APP_URL ?>/public/products.php" class="btn btn-primary">
              <i class="fa-solid fa-arrow-right"></i> Continue Shopping
            </a>
          </div>
        </div>
      </div>
    </div>

  </div><!-- /checkout-wrap -->
</main>

<script>
// ── State ────────────────────────────────────────────────────
let cartData     = [];
let totalAmount  = 0;
let currentStep  = 1;
const STEPS      = 4;
const CSRF       = '<?= $csrfToken ?>';
const APP_URL    = '<?= APP_URL ?>';
let selectedPayment = 'cod';
let placedOrder  = null;

// ── Step Navigation ──────────────────────────────────────────
function goStep(n) {
  if (n < 1 || n > STEPS) return;
  document.getElementById(`step-${currentStep}`).classList.remove('active');
  currentStep = n;
  document.getElementById(`step-${currentStep}`).classList.add('active');

  // Update step bar
  for (let i = 1; i <= STEPS; i++) {
    const si = document.getElementById(`si-${i}`);
    si.classList.remove('active', 'done');
    if (i < n)  si.classList.add('done');
    if (i === n) si.classList.add('active');
  }
  for (let i = 1; i < STEPS; i++) {
    const sl = document.getElementById(`sl-${i}`);
    sl.classList.toggle('done', i < n);
  }
  window.scrollTo({ top: 0, behavior: 'smooth' });
}

// ── Load Cart ────────────────────────────────────────────────
async function loadCart() {
  try {
    const res  = await fetch(`${APP_URL}/api/cart/get.php`);
    const data = await res.json();

    if (!data.success || !data.items?.length) {
      document.getElementById('reviewCartItems').innerHTML = `
        <div style="text-align:center;padding:3rem 1rem;color:var(--text-muted);">
          <i class="fa-solid fa-shopping-bag" style="font-size:2.5rem;margin-bottom:1rem;"></i>
          <h3 style="margin-bottom:.5rem;">Your bag is empty</h3>
          <a href="${APP_URL}/public/products.php" class="btn btn-primary" style="margin-top:1rem;">Browse Catalog</a>
        </div>`;
      document.getElementById('step1Next').disabled = true;
      document.getElementById('step1Next').style.opacity = '0.5';
      return;
    }

    cartData    = data.items;
    totalAmount = parseFloat(data.total_amount);

    // Review step items
    document.getElementById('reviewCartItems').innerHTML = cartData.map(it => `
      <div style="display:flex;align-items:center;gap:1rem;padding:1rem 0;border-bottom:1px solid var(--border-subtle);">
        <img src="${APP_URL}/${esc(it.main_image)}" alt="${esc(it.title)}"
             style="width:72px;height:72px;object-fit:cover;border-radius:var(--radius-md);" />
        <div style="flex:1;min-width:0;">
          <div style="font-size:.75rem;color:var(--accent-gold);font-weight:700;text-transform:uppercase;margin-bottom:2px;">${esc(it.category_name)}</div>
          <div style="font-weight:700;margin-bottom:2px;">${esc(it.title)}</div>
          <div style="font-size:.85rem;color:var(--text-muted);">Qty: ${it.quantity} × ${fmt(it.price)}</div>
        </div>
        <div style="font-weight:700;color:var(--accent-gold);font-size:1.05rem;white-space:nowrap;">${fmt(it.subtotal)}</div>
      </div>
    `).join('');

    renderSummary('reviewSummaryItems');
    renderSummary('deliverySummaryItems');
    renderSummary('paymentSummaryItems');
    setTotals();

  } catch(e) { console.error('Cart load error:', e); }
}

function renderSummary(containerId) {
  document.getElementById(containerId).innerHTML = cartData.map(it => `
    <div class="summary-item">
      <img src="${APP_URL}/${esc(it.main_image)}" alt="${esc(it.title)}" onerror="this.style.display='none'" />
      <div class="summary-item-info">
        <div class="summary-item-name">${esc(it.title)}</div>
        <div class="summary-item-qty">×${it.quantity}</div>
      </div>
      <div class="summary-item-price">${fmt(it.subtotal)}</div>
    </div>
  `).join('');
}

function setTotals() {
  const f = fmt(totalAmount);
  ['sumSubtotal','sumTotal','sumTotal2','sumTotal3','sumTotal3b'].forEach(id => {
    const el = document.getElementById(id);
    if (el) el.textContent = f;
  });
}

// ── Delivery Validation ──────────────────────────────────────
function validateDelivery() {
  const name    = document.getElementById('shipName').value.trim();
  const phone   = document.getElementById('shipPhone').value.trim();
  const address = document.getElementById('shipAddress').value.trim();
  const city    = document.getElementById('shipCity').value.trim();
  const pin     = document.getElementById('shipPin').value.trim();

  if (!name || !phone || !address || !city || !pin) {
    showToastError('Please fill in all required delivery fields.');
    return;
  }
  if (!/^\d{6}$/.test(pin)) {
    showToastError('PIN code must be exactly 6 digits.');
    return;
  }
  if (!/^\+?[\d\s\-]{10,15}$/.test(phone)) {
    showToastError('Please enter a valid phone number.');
    return;
  }
  goStep(3);
}

// ── Payment Method Selection ─────────────────────────────────
function selectPayment(radio) {
  selectedPayment = radio.value;
  document.querySelectorAll('.pay-opt').forEach(el => {
    el.classList.remove('selected');
    el.querySelector('.fa-check')?.remove();
  });
  const selected = radio.closest('.pay-opt');
  selected.classList.add('selected');
  const icon = document.createElement('i');
  icon.className = 'fa-solid fa-check text-accent';
  icon.style.fontSize = '1.1rem';
  selected.appendChild(icon);

  document.getElementById('upiFields').style.display  = selectedPayment === 'upi'  ? 'block' : 'none';
  document.getElementById('cardFields').style.display = selectedPayment === 'card' ? 'block' : 'none';
}

// ── Place Order ──────────────────────────────────────────────
async function placeOrder() {
  const btn = document.getElementById('placeOrderBtn');
  btn.disabled = true;

  const payload = {
    csrf_token:       CSRF,
    shipping_name:    document.getElementById('shipName').value.trim(),
    shipping_address: document.getElementById('shipAddress').value.trim(),
    shipping_city:    document.getElementById('shipCity').value.trim(),
    shipping_state:   document.getElementById('shipState').value.trim(),
    shipping_pin:     document.getElementById('shipPin').value.trim(),
    shipping_phone:   document.getElementById('shipPhone').value.trim(),
    payment_method:   selectedPayment,
  };

  document.getElementById('placingOverlay').classList.add('show');

  try {
    const res  = await fetch(`${APP_URL}/api/orders/place.php`, {
      method:  'POST',
      headers: { 'Content-Type': 'application/json' },
      body:    JSON.stringify(payload),
    });
    const data = await res.json();

    document.getElementById('placingOverlay').classList.remove('show');

    if (data.success) {
      placedOrder = data;
      populateConfirmation(data, payload);
      goStep(4);
      // Update cart badge to 0
      const badge = document.getElementById('headerCartBadge');
      if (badge) { badge.textContent = '0'; badge.style.display = 'none'; }
    } else {
      showToastError(data.error || 'Could not place order. Please try again.');
      btn.disabled = false;
    }
  } catch(e) {
    document.getElementById('placingOverlay').classList.remove('show');
    showToastError('Network error. Please check your connection.');
    btn.disabled = false;
  }
}

function populateConfirmation(data, payload) {
  document.getElementById('confirmOrderNum').textContent  = `#${data.order_number}`;
  document.getElementById('cdOrderNum').textContent       = data.order_number;
  document.getElementById('cdTotal').textContent          = fmt(data.total_amount);
  document.getElementById('cdPayment').textContent        = { cod: 'Cash on Delivery', upi: 'UPI Payment', card: 'Credit / Debit Card' }[payload.payment_method] || 'COD';
  document.getElementById('cdAddress').textContent        = `${payload.shipping_address}, ${payload.shipping_city}, ${payload.shipping_state} — ${payload.shipping_pin}`;

  const now = new Date();
  now.setDate(now.getDate() + 7);
  document.getElementById('cdDelivery').textContent = now.toLocaleDateString('en-IN', { weekday:'long', day:'numeric', month:'long' });
}

// ── Helpers ──────────────────────────────────────────────────
function esc(str) {
  if (!str) return '';
  return str.replace(/[&<>"']/g, t => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[t]||t));
}
function fmt(amount) {
  return '₹' + parseFloat(amount).toLocaleString('en-IN', { minimumFractionDigits: 2 });
}
function showToastError(msg) {
  let t = document.getElementById('co-toast');
  if (!t) {
    t = document.createElement('div');
    t.id = 'co-toast';
    t.style.cssText = 'position:fixed;bottom:24px;left:50%;transform:translateX(-50%);background:#ef4444;color:#fff;padding:10px 22px;border-radius:99px;font-weight:600;font-size:.88rem;z-index:10000;opacity:0;transition:opacity .3s;pointer-events:none;';
    document.body.appendChild(t);
  }
  t.textContent = msg;
  t.style.opacity = '1';
  setTimeout(() => { t.style.opacity = '0'; }, 3500);
}

document.addEventListener('DOMContentLoaded', loadCart);
</script>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
