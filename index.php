<?php
session_start();
require_once 'autoload.php';
$request_uri = explode("/", substr(@$_SERVER['REQUEST_URI'], 1));
$db = new DB();

if (isset($_POST['login'])) {
    $auth = new Auth($db);
    $auth->login();
}

$page = $request_uri[0] ?? '';
$action = $request_uri[1] ?? '';
$id = $request_uri[2] ?? '';

if (isset($_SESSION['uid'])) {
    switch ($page) {
        case '':
            require_once 'template.html';
            break;
        case 'workers':
            $workers_class = new Workers($db);
            switch ($action) {
                case '':
                    $workers = $workers_class->get();
                    require_once 'pages/workers/workers_list.php';
                    break;
                case 'create':
                    $positions = $workers_class->getPositions();
                    require_once 'pages/workers/create.php';
                    break;
                case 'store':
                    $workers_class->store($_POST);
                    header('Location: /workers');
                    break;
                case 'edit':
                    $worker = $workers_class->edit($id);
                    require_once 'pages/workers/update.php';
                    break;
                case 'update':
                    $workers_class->update($_POST, $id);
                    header('Location: /workers');
                    break;
            }
            break;
        case 'logout':
            session_unset();
            session_destroy();
            header('Location: /');
            break;
    }
} else {
    require_once 'pages/auth/login.phtml';
}
