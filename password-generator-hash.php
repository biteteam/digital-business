<?php

echo "\nPassword: ";
$raw_password = trim(fgets(fopen("php://stdin", "r")));
$hash_password = password_hash($raw_password, PASSWORD_DEFAULT);

echo "\n========================================\n";
echo "Raw  Password: {$raw_password}\n";
echo "Hash Password: {$hash_password}\n";
