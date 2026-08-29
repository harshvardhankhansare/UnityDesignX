<?php
/**
 * Public Contact Us Page
 * UnityDesignX Platform
 */
require_once __DIR__ . '/../includes/header.php';
?>

<style>
.contact-wrap {
  max-width: 1100px;
  margin: 0 auto;
  padding: 3rem 1.5rem 5rem;
}

.contact-grid {
  display: grid;
  grid-template-columns: 1fr 1.2fr;
  gap: 3rem;
  align-items: start;
}
@media (max-width: 850px) {
  .contact-grid { grid-template-columns: 1fr; }
}

.contact-info-card {
  background: var(--bg-card);
  border: 1px solid var(--border-subtle);
  border-radius: var(--radius-lg);
  padding: 2.5rem;
}

.info-item {
  display: flex;
  align-items: flex-start;
  gap: 1.25rem;
  margin-bottom: 2rem;
}
.info-icon {
  width: 48px;
  height: 48px;
  border-radius: 12px;
  background: rgba(212,175,55,0.1);
  border: 1px solid rgba(212,175,55,0.25);
  color: var(--accent-gold);
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1.3rem;
  flex-shrink: 0;
}
.info-title { font-weight: 700; font-size: 1.05rem; margin-bottom: 4px; }
.info-desc { color: var(--text-secondary); font-size: 0.9rem; line-height: 1.5; }

.contact-form-card {
  background: var(--bg-card);
  border: 1px solid var(--border-subtle);
  border-radius: var(--radius-lg);
  padding: 2.5rem;
}

.form-group {
  display: flex;
  flex-direction: column;
  gap: 6px;
  margin-bottom: 1.25rem;
}
.form-group label {
  font-size: 0.82rem;
  font-weight: 600;
  color: var(--text-secondary);
  letter-spacing: 0.4px;
}
.form-group input, .form-group textarea, .form-group select {
  padding: 0.8rem 1rem;
  background: var(--bg-primary);
  border: 1px solid var(--border-subtle);
  border-radius: var(--radius-md);
  color: var(--text-primary);
  font-family: var(--font-body);
  font-size: 0.95rem;
  outline: none;
  transition: border-color 0.2s;
}
.form-group input:focus, .form-group textarea:focus {
  border-color: var(--accent-gold);
  box-shadow: 0 0 0 3px rgba(212,175,55,0.12);
}

.alert-box {
  padding: 1rem 1.25rem;
  border-radius: var(--radius-md);
  font-size: 0.9rem;
  margin-bottom: 1.5rem;
  display: none;
}
.alert-success { background: rgba(16,185,129,0.15); border: 1px solid rgba(16,185,129,0.3); color: #34d399; }
.alert-error { background: rgba(239,68,68,0.15); border: 1px solid rgba(239,68,68,0.3); color: #f87171; }
</style>

<main>
  <div class="contact-wrap">
    <div style="text-align: center; max-width: 600px; margin: 0 auto 3.5rem;">
      <h1 style="font-size: 2.5rem; margin-bottom: 0.5rem;">
        Get in <span class="text-accent">Touch</span>
      </h1>
      <p style="color: var(--text-secondary);">Have a question about our interior design services or furniture catalog? We'd love to hear from you.</p>
    </div>

    <div class="contact-grid">
      <!-- Studio Info Card -->
      <div class="contact-info-card">
        <h3 style="font-size: 1.4rem; font-family: var(--font-heading); margin-bottom: 2rem;">Studio Information</h3>

        <div class="info-item">
          <div class="info-icon"><i class="fa-solid fa-location-dot"></i></div>
          <div>
            <div class="info-title">Design Studio & Headquarters</div>
            <div class="info-desc">Level 8, Unity Plaza, MG Road<br>Bengaluru, Karnataka 560001</div>
          </div>
        </div>

        <div class="info-item">
          <div class="info-icon"><i class="fa-solid fa-phone"></i></div>
          <div>
            <div class="info-title">Call Us</div>
            <div class="info-desc">+91 (80) 4567 8900<br>Mon – Sat, 9:00 AM – 7:00 PM</div>
          </div>
        </div>

        <div class="info-item">
          <div class="info-icon"><i class="fa-solid fa-envelope"></i></div>
          <div>
            <div class="info-title">Email Us</div>
            <div class="info-desc">contact@unitydesign.com<br>support@unitydesign.com</div>
          </div>
        </div>

        <div class="info-item" style="margin-bottom:0;">
          <div class="info-icon"><i class="fa-solid fa-clock"></i></div>
          <div>
            <div class="info-title">Consultation Hours</div>
            <div class="info-desc">Private 3D Room Consultations available by appointment.</div>
          </div>
        </div>
      </div>

      <!-- Contact Form Card -->
      <div class="contact-form-card">
        <h3 style="font-size: 1.4rem; font-family: var(--font-heading); margin-bottom: 1.5rem;">Send Us a Message</h3>

        <div class="alert-box alert-success" id="alertSuccess">
          <i class="fa-solid fa-circle-check"></i> <span id="successMsg"></span>
        </div>
        <div class="alert-box alert-error" id="alertError">
          <i class="fa-solid fa-circle-exclamation"></i> <span id="errorMsg"></span>
        </div>

        <form id="contactForm" onsubmit="submitContactForm(event)">
          <div class="form-group">
            <label>Your Name *</label>
            <input type="text" id="cName" required placeholder="John Doe" />
          </div>

          <div class="form-group">
            <label>Email Address *</label>
            <input type="email" id="cEmail" required placeholder="john@example.com" />
          </div>

          <div class="form-group">
            <label>Subject</label>
            <input type="text" id="cSubject" placeholder="Interior Design Consultation Inquiry" />
          </div>

          <div class="form-group">
            <label>Your Message *</label>
            <textarea id="cMessage" rows="5" required placeholder="Tell us about your space or inquiry..."></textarea>
          </div>

          <button type="submit" class="btn btn-primary" id="btnSubmit" style="width: 100%; justify-content: center; padding: 0.9rem;">
            Send Message <i class="fa-solid fa-paper-plane"></i>
          </button>
        </form>
      </div>
    </div>
  </div>
</main>

<script>
async function submitContactForm(e) {
  e.preventDefault();
  const btn = document.getElementById('btnSubmit');
  const alertSuccess = document.getElementById('alertSuccess');
  const alertError = document.getElementById('alertError');

  alertSuccess.style.display = 'none';
  alertError.style.display = 'none';

  btn.disabled = true;
  btn.innerHTML = '<i class="fa-solid fa-circle-notch fa-spin"></i> Sending...';

  const payload = {
    name: document.getElementById('cName').value.trim(),
    email: document.getElementById('cEmail').value.trim(),
    subject: document.getElementById('cSubject').value.trim(),
    message: document.getElementById('cMessage').value.trim()
  };

  try {
    const res = await fetch('<?= APP_URL ?>/api/contact.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(payload)
    });
    const data = await res.json();

    if (data.success) {
      document.getElementById('successMsg').innerText = data.message;
      alertSuccess.style.display = 'block';
      document.getElementById('contactForm').reset();
    } else {
      document.getElementById('errorMsg').innerText = data.error || 'Failed to send message.';
      alertError.style.display = 'block';
    }
  } catch (err) {
    document.getElementById('errorMsg').innerText = 'Network error. Please try again.';
    alertError.style.display = 'block';
  } finally {
    btn.disabled = false;
    btn.innerHTML = 'Send Message <i class="fa-solid fa-paper-plane"></i>';
  }
}
</script>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
