<?php

class CustomerModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    /**
     * Check if an email already exists in the database
     */
    public function emailExists($email) {
        $stmt = $this->pdo->prepare("SELECT id FROM customers WHERE email = ? LIMIT 1");
        $stmt->execute([$email]);
        return $stmt->fetch() !== false;
    }

    /**
     * Insert a new customer record
     */
    public function create($data) {
    $sql = "CALL sp_CreateCustomer(:fname, :lname, :email, :pass, :phone, :addr, :city)";
    $stmt = $this->pdo->prepare($sql);
    return $stmt->execute($data);
}
}