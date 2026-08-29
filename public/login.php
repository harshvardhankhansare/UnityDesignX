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
            <i class="fa-solid fa-user-lock text-accent" style="font-size: 2.5rem; margin-bottom: 1rem;"></i>
            <h2>Welcome Back</h2>
            <p style="color: var(--text-secondary); font-size: 0.9rem; margin-top: 0.5rem;">Log in to access your saved interior projects & cart</p>
        </div>

        <div id="alertBanner" class="alert-banner alert-error"></div>

        <form id="loginForm">
            <div class="form-group">
                <label class="form-label" for="email">Email Address</label>
                <input type="email" id="email" name="email" class="form-control" placeholder="tester@gmail.com" required />
            </div>

            <div class="form-group">
                <label class="form-label" for="password">Password</label>
                <input type="password" id="password" name="password" class="form-control" placeholder="••••••••" required />
            </div>

            <button type="submit" id="submitBtn" class="btn btn-primary" style="width: 100%; justify-content: center;">
                Log In
            </button>
        </form>

        <div style="text-align: center; margin-top: 1.5rem; font-size: 0.9rem; color: var(--text-secondary);">
            Don't have an account? <a href="<?= APP_URL ?>/public/register.php" class="text-accent" style="font-weight: 600;">Create Account</a>
        </div>
    </div>
</main>

<script>
document.getElementById('loginForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    const alertBanner = document.getElementById('alertBanner');
    const submitBtn = document.getElementById('submitBtn');
    
    alertBanner.style.display = 'none';
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Logging in...';

    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;

    try {
        const response = await fetch('<?= APP_URL ?>/api/auth/login.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ email, password })
        });

        const result = await response.json();

        if (result.success) {
            alertBanner.className = 'alert-banner alert-success';
            alertBanner.innerText = result.message;
            alertBanner.style.display = 'block';
            setTimeout(() => {
                window.location.href = result.redirect_url || '<?= APP_URL ?>/public/index.php';
            }, 800);
        } else {
            alertBanner.className = 'alert-banner alert-error';
            alertBanner.innerText = result.error || 'Login failed';
            alertBanner.style.display = 'block';
            submitBtn.disabled = false;
            submitBtn.innerHTML = 'Log In';
        }
    } catch (error) {
        alertBanner.className = 'alert-banner alert-error';
        alertBanner.innerText = 'Network error occurred. Please try again.';
        alertBanner.style.display = 'block';
        submitBtn.disabled = false;
        submitBtn.innerHTML = 'Log In';
    }
});
</script>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
