<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Auth;
use App\Repositories\TripRepository;
use App\Repositories\AgencyRepository;

/**
 * Création / consultation / édition / suppression des trajets par l'utilisateur.
 */
class TripController extends Controller
{
    public function __construct(
        private TripRepository $trips,
        private AgencyRepository $agencies,
        private Auth $auth
    ) {}

    /** Formulaire de création d'un trajet. */
    public function createForm(): void
    {
        if (!$this->auth->check()) $this->redirect('/login');
        $agencies = $this->agencies->all();
        $this->view('trips/create', ['agencies' => $agencies]);
    }

    /** Enregistre un nouveau trajet après validations. */
    public function create(): void
    {
        if (!$this->auth->check()) $this->redirect('/login');

        $data = [
            'departure_agency_id' => (int)($_POST['departure_agency_id'] ?? 0),
            'arrival_agency_id'   => (int)($_POST['arrival_agency_id'] ?? 0),
            'departure_at'        => $this->normalizeDate($_POST['departure_at'] ?? ''),
            'arrival_at'          => $this->normalizeDate($_POST['arrival_at'] ?? ''),
            'total_seats'         => (int)($_POST['total_seats'] ?? 0),
            'available_seats'     => (int)($_POST['available_seats'] ?? 0),
            'contact_user_id'     => $this->auth->id(),
            'created_by_user_id'  => $this->auth->id(),
        ];

        $errors = $this->validateTrip($data);
        if ($errors) {
            $agencies = $this->agencies->all();
            $this->view('trips/create', ['agencies' => $agencies, 'errors' => $errors, 'old' => $data]);
            return;
        }

        $this->trips->create($data);
        $this->redirect('/');
    }

    /**
     * Affiche le détail d'un trajet (protégé : nécessite connexion).
     * @param int $id
     */
    public function show(int $id): void
    {
        if (!$this->auth->check()) {
            $this->redirect('/login');
        }

        if ($id <= 0) $this->redirect('/');
        $trip = $this->trips->findById($id);
        if (!$trip) {
            http_response_code(404);
            echo 'Trajet introuvable';
            return;
        }
        $this->view('trips/show', ['trip' => $trip]);
    }

    /** Formulaire d'édition (réservé à l'auteur du trajet). */
    public function editForm(int $id): void
    {
        if (!$this->auth->check()) $this->redirect('/login');
        $trip = $this->trips->findById($id);
        if (!$trip || (int)$trip['created_by_user_id'] !== $this->auth->id()) $this->redirect('/');
        $agencies = $this->agencies->all();
        $this->view('trips/edit', ['trip' => $trip, 'agencies' => $agencies]);
    }

    /** Met à jour un trajet après validations (réservé à l'auteur). */
    public function update(int $id): void
    {
        if (!$this->auth->check()) $this->redirect('/login');
        $trip = $this->trips->findById($id);
        if (!$trip || (int)$trip['created_by_user_id'] !== $this->auth->id()) $this->redirect('/');

        $data = [
            'departure_agency_id' => (int)($_POST['departure_agency_id'] ?? 0),
            'arrival_agency_id'   => (int)($_POST['arrival_agency_id'] ?? 0),
            'departure_at'        => $this->normalizeDate($_POST['departure_at'] ?? ''),
            'arrival_at'          => $this->normalizeDate($_POST['arrival_at'] ?? ''),
            'total_seats'         => (int)($_POST['total_seats'] ?? 0),
            'available_seats'     => (int)($_POST['available_seats'] ?? 0)
        ];

        $errors = $this->validateTrip($data);
        if ($errors) {
            $agencies = $this->agencies->all();
            $this->view('trips/edit', ['trip' => array_merge($trip, $data), 'agencies' => $agencies, 'errors' => $errors]);
            return;
        }

        $this->trips->update($id, $data);
        $this->redirect('/');
    }

    /** Supprime un trajet (réservé à l'auteur). */
    public function delete(int $id): void
    {
        if (!$this->auth->check()) $this->redirect('/login');
        $trip = $this->trips->findById($id);
        if ($trip && (int)$trip['created_by_user_id'] === $this->auth->id()) {
            $this->trips->delete($id);
        }
        $this->redirect('/');
    }

    /** Normalise une date HTML5 datetime-local vers "Y-m-d H:i:00". */
    private function normalizeDate(?string $s): string
    {
        if (!$s) return '';
        $ts = strtotime($s); // gère le 'T'
        return $ts ? date('Y-m-d H:i:00', $ts) : '';
    }

    /**
     * Valide les données d'un trajet.
     *
     * Règles :
     * - agences valides et différentes
     * - départ >= maintenant
     * - arrivée > départ
     * - total_seats >= 1
     * - available_seats >= 1 et <= total_seats
     *
     * @param array<string,mixed> $d
     * @return string[] Liste d'erreurs
     */
    private function validateTrip(array $d): array
    {
        $errors = [];

        $depTs = $d['departure_at'] ? strtotime($d['departure_at']) : 0;
        $arrTs = $d['arrival_at']   ? strtotime($d['arrival_at'])   : 0;
        $now   = time();

        if ($d['departure_agency_id'] <= 0 || $d['arrival_agency_id'] <= 0) {
            $errors[] = 'Agences invalides.';
        }
        if ($d['departure_agency_id'] === $d['arrival_agency_id']) {
            $errors[] = 'Départ et arrivée doivent être différents.';
        }

        if (!$depTs || !$arrTs) {
            $errors[] = 'Dates invalides.';
        } else {
            if ($depTs < $now) {
                $errors[] = "La date/heure de départ ne peut pas être antérieure à maintenant.";
            }
            if ($arrTs <= $depTs) {
                $errors[] = "La date/heure d'arrivée doit être postérieure au départ.";
            }
        }

        if ($d['total_seats'] < 1) {
            $errors[] = 'Le nombre total de places doit être au moins 1.';
        }
        if ($d['available_seats'] < 1) {
            $errors[] = 'Les places disponibles doivent être au moins 1.';
        }
        if ($d['available_seats'] > $d['total_seats']) {
            $errors[] = 'Les places disponibles ne peuvent pas dépasser le total.';
        }

        return $errors;
    }
}
