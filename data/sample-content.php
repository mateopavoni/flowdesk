<?php
/**
 * Contenido de ejemplo para FlowDesk: 4 categorías, 8 posts, 5 testimonios,
 * 3 case studies. Corrido vía wp-cli: `wp eval-file data/sample-content.php`
 * (ver RUN.md). Es idempotente: si ya existe un post con ese título, lo saltea.
 *
 * ponytail: sin imágenes destacadas reales (requeriría bajar fotos de stock
 * con licencia y conexión a internet en el script). Los templates ya
 * muestran un placeholder con gradiente cuando no hay thumbnail — si Mateo
 * quiere fotos reales para las capturas del portfolio, se suben a mano desde
 * wp-admin en los posts que van a salir en el README/screenshots.
 */

if ( ! defined( 'WP_CLI' ) ) {
	echo "Corré esto con wp-cli: wp eval-file data/sample-content.php\n";
	exit;
}

// --- Categorías ------------------------------------------------------------
$categories = array( 'Productividad', 'Gestión de equipos', 'SaaS', 'Automatización' );
$cat_ids    = array();
foreach ( $categories as $cat_name ) {
	$term = term_exists( $cat_name, 'category' );
	$cat_ids[ $cat_name ] = $term ? $term['term_id'] : wp_insert_term( $cat_name, 'category' )['term_id'];
}

// --- Posts -------------------------------------------------------------
$posts = array(
	array(
		'title'    => 'Cómo mejorar la productividad de tu equipo en 5 pasos',
		'category' => 'Productividad',
		'excerpt'  => 'Cinco cambios concretos, sin comprar ninguna herramienta nueva, que reducen el tiempo perdido en coordinación.',
		'content'  => "La mayoría de los equipos no tiene un problema de esfuerzo, tiene un problema de coordinación. Estos cinco pasos no piden más horas de trabajo — piden menos fricción entre las horas que ya se están poniendo.\n\n**1. Un solo lugar para el estado del trabajo.** Si para saber en qué está una tarea hay que preguntar en el chat, revisar un mail y mirar una planilla, ya perdiste. Centralizar el estado (aunque sea en un tablero simple) elimina la mitad de los \"¿cómo va esto?\" del día.\n\n**2. Menos reuniones, más async.** Una reunión de estado de 30 minutos con 6 personas cuesta 3 horas-persona. La mayoría de esa información se puede escribir en 5 minutos y leer en 1.\n\n**3. Definir \"terminado\" antes de empezar.** Ambigüedad sobre qué significa completar una tarea genera retrabajo. Un criterio de aceptación de dos líneas ahorra una ronda entera de correcciones.\n\n**4. Automatizar lo repetitivo, no lo importante.** Mover una tarjeta de columna cuando cambia de estado, avisar a alguien cuando algo se vence — eso se automatiza. Las decisiones reales las sigue tomando una persona.\n\n**5. Medir carga, no solo progreso.** Un equipo puede estar \"al día\" con las tareas y aun así estar sobrecargado. Ver cuánto tiene cada persona evita el burnout silencioso.\n\nNinguno de estos pasos requiere un cambio de herramienta — pero tener todo en un solo lugar ayuda a que se sostengan en el tiempo en vez de degradarse a la semana siguiente.",
	),
	array(
		'title'    => 'Gestión de equipos remotos: la guía que nadie te dio',
		'category' => 'Gestión de equipos',
		'excerpt'  => 'Lo que cambia de verdad cuando el equipo no comparte oficina, y lo que no hace falta copiar de una startup de Silicon Valley.',
		'content'  => "Gestionar un equipo remoto no es gestionar el mismo equipo pero por Zoom. Cambian las reglas del juego, y pretender que no es así es la causa más común de fricción.\n\n**La comunicación por defecto tiene que ser escrita.** No porque el video esté mal, sino porque lo escrito queda, se puede buscar y no depende de que todos estén conectados al mismo tiempo. Un equipo distribuido en husos horarios distintos que depende de reuniones sincrónicas para decidir cosas simplemente decide más lento.\n\n**La confianza se construye con visibilidad, no con vigilancia.** Pedir capturas de pantalla o medir tiempo activo en la compu genera resentimiento y no mide nada real. Lo que sí funciona: que el trabajo entregado sea visible, y que el estado de las tareas no dependa de preguntar.\n\n**Documentar decisiones, no solo tareas.** Cuando alguien se suma al equipo tres meses después, necesita entender por qué se tomó una decisión, no solo qué se hizo. Un historial de decisiones (aunque sea informal) ahorra repetir discusiones.\n\n**No todas las reuniones son malas.** El objetivo no es cero reuniones, es que cada reunión tenga una razón que no se resuelve mejor por escrito: alinear visión, resolver un desacuerdo real, o simplemente que el equipo se conozca como personas.\n\nLo que no hace falta copiar: el ritual de la startup que tuvo éxito con 9 personas y ahora tiene un libro sobre cultura remota. Tu equipo tiene su propio contexto — las reglas de arriba son un punto de partida, no un manual.",
	),
	array(
		'title'    => 'SaaS: guía completa para arrancar una startup de software',
		'category' => 'SaaS',
		'excerpt'  => 'Qué hay que resolver antes de escribir la primera línea de código, y qué se puede posponer sin culpa.',
		'content'  => "Arrancar un SaaS se siente como un problema técnico, pero la mayoría de los SaaS que fracasan no fracasan por el código. Fracasan porque nadie necesitaba el producto, o porque el modelo de precio no sostenía el negocio.\n\n**Antes de escribir código: hablá con 10 personas del problema que querés resolver.** No les muestres el producto, preguntales cómo resuelven ese problema hoy. Si ya tienen una solución que funciona \"suficientemente bien\", vas a competir contra la inercia, no contra otro producto.\n\n**El precio no es lo último que se decide.** Define quién paga, cuánto y por qué, antes de construir. Un SaaS con buen producto y mal pricing igual puede no sobrevivir; un SaaS con producto mínimo y pricing claro puede validar rápido.\n\n**MVP no significa \"versión fea del producto final\".** Significa la versión más chica que resuelve el problema completo para un grupo chico de usuarios. Si tu MVP resuelve el 20% del problema para el 100% de los usuarios, nadie lo va a adoptar en serio.\n\n**Churn temprano no es igual a churn tardío.** Perder usuarios en la primera semana suele ser un problema de onboarding. Perder usuarios después de meses de uso suele ser un problema de valor real. Son problemas distintos con soluciones distintas.\n\n**Lo que se puede posponer:** escalabilidad para un millón de usuarios, multi-tenancy sofisticado, internacionalización. Todo eso importa cuando el problema es tener demasiados usuarios — un problema que, con suerte, vas a tener que resolver más adelante.",
	),
	array(
		'title'    => 'Automatización de workflows: por dónde empezar sin complicarte',
		'category' => 'Automatización',
		'excerpt'  => 'No hace falta un motor de reglas complejo para sacarte de encima el trabajo repetitivo. Con tres automatizaciones simples se nota.',
		'content'  => "\"Automatización\" suena a proyecto grande, pero las automatizaciones que más tiempo ahorran suelen ser reglas de una sola línea: \"cuando pasa X, hacé Y\".\n\n**Empezá por lo que hacés todas las semanas sin pensar.** Mover una tarea a \"en revisión\" cuando se marca como lista, avisar al equipo cuando algo vence en menos de 2 días, asignar automáticamente según la categoría de la tarea. Ninguna de estas decisiones requiere criterio humano — son reglas fijas.\n\n**No automatices lo que todavía no entendés bien.** Si un proceso cambia seguido o nadie lo puede explicar en dos frases, automatizarlo temprano solo congela el desorden. Primero se simplifica el proceso, después se automatiza.\n\n**Las automatizaciones necesitan dueño.** Una regla que nadie revisa hace 8 meses puede estar generando ruido (notificaciones a alguien que ya no está en el equipo, tareas asignadas a un proyecto archivado). Revisar automatizaciones activas una vez por trimestre evita que se acumule basura silenciosa.\n\n**El objetivo es sacar trabajo, no agregar reglas.** Es fácil terminar con 40 automatizaciones que nadie recuerda por qué existen. Si una regla no le ahorra tiempo real a una persona, no vale la complejidad de mantenerla.\n\nCon tres o cuatro automatizaciones bien elegidas — no cuarenta — la mayoría de los equipos ya recupera varias horas por semana que antes se iban en coordinación manual.",
	),
	array(
		'title'    => 'Cómo elegir las métricas correctas para tu equipo',
		'category' => 'Productividad',
		'excerpt'  => 'Medir "velocidad" sin medir calidad ni carga es la forma más rápida de optimizar las métricas equivocadas.',
		'content'  => "Cuando un equipo empieza a medirse, la tentación es agarrar lo más fácil de contar: tareas cerradas por semana, líneas de código, tickets resueltos. El problema es que lo fácil de contar rara vez es lo que importa.\n\n**Cantidad sin calidad es una métrica peligrosa.** Un equipo puede cerrar más tareas por semana simplemente partiendo cada tarea en pedazos más chicos, sin entregar más valor real. Si la métrica no distingue eso, va a incentivar exactamente ese comportamiento.\n\n**Medí flujo, no solo output.** Cuánto tiempo pasa una tarea esperando (sin que nadie la toque) suele decir más sobre dónde está el cuello de botella que cuántas tareas se cerraron. Un equipo con poco \"tiempo de espera\" entrega más predeciblemente, aunque el volumen total sea similar.\n\n**La carga por persona importa tanto como el progreso del equipo.** Un sprint \"exitoso\" en el que dos personas absorbieron el 70% del trabajo no es sostenible, aunque los números generales se vean bien.\n\n**Las métricas son para conversar, no para castigar.** En el momento en que una métrica se usa para evaluar personas individualmente, la gente empieza a optimizar la métrica en vez del trabajo. Usalas para detectar patrones de equipo, no para armar un ranking.\n\nElegir bien qué medir es más importante que medir mucho. Tres métricas que el equipo entiende y revisa de verdad valen más que un dashboard con veinte números que nadie mira.",
	),
	array(
		'title'    => 'Reuniones: cómo tener menos y mejores',
		'category' => 'Gestión de equipos',
		'excerpt'  => 'La reunión recurrente que nadie se anima a cancelar suele ser el mayor costo de coordinación de un equipo.',
		'content'  => "El costo de una reunión no es la hora que dura — es la hora multiplicada por cada persona en la sala, más el tiempo de contexto que se pierde al volver a lo que se estaba haciendo antes.\n\n**Toda reunión recurrente necesita revisarse cada tanto.** Lo que tenía sentido cuando el equipo tenía 4 personas puede no tenerlo con 12. Preguntá: si canceláramos esta reunión durante un mes, ¿qué se rompería? Si la respuesta no es clara, probablemente se pueda reemplazar por un mensaje escrito.\n\n**Agenda escrita o no hay reunión.** Sin agenda, una reunión de estado se convierte en una ronda donde cada persona cuenta lo que hizo — información que se podía leer en un tablero. La agenda obliga a que la reunión sea para decidir o discutir algo puntual, no para reportar.\n\n**Menos gente, decisiones más rápidas.** Invitar \"por las dudas\" a alguien que no necesita estar ahí no es cortesía, es costo. Esa persona puede leer las notas después.\n\n**Reuniones cortas por default.** Una reunión programada para 30 minutos tiende a llenar los 30 minutos, la tenga o no. Programarlas más cortas (15-20 min) obliga a ir al punto.\n\nMenos reuniones no significa menos comunicación — significa mover a texto lo que no necesita estar sincronizado, y reservar el tiempo en vivo para lo que de verdad lo necesita.",
	),
	array(
		'title'    => 'De planilla a herramienta: cuándo migrar la gestión de tu equipo',
		'category' => 'SaaS',
		'excerpt'  => 'La planilla de Excel funcionó durante meses. Estas son las señales de que dejó de alcanzar.',
		'content'  => "Casi todos los equipos empiezan gestionando el trabajo en una planilla. Es gratis, todos saben usarla, y al principio alcanza de sobra. El problema no es empezar así — es no notar cuándo dejó de funcionar.\n\n**Señal 1: nadie confía en que la planilla esté actualizada.** Cuando la respuesta a \"¿está actualizado esto?\" es \"probablemente no\", la planilla dejó de cumplir su función principal: ser la fuente de verdad.\n\n**Señal 2: hay una planilla por persona o por equipo.** Si para saber el estado general hay que consolidar tres archivos distintos a mano, el costo de coordinación ya superó el costo de migrar a una herramienta.\n\n**Señal 3: las fórmulas se rompen y nadie se anima a tocarlas.** Una planilla que creció orgánicamente durante un año suele tener lógica frágil que solo una persona entiende. Eso es deuda técnica, aunque no sea código.\n\n**Señal 4: falta historial.** Una planilla sobreescribe el estado anterior. Si necesitás saber cómo estaba una tarea hace dos semanas, no hay forma de reconstruirlo.\n\n**Cuándo NO migrar todavía:** si el equipo es de 2-3 personas y la planilla se actualiza de verdad, migrar puede ser resolver un problema que todavía no tenés. La herramienta correcta es la que resuelve un dolor real, no la que se ve mejor en una demo.\n\nMigrar no es solo cambiar de software — es la oportunidad de simplificar el proceso que la planilla dejó crecer sin control.",
	),
	array(
		'title'    => 'Async por default: cómo comunicarse sin perder contexto',
		'category' => 'Automatización',
		'excerpt'  => 'Trabajar async no es "contestar cuando puedas". Es diseñar la comunicación para que no dependa de una respuesta inmediata.',
		'content'  => "Async mal entendido es simplemente lento: mandás un mensaje, esperás horas, volvés a preguntar. Async bien hecho reduce la dependencia de estar todos conectados al mismo tiempo, sin perder velocidad real.\n\n**Escribí mensajes que se puedan responder sin ida y vuelta.** \"¿Tenés un minuto?\" obliga a una respuesta antes de poder ayudar. \"Necesito que revises el punto 3 del brief, tengo dudas sobre el alcance\" ya trae el contexto necesario para responder de una.\n\n**El contexto va en el mensaje, no en la cabeza de quien pregunta.** Si la respuesta depende de que la otra persona recuerde una conversación de hace dos semanas, el mensaje está incompleto. Un link a la tarea o decisión relevante ahorra una ronda entera.\n\n**Definí qué SÍ es urgente.** Async no significa que nada se resuelve rápido. Significa que lo urgente se marca como tal explícitamente (y en un canal separado), en vez de que todo tenga la misma prioridad falsa de \"necesito esto ya\".\n\n**Las decisiones importantes se documentan, no se asumen.** Una decisión tomada en un hilo de chat que se pierde en el scroll no es una decisión documentada. Si va a importar en un mes, necesita vivir en un lugar buscable.\n\nEl beneficio real de async no es \"trabajar cuando quieras\" — es que el equipo deja de depender de que todos estén disponibles al mismo tiempo para avanzar.",
	),
);

foreach ( $posts as $post_data ) {
	if ( get_page_by_title( $post_data['title'], OBJECT, 'post' ) ) {
		continue;
	}
	// WordPress no procesa Markdown: los **bold** del texto se guardan
	// como <strong> reales (si no, quedan asteriscos literales en pantalla).
	$content = preg_replace( '/\*\*(.+?)\*\*/', '<strong>$1</strong>', $post_data['content'] );

	$post_id = wp_insert_post( array(
		'post_title'   => $post_data['title'],
		'post_excerpt' => $post_data['excerpt'],
		'post_content' => $content,
		'post_status'  => 'publish',
		'post_type'    => 'post',
		'post_author'  => 1,
	) );
	if ( ! is_wp_error( $post_id ) ) {
		wp_set_post_categories( $post_id, array( $cat_ids[ $post_data['category'] ] ) );
	}
}

// --- Testimonios ---------------------------------------------------------
$testimonials = array(
	array( 'name' => 'Lucía Fernández', 'role' => 'Product Manager', 'company' => 'Nimbus Labs', 'quote' => 'Dejamos de perseguir el estado de las tareas por Slack. En dos semanas el equipo ya no preguntaba "¿cómo va esto?" — lo veía.' ),
	array( 'name' => 'Martín Ibáñez', 'role' => 'Head of Engineering', 'company' => 'Cactus Software', 'quote' => 'Las automatizaciones simples (asignar, avisar vencimientos) nos sacaron una tarea manual diaria de encima. Poca cosa que suma mucho.' ),
	array( 'name' => 'Rocío Paz', 'role' => 'COO', 'company' => 'Vela Studio', 'quote' => 'Somos un equipo remoto en tres husos horarios. FlowDesk fue lo que nos permitió dejar de depender de reuniones sincrónicas para decidir cosas simples.' ),
	array( 'name' => 'Diego Torres', 'role' => 'Founder', 'company' => 'Hilo', 'quote' => 'Migramos de una planilla que ya nadie confiaba que estuviera actualizada. El primer mes ya se notó en cuántas menos veces preguntábamos por estado.' ),
	array( 'name' => 'Valentina Gómez', 'role' => 'Team Lead', 'company' => 'Puente Digital', 'quote' => 'Los reportes en vivo nos ahorran armar una planilla de seguimiento a mano cada viernes. Nada revolucionario, pero es tiempo que ahora se va a otra cosa.' ),
);

foreach ( $testimonials as $t ) {
	if ( get_page_by_title( $t['name'], OBJECT, 'testimonial' ) ) {
		continue;
	}
	$post_id = wp_insert_post( array(
		'post_title'   => $t['name'],
		'post_content' => $t['quote'],
		'post_status'  => 'publish',
		'post_type'    => 'testimonial',
	) );
	if ( ! is_wp_error( $post_id ) ) {
		update_post_meta( $post_id, Flowdesk_CPT_Testimonials::META_ROLE, $t['role'] );
		update_post_meta( $post_id, Flowdesk_CPT_Testimonials::META_COMPANY, $t['company'] );
	}
}

// --- Case studies ----------------------------------------------------------
$case_studies = array(
	array(
		'title'    => 'Cómo Nimbus Labs redujo sus reuniones de estado a la mitad',
		'client'   => 'Nimbus Labs',
		'industry' => 'Software B2B',
		'result'   => '-50% reuniones de estado',
		'summary'  => "Nimbus Labs tenía una reunión diaria de 30 minutos con todo el equipo de producto solo para reportar estado. Con tableros compartidos y notificaciones automáticas de cambios de estado, pasaron a una reunión semanal de 15 minutos enfocada solo en decisiones, no en reportes.",
	),
	array(
		'title'    => 'Cactus Software y la automatización de su flujo de QA',
		'client'   => 'Cactus Software',
		'industry' => 'Consultora de desarrollo',
		'result'   => '+35% entregas a tiempo',
		'summary'  => "El equipo de Cactus perdía tiempo asignando manualmente tareas de QA cada vez que una tarea de desarrollo pasaba a 'lista para revisión'. Automatizar esa asignación y el aviso al equipo de QA redujo el tiempo entre 'listo para revisar' y 'revisado' de 2 días a medio día en promedio.",
	),
	array(
		'title'    => 'Vela Studio: gestionar un equipo en tres husos horarios',
		'client'   => 'Vela Studio',
		'industry' => 'Agencia de diseño',
		'result'   => '3 husos horarios, 0 reuniones diarias',
		'summary'  => "Con diseñadores en Argentina, España y México, las reuniones sincrónicas diarias eran insostenibles. Migrando la coordinación a tableros + comentarios async, Vela Studio eliminó por completo las reuniones diarias sin perder visibilidad del estado de cada proyecto.",
	),
);

foreach ( $case_studies as $cs ) {
	if ( get_page_by_title( $cs['title'], OBJECT, 'case_study' ) ) {
		continue;
	}
	$post_id = wp_insert_post( array(
		'post_title'   => $cs['title'],
		'post_content' => $cs['summary'],
		'post_status'  => 'publish',
		'post_type'    => 'case_study',
	) );
	if ( ! is_wp_error( $post_id ) ) {
		update_post_meta( $post_id, Flowdesk_CPT_Case_Studies::META_CLIENT, $cs['client'] );
		update_post_meta( $post_id, Flowdesk_CPT_Case_Studies::META_INDUSTRY, $cs['industry'] );
		update_post_meta( $post_id, Flowdesk_CPT_Case_Studies::META_RESULT, $cs['result'] );
	}
}

WP_CLI::success( 'Contenido de ejemplo cargado: ' . count( $posts ) . ' posts, ' . count( $testimonials ) . ' testimonios, ' . count( $case_studies ) . ' case studies.' );
