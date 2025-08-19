<?php
use App\Core\Router;
use App\Core\Database;
use App\Core\Auth;
use App\Repositories\{TripRepository, AgencyRepository, UserRepository};
use App\Controllers\{HomeController, AuthController, TripController, AdminController};

$config = require __DIR__ . '/../config/config.php';
$db = new Database($config['db']);

$users     = new UserRepository($db);
$agencies  = new AgencyRepository($db);
$trips     = new TripRepository($db);
$auth      = new Auth($users);

$home  = new HomeController($trips);
$authc = new AuthController($auth);
$tripc = new TripController($trips, $agencies, $auth);
$admin = new AdminController($auth, $users, $agencies, $trips);

$router = new Router();

$router->get('/', fn() => $home->index());
$router->get('/login', fn() => $authc->showLogin());
$router->post('/login', fn() => $authc->login());
$router->get('/logout', fn() => $authc->logout());
$router->get('/trips/create', fn() => $tripc->createForm());
$router->post('/trips', fn() => $tripc->create());
$router->get('/admin', fn() => $admin->dashboard());

return $router;
