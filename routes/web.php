<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NotificacionController;

// Rutas de envío de formulario
Route::post('/notificaciones/solicitar', [NotificacionController::class, 'store'])->name('notificaciones.store');
Route::post('/notificaciones/finalizar/{id}', [NotificacionController::class, 'finalizar'])->name('notificaciones.finalizar');
Route::get('/', function () {
    return view('welcome'); // O tu vista personalizada
});
Route::get('/home', function () {
    return view('welcome'); // O tu vista personalizada
})->name('home');
// Vistas con datos desde el controlador
Route::get('/notificaciones/mesadepartes/bandeja', [NotificacionController::class, 'bandeja'])->name('notificaciones.mesadepartes.bandeja');
Route::get('/notificaciones/mesadepartes/elaboracion/{id}', [NotificacionController::class, 'elaborar'])->name('notificaciones.mesadepartes.elaboracion');

// Agrupación de vistas que no requieren lógica
Route::prefix('notificaciones')->name('notificaciones.')->group(function () {
    // Funcionario
    Route::view('/dependencia/bandeja', 'notificaciones.dependencia-bandeja')->name('dependencia.bandeja');
    Route::view('/dependencia/solicitud', 'notificaciones.dependencia-solicitud')->name('dependencia.solicitud');

    // Mesa de partes
    Route::get('/mesadepartes/entrega-lista', [NotificacionController::class, 'entregaLista'])->name('mesadepartes.entrega.lista');
    Route::get('/mesadepartes/entrega/{id}', function($id) {
        $notificacion = \App\Models\Notificacion::findOrFail($id);
        return view('notificaciones.mesadepartes-entrega', compact('notificacion'));
    })->name('mesadepartes.entrega');
    Route::post('/mesadepartes/entrega/{id}', [NotificacionController::class, 'entregar'])->name('mesadepartes.entregar');
    Route::view('/mesadepartes/registro', 'notificaciones.mesadepartes-registro')->name('mesadepartes.registro');
    Route::view('/mesadepartes/archivar', 'notificaciones.mesadepartes-archivar')->name('mesadepartes.archivar');

    // Usuario
    Route::view('/usuario/bandeja', 'notificaciones.usuario-bandeja')->name('usuario.bandeja');
});

require __DIR__.'/auth.php';
