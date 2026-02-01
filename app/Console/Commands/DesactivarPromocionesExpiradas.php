<?php

namespace App\Console\Commands;

use App\Models\Promocion;
use Illuminate\Console\Command;

class DesactivarPromocionesExpiradas extends Command
{
    /**
     * Nombre y firma del comando de consola.
     *
     * @var string
     */
    protected $signature = 'promociones:desactivar';

    /**
     * Descripción del comando de consola.
     *
     * @var string
     */
    protected $description = 'Desactiva las promociones cuya fecha de fin ha pasado';

    /**
     * Ejecutar el comando de consola.
     *
     * @return int
     */
    public function handle()
    {
        // Obtener promociones activas cuya fecha_fin ya pasó
        $promocionesExpiradas = Promocion::where('activo', true)
            ->where('fecha_fin', '<', now())
            ->get();

        $contador = 0;

        foreach ($promocionesExpiradas as $promocion) {
            $promocion->activo = false;
            $promocion->save();
            $contador++;

            $this->info("Desactivada: {$promocion->titulo}");
        }

        if ($contador > 0) {
            $this->info("Se desactivaron {$contador} promociones expiradas.");
        } else {
            $this->info("No hay promociones expiradas para desactivar.");
        }

        return Command::SUCCESS;
    }
}
