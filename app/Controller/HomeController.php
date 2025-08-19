<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Repositories\TripRepository;

class HomeController extends Controller
{
    public function __construct(private TripRepository $trips){}

    public function index(): void
    {
        $list = $this->trips->upcomingWithAvailability();
        $this->view('home/index', ['trips' => $list]);
    }
}
