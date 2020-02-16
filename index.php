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

require_once 'php/conn.php';
require_once 'php/queries.php';
require_once 'components/head.php';
require_once 'components/nav.php';

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

    default:
        require_once 'components/item.php';
}

if (in_array($page, $routes)) {
    require_once 'components/footer.php';
}
