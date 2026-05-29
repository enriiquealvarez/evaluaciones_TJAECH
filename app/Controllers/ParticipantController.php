<?php
// app/Controllers/ParticipantController.php
class ParticipantController extends BaseController {
    private const PARTICIPANT_GUIDE_RELATIVE_PATH = '/assets/docs/indicaciones-participantes-capacitaciones.pdf';
    private const COURSE_REGISTRATION_INSTITUTIONS = [
        'Secretaría General de Gobierno y Mediación',
        'Secretaría de Finanzas.',
        'Secretaría de Campo',
        'Secretaría Anticorrupción y Buen Gobierno.',
        'Secretaría de la Mujer e Igualdad de Género.',
        'Secretaría de Protección Civil.',
        'Secretaría de Infraestructura.',
        'Secretaría de Medio Ambiente e Historia Natural.',
        'Secretaría de Economía y del Trabajo.',
        'Secretaría del Humanismo.',
        'Secretaría de Agricultura, Ganadería y Pesca.',
        'Secretaría de Turismo',
        'Secretaría para el Desarrollo Sustentable de los Pueblos Indígenas.',
        'Secretaría de Salud.',
        'Secretaría de Educación.',
        'Secretaría de Seguridad del Pueblo.',
        'Secretaría de Movilidad y Transporte.',
        'Secretaría de la frontera sur.',
        'Instituto de Consejería Jurídica del Buen Gobierno del Estado.',
        'Secretaría de Pesca y Acuacultura del Pueblo.',
        'Comisión Estatal de Búsqueda de Personas',
        'Oficialía Mayor del Estado de Chiapas',
        'Transparencia para el Pueblo de Chiapas',
        'Centro Estatal de Trasplantes del Estado de Chiapas',
        'Coordinación Estatal para el Mejoramiento del Zoológico "Miguel Álvarez del Toro"',
        'Junta Local de Conciliación y Arbitraje del Estado de Chiapas',
        'Instituto de la Juventud del Estado de Chiapas',
        'Instituto de Protección Social y Beneficencia Pública del Estado de Chiapas',
        'Centro Estatal de Prevención Social de la Violencia y Participación Ciudadana',
        'Universidad de Seguridad Pública del Sureste',
        'Instituto de Evaluacion, Profesionalizacion y Promocion Docente de Chiapas',
        'Comision Estatal de Simplificacion Administrativa',
        'Instituto para la Gestion Integral de Riesgos de Desastres del Estado de Chiapas',
        'Comision Ejecutiva Estatal de Atencion a Victimas para el Estado de Chiapas',
        'Instituto del Patrimonio del Estado',
        'Agencia Digital Tecnologica del Estado',
        'Instituto de Bomberos del Estado de Chiapas',
        'Comision Estatal de Caminos',
        'Comision Estatal del Agua y Saneamiento de Chiapas',
        'Procuraduria Ambiental del Estado de Chiapas',
        'Instituto de Capacitacion y Vinculacion Tecnologica del Estado de Chiapas',
        'Instituto Casa de las Artesanias de Chiapas',
        'Centro de Conciliacion Laboral del Estado de Chiapas',
        'Promotora de Vivienda Chiapas',
        'Instituto de Salud',
        'Sistema para el Desarrollo Integral de la Familia del Estado de Chiapas (SISTEMA DIF CHIAPAS)',
        'Colegio de Bachilleres de Chiapas',
        'Colegio de Educacion Profesional Tecnica del Estado de Chiapas (CONALEP CHIAPAS)',
        'Universidad Tecnologica de la Selva',
        'Instituto Chiapaneco de Educacion para Jovenes y Adultos',
        'Instituto Tecnologico Superior de Cintalapa',
        'Universidad Politecnica de Chiapas',
        'Universidad Intercultural de Chiapas',
        'Instituto de la Infraestructura Fisica Educativa del Estado de Chiapas',
        'Talleres Graficos de Chiapas',
        'Centro Estatal de Control de Confianza Certificado del Estado de Chiapas',
        'Sistema Chiapaneco de Radio, Television y Cinematografia',
        'Colegio de Estudios Cientificos y Tecnologicos del Estado de Chiapas',
        'Oficina de Convenciones y Visitantes',
        'Instituto de Seguridad Social de los Trabajadores del Estado de Chiapas',
        'Consejo Estatal para las Culturas y las Artes de Chiapas',
        'Comision Estatal de Conciliacion y Arbitraje Medico del Estado de Chiapas',
        'Secretariado Ejecutivo del Sistema Estatal de Seguridad Publica',
        'Secretaria Ejecutiva del Sistema Anticorrupcion del Estado de Chiapas',
        'Archivo General del Estado',
        'Instituto del Cafe de Chiapas',
        'Instituto de Comunicacion Social y Relaciones Publicas del Estado de Chiapas',
        'Instituto del Deporte del Estado de Chiapas',
        'Sociedad Operadora de la Torre Chiapas S.A. de C.V.',
        'Sociedad Operadora del Aeropuerto Internacional "Angel Albino Corzo"',
        'Ayuntamiento de Acacoyagua',
        'Ayuntamiento de Acala',
        'Ayuntamiento de Acapetahua',
        'Ayuntamiento de Aldama',
        'Ayuntamiento de Altamirano',
        'Ayuntamiento de Amatan',
        'Ayuntamiento de Amatenango de la Frontera',
        'Ayuntamiento de Amatenango del Valle',
        'Ayuntamiento de Angel Albino Corzo',
        'Ayuntamiento de Arriaga',
        'Ayuntamiento de Bejucal de Ocampo',
        'Ayuntamiento de Bella Vista',
        'Ayuntamiento de Benemerito de las Americas',
        'Ayuntamiento de Berriozabal',
        'Ayuntamiento de Bochil',
        'Ayuntamiento de Cacahoatan',
        'Ayuntamiento de Capitan Luis Angel Vidal',
        'Ayuntamiento de Catazaja',
        'Ayuntamiento de Chalchihuitan',
        'Ayuntamiento de Chamula',
        'Ayuntamiento de Chanal',
        'Ayuntamiento de Marques de Comillas',
        'Ayuntamiento de Mazapa de Madero',
        'Ayuntamiento de Mazatan',
        'Ayuntamiento de Metapa',
        'Ayuntamiento de Mezcalapa',
        'Ayuntamiento de Mitontic',
        'Ayuntamiento de Montecristo de Guerrero',
        'Ayuntamiento de Motozintla',
        'Ayuntamiento de Nicolas Ruiz',
        'Ayuntamiento de Ocosingo',
        'Ayuntamiento de Ocotepec',
        'Ayuntamiento de Ocozocoautla de Espinosa',
        'Ayuntamiento de Ostuacan',
        'Ayuntamiento de Osumacinta',
        'Ayuntamiento de Oxchuc',
        'Ayuntamiento de Palenque',
        'Ayuntamiento de Pantelho',
        'Ayuntamiento de Pantepec',
        'Ayuntamiento de Pichucalco',
        'Ayuntamiento de Pijijiapan',
        'Ayuntamiento de Pueblo Nuevo Solistahuacan',
        'Ayuntamiento de Chapultenango',
        'Ayuntamiento de Chenalho',
        'Ayuntamiento de Chiapa de Corzo',
        'Ayuntamiento de Chiapilla',
        'Ayuntamiento de Chicoasen',
        'Ayuntamiento de Chicomuselo',
        'Ayuntamiento de Chilon',
        'Ayuntamiento de Cintalapa',
        'Ayuntamiento de Coapilla',
        'Ayuntamiento de Comitan de Dominguez',
        'Ayuntamiento de Copainala',
        'Ayuntamiento de El Bosque',
        'Ayuntamiento de El Parral',
        'Ayuntamiento de El Porvenir',
        'Ayuntamiento de Emiliano Zapata',
        'Ayuntamiento de Escuintla',
        'Ayuntamiento de Francisco Leon',
        'Ayuntamiento de Frontera Comalapa',
        'Ayuntamiento de Frontera Hidalgo',
        'Ayuntamiento de Honduras de la Sierra',
        'Ayuntamiento de Huehuetan',
        'Ayuntamiento de Huitiupan',
        'Ayuntamiento de Huixtan',
        'Ayuntamiento de Huixtla',
        'Ayuntamiento de Ixhuatan',
        'Ayuntamiento de Ixtacomitan',
        'Ayuntamiento de Ixtapa',
        'Ayuntamiento de Ixtapangajoya',
        'Ayuntamiento de Jiquipilas',
        'Ayuntamiento de Rayon',
        'Ayuntamiento de Reforma',
        'Ayuntamiento de Rincon Chamula San Pedro',
        'Ayuntamiento de Sabanilla',
        'Ayuntamiento de Salto de Agua',
        'Ayuntamiento de San Andres Duraznal',
        'Ayuntamiento de San Cristobal de las Casas',
        'Ayuntamiento de San Fernando',
        'Ayuntamiento de San Juan Cancuc',
        'Ayuntamiento de San Lucas',
        'Ayuntamiento de Santiago el Pinar',
        'Ayuntamiento de Siltepec',
        'Ayuntamiento de Simojovel',
        'Ayuntamiento de Sitala',
        'Ayuntamiento de Socoltenango',
        'Ayuntamiento de Solosuchiapa',
        'Ayuntamiento de Soyalo',
        'Ayuntamiento de Suchiapa',
        'Ayuntamiento de Suchiate',
        'Ayuntamiento de Sunuapa',
        'Ayuntamiento de Tapachula',
        'Ayuntamiento de Tapalapa',
        'Ayuntamiento de Tapilula',
        'Ayuntamiento de Tecpatan',
        'Ayuntamiento de Tenejapa',
        'Ayuntamiento de Teopisca',
        'Ayuntamiento de Tila',
        'Ayuntamiento de Tonala',
        'Ayuntamiento de Totolapa',
        'Ayuntamiento de Jitotol',
        'Ayuntamiento de Juarez',
        'Ayuntamiento de La Concordia',
        'Ayuntamiento de La Grandeza',
        'Ayuntamiento de La Independencia',
        'Ayuntamiento de La Libertad',
        'Ayuntamiento de La Trinitaria',
        'Ayuntamiento de Larrainzar',
        'Ayuntamiento de Las Margaritas',
        'Ayuntamiento de Las Rosas',
        'Ayuntamiento de Mapastepec',
        'Ayuntamiento de Maravilla Tenejapa',
        'Ayuntamiento de Tumbala',
        'Ayuntamiento de Tuxtla Chico',
        'Ayuntamiento de Tuxtla Gutierrez',
        'Ayuntamiento de Tuzantan',
        'Ayuntamiento de Tzimol',
        'Ayuntamiento de Union Juarez',
        'Ayuntamiento de Venustiano Carranza',
        'Ayuntamiento de Villa Comaltitlan',
        'Ayuntamiento de Villa Corzo',
        'Ayuntamiento de Villaflores',
        'Ayuntamiento de Yajalon',
        'Ayuntamiento de Zinacantan',
        'Ayuntamiento de Belisario Domínguez',
        'Tribunal de Justicia Administrativa del Estado de Chiapas',
        'Instituto de Elecciones y Participación Ciudadana',
        'Comisión Estatal de los Derechos Humanos',
        'Tribunal Electoral del Estado de Chiapas.',
        'Fiscalía General del Estado',
        'Benemérita Universidad Autónoma de Chiapas',
        'Universidad de Ciencias y Artes de Chiapas',
        'Comisión Federal de Electricidad',
        'Auditoría Superior del Estado de Chiapas',
        'Congreso del Estado de Chiapas',
        'Tribunal Superior de Justicia del Estado de Chiapas',
        'Consejo de la Judicatura del Estado de Chiapas',
        'Público en General',
        'Estudiante',
        'No aplica',
        'Otro'
        ];

    public function showCourseRegistration(): void {
        $cursoId = (int)($_GET['curso_id'] ?? 0);
        $curso = $cursoId ? Curso::find($cursoId) : null;
        if (!$curso || (int)$curso['activo'] !== 1 || (int)($curso['terminado'] ?? 0) === 1) {
            Session::flash('error', 'El curso no está disponible.');
            redirect('/');
        }

        $canGoEvaluation = (int)Session::get('ready_evaluacion_curso_' . $cursoId, 0) === 1;

        $cupoLleno = false;
        if ((int)($curso['tiene_cupo'] ?? 0) === 1) {
            $inscritos = InscripcionCurso::countByCurso($cursoId);
            $cupoMaximo = (int)($curso['cupo_maximo'] ?? 0);
            if ($inscritos >= $cupoMaximo && $cupoMaximo > 0) {
                $cupoLleno = true;
            }
        }

        $this->render('public/curso_registro', [
            'curso' => $curso,
            'canGoEvaluation' => $canGoEvaluation,
            'cupoLleno' => $cupoLleno,
            'institutionOptions' => self::COURSE_REGISTRATION_INSTITUTIONS,
            'participantGuideUrl' => asset(self::PARTICIPANT_GUIDE_RELATIVE_PATH) . '?v=' . time(),
            'errors' => Session::flash('errors') ?? [],
            'old' => Session::flash('old') ?? [],
            'error' => Session::flash('error'),
            'success' => Session::flash('success')
        ], 'public');
    }

    public function submitCourseRegistration(): void {
        if (!CSRF::validate($_POST['_csrf'] ?? null)) {
            Session::flash('error', 'Token inválido.');
            redirect('/');
        }

        $cursoId = (int)($_POST['curso_id'] ?? 0);
        $curso = $cursoId ? Curso::find($cursoId) : null;
        if (!$curso || (int)$curso['activo'] !== 1 || (int)($curso['terminado'] ?? 0) === 1) {
            Session::flash('error', 'El curso no está disponible.');
            redirect('/');
        }

        if ((int)($curso['tiene_cupo'] ?? 0) === 1) {
            $inscritos = InscripcionCurso::countByCurso($cursoId);
            $cupoMaximo = (int)($curso['cupo_maximo'] ?? 0);
            if ($inscritos >= $cupoMaximo && $cupoMaximo > 0) {
                Session::flash('error', 'El cupo máximo para este curso se ha agotado.');
                redirect('/curso/registro?curso_id=' . $cursoId);
            }
        }

        $nombre = trim($_POST['nombre_completo'] ?? '');
        $edad = (int)($_POST['edad'] ?? 0);
        $genero = trim($_POST['genero'] ?? '');
        $correo = mb_strtolower(trim($_POST['correo'] ?? ''));
        $telefono = preg_replace('/\D+/', '', (string)($_POST['telefono'] ?? ''));
        $institucion = trim($_POST['institucion'] ?? '');
        $institucionOtra = trim($_POST['institucion_otra'] ?? '');
        $cargo = trim($_POST['cargo_puesto'] ?? '');
        $grado = trim($_POST['grado_estudios'] ?? '');
        $gradoOtro = trim($_POST['grado_otro'] ?? '');
        $colectivos = $_POST['colectivos'] ?? [];
        if (!is_array($colectivos)) {
            $colectivos = [];
        }
        $colectivos = array_values(array_unique(array_map('trim', $colectivos)));

        $validator = new Validator();
        $generosValidos = ['Mujer', 'Hombre', 'No binario/otro', 'Prefiero no responder'];
        $gradosValidos = ['Educacion media superior', 'Licenciatura', 'Posgrado', 'Otro'];

        $validator->required('nombre_completo', $nombre, 'El nombre completo es obligatorio.');
        if ($edad < 10 || $edad > 99) {
            $validator->required('edad', '', 'La edad debe estar entre 10 y 99 años.');
        }
        if (!in_array($genero, $generosValidos, true)) {
            $validator->required('genero', '', 'Seleccione un género válido.');
        }
        $validator->required('correo', $correo, 'El correo es obligatorio.');
        $validator->email('correo', $correo, 'Correo inválido.');
        $validator->required('telefono', $telefono, 'El teléfono es obligatorio.');
        if (mb_strlen($telefono) < 10) {
            $validator->required('telefono', '', 'El teléfono debe contener al menos 10 dígitos.');
        }
        $validator->required('institucion', $institucion, 'La institución es obligatoria.');
        if ($institucion !== '' && !in_array($institucion, self::COURSE_REGISTRATION_INSTITUTIONS, true)) {
            $validator->required('institucion', '', 'Seleccione una institucion o ayuntamiento de la lista autorizada.');
        }
        if ($institucion === 'Otro') {
            $validator->required('institucion_otra', $institucionOtra, 'Especifique su institución.');
        }
        // $validator->required('cargo_puesto', $cargo, 'El cargo o puesto es obligatorio.');
        if (!in_array($grado, $gradosValidos, true)) {
            $validator->required('grado_estudios', '', 'Seleccione el último grado de estudios.');
        }
        if ($grado === 'Otro' && $gradoOtro === '') {
            $validator->required('grado_otro', '', 'Especifique el grado de estudios.');
        }
        if (empty($colectivos)) {
            $validator->required('colectivos', '', 'Seleccione al menos un grupo o colectivo.');
        }

        if (InscripcionCurso::existsByCorreoOrTelefono($cursoId, $correo, $telefono)) {
            $validator->required('inscripcion', '', 'Ya existe un registro previo con ese correo o teléfono para este curso.');
        }

        if ($validator->hasErrors()) {
            Session::flash('errors', $validator->errors());
            Session::flash('old', $_POST);
            redirect('/curso/registro?curso_id=' . $cursoId);
        }

        InscripcionCurso::create([
            'curso_id' => $cursoId,
            'nombre_completo' => $nombre,
            'edad' => $edad,
            'genero' => $genero,
            'correo' => $correo,
            'telefono' => $telefono,
            'institucion' => $institucion,
            'institucion_otra' => $institucion === 'Otro' ? $institucionOtra : '',
            'cargo_puesto' => $cargo,
            'grado_estudios' => $grado,
            'grado_otro' => $grado === 'Otro' ? $gradoOtro : '',
            'colectivos_json' => json_encode($colectivos, JSON_UNESCAPED_UNICODE)
        ]);

        $this->sendParticipantRegistrationEmail($nombre, $correo, $curso, $telefono);

        Session::flash('success', 'Registro al curso completado, las indicaciones y recomendaciones del curso fueron enviadas a su correo electrónico. Cuando el curso tenga evaluación, podrá ingresar con su correo y número telefónico.');
        redirect('/curso/registro?curso_id=' . $cursoId);
    }

    private function sendParticipantRegistrationEmail(string $name, string $email, array $curso, string $telefono): void {
        if ($email === '') {
            return;
        }

        $guidePath = $this->participantGuideFilePath();
        if (!is_file($guidePath)) {
            return;
        }

        try {
            $mailer = new Mailer();
            $subject = 'Confirmacion de registro - Programa de capacitacion TJAECH';
            $html = $this->buildParticipantRegistrationEmail(
                $name,
                (string)($curso['nombre'] ?? 'Programa de capacitaciÃ³n'),
                $email,
                $telefono
            );
            $text = "Hola {$name},\n\nTu registro al curso \"" . ($curso['nombre'] ?? 'Programa de capacitación') . "\" ha sido recibido exitosamente.\nAdjuntamos el documento con indicaciones y recomendaciones para tu participación, te sugerimos revisarlo antes del curso.\n\nCorreo registrado: {$email}\nTelefono registrado: {$telefono}\nContacto: ija@tjaech.gob.mx\n\nTribunal de Justicia Administrativa del Estado de Chiapas";
            $mailer->send($email, $name, $subject, $html, $text, [[
                'path' => $guidePath,
                'filename' => 'indicaciones-participantes-capacitaciones.pdf',
                'mime' => 'application/pdf',
            ]], [
                'from_name' => 'Instituto de Justicia Administrativa',
                'reply_to_email' => 'ija@tjaech.gob.mx',
                'reply_to_name' => 'Instituto de Justicia Administrativa',
            ]);
        } catch (Throwable $e) {
            error_log($e->getMessage());
        }
    }

    private function buildParticipantRegistrationEmail(string $name, string $courseName, string $email, string $telefono): string {
        $safeName = e($name);
        $safeCourse = e($courseName);
        $safeEmail = e($email);
        $safeTelefono = e($telefono);

        return <<<HTML
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Confirmacion de registro</title>
</head>
<body style="margin:0;background:#f5f6f9;font-family:Arial,sans-serif;color:#1a1a1a;">
  <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="padding:24px 0;">
    <tr>
      <td align="center">
        <table role="presentation" width="560" cellspacing="0" cellpadding="0" style="background:#fff;border-radius:16px;overflow:hidden;border:1px solid #e6d7b3;">
          <tr>
            <td style="background:#1b3f66;color:#fff;padding:18px 24px;">
              <strong>Sistema de Evaluacion de Capacitaciones TJAECH</strong><br>
              <span style="font-size:12px;opacity:0.9;">Tribunal de Justicia Administrativa del Estado de Chiapas</span>
            </td>
          </tr>
          <tr>
            <td style="padding:24px 24px 8px;">
              <h2 style="margin:0 0 8px 0;">Registro recibido correctamente</h2>
              <p style="margin:0 0 12px 0;">Hola {$safeName},</p>
              <p style="margin:0 0 12px 0;">Tu registro al curso "<strong>{$safeCourse}</strong>" ha sido recibido exitosamente.</p>
              <p style="margin:0 0 12px 0;">Adjuntamos el documento con indicaciones y recomendaciones para tu participación, te sugerimos revisarlo antes del curso.</p>
            </td>
          </tr>
          <tr>
            <td style="padding:8px 24px 16px;">
              <div style="border:1px solid #e6d7b3;border-radius:12px;padding:14px 16px;background:#faf7ef;">
                <p style="margin:0 0 8px 0;"><strong>Correo registrado:</strong> {$safeEmail}</p>
                <p style="margin:0 0 8px 0;"><strong>Telefono registrado:</strong> {$safeTelefono}</p>
                <p style="margin:0;"><strong>Contacto:</strong> ija@tjaech.gob.mx</p>
              </div>
            </td>
          </tr>
          <tr>
            <td style="padding:0 24px 18px;">
              <p style="margin:0;font-size:13px;color:#334;">Conserva este mensaje para futuras referencias sobre tu participacion.</p>
            </td>
          </tr>
          <tr>
            <td style="padding:14px 24px;background:#faf7ef;font-size:12px;color:#334;">
              Instituto de Justicia Administrativa - Tribunal de Justicia Administrativa del Estado de Chiapas
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
</body>
</html>
HTML;
    }

    private function participantGuideFilePath(): string {
        return dirname(__DIR__, 2) . '/public' . self::PARTICIPANT_GUIDE_RELATIVE_PATH;
    }

    public function show(): void {
        $cursoId = (int)($_GET['curso_id'] ?? 0);
        $curso = $cursoId ? Curso::find($cursoId) : null;
        if (!$curso || (int)$curso['activo'] !== 1 || (int)($curso['terminado'] ?? 0) === 1) {
            Session::flash('error', 'El curso no está disponible.');
            redirect('/');
        }
        $evaluacion = Evaluacion::activeByCurso($cursoId);
        if (!$evaluacion) {
            Session::flash('error', 'No hay evaluación activa para este curso.');
            redirect('/');
        }
        $preguntas = Pregunta::byEvaluacion((int)$evaluacion['id']);
        $this->render('public/participante_form', [
            'curso' => $curso,
            'evaluacion' => $evaluacion,
            'preguntas' => $preguntas,
            'errors' => Session::flash('errors') ?? [],
            'old' => Session::flash('old') ?? [],
            'error' => Session::flash('error')
        ], 'public');
    }

    public function submit(): void {
        if (!CSRF::validate($_POST['_csrf'] ?? null)) {
            Session::flash('error', 'Token inválido.');
            redirect('/');
        }
        $cursoId = (int)($_POST['curso_id'] ?? 0);
        $evaluacionId = (int)($_POST['evaluacion_id'] ?? 0);
        $curso = $cursoId ? Curso::find($cursoId) : null;
        $evaluacion = $evaluacionId ? Evaluacion::find($evaluacionId) : null;
        if (!$curso || !$evaluacion || (int)$curso['id'] !== (int)$evaluacion['curso_id']) {
            Session::flash('error', 'Solicitud inválida.');
            redirect('/');
        }

        $validator = new Validator();
        $correo = mb_strtolower(trim($_POST['correo'] ?? ''));
        $telefono = preg_replace('/\D+/', '', (string)($_POST['telefono'] ?? ''));
        $comentarios = trim($_POST['comentarios'] ?? '');

        $validator->email('correo', $correo, 'Correo inválido.');
        $validator->required('correo', $correo, 'El correo es obligatorio.');
        $validator->required('telefono', $telefono, 'El teléfono es obligatorio.');
        if (mb_strlen($telefono) < 10) {
            $validator->required('telefono', '', 'El teléfono debe contener al menos 10 dígitos.');
        }

        $inscripcion = InscripcionCurso::findByContacto($cursoId, $correo, $telefono);
        if (!$inscripcion) {
            $validator->required('registro', '', 'No encontramos un registro previo del curso con ese correo y teléfono.');
        } elseif (!(int)($inscripcion['validado_evaluacion'] ?? 0)) {
            $validator->required('registro', '', 'Su acceso a la evaluación aún no ha sido validado. Por favor, asegúrese de haber cumplido con los requisitos de asistencia.');
        }

        $preguntas = Pregunta::byEvaluacion($evaluacionId);
        $answers = $_POST['answers'] ?? [];
        foreach ($preguntas as $pregunta) {
            $pid = (int)$pregunta['id'];
            $required = (int)$pregunta['requerido'] === 1;
            $value = $answers[$pid] ?? null;
            if ($required && (is_array($value) ? empty($value) : trim((string)$value) === '')) {
                $validator->required('pregunta_' . $pid, '', 'Faltan respuestas obligatorias.');
                break;
            }
        }

        if ($validator->hasErrors()) {
            Session::flash('errors', $validator->errors());
            Session::flash('old', $_POST);
            redirect('/participante/registro?curso_id=' . $cursoId);
        }

        if (Respuesta::existsByContactoPair($cursoId, $correo, $telefono)) {
            Session::flash('error', 'Ya existe una evaluación registrada con este correo y teléfono.');
            Session::flash('old', $_POST);
            redirect('/participante/registro?curso_id=' . $cursoId);
        }

        $folio = strtoupper(bin2hex(random_bytes(4))) . '-' . date('ymd');
        $respuestaId = Respuesta::create([
            'curso_id' => $cursoId,
            'evaluacion_id' => $evaluacionId,
            'folio' => $folio,
            'nombre_completo' => $inscripcion['nombre_completo'],
            'correo' => $correo,
            'telefono' => $telefono,
            'municipio' => $inscripcion['institucion'],
            'cargo_puesto' => $inscripcion['cargo_puesto'],
            'comentarios' => $comentarios,
            'ip' => $_SERVER['REMOTE_ADDR'] ?? '',
            'user_agent' => substr($_SERVER['HTTP_USER_AGENT'] ?? '', 0, 180)
        ]);

        foreach ($preguntas as $pregunta) {
            $pid = (int)$pregunta['id'];
            $tipo = $pregunta['tipo'];
            $raw = $answers[$pid] ?? null;
            $data = ['valor_texto' => null, 'valor_opcion' => null, 'valor_num' => null];

            if (in_array($tipo, ['opcion', 'si_no'], true)) {
                $data['valor_opcion'] = is_array($raw) ? ($raw[0] ?? null) : $raw;
            } elseif ($tipo === 'likert') {
                $data['valor_num'] = (int)$raw;
            } else {
                $data['valor_texto'] = trim((string)$raw);
            }
            RespuestaDetalle::create($respuestaId, $pid, $data);
        }

        redirect('/participante/satisfaccion?folio=' . urlencode($folio));
    }

    public function checkContact(): void {
        $evaluacionId = (int)($_GET['evaluacion_id'] ?? 0);
        $cursoId = (int)($_GET['curso_id'] ?? 0);
        $correo = trim($_GET['correo'] ?? '');
        $telefono = trim($_GET['telefono'] ?? '');

        // Ensure clean JSON response even if any buffer was started earlier.
        while (ob_get_level() > 0) {
            ob_end_clean();
        }
        header('Content-Type: application/json; charset=utf-8');

        if ($evaluacionId <= 0 && $cursoId <= 0) {
            echo json_encode(['ok' => false, 'exists' => false, 'message' => 'Evaluación inválida.']);
            return;
        }

        if ($correo === '' && $telefono === '') {
            echo json_encode(['ok' => true, 'exists' => false]);
            return;
        }

        $inscripcion = InscripcionCurso::findByContacto($cursoId, $correo, $telefono);
        if (!$inscripcion) {
            echo json_encode([
                'ok' => true,
                'exists' => true,
                'message' => 'No encontramos un registro previo del curso con ese correo y teléfono.'
            ]);
            return;
        }

        if (!(int)($inscripcion['validado_evaluacion'] ?? 0)) {
            echo json_encode([
                'ok' => true,
                'exists' => true,
                'message' => 'Su acceso a la evaluación aún no ha sido validado. Asegúrese de haber cumplido con la asistencia.'
            ]);
            return;
        }

        $exists = Respuesta::existsByContactoPair($cursoId, $correo, $telefono);
        echo json_encode([
            'ok' => true,
            'exists' => $exists,
            'message' => $exists ? 'Ya existe una evaluación registrada con este correo y teléfono.' : null
        ]);
    }

    public function receipt(): void {
        $folio = trim($_GET['folio'] ?? '');
        $respuesta = $folio ? Respuesta::findByFolio($folio) : null;
        if (!$respuesta) {
            Session::flash('error', 'Folio no encontrado.');
            redirect('/');
        }
        if (!EncuestaSatisfaccion::existsByRespuesta((int)$respuesta['id'])) {
            Session::flash('error', 'Antes de continuar, complete la encuesta de satisfaccion.');
            redirect('/participante/satisfaccion?folio=' . urlencode($folio));
        }
        $this->render('public/acuse', [
            'respuesta' => $respuesta
        ], 'public');
    }

    public function showSatisfaction(): void {
        $folio = trim($_GET['folio'] ?? '');
        $respuesta = $folio ? Respuesta::findByFolio($folio) : null;
        if (!$respuesta) {
            Session::flash('error', 'No se encontro la evaluacion para este folio.');
            redirect('/');
        }

        if (EncuestaSatisfaccion::existsByRespuesta((int)$respuesta['id'])) {
            redirect('/participante/ver-calificacion?id=' . (int)$respuesta['id']);
        }

        $this->render('public/satisfaccion_form', [
            'respuesta' => $respuesta,
            'errors' => Session::flash('errors') ?? [],
            'old' => Session::flash('old') ?? [],
            'error' => Session::flash('error')
        ], 'public');
    }

    public function submitSatisfaction(): void {
        if (!CSRF::validate($_POST['_csrf'] ?? null)) {
            Session::flash('error', 'Token invalido.');
            redirect('/');
        }

        $folio = trim($_POST['folio'] ?? '');
        $respuesta = $folio ? Respuesta::findByFolio($folio) : null;
        if (!$respuesta) {
            Session::flash('error', 'No se encontro la evaluacion para este folio.');
            redirect('/');
        }

        if (EncuestaSatisfaccion::existsByRespuesta((int)$respuesta['id'])) {
            redirect('/participante/ver-calificacion?id=' . (int)$respuesta['id']);
        }

        $validator = new Validator();

        $q1 = trim($_POST['q1'] ?? '');
        $q2 = trim($_POST['q2'] ?? '');
        $q3 = trim($_POST['q3'] ?? '');
        $q4 = trim($_POST['q4'] ?? '');
        $q5 = trim($_POST['q5'] ?? '');
        $comentarios = trim($_POST['comentarios'] ?? '');

        $qScaleValid = ['5', '4', '3', '2', '1'];
        $q1Valid = array_merge(['Muy satisfecho/a', 'Satisfecho/a', 'Ni satisfecho/a ni insatisfecho/a', 'Insatisfecho/a'], $qScaleValid);
        $q2Valid = array_merge(['Muy buena', 'Buena', 'Regular', 'Deficiente'], $qScaleValid);
        $q3Valid = array_merge(['Excelente', 'Buena', 'Regular', 'Deficiente'], $qScaleValid);
        $q4Valid = array_merge(['Muy utiles', 'Utiles', 'Poco utiles', 'Nada utiles'], $qScaleValid);
        $q5Valid = array_merge(['Si, definitivamente', 'Probablemente si', 'Probablemente no', 'No'], $qScaleValid);

        if (!in_array($q1, $q1Valid, true)) {
            $validator->required('q1', '', 'Seleccione una opción válida para la pregunta 1.');
        }
        if (!in_array($q2, $q2Valid, true)) {
            $validator->required('q2', '', 'Seleccione una opción válida para la pregunta 2.');
        }
        if (!in_array($q3, $q3Valid, true)) {
            $validator->required('q3', '', 'Seleccione una opción válida para la pregunta 3.');
        }
        if (!in_array($q4, $q4Valid, true)) {
            $validator->required('q4', '', 'Seleccione una opción válida para la pregunta 4.');
        }
        if (!in_array($q5, $q5Valid, true)) {
            $validator->required('q5', '', 'Seleccione una opción válida para la pregunta 5.');
        }
        if (mb_strlen($comentarios) > 1000) {
            $validator->required('comentarios', '', 'Los comentarios no deben exceder 1000 caracteres.');
        }

        if ($validator->hasErrors()) {
            Session::flash('errors', $validator->errors());
            Session::flash('old', $_POST);
            redirect('/participante/satisfaccion?folio=' . urlencode($folio));
        }

        EncuestaSatisfaccion::create([
            'respuesta_id' => (int)$respuesta['id'],
            'curso_id' => (int)$respuesta['curso_id'],
            'evaluacion_id' => (int)$respuesta['evaluacion_id'],
            'folio' => $folio,
            'q1_satisfaccion_general' => $q1,
            'q2_calidad_contenidos' => $q2,
            'q3_organizacion_actividades' => $q3,
            'q4_utilidad_funciones' => $q4,
            'q5_recomendacion' => $q5,
            'comentarios' => $comentarios
        ]);

        $this->triggerWebhookSiAprobado((int)$respuesta['id']);

        Session::flash('success', 'Encuesta de satisfacción enviada. Aquí puede consultar su calificación.');
        redirect('/participante/ver-calificacion?id=' . (int)$respuesta['id']);
    }

    private function triggerWebhookSiAprobado(int $respuestaId): void {
        try {
            $resultado = Respuesta::getDetailedScore($respuestaId);
            if (!$resultado || $resultado['puntuacion'] < 70) {
                return;
            }

            $url = Env::get('CONSTANCIAS_WEBHOOK_URL');
            $secret = Env::get('CONSTANCIAS_WEBHOOK_SECRET');

            if (!$url || !$secret) {
                return;
            }

            $ch = curl_init($url);
            $payload = json_encode([
                'participant_name' => $resultado['nombre_completo'],
                'participant_email' => $resultado['correo'],
                'course_name' => $resultado['curso_nombre'],
                'doc_type' => 'Constancia'
            ]);

            curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json',
                'Authorization: Bearer ' . $secret
            ]);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 5); // 5 sec timeout to avoid blocking user UI too much

            curl_exec($ch);
            curl_close($ch);
        } catch (\Throwable $e) {
            error_log('Webhook trigger error: ' . $e->getMessage());
        }
    }

    public function searchScores(): void {
        $this->render('public/buscar_calificaciones', [
            'cursos' => Curso::all(),
            'errors' => Session::flash('errors') ?? [],
            'old' => Session::flash('old') ?? [],
            'error' => Session::flash('error')
        ], 'public');
    }

    public function getScores(): void {
        if (!CSRF::validate($_POST['_csrf'] ?? null)) {
            Session::flash('error', 'Token inválido.');
            redirect('/participante/buscar-calificaciones');
        }

        $correo = mb_strtolower(trim($_POST['correo'] ?? ''));
        $telefono = preg_replace('/\D+/', '', (string)($_POST['telefono'] ?? ''));
        $status = trim($_POST['status'] ?? '');
        $cursoId = (int)($_POST['curso_id'] ?? 0);

        $validator = new Validator();

        if ($correo === '' && $telefono === '') {
            $validator->required('contacto', '', 'Ingrese al menos un correo o teléfono para buscar.');
        }

        if ($correo !== '') {
            $validator->email('correo', $correo, 'Correo inválido.');
        }

        if ($telefono !== '' && mb_strlen($telefono) < 10) {
            $validator->required('telefono', '', 'El teléfono debe contener al menos 10 dígitos.');
        }

        if ($status !== '' && !in_array($status, ['aprobado', 'reprobado', 'pendiente'], true)) {
            $validator->required('status', '', 'Seleccione un status válido.');
        }

        if ($validator->hasErrors()) {
            Session::flash('errors', $validator->errors());
            Session::flash('old', $_POST);
            redirect('/participante/buscar-calificaciones');
        }

        $resultados = Respuesta::searchByContact($correo, $telefono, $status, $cursoId);

        $this->render('public/resultados_calificaciones', [
            'resultados' => $resultados,
            'cursos' => Curso::all(),
            'filtros' => [
                'correo' => $correo,
                'telefono' => $telefono,
                'status' => $status,
                'curso_id' => $cursoId
            ]
        ], 'public');
    }

    public function showScore(): void {
        $respuestaId = (int)($_GET['id'] ?? 0);
        $respuesta = $respuestaId > 0 ? Respuesta::getDetailedScore($respuestaId) : null;

        if (!$respuesta) {
            Session::flash('error', 'Calificación no encontrada.');
            redirect('/participante/buscar-calificaciones');
        }

        $this->render('public/detalle_calificacion', [
            'respuesta' => $respuesta,
            'isAdminView' => false,
            'success' => Session::flash('success'),
            'error' => Session::flash('error')
        ], 'public');
    }
}
