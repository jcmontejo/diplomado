<?php
namespace App;

class Permission extends \Spatie\Permission\Models\Permission
{
    public static function defaultPermissions()
    {
        return [
            // 
            'modulo-inicio',

            'modulo-perfil',

            'modulo-alumnos',
            // 'ver-alumnos-inscritos',
            // 'ver-alumnos-prospectos',
            // 'agregar-alumno',
            // 'editar-alumno',
            // 'agregar-documentos-alumno',
            // 'inscribir-alumno',

            'modulo-docentes',
            // 'ver-docentes',
            // 'agregar-docente',
            // 'editar-docente',
            // 'eliminar-docente',

            'modulo-control-escolar',
            // 'ver-diplomados',
            // 'agregar-diplomado',
            // 'editar-diplomado',
            // 'eliminar-diplomado',
            // 'ver-generaciones',
            // 'agregar-generacion',
            // 'ver-alumnos-por-generacion',
            // 'eliminar-generacion',

            'modulo-cuentas-bancarias',
            // 'ver-cuentas-bancarias',
            // 'agregar-cuenta-bancaria',
            // 'editar-cuenta-bancaria',
            // 'eliminar-cuenta-bancaria',

            'modulo-transacciones',
            // 'ver-ingresos',
            // 'filtrar-por-fechas',
            // 'ver-egresos',
            // 'agregar-egreso',
            // 'ver-metodos-de-pago',
            // 'agregar-metodo-de-pago',
            // 'editar-metodo-de-pago',
            // 'eliminar-metodo-de-pago',

            'modulo-cuotas-de-estudiantes',
            // 'ver-tipo-de-cuotas',
            // 'agregar-tipo-de-cuota',
            // 'editar-tipo-de-cuota',
            // 'eliminar-tipo-de-cuota',
            // 'recibir-pago',

            'modulo-emails',
            // 'enviar-email',
            // 'ver-emails-enviados',

            'modulo-reportes',
            // 'ver-reporte-de-ingresos',
            // 'ver-reporte-de-egresos',

            'modulo-administracion',
            // 'ver-gestion-de-usuarios',
            // 'agregar-nuevo-usuario',
            // 'editar-usuario',
            // 'eliminar-usuario',
            // 'ver-roles-de-usuario',
            // 'agregar-nuevo-rol',
        ];
    }
}
