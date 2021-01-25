<?php

namespace Tests;
use DateTime;
use DateInterval;

trait DatosPrueba{
    
    //LoginTest
    private $usuario_login =[
        'identificador' => '14161234',
        'nombre' => 'Daniel',
        'apellido_paterno' => 'Perez',
        'apellido_materno' => 'Robles',
        'sexo' => 'H',
        'celular' => '951 947 67 34',
        'telefono' => '',
        'grado' => '',
        'role_id' => 3,
        'carrera_id' => 1,
        'email' => 'sndkj@fsknf',
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'remember_token' => 'asdfghjklz',        
    ];
    
     //Datos para registro correcto
     //RegistroTest--SolicitudSolicitanteTest--RecomendacionTest --CoordinadorSolicitudTest --JefeSolicitudTest --SecretarioSolicitud --DirectorDictamenTest --CoordinadoDictamenTest --JefeDictamenTest
     private $usuario_correcto = [
        'identificador' => '14161234',
        'nombre' => 'Daniel',
        'apellido_paterno' => 'Perez',
        'apellido_materno' => 'Robles',
        'sexo' => 'H',
        'celular' => '951 947 67 34',
        'telefono' => '',
        'grado' => '',
        'role_id' => 3,
        'carrera_id' => 1,
        'adscripcion_id' => null,
        'email' => 'daniel@gmail.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ];

    private $docente = [
        'identificador' => '141612340001',
        'nombre' => 'Ramon',
        'apellido_paterno' => 'Lopez',
        'apellido_materno' => 'Robles',
        'sexo' => 'H',
        'celular' => '951 712 34 01',
        'telefono' => '',
        'grado' => '',
        'role_id' => 4,
        'carrera_id' => null,
        'adscripcion_id' => 1,
        'email' => 'ra_lo_ro@gmail.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ];

    private $user_depto = [
        'identificador' => 'depto_actextra',
        'nombre' => 'Fernando',
        'apellido_paterno' => 'Manuel',
        'apellido_materno' => 'Aquino',
        'sexo' => 'H',
        'celular' => '951 183 09 10',
        'telefono' => '',
        'grado' => '',
        'role_id' => 10,
        'carrera_id' => null,
        'adscripcion_id' => 24,
        'email' => 'dep_ae@gmail.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ];
    
    
    
    //datos de usuario incorrectos con apellido_paterno no ingresado y confirmacion de contraseña incorrecto
    private $usuario_incorrecto = [
        'identificador' => '14160172',
        'nombre' => 'Daniel',
        'apellido_paterno' => '',
        'apellido_materno' => 'Sanchez',
        'sexo' => 'H',
        'celular' => '',
        'telefono' => '',
        'grado' => '',
        'role_id' => 3,
        'carrera_id' => '1',
        'adscripcion_id' => '',
        'email' => 'asfajj@afsf',
        'password' => 'password',
        'password_confirmation' => 'passworddddd',
    ];


    //SolicitudSolicitanteTest 
    private $solicitud= [
        'asunto' => 'prueba asunto',
        'motivos_academicos' => '',
        'motivos_personales' => '',
        'otros_motivos' => '', 
        'evidencias' => 'subidas/evidencias.pdf',
        'solicitud_firmada' => 'subidas/solicitud.pdf',
        'observaciones' => 'observaciones hechas en reunion',
        'fecha' => '2020-06-17',
        'identificador' => '14161234',
        'semestre' => '12',
        'enviado' => false,
        'enviadocoor' => false,
        'carrera_profesor' => 'sankjf',
        'calendario_id' => 1,
        'file' => ['asfas.jpg']
    ];
    
    //CoordinadorSolicitudTest
    private $solicitud_enviada= [
        'asunto' => 'prorroga para cursar semestre 13',
        'motivos_academicos' => '',
        'motivos_personales' => '',
        'otros_motivos' => '', 
        'evidencias' => 'subidas/evidencias.pdf',
        'solicitud_firmada' => 'subidas/solicitud.pdf',
        'observaciones' => 'ninguna observacion',
        'fecha' => '2020-06-17',
        'identificador' => '14161234',
        'semestre' => '12',
        'enviado' => true,
        'enviadocoor' => false,
        'carrera_profesor' => 'zfsf',
        'calendario_id' => 1,
        'file' => ['asfas.jpg']
    ];

    //RecomendacionTest --JefeSolicitudTest --SecretarioSolicitudTest --DirectorDictamenTest --CoordinadorDictamenTest --JefeDictamenTest
    private $solicitud_enviada_coor= [
        'asunto' => 'prorroga para cursar semestre 13',
        'motivos_academicos' => '',
        'motivos_personales' => '',
        'otros_motivos' => '', 
        'evidencias' => 'subidas/evidencias.pdf',
        'solicitud_firmada' => 'subidas/solicitud.pdf',
        'observaciones' => 'ninguna observacion',
        'fecha' => '2020-06-17',
        'identificador' => '14161234',
        'semestre' => '12',
        'enviado' => true,
        'enviadocoor' => true,
        'carrera_profesor' => '',
        'calendario_id' => 1,
        'file' => ['asfas.jpg']
    ];

    private $solicitud_por_secretario= [
        'asunto' => 'prorroga para cursar semestre 14',
        'motivos_academicos' => '',
        'motivos_personales' => '',
        'otros_motivos' => '', 
        'evidencias' => '',
        'solicitud_firmada' => '',
        'observaciones' => '',
        'fecha' => '2020-06-17',
        'identificador' => '14161234',
        'semestre' => '13',
        'enviado' => true,
        'enviadocoor' => true,
        'carrera_profesor' => '',
        'calendario_id' => 1,
    ];  
    

    //RecomendacionTest --CoordinadorSolicitudTest -JefeSolicitudTest --SecretarioSolicitudTest --DirectorDictamenTest --CoordinadorDictamenTest --JefeDictamenTest
    private $coordinador = [
        'identificador' => 'coorsistemas',
        'nombre' => 'Maria',
        'apellido_paterno' => 'Morales',
        'apellido_materno' => 'Ramirez',
        'sexo' => 'M',
        'celular' => '951 683 65 29',
        'telefono' => '',
        'grado' => 'Lic.',
        'role_id' => 6,
        'adscripcion_id' => 1,
        'email' => 'maria@gmail.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ];

    //observacion de coordinador de solicitud enviada
    //RecomendacionTest --JefeSolicitudTest --SecretarioSolicitudTest --DirectorDictamenTest --CoordinadorDictamenTest --JefeDictamenTest
    private $observacion_coordinador = [
        'identificador' => 'coorsistemas',
        'solicitud_id' => 1,
        'descripcion' =>'solicitud cumple con los acordado, si procede',
        'visto' => true,
    ];
    
    //RecomendacionTest --JefeSolicitudTest --SecretarioSolicitudTest --DirectorDictamenTest --CoordinadorDictamenTest --JefeDictamenTest --ListaAsistenciaTest
    private $jefe = [
        'identificador' => 'jefesistemas',
        'nombre' => 'Elena',
        'apellido_paterno' => 'Pérez',
        'apellido_materno' => 'Jimenez',
        'sexo' => 'M',
        'celular' => '951 604 61 24',
        'telefono' => '',
        'grado' => 'Mtra.',
        'role_id' => 5,
        'adscripcion_id' => 1,
        'email' => 'elena@gmail.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ];

    private $jefe_division = [
        'identificador' => 'jefedivision',
        'nombre' => 'Marcos',
        'apellido_paterno' => 'Rodriguez',
        'apellido_materno' => 'Sanchez',
        'sexo' => 'H',
        'celular' => '951 811 99 17',
        'telefono' => '',
        'grado' => 'Ing.',
        'role_id' => 5,
        'adscripcion_id' => 11,
        'email' => 'marcos_division@gmail.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ];
    

    //RecomendacionTest --SecretarioSolicitudTest --DirectorDictamenTest --CoordinadorDictamenTest --JefeDictamenTest
    //observacion de jefe a la solicitud enviada
    private $observacion_jefe = [
        'identificador' => 'jefesistemas',
        'solicitud_id' => 1,
        'descripcion' =>'solicitud aceptada, voto a favor',
        'visto' => true,
    ];

    //RecomendacionTest --SecretarioSolicitudTest --DirectorDictamenTest --ListaAsistenciaTest
    private $secretario = [
        'identificador' => 'secretario_tecnico',
        'nombre' => 'Ramon',
        'apellido_paterno' => 'Alvarez',
        'apellido_materno' => 'Lopez',
        'sexo' => 'H',
        'celular' => '951 609 81 34',
        'telefono' => '',
        'grado' => 'Ing.',
        'role_id' => 1,
        'adscripcion_id' => 3,
        'email' => 'ra_mon@gmail.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ];
    

    //RecomendacionTest
    private $recomendacion = [
        'id' => 1,
        'respuesta' => 'SI',
        'observaciones' => 'se le condiciona que pase todas sus materias',
        'id_solicitud' => 1,
    ];
    
    //--DirectorDictamenTest --JefeDictamenTest
    private $recomendacion_enviada = [
        'id' => 1,
        'num_recomendacion' => '256/20',
        'num_oficio' => 'CA-00-256/20',
        'fecha' => '14/enero/2020',
        'respuesta' => 'SI',
        'condicion' => 'condicionado a pasar sus materias',
        'observaciones' => '',
        'motivos' => '',
        'archivo' => 'subidas/recomendacion.pdf',
        'enviado' => true,
        'id_solicitud' => 1,
    ];
    

    //RecomendacionTest --DirectorDictamenTest --JefeDictamenTest --ListaAsistenciaTest
    private $subdirector = [
        'identificador' => 'subdirector',
        'nombre' => 'Ana',
        'apellido_paterno' => 'Ruiz',
        'apellido_materno' => 'Tames',
        'sexo' => 'M',
        'celular' => '951 561 28 89',
        'telefono' => '51 234 55',
        'grado' => 'Ing.',
        'role_id' => 8,
        'adscripcion_id' => 10,
        'email' => 'ana_tames@gmail.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ];

    //RecomendacionTest --DirectorDictamenTest 
    private $director = [
        'identificador' => 'director',
        'nombre' => 'Gabriel',
        'apellido_paterno' => 'Vicente',
        'apellido_materno' => 'Sanchez',
        'sexo' => 'H',
        'celular' => '951 901 67 15',
        'telefono' => '',
        'grado' => 'Ing.',
        'role_id' => 2,
        'adscripcion_id' => 9,
        'email' => 'gabriel@gmail.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ];

    //--DirectorDictamenTest
    private $dictamen = [
        'recomendacion_id' => 1,
        'num_oficio' => 'DIR-00-100/2020',
        'num_dictamen' => '100/2020',
        'respuesta' => 'SI',
        'anotaciones' => '',
        'fecha' => '15/enero/2020',
        'dictamen_firmado' => 'subidas/dictamen.pdf',
        'enviado' => false,
        'entregado'=> false,
        'entregadodepto' => false,
    ];

    //CoordinadorDictamenTest  --JefeDictamenTest
    private $dictamen_enviado = [
        'recomendacion_id' => 1,
        'num_oficio' => 'DIR-00-101/2020',
        'num_dictamen' => '101/2020',
        'respuesta' => 'SI',
        'anotaciones' => '',
        'fecha' => '15/enero/2020',
        'dictamen_firmado' => 'subidas/dictamen.pdf',
        'enviado' => true,
        'entregado'=> false,
        'entregadodepto' => true,
    ];

    //--ListaAsistenciaTest
    private $jefequimica = [
        'identificador' => 'jefequimica',
        'nombre' => 'Alejandro',
        'apellido_paterno' => 'Rodriguez',
        'apellido_materno' => 'Lopez',
        'sexo' => 'H',
        'celular' => '951 604 61 24',
        'telefono' => '',
        'grado' => 'Mtro.',
        'role_id' => 5,
        'adscripcion_id' => 2,
        'email' => 'ale_jandro@gmail.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ];
    

    //--ListaAsistenciaTest
    private $lista_asistencia=[
        'lista_archivo' =>'',
        'calendario_id' => 1
    ];

    //--ListaAsistenciaTest
    private $asistencia_secretario=[
        'lista_id' => 1,
        'identificador' => 'secretario_tecnico',
        'observacion' => 'ASISTENCIA',
    ];
    //--ListaAsistenciaTest
    private $asistencia_subdirector=[
        'lista_id' => 1,
        'identificador' => 'subdirector',
        'observacion' => 'ASISTENCIA',
    ];
    //--ListaAsistenciaTest
    private $asistencia_jefe=[
        'lista_id' => 1,
        'identificador' => 'jefesistemas',
        'observacion' => 'ASISTENCIA',
    ];
    //--ListaAsistenciaTest
    private $asistencia_jefequimica=[
        'lista_id' => 1,
        'identificador' => 'jefequimica',
        'observacion' => 'ASISTENCIA',
    ];

    private $citatorio = [
        'fecha' => '2020-06-20',
        'oficio' => 'CA-01-2020',
        'archivo' => '',
        'enviado' => false,
        'calendario_id' => 1,
    ];
    
    private $acta = [
        'titulo' => 'PRIMERA REUNIÓN DE COMITÉ ACADÉMICO',
        'contenido' => 'CONTENIDO ACTA',
        'calendario_id' => 1
    ];

    private $carrera = [
        'nombre' => 'Ingenieria en agronomia',
    ];

    private $adscripcion = [
        'nombre_adscripcion' => 'Departamento del campo',
        'tipo' => 'carrera',
    ];

    private $asunto = [
        'asunto' => 'prorroga para cursar el semestre 14',
        'descripcion' => 'indique el periodo del semestre el cual cursara',
    ];

    private $orden = [
        'titulo' => 'ordendia',
        'contenido' => 'puntouno--puntodos--puntotres',
        'calendario_id' => 3,
    ];

    private $orden_dia = [
        'titulo' => 'ordendia',
        'contenido' => 'puntouno--puntodos--puntotres',
        'acta_file' => 'subidas/actaorden.pdf',
        'calendario_id' => 1,
    ];



}