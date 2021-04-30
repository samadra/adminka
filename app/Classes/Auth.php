<?php


class Auth
{
    private DB $db;

    public function __construct(DB $db)
    {
        $this->db = $db;
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $query = "SELECT * FROM workers WHERE `email` = :email";
            $user = $this->db->select($query, [
                ':email' => $_POST['email'],
            ]);
            if (!empty($user)) {
                $password = $user[0]['password'];
                if (password_verify($_POST['password'], $password)) {
                    $_SESSION['uid'] = md5($user[0]['email']);
                    $_SESSION['username'] = $user[0]['name'] . ' ' . $user[0]['surname'];
                    header('Location: /');
                    exit();
                } else {
                    $_SESSION['error'] = ['Invalid password'];
                }
            } else {
                $_SESSION['error'] = ['Invalid email'];
            }
        } else {
            echo 'Error';
        }
    }
}