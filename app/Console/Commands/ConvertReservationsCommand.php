<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Reservation;
use App\Models\Contrat;
use App\Enums\ReservationStatusEnum;
use App\Enums\ContratStatusEnum;
use App\Enums\VehicleStatusEnum;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class ConvertReservationsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:convert-reservations';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Convertit automatiquement les réservations confirmées en contrats le jour de leur début';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Début de la conversion des réservations...');
        Log::info('Tâche de conversion des réservations démarrée.');

        $reservationsToConvert = Reservation::where('statut', ReservationStatusEnum::CONFIRMEE)
            ->whereDate('date_debut', '<=', Carbon::today())
            ->get();

        if ($reservationsToConvert->isEmpty()) {
            $this->info('Aucune réservation à convertir aujourd\'ui.');
            Log::info('Aucune réservation à convertir trouvée.');
            return;
        }

        $this->info($reservationsToConvert->count() . ' réservation(s) à convertir.');

        foreach ($reservationsToConvert as $reservation) {
            try {
                // Créer le contrat
                $contrat = Contrat::create([
                    'entreprise_id' => $reservation->agent->entreprise_id,
                    'client_id' => $reservation->client_id,
                    'user_id' => $reservation->agent_id, // L'agent est maintenant user_id dans Contrat
                    'vehicle_id' => $reservation->vehicle_id,
                    'date_debut' => $reservation->date_debut,
                    'date_fin' => $reservation->date_fin,
                    'type_prix' => $reservation->type_prix,
                    'prix_total' => $reservation->prix_estime,
                    'caution' => 0, // Caution à 0 par défaut pour la conversion auto
                    'status' => ContratStatusEnum::EN_ATTENTE,
                ]);

                // Mettre à jour le statut de la réservation
                $reservation->statut = ReservationStatusEnum::CONVERTIE;
                $reservation->save();

                // Mettre à jour la disponibilité du véhicule
                $vehicle = $reservation->vehicle;
                $vehicle->statut_disponibilite = VehicleStatusEnum::INDISPONIBLE;
                $vehicle->save();
                
                // La facture est créée automatiquement par le ContratObserver

                $this->info('Réservation #' . $reservation->id . ' convertie en contrat #' . $contrat->id);
                Log::info('Réservation #' . $reservation->id . ' convertie en contrat #' . $contrat->id);

            } catch (
Exception $e) {
                $this->error('Erreur lors de la conversion de la réservation #' . $reservation->id . ': ' . $e->getMessage());
                Log::error('Erreur conversion réservation #' . $reservation->id, ['error' => $e->getMessage()]);
            }
        }

        $this->info('Conversion des réservations terminée.');
        Log::info('Tâche de conversion des réservations terminée.');
    }
}