<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: rsvp.html');
    exit;
}

$csvDirectory = dirname(__DIR__) . '/csv';
$csvFile = $csvDirectory . '/rsvp-submissions.csv';

if (!is_dir($csvDirectory) && !mkdir($csvDirectory, 0777, true) && !is_dir($csvDirectory)) {
    http_response_code(500);
    exit('Could not create the RSVP storage directory.');
}

if (!file_exists($csvFile)) {
    $handle = fopen($csvFile, 'w');
    if ($handle === false) {
        http_response_code(500);
        exit('Could not create RSVP storage file.');
    }
    fputcsv($handle, ['timestamp', 'guest_name', 'party_members', 'attending', 'lodging_needed', 'lodging_email', 'dietary_requests', 'contact_email', 'phone_number']);
    fclose($handle);
}

if (!is_writable($csvDirectory)) {
    http_response_code(500);
    exit('The RSVP storage directory is not writable by PHP.');
}

$timestamp = date('Y-m-d H:i:s');
$data = [
    $timestamp,
    $_POST['guest_name'] ?? '',
    $_POST['party_members'] ?? '',
    $_POST['attending'] ?? '',
    $_POST['lodging_needed'] ?? '',
    $_POST['lodging_email'] ?? '',
    $_POST['dietary_requests'] ?? '',
    $_POST['contact_email'] ?? '',
    $_POST['phone_number'] ?? ''
];

$handle = fopen($csvFile, 'a');
if ($handle === false) {
    http_response_code(500);
    exit('Could not write RSVP entry.');
}

fputcsv($handle, $data);
fclose($handle);

header('Location: rsvp-thank-you.html');
exit;
