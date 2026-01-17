<?php
$projectPath = __DIR__;
$files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($projectPath));
$tables = ['users','movies','showtimes','bookings','offers','contact_messages','settings']; // add your table names

$used = [];

foreach ($files as $file) {
    if (pathinfo($file, PATHINFO_EXTENSION) === 'php') {
        $content = file_get_contents($file);
        foreach ($tables as $table) {
            if (stripos($content, $table) !== false) {
                $used[$table] = true;
            }
        }
    }
}

echo "<h2>📊 Table Usage Report</h2>";
foreach ($tables as $table) {
    if (isset($used[$table])) {
        echo "<p style='color:#00ff99;'>✅ $table — Used in project</p>";
    } else {
        echo "<p style='color:#ff5555;'>❌ $table — Not used in any file</p>";
    }
}
?>
