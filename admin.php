<?php
// === LIVE DATABASE ADMIN DASHBOARD ===
$servername = "sprenvonixdatabase.cg3qee2cupk4.us-east-1.rds.amazonaws.com";
$username   = "admin";
$password   = "wavelearning12%";
$dbname     = "contactdb";

$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Handle Seed / Clear actions
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] === 'seed') {
        $samples = [
            ['Amina Yusuf','Praxis Digital Advisory','amina@praxisdigital.ca','+1 403 555 0134','Cloud Architecture & Migration','Project Scoping','2026-04-15','10:00','We need a secure cloud hosting strategy for a new consulting platform and would like an architecture review.'],
            ['Daniel Ofori','NorthPeak Learning','daniel@northpeaklearning.org','+1 587 555 0178','Technical Training & Curriculum Design','Training Partnership','2026-04-18','13:30','We are exploring a cohort-based technical upskilling program for cloud and DevOps fundamentals.']
        ];
        foreach ($samples as $s) {
            $stmt = $conn->prepare("INSERT INTO Customer (fullName, organization, email, phone, service, requestType, preferredDate, preferredTime, message) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssssss", $s[0], $s[1], $s[2], $s[3], $s[4], $s[5], $s[6], $s[7], $s[8]);
            $stmt->execute();
            $stmt->close();
        }
        header("Location: admin.php?msg=Sample records loaded successfully");
        exit;
    }
    if ($_POST['action'] === 'clear') {
        mysqli_query($conn, "DELETE FROM Customer");
        header("Location: admin.php?msg=All records cleared");
        exit;
    }
}

// Fetch all records
$result = mysqli_query($conn, "SELECT * FROM Customer ORDER BY id DESC"); // or submittedAt if you added it
$records = mysqli_fetch_all($result, MYSQLI_ASSOC);
mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard | Sprevonix</title>
  <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
  <!-- HEADER (same as original) -->
  <header class="site-header">
    <div class="container nav-wrap">
      <div class="logo">
        <div class="logo-mark">S</div>
        Sprevonix
      </div>
      <nav class="site-nav">
        <a href="index.php">Home</a>
        <a href="about.php">About</a>
        <a href="services.php">Services</a>
        <a href="portfolio.php">Portfolio</a>
        <a href="contact.php">Contact</a>
        <a href="admin.php" class="active">Admin</a>
      </nav>
      <button class="nav-toggle">☰</button>
    </div>
  </header>

  <main class="container" style="padding-top: 2rem;">
    <h1>Admin Dashboard</h1>
    <p class="lead">Submission review console – live from RDS database</p>

    <?php if (isset($_GET['msg'])): ?>
      <div class="form-message" style="color:#0f9d58; margin-bottom:1rem;">
        <?= htmlspecialchars($_GET['msg']) ?>
      </div>
    <?php endif; ?>

    <div class="admin-toolbar">
      <form method="POST" style="display:inline;">
        <button type="submit" name="action" value="seed" class="btn">Load Sample Records</button>
      </form>
      <form method="POST" style="display:inline;">
        <button type="submit" name="action" value="clear" class="btn danger">Clear All Records</button>
      </form>
    </div>

    <div class="table-card">
      <table>
        <thead>
          <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Service</th>
            <th>Request Type</th>
            <th>Preferred Slot</th>
            <th>Submitted</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($records)): ?>
            <tr><td colspan="6" class="empty-state">No records yet. Submit the form or load sample records.</td></tr>
          <?php else: ?>
            <?php foreach ($records as $item): ?>
              <tr>
                <td><strong><?= htmlspecialchars($item['fullName']) ?></strong><br><span><?= htmlspecialchars($item['organization'] ?? '—') ?></span></td>
                <td><?= htmlspecialchars($item['email']) ?><br><span><?= htmlspecialchars($item['phone'] ?? '—') ?></span></td>
                <td><?= htmlspecialchars($item['service'] ?? '—') ?></td>
                <td><?= htmlspecialchars($item['requestType'] ?? '—') ?></td>
                <td><?= htmlspecialchars($item['preferredDate'] ?? '—') ?> <?= htmlspecialchars($item['preferredTime'] ?? '') ?></td>
                <td><?= isset($item['submittedAt']) ? htmlspecialchars($item['submittedAt']) : 'Just now' ?></td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </main>

  <!-- FOOTER (same as original) -->
  <footer class="site-footer">
    <!-- ... your original footer HTML ... -->
  </footer>

  <script src="assets/js/app.js"></script>
</body>
</html>
