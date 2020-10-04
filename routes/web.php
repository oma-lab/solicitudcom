<?php
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Auth::routes();
Route::get('register/docente', 'Auth\RegisterController@registrarDocente')->name('register.docente');
Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index')->name('home');

//----RUTAS SOLICITANTE-----------------------------------------------------------------
Route::get('/solicitante','SolicitanteController@home')->name('solicitante.home');
Route::get('/crear/solicitud','SolicitanteController@crearSolicitud')->name('crear.solicitud');
Route::post('/guardar/solicitud','SolicitanteController@guardarSolicitud')->name('registrar.solicitud');
Route::get('/editar/{solicitud}','SolicitanteController@editarSolicitud')->name('editar.solicitud');
Route::patch('/update/{solicitud}','SolicitanteController@updateSolicitud')->name('update.solicitud');
Route::get('/solicitud-pdf/{id}','SolicitanteController@verSolicitud')->name('ver.solicitud');
Route::get('/mostrar/dictamen','SolicitanteController@dictamenes')->name('dictamenes');
Route::get('/calendario','SolicitanteController@calendario')->name('usuario.calendario');
Route::get('/editar_usuario','SolicitanteController@editarUsuario')->name('solicitante.editar');
Route::get('/enviar/{id}','SolicitanteController@enviarSolicitud')->name('enviar.solicitud');
Route::delete('/eliminar/{id}','SolicitanteController@eliminarSolicitud')->name('eliminar.solicitud');


//----RUTAS COORDINADOR-----------------------------------------------------------------
Route::get('/solicitudes_recibidas/{filtro}','CoordinadorController@solicitudes')->name('coordinador.solicitudes');
Route::get('/calendariocoor','CoordinadorController@calendario')->name('coordinador.calendario');
Route::get('/dictamen/recibidos','CoordinadorController@dictamenes')->name('coordinador.dictamenes');
Route::get('/editar_coordinador','CoordinadorController@editarUsuario')->name('coordinador.editar');
Route::post('/cancelar','CoordinadorController@cancelarSolicitud')->name('solicitud.cancelar');
Route::post('/enviar_sol/{id}','CoordinadorController@enviarSolicitud')->name('envio.solicitud');


//----RUTAS JEFE-----------------------------------------------------------------
Route::get('/solicitudes/{filtro}','JefeController@solicitudesRecibidas')->name('jefe.solicitudes');
Route::get('/calendariojefe','JefeController@calendario')->name('jefe.calendario');
Route::get('/editar_jefe','JefeController@editarUsuario')->name('jefe.editar');
Route::get('/dictamenes_jefe/{f}','JefeController@dictamenes')->name('jefe.dictamenes');
Route::get('/dictamen_entregar/{id}','JefeController@entregarDictamen')->name('dictamen.entregado');

//----RUTAS SUBDIRECTOR-----------------------------------------------------------------
Route::get('/calendariosub','SubdirectorController@calendario')->name('sub.calendario');
Route::get('/editar_sub','SubdirectorController@editarUsuario')->name('sub.editar');
Route::get('/recomendaciones','SubdirectorController@recomendaciones')->name('recomendaciones');
Route::get('/recomendaciones_finalizadas','SubdirectorController@recomendacionesFinalizadas')->name('recomendaciones.finalizadas');
Route::get('/recomendacion/{id}','SubdirectorController@editarRecomendacion')->name('editar.recomendacion');
Route::patch('/recomendacion/{id}','SubdirectorController@guardarRecomendacion')->name('guardar.recomendacion');
Route::delete('/recomendacion/{id}','SubdirectorController@eliminarRecomendacion')->name('eliminar.recomendacion');
Route::get('/verrecomendacion/{id}','SubdirectorController@generarRecomendacion')->name('generar.recomendacion');
Route::get('/enviarrecomendacion/{id}','SubdirectorController@enviarRecomendacion')->name('enviar.recomendacion');
Route::get('/dictamenes_sub','SubdirectorController@dictamen')->name('sub.dictamenes');


//----RUTAS DIRECTOR-----------------------------------------------------------------
Route::get('/recomendaciones_director','DirectorController@recomendaciones')->name('director.recomendaciones');
Route::get('/dictamenes/{filtro}','DirectorController@dictamenes')->name('director.dictamenes');
Route::get('/dictamen_entregado','DirectorController@dictamenEntregado')->name('dictamenes.entregados');
Route::patch('/dictamen/{id}','DirectorController@guardarDictamen')->name('guardar.dictamen');
Route::get('/dictamen_pdf/{id}','DirectorController@verDictamenpdf')->name('dictamen.pdf');
Route::get('/enviar_dictamen{id}','DirectorController@enviarDictamen')->name('enviar.dictamen');
Route::post('/entregar/dictamen','DirectorController@entregarDictamen')->name('entregar.dictamen');
Route::get('/editar_dictamen/{id}','DirectorController@editarDictamen')->name('editar.dictamen');
Route::delete('/dictamen/{id}','DirectorController@eliminarDictamen')->name('eliminar.dictamen');
Route::get('/calendariodirector','DirectorController@calendario')->name('director.calendario');
Route::get('/editar_director','DirectorController@editarUsuario')->name('director.editar');


//----RUTAS TODOS LOS USUARIOS-----------------------------------------------------------------
Route::get('/versolicitudEvidencia/{id}','UsuariosController@verSolicitudEvidencia')->name('solicitudEvidencia');
Route::post('/save_observaciones','UsuariosController@guardarObservacion')->name('guardar.observacion');
Route::get('/historial','UsuariosController@getHistorial')->name('getHistorial');
Route::get('/observaciones','UsuariosController@getObservaciones');
Route::get('/reunion','UsuariosController@mostrarReuniones');
Route::get('/mostrar/citatorio/{id}','UsuariosController@mostrarCitatorio');
Route::get('/notificaciones','UsuariosController@getNotificaciones');
Route::get('/notificacion/{id}','UsuariosController@verNotificacion');
Route::patch('/usuarios/{id}','UsuariosController@actualizarUsuario')->name('usuario.actualizar');


//----RUTAS ADMIN-----------------------------------------------------------------
Route::get('solicitudes','AdminController@solicitudes')->name('solicitudes');
Route::get('/calendarioadmin','AdminController@calendario')->name('admin.calendario');
Route::get('/formato','AdminController@formato')->name('formato');
Route::get('/carreras_adscripciones','AdminController@verAdscripciones')->name('carrera.adscripcion');
Route::post('/guardar_carrera','AdminController@guardarCarrera')->name('guardar.carrera');
Route::post('/guardar_adscripcion','AdminController@guardarAdscripcion')->name('guardar.adscripcion');
Route::delete('/eliminar_carrera/{id}','AdminController@eliminarCarrera')->name('eliminar.carrera');
Route::delete('/eliminar_adscripcion/{id}','AdminController@eliminarAdscripcion')->name('eliminar.adscripcion');
Route::post('vista_previa','AdminController@vistaPrevia')->name('vistaprevia');
Route::post('cambiar_formato','AdminController@cambiarFormato')->name('cambiar.formato');
Route::delete('eliminar_formato','AdminController@eliminarFormato')->name('eliminar.formato');
Route::post('reunion','AdminController@guardarFecha')->name('guardar.fecha');
Route::delete('reunion/{id}','AdminController@eliminarFecha')->name('eliminar.fecha');
Route::patch('respuesta/{id}','AdminController@respuestaSolicitud')->name('respuesta.solicitud');
Route::get('actualizarsolicitud/{id}','AdminController@actualizarSolicitud')->name('actualizar.solicitud');
Route::patch('guardarSolicitud/{id}','AdminController@guardarSolicitud')->name('guardar.solicitud');
Route::get('/usuarios/{rol}','AdminController@usuarios')->name('usuarios');
Route::get('/usuarios/{id}/edit','AdminController@editarUsuario')->name('usuarios.edit');
Route::delete('/usuarios/{id}','AdminController@eliminarUsuario')->name('usuarios.eliminar');
Route::get('/carreras','AdminController@getCarreras');
Route::post('/permisos','AdminController@cambiarPermisos')->name('permisos');
Route::post('/registrar/usuario','Auth\RegisterController@registrar')->name('registrar.usuario');
Route::get('/registrar/usuario','Auth\RegisterController@crear')->name('crear.usuario');
Route::get('/registrar/documento','AdminController@registrarDocumento')->name('registrar.documento');
Route::post('/generar/documento','AdminController@generarDocumento')->name('generar.documento');
Route::get('/posponer','AdminController@vistaPosponer')->name('vista.posponer');
Route::post('/posponer','AdminController@posponer')->name('posponer');



Route::resource('citatorio','CitatorioController',['except' => ['edit','create','show']]);
Route::get('/citatorio/enviar/{id}','CitatorioController@enviar')->name('enviar.citatorio');
Route::get('/cita','CitatorioController@getCitatorio');
Route::get('citatorio_pdf/{id}','CitatorioController@citatorioPdf')->name('citatorio_pdf');
Route::resource('listaasistencia','ListaAsistenciaController',['except' => ['create','show']]);
Route::get('verLista/{id}','ListaAsistenciaController@verLista')->name('verLista');
Route::resource('acta','ActaController',['except' => ['show']]);
Route::get('acta/descargar/{id}','ActaController@descargarActa')->name('descargar.acta');
Route::get('/link', function () {
    Artisan::call('storage:link');
});


