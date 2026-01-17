<?php
require __DIR__ . '/functions.php';
admin_check();
$res = $conn->query("SELECT al.*, a.username FROM audit_log al LEFT JOIN admins a ON a.id = al.admin_id ORDER BY al.created_at DESC LIMIT 200");
?>
<!doctype html><html><head><meta charset="utf-8"><title>Audit Log</title>
<link rel="stylesheet" href="../style.css"></head><body>
<?php include 'admin-header.php'; ?>
<div style="max-width:1200px;margin:20px auto">
  <h2>Audit Log (recent)</h2>
  <table width="100%" cellpadding="8">
    <thead><tr><th>When</th><th>Admin</th><th>Action</th><th>Details</th><th>IP</th></tr></thead>
    <?php while($r=$res->fetch_assoc()): ?>
    <tr>
      <td><?php echo $r['created_at']; ?></td>
      <td><?php echo htmlspecialchars($r['username'] ?? 'System'); ?></td>
      <td><?php echo htmlspecialchars($r['action']); ?></td>
      <td><?php echo htmlspecialchars($r['details']); ?></td>
      <td><?php echo htmlspecialchars($r['ip']); ?></td>
    </tr>
    <?php endwhile; ?>
  </table>
</div>
</body></html>
