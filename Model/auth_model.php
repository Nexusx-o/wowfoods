<?php
// models/AuthModel.php

class AuthModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    /**
     * Calls the SP to find a user in either table by username/email
     */
    public function getUserByAnyIdentifier($identifier) {
        $stmt = $this->pdo->prepare("CALL sp_AuthenticateUser(?)");
        $stmt->execute([$identifier]);
        return $stmt->fetch();
    }

    public function verifyResetToken($token) {
        $stmt = $this->pdo->prepare("CALL sp_VerifyResetToken(?)");
        $stmt->execute([$token]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        return $result;
    }

    public function performPasswordReset($token, $type, $id, $hashedPassword) {
        try {
            $stmt = $this->pdo->prepare("CALL sp_PerformPasswordReset(?, ?, ?, ?)");
            $result = $stmt->execute([$token, $type, $id, $hashedPassword]);
            $stmt->closeCursor();
            return $result;
        } catch (PDOException $e) {
            return false;
        }
    }
}