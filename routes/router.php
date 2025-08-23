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

// Public
$router->get('/', fn() => $home->index());
$router->get('/login', fn() => $authc->showLogin());
$router->post('/login', fn() => $authc->login());
$router->get('/logout', fn() => $authc->logout());

// Trips (user)
$router->get('/trips/create', fn() => $tripc->createForm());
$router->post('/trips', fn() => $tripc->create());
$router->get('/trips/show', fn() => $tripc->show((int)($_GET['id'] ?? 0)));
$router->get('/trips/edit', fn() => $tripc->editForm((int)($_GET['id'] ?? 0)));
$router->post('/trips/update', fn() => $tripc->update((int)($_POST['id'] ?? 0)));
$router->post('/trips/delete', fn() => $tripc->delete((int)($_POST['id'] ?? 0)));

// Admin (pages distinctes)
$router->get('/admin', fn() => $admin->usersIndex());            
$router->get('/admin/users', fn() => $admin->usersIndex());
$router->get('/admin/agencies', fn() => $admin->agenciesIndex());
$router->get('/admin/trips', fn() => $admin->tripsIndex());

// Admin actions
$router->post('/admin/agencies', fn() => $admin->agenciesCreate());
$router->post('/admin/agencies/update', fn() => $admin->agenciesUpdate());
$router->post('/admin/agencies/delete', fn() => $admin->agenciesDelete());
$router->post('/admin/trips/delete', fn() => $admin->tripsDelete());

return $router;
