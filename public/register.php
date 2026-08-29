<?php
require_once __DIR__ . '/../includes/header.php';
if (is_logged_in()) {
    header('Location: ' . APP_URL . '/public/index.php');
    exit;
}
?>

<main class="auth-wrapper">
    <div class="auth-card">
        <div style="text-align: center; margin-bottom: 2rem;">
            <i class="fa-solid fa-user-plus text-accent" style="font-size: 2.5rem; margin-bottom: 1rem;"></i>
            <h2>Create Account</h2>
            <p style="color: var(--text-secondary); font-size: 0.9rem; margin-top: 0.5rem;">Join UnityDesignX for custom interior collections</p>
        </div>

        <div id="alertBanner" class="alert-banner alert-error"></div>

        <form id="registerForm">
            <div class="form-group">
                <label class="form-label" for="full_name">Full Name</label>
                <input type="text" id="full_name" name="full_name" class="form-control" placeholder="Harsh Khansare" required />
            </div>

            <div class="form-group">
                <label class="form-label" for="email">Email Address</label>
                <input type="email" id="email" name="email" class="form-control" placeholder="harsh@example.com" required />
            </div>

            <div class="form-group">
                <label class="form-label" for="password">Password (min 6 chars)</label>
                <input type="password" id="password" name="password" class="form-control" placeholder="••••••••" minlength="6" required />
            </div>

            <button type="submit" id="submitBtn" class="btn btn-primary" style="width: 100%; justify-content: center;">
                Create Account
            </button>
        </form>

        <div style="text-align: center; margin-top: 1.5rem; font-size: 0.9rem; color: var(--text-secondary);">
            Already have an account? <a href="<?= APP_URL ?>/public/login.php" class="text-accent" style="font-weight: 600;">Log In</a>
        </div>
    </div>
</main>

<script>
document.getElementById('registerForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    const alertBanner = document.getElementById('alertBanner');
    const submitBtn = document.getElementById('submitBtn');
    
    alertBanner.style.display = 'none';
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Creating Account...';

    const full_name = document.getElementById('full_name').value;
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;

    try {
        const response = await fetch('<?= APP_URL ?>/api/auth/register.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ full_name, email, password })
        });

        const result = await response.json();

        if (result.success) {
            alertBanner.className = 'alert-banner alert-success';
            alertBanner.innerText = result.message;
            alertBanner.style.display = 'block';
            setTimeout(() => {
                window.location.href = '<?= APP_URL ?>/public/index.php';
            }, 1000);
        } else {
            alertBanner.className = 'alert-banner alert-error';
            alertBanner.innerText = result.error || 'Registration failed';
            alertBanner.style.display = 'block';
            submitBtn.disabled = false;
            submitBtn.innerHTML = 'Create Account';
        }
    } catch (error) {
        alertBanner.className = 'alert-banner alert-error';
        alertBanner.innerText = 'Network error occurred. Please try again.';
        alertBanner.style.display = 'block';
        submitBtn.disabled = false;
        submitBtn.innerHTML = 'Create Account';
    }
});
</script>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
