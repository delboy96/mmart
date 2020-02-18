<?php
@session_start();

$page = $_GET['page'] ?? null;

$routes = [
    'about',
    'gallery',
    'projects',
    'project',
    'contact',
    'login',
    'exhibitions',
    'exhibition'
];

require_once 'php/functions.php';
require_once 'php/conn.php';
require_once 'models/menu.php';
require_once 'models/user.php';
require_once 'components/head.php';
require_once 'components/nav.php';

if (userLoggedIn()) {
    logActivity(
        $conn,
        "User visited {$_SERVER['REQUEST_URI']}",
        auth()->id,
        $_SERVER['HTTP_USER_AGENT']
    );
}

switch ($page) {
    case 'about':
        require_once 'views/about.php';
        break;

    case 'gallery':
        require_once 'views/gallery.php';
        break;

    case 'projects':
        require_once 'views/projects.php';
        break;

    case 'project':
        require_once 'views/project.php';
        break;

    case 'contact':
        require_once 'views/contact.php';
        break;

    case 'exhibitions':
        require_once 'views/exhibitions.php';
        break;

    case 'exhibition':
        require_once 'views/exhibition.php';
        break;

    case 'login':
        require_once 'views/loginReg.php';
        break;

    case 'activation':
        require_once 'views/activation.php';
        break;

    default:
        require_once 'components/item.php';
}

if (in_array($page, $routes)) {
    require_once 'components/footer.php';
}
