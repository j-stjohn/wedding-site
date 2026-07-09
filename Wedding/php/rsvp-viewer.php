<?php
$csvFile = __DIR__ . '/rsvp-submissions.csv';
$rows = [];

if (file_exists($csvFile)) {
    $handle = fopen($csvFile, 'r');
    if ($handle !== false) {
        $header = fgetcsv($handle);
        while (($row = fgetcsv($handle)) !== false) {
            if (count($row) === 0) {
                continue;
            }
            $rows[] = array_combine($header, $row);
        }
        fclose($handle);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>RSVP Viewer</title>
  <style>
    body {
      margin: 0;
      font-family: Georgia, serif;
      background: linear-gradient(135deg, #f8f5ef 0%, #dfe8ef 45%, #cfdce8 100%);
      color: #2b2f35;
      padding: 24px;
    }

    .page {
      max-width: 1100px;
      margin: 0 auto;
    }

    h1 {
      color: #183b63;
      margin-bottom: 8px;
    }

    .summary {
      margin-bottom: 20px;
      color: #4f6f8d;
    }

    .card {
      background: rgba(255,255,255,0.92);
      border-radius: 18px;
      padding: 20px;
      margin-bottom: 16px;
      box-shadow: 0 10px 24px rgba(47,47,47,0.08);
    }

    .card h2 {
      margin-top: 0;
      color: #183b63;
      font-size: 1.1rem;
    }

    .meta {
      display: flex;
      flex-wrap: wrap;
      gap: 12px;
      margin-bottom: 10px;
      color: #4f6f8d;
      font-size: 0.95rem;
    }

    .field {
      margin-bottom: 6px;
    }

    .field strong {
      color: #183b63;
    }
  </style>
</head>
<body>
  <div class="page">
    <h1>Wedding RSVP Viewer</h1>
    <p class="summary">This page shows the RSVP submissions in an easier-to-read format for local hosting.</p>

    <?php if (empty($rows)): ?>
      <div class="card">
        <p>No RSVP submissions have been received yet.</p>
      </div>
    <?php else: ?>
      <?php foreach ($rows as $index => $row): ?>
        <div class="card">
          <h2><?php echo htmlspecialchars($row['guest_name'] ?: 'Unnamed guest'); ?></h2>
          <div class="meta">
            <span>Submitted: <?php echo htmlspecialchars($row['timestamp'] ?? ''); ?></span>
            <span>Attending: <?php echo htmlspecialchars($row['attending'] ?? ''); ?></span>
          </div>
          <div class="field"><strong>Party:</strong> <?php echo htmlspecialchars($row['party_members'] ?? ''); ?></div>
          <div class="field"><strong>Lodging needed:</strong> <?php echo htmlspecialchars($row['lodging_needed'] ?? ''); ?></div>
          <div class="field"><strong>Lodging email:</strong> <?php echo htmlspecialchars($row['lodging_email'] ?? ''); ?></div>
          <div class="field"><strong>Dietary requests:</strong> <?php echo htmlspecialchars($row['dietary_requests'] ?? ''); ?></div>
          <div class="field"><strong>Contact email:</strong> <?php echo htmlspecialchars($row['contact_email'] ?? ''); ?></div>
          <div class="field"><strong>Phone:</strong> <?php echo htmlspecialchars($row['phone_number'] ?? ''); ?></div>
        </div>
      <?php endforeach; ?>
    <?php endif; ?>
  </div>
</body>
</html>
