<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Auth;
use App\Repositories\TripRepository;
use App\Repositories\AgencyRepository;

class TripController extends Controller
{
    public function __construct(
        private TripRepository $trips,
        private AgencyRepository $agencies,
        private Auth $auth
    ){ }

    public function createForm(): void
    {
        if (!$this->auth->check()) $this->redirect('/login');
        $this->view('trips/create', ['agencies' => $this->agencies->all()]);
    }

    public function create(): void
    {
        if (!$this->auth->check()) $this->redirect('/login');
        $data = [
            'departure_agency_id' => (int)$_POST['departure_agency_id'],
            'arrival_agency_id'   => (int)$_POST['arrival_agency_id'],
            'departure_at'        => $_POST['departure_at'],
            'arrival_at'          => $_POST['arrival_at'],
            'total_seats'         => (int)$_POST['total_seats'],
            'available_seats'     => (int)$_POST['available_seats'],
            'contact_user_id'     => $this->auth->id(),
            'created_by_user_id'  => $this->auth->id(),
        ];
        $this->trips->create($data);
        $this->redirect('/');
    }
}
