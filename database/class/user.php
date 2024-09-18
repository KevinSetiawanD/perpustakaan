<?php

class user
{
    private $db;

    public function __construct($db_conn)
    {
        $this->db = $db_conn;
    }

    public function view()
    {
        $stmt = $this->db->prepare("SELECT * FROM user");
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function tambah($nama, $email, $password, $role)
    {
        $hashPw = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $this->db->prepare("INSERT INTO user VALUES ('', '$nama', '$email', '$hashPw', '$role')");
        $stmt->execute();

        return true;
    }
}
