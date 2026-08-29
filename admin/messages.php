<?php
/**
 * Admin Contact Messages Inbox
 * UnityDesignX Platform
 */
require_once __DIR__ . '/../includes/header.php';
require_admin();

$db = get_db();

// Handle Delete Message
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_msg_id'])) {
    $delId = (int)$_POST['delete_msg_id'];
    if ($delId > 0) {
        $stmt = $db->prepare("DELETE FROM contact_messages WHERE message_id = :mid");
        $stmt->execute([':mid' => $delId]);
    }
}

// Fetch all contact messages
$messages = $db->query("SELECT * FROM contact_messages ORDER BY created_at DESC")->fetchAll();
?>

<style>
.admin-wrap { max-width: 1100px; margin: 0 auto; padding: 2.5rem 1.5rem 4rem; }

.table-card {
  background: var(--bg-card);
  border: 1px solid var(--border-subtle);
  border-radius: var(--radius-lg);
  padding: 1.5rem;
  margin-top: 1.5rem;
}

.msg-table { width: 100%; border-collapse: collapse; font-size: 0.88rem; }
.msg-table th, .msg-table td { padding: 0.9rem 0.75rem; text-align: left; border-bottom: 1px solid var(--border-subtle); }
.msg-table th { color: var(--text-muted); font-size: 0.75rem; text-transform: uppercase; }
</style>

<main>
  <div class="admin-wrap">
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1.5rem;">
      <div>
        <h1 style="font-size: 2.2rem; margin-bottom: 0.25rem;">
          Customer <span class="text-accent">Messages Inbox</span>
        </h1>
        <p style="color: var(--text-secondary);">Inquiries submitted through the Contact Us form.</p>
      </div>
      <div>
        <a href="<?= APP_URL ?>/admin/dashboard.php" class="btn btn-secondary"><i class="fa-solid fa-arrow-left"></i> Back to Dashboard</a>
      </div>
    </div>

    <div class="table-card">
      <?php if (empty($messages)): ?>
        <p style="color:var(--text-muted);text-align:center;padding:3rem 0;">No contact messages received yet.</p>
      <?php else: ?>
        <div style="overflow-x:auto;">
          <table class="msg-table">
            <thead>
              <tr>
                <th>Date</th>
                <th>Sender</th>
                <th>Subject</th>
                <th>Message</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($messages as $m): ?>
                <tr>
                  <td style="color:var(--text-muted);font-size:0.8rem;white-space:nowrap;">
                    <?= date('d M, Y H:i', strtotime($m['created_at'])) ?>
                  </td>
                  <td>
                    <div style="font-weight:700;"><?= e($m['name']) ?></div>
                    <a href="mailto:<?= e($m['email']) ?>" style="font-size:0.78rem;color:var(--accent-gold);"><?= e($m['email']) ?></a>
                  </td>
                  <td style="font-weight:600;color:var(--text-primary);"><?= e($m['subject']) ?></td>
                  <td style="max-width:320px;color:var(--text-secondary);font-size:0.85rem;line-height:1.4;">
                    <?= e($m['message']) ?>
                  </td>
                  <td>
                    <form method="POST" onsubmit="return confirm('Delete this message?');">
                      <input type="hidden" name="delete_msg_id" value="<?= $m['message_id'] ?>" />
                      <button type="submit" class="btn btn-ghost" style="padding:0.4rem 0.6rem;color:#ef4444;" title="Delete Message">
                        <i class="fa-solid fa-trash-can"></i>
                      </button>
                    </form>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      <?php endif; ?>
    </div>
  </div>
</main>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
