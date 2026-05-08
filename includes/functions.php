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

//function generateOrderNumber(mysqli $conn): string
//{
    //return generateUniqueCode($conn, 'orders', 'order_number', 'ORD', 8);
//}

// includes/functions.php

/**
 * PDO භාවිතා කර අලුත් Order Number එකක් සෑදීම
 */
function generateOrderNumber($pdo) {
    // අන්තිමටම ඇතුළත් කළ Order එකේ ID එක ලබා ගැනීම
    $stmt = $pdo->query("SELECT id FROM orders ORDER BY id DESC LIMIT 1");
    $lastOrder = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($lastOrder) {
        $nextId = $lastOrder['id'] + 1;
    } else {
        $nextId = 1;
    }

    // උදාහරණ: ORD-2026-0001 වැනි ආකාරයට සකස් කිරීම
    return "ORD-" . date("Y") . "-" . str_pad($nextId, 4, "0", STR_PAD_LEFT);
}

function formatFullName(string $firstName, string $lastName): string
{
    return trim($firstName . ' ' . $lastName);
}

?>