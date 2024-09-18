<?php

class auth
{
    private $db;
    private $error;

    private static $newObjek;

    public function __construct($con)
    {
        $this->db = $con;
        @session_start();
    }

    public static function makeObjek($pdo)
    {
        if (self::$newObjek == NULL) {
            self::$newObjek = new auth($pdo);
        }
        return self::$newObjek;
    }

    public function register($name, $email, $password, $role)
    {
        try {

            $hashPassword = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $this->db->prepare("INSERT INTO user(id_user, name, email, password, role) VALUE(NULL, :name, :email, :password, :role)");
            $stmt->bindParam(":name", $name);
            $stmt->bindParam(":email", $email);
            $stmt->bindParam(":password", $hashPassword);
            $stmt->bindParam(":role", $role);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function login($email, $password)
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM user WHERE email = :email");
            $stmt->bindParam(":email", $email);
            $stmt->execute();
            $data = $stmt->fetch();

            if ($stmt->rowCount()  > 0) {

                if (password_verify($password, $data["password"])) {
                    $_SESSION['user_session'] = $data['id'];
                    return true;
                } else {
                    $this->error = 'email Atau Password Salah';
                    return false;
                }
            } else {
                $this->error = 'email Atau Password Salah';
                return false;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function isLoggedIn()
    {
        if (isset($_SESSION["user_session"])) {
            return true;
        }
    }

    public function getUser()
    {
        if (!$this->isLoggedIn()) {
            return false;
        }
        try {
            $stmt = $this->db->prepare("SELECT * FROM user WHERE id = :id");
            $stmt->bindParam(":id", $_SESSION['user_session']);
            $stmt->execute();
            return $stmt->fetch();
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function logout()
    {
        unset($_SESSION['user_session']);
        session_destroy();
        return true;
    }
}
