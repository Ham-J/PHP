<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Repositories\TripRepository;

/**
 * Page d'accueil : liste des trajets disponibles.
 */
class HomeController extends Controller
{
    public function __construct(private TripRepository $trips){}

    /** Affiche les trajets futurs avec places disponibles. */
    public function index(): void
    {
        $trips = $this->trips->upcomingWithAvailability();
        $this->view('home/index', ['trips' => $trips]);
    }
}

