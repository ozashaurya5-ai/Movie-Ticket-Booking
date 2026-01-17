<?php
// admin/admin-header.php
require __DIR__ . '/functions.php';
admin_check();
?>
<header style="
  background: #ffffff;
  border-bottom: 1px solid #e2e8f0;
  box-shadow: 0 2px 8px rgba(0,0,0,0.05);
  padding: 14px 0;
  position: sticky;
  top: 0;
  z-index: 10;
">
  <div style="
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
  ">
    <div style="display:flex;align-items:center;gap:8px;">
      <a href="index.php" style="
        font-weight: 800;
        font-size: 20px;
        color: #0b63ff;
        text-decoration: none;
      ">TRX Cinema Admin</a>
    </div>

    <div style="font-size:14px; color:#334155;">
      Logged in as 
      <b style="color:#0b63ff;"><?php echo htmlspecialchars($_SESSION['admin_name']); ?></b>
      &nbsp;|&nbsp;
      <a href="logout.php" style="
        color:#ef4444;
        text-decoration:none;
        font-weight:600;
      ">Logout</a>
    </div>
  </div>
</header>
