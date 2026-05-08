<?php
class UserModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAll() {
        $stmt = $this->conn->prepare("CALL GetAllUsers()");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM `user` WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $stmt = $this->conn->prepare("CALL AddUser(:first, :last, :user, :pass, :email, :role)");
        return $stmt->execute($data);
    }

    public function update($data) {
        $stmt = $this->conn->prepare("CALL UpdateUser(:id, :first, :last, :user, :email, :role)");
        return $stmt->execute($data);
    }

    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM `user` WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }


    public function findAccountByEmail($email) {
        // This single call now checks both tables thanks to the UNION
        $stmt = $this->conn->prepare("CALL sp_FindAccountByEmail(?)");
        $stmt->execute([$email]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->closeCursor(); 

        return $result; // Returns ['id' => X, 'account_type' => 'user' OR 'customer'] or false
    }

    public function createPasswordReset($type, $id, $token) {
    // Safety check: if type is somehow still null, don't even try the SQL
    if (empty($type)) {
        error_log("Password reset failed: Account type is missing for ID " . $id);
        return false;
    }

    $stmt = $this->conn->prepare("CALL sp_CreatePasswordReset(?, ?, ?)");
    return $stmt->execute([$type, $id, $token]);
}
}