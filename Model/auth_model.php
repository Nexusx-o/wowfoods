<?php
// models/AuthModel.php

class AuthModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function verifyResetToken($token) {
        $stmt = $this->pdo->prepare("SELECT * FROM password_resets WHERE token = ? LIMIT 1");
        $stmt->execute([$token]);
        return $stmt->fetch();
    }

    public function performPasswordReset($token, $type, $id, $hashedPassword) {
        $sql = "CALL sp_ResetPassword(:token, :type, :id, :pass)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':token' => $token,
            ':type'  => $type,
            ':id'    => $id,
            ':pass'  => $hashedPassword
        ]);
    }

    /**
     * Calls the SP to find a user in either table by username/email
     */
    public function getUserByAnyIdentifier($identifier) {
        $stmt = $this->pdo->prepare("CALL sp_AuthenticateUser(?)");
        $stmt->execute([$identifier]);
        return $stmt->fetch();
    }
}