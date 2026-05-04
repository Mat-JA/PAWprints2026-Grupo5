<?php

namespace App\Services;

use InvalidArgumentException;

class ReservaService
{
    private MailService $mailService;
    private string $reservasMail;

    public function __construct(MailService $mailService)
    {
        $this->mailService  = $mailService;
        $this->reservasMail = $_ENV['RESERVAS_MAIL'];
    }

    public function procesarReserva(array $datos): void
    {
        $this->validar($datos);

        $asunto = "Nueva reserva - {$datos['envio_nombre']} {$datos['envio_apellido']}";
        $cuerpo = $this->construirEmail($datos);

        $this->mailService->send($this->reservasMail, $asunto, $cuerpo);
    }

    private function validar(array $datos): void
    {
        $requeridos = [
            'envio_nombre', 'envio_apellido', 'envio_email',
            'envio_pais', 'envio_provincia', 'envio_ciudad',
            'envio_calle', 'envio_nro_calle',
            'fact_nombre', 'fact_apellido', 'fact_email',
            'fact_pais', 'fact_provincia', 'fact_ciudad',
            'fact_calle', 'fact_nro_calle',
            'fact_nro_tarjeta', 'fact_vencimiento',
        ];

        foreach ($requeridos as $campo) {
            if (empty(trim($datos[$campo] ?? ''))) {
                throw new InvalidArgumentException("El campo {$campo} es requerido.");
            }
        }

        if (!filter_var($datos['envio_email'], FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException('El email de envío no es válido.');
        }
        if (!filter_var($datos['fact_email'], FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException('El email de facturación no es válido.');
        }

        if (mb_strlen($datos['envio_nombre']) < 2 || mb_strlen($datos['envio_nombre']) > 15) {
            throw new InvalidArgumentException('El nombre de envío debe tener entre 2 y 15 caracteres.');
        }
        if (mb_strlen($datos['envio_apellido']) < 2 || mb_strlen($datos['envio_apellido']) > 25) {
            throw new InvalidArgumentException('El apellido de envío debe tener entre 2 y 25 caracteres.');
        }
        if (mb_strlen($datos['fact_nombre']) < 2 || mb_strlen($datos['fact_nombre']) > 15) {
            throw new InvalidArgumentException('El nombre de facturación debe tener entre 2 y 15 caracteres.');
        }
        if (mb_strlen($datos['fact_apellido']) < 2 || mb_strlen($datos['fact_apellido']) > 25) {
            throw new InvalidArgumentException('El apellido de facturación debe tener entre 2 y 25 caracteres.');
        }

        if (!preg_match('/^\d{12}$/', $datos['fact_nro_tarjeta'])) {
            throw new InvalidArgumentException('El número de tarjeta debe tener exactamente 12 dígitos.');
        }

        if (!preg_match('/^\d{4}-(0[1-9]|1[0-2])$/', $datos['fact_vencimiento'])) {
            throw new InvalidArgumentException('El vencimiento de tarjeta no es válido.');
        }

        if (!ctype_digit((string) $datos['envio_nro_calle']) || (int)$datos['envio_nro_calle'] < 0) {
            throw new InvalidArgumentException('El número de calle de envío no es válido.');
        }
        if (!ctype_digit((string) $datos['fact_nro_calle']) || (int)$datos['fact_nro_calle'] < 0) {
            throw new InvalidArgumentException('El número de calle de facturación no es válido.');
        }
    }

    private function construirEmail(array $d): string
    {
        date_default_timezone_set('America/Argentina/Buenos_Aires');
        $fecha = date('d/m/Y H:i');
        
        return "
            <h2>Nueva Reserva de Libro</h2>

            <h3>Datos de Envío</h3>
            <ul>
                <li><strong>Nombre:</strong> {$d['envio_nombre']} {$d['envio_apellido']}</li>
                <li><strong>Email:</strong> {$d['envio_email']}</li>
                <li><strong>País:</strong> {$d['envio_pais']}</li>
                <li><strong>Provincia:</strong> {$d['envio_provincia']}</li>
                <li><strong>Ciudad:</strong> {$d['envio_ciudad']}</li>
                <li><strong>Dirección:</strong> {$d['envio_calle']} {$d['envio_nro_calle']}</li>
            </ul>

            <h3>Datos de Facturación</h3>
            <ul>
                <li><strong>Nombre:</strong> {$d['fact_nombre']} {$d['fact_apellido']}</li>
                <li><strong>Email:</strong> {$d['fact_email']}</li>
                <li><strong>País:</strong> {$d['fact_pais']}</li>
                <li><strong>Provincia:</strong> {$d['fact_provincia']}</li>
                <li><strong>Ciudad:</strong> {$d['fact_ciudad']}</li>
                <li><strong>Dirección:</strong> {$d['fact_calle']} {$d['fact_nro_calle']}</li>
                <li><strong>Vencimiento tarjeta:</strong> {$d['fact_vencimiento']}</li>
            </ul>

            <p><em>Reserva recibida el {$fecha}</em></p>
        ";
    }
}