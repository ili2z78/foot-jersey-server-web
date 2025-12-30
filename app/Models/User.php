<?php
class User extends Model {

    public function create($email, $password, $fullname = '', $role = 'user') {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = self::$db->prepare("INSERT INTO users (email, password, fullname, role) VALUES (?, ?, ?, ?)");
        $stmt->execute([$email, $hash, $fullname, $role]);
        return self::$db->lastInsertId();
    }

    public function findByEmail($email) {
        $stmt = self::$db->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch();
    }

    public function findById($id) {
        $stmt = self::$db->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
}
