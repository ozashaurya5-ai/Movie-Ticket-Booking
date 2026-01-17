<?php
// make_hash.php
$plain = 'admin12345'; // your chosen password
echo password_hash($plain, PASSWORD_DEFAULT) . PHP_EOL;