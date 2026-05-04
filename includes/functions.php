<?php

function generateRandomCode(string $prefix, int $length = 6): string
{
    $random = strtoupper(substr(bin2hex(random_bytes(ceil($length / 2))), 0, $length));
    return $prefix ? $prefix . '-' . $random : $random;
}

function generateUniqueCode(mysqli $conn, string $table, string $column, string $prefix, int $length = 6): string
{
    do {
        $code = generateRandomCode($prefix, $length);
        $stmt = $conn->prepare("SELECT 1 FROM {$table} WHERE {$column} = ? LIMIT 1");
        $stmt->bind_param('s', $code);
        $stmt->execute();
        $stmt->store_result();
        $isDuplicate = $stmt->num_rows > 0;
        $stmt->close();
    } while ($isDuplicate);

    return $code;
}

function generateOrderNumber(mysqli $conn): string
{
    return generateUniqueCode($conn, 'orders', 'order_number', 'ORD', 8);
}

function formatFullName(string $firstName, string $lastName): string
{
    return trim($firstName . ' ' . $lastName);
}

?>