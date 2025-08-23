<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Auth;
use App\Repositories\UserRepository;
use App\Repositories\AgencyRepository;
use App\Repositories\TripRepository;

/**
 * Pages et actions d'administration.
 */
class AdminController extends Controller
{
    public function __construct(
        private Auth $auth,
        private UserRepository $users,
        private AgencyRepository $agencies,
        private TripRepository $trips
    ) {}

    /** Redirige si l'utilisateur n'est pas admin. */
    private function requireAdmin(): void
    {
        if (!$this->auth->isAdmin()) $this->redirect('/');
    }

    /** Page liste des utilisateurs. */
    public function usersIndex(): void
    {
        $this->requireAdmin();
        $this->view('admin/users', [
            'users' => $this->users->all(),
        ]);
    }

    /** Page listes et formulaires agences (CRUD). */
    public function agenciesIndex(): void
    {
        $this->requireAdmin();
        $this->view('admin/agencies', [
            'agencies' => $this->agencies->all(),
        ]);
    }

    /** Page liste des trajets + formulaire création. */
    public function tripsIndex(): void
    {
        $this->requireAdmin();
        $this->view('admin/trips', [
            'trips'    => $this->trips->all(),
            'agencies' => $this->agencies->all(),
        ]);
    }

    // ------- Utils validations -------
    private function normalizeDate(?string $s): string
    {
        if (!$s) return '';
        $ts = strtotime($s);
        return $ts ? date('Y-m-d H:i:00', $ts) : '';
    }

    /** @param array<string,mixed> $d */
    private function validateTripData(array $d): array
    {
        $errors = [];
        $depTs = $d['departure_at'] ? strtotime($d['departure_at']) : 0;
        $arrTs = $d['arrival_at']   ? strtotime($d['arrival_at'])   : 0;
        $now   = time();

        if ($d['departure_agency_id'] <= 0 || $d['arrival_agency_id'] <= 0) $errors[] = 'Agences invalides.';
        if ($d['departure_agency_id'] === $d['arrival_agency_id']) $errors[] = 'Départ et arrivée doivent être différents.';
        if (!$depTs || !$arrTs) $errors[] = 'Dates invalides.';
        else {
            if ($depTs < $now) $errors[] = "La date/heure de départ ne peut pas être antérieure à maintenant.";
            if ($arrTs <= $depTs) $errors[] = "La date/heure d'arrivée doit être postérieure au départ.";
        }
        if ($d['total_seats'] < 1) $errors[] = 'Le nombre total de places doit être au moins 1.';
        if ($d['available_seats'] < 1) $errors[] = 'Les places disponibles doivent être au moins 1.';
        if ($d['available_seats'] > $d['total_seats']) $errors[] = 'Les places disponibles ne peuvent pas dépasser le total.';
        return $errors;
    }

    // ------- Actions agences --------
    public function agenciesCreate(): void
    {
        $this->requireAdmin();
        $name = trim($_POST['name'] ?? '');
        if ($name !== '') {
            $this->agencies->create($name);
        }
        $this->redirect('/admin/agencies');
    }

    public function agenciesUpdate(): void
    {
        $this->requireAdmin();
        $id = (int)($_POST['id'] ?? 0);
        $name = trim($_POST['name'] ?? '');
        if ($id > 0 && $name !== '') {
            $this->agencies->update($id, $name);
        }
        $this->redirect('/admin/agencies');
    }

    public function agenciesDelete(): void
    {
        $this->requireAdmin();
        $id = (int)($_POST['id'] ?? 0);
        if ($id > 0) {
            $this->agencies->delete($id);
        }
        $this->redirect('/admin/agencies');
    }

    // ------- Actions trajets --------
    public function tripsCreate(): void
    {
        $this->requireAdmin();

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

        $errors = $this->validateTripData($data);
        if ($errors) {
            $this->view('admin/trips', [
                'trips'    => $this->trips->all(),
                'agencies' => $this->agencies->all(),
                'errors'   => $errors,
                'old'      => $data,
            ]);
            return;
        }

        $this->trips->create($data);
        $this->redirect('/admin/trips');
    }

    public function tripsDelete(): void
    {
        $this->requireAdmin();
        $id = (int)($_POST['id'] ?? 0);
        if ($id > 0) {
            $this->trips->delete($id);
        }
        $this->redirect('/admin/trips');
    }
}
