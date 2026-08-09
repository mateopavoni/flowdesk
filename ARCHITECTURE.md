# ARCHITECTURE.md — FlowDesk

## Por qué WordPress custom, no un builder

El brief pedía un sitio de marketing + blog defendible como trabajo de desarrollo, no de configuración.
Elementor/ACF resuelven esto más rápido pero producen un sitio que "se armó", no que "se construyó": no
hay CPTs propios que mostrar, no hay REST endpoint que explicar, no hay decisiones de seguridad que
defender en una entrevista. Tema y plugin custom, sin dependencias de builder, es la versión que se
puede abrir en el editor y explicar línea por línea.

## Capas

```
wp-content/
├── themes/flowdesk-theme/       ← presentación: templates, Tailwind, JS
│   ├── functions.php            ← theme setup, enqueue de assets
│   ├── inc/seo.php              ← meta/OG/JSON-LD propio
│   ├── front-page.php + template-parts/*   ← landing (hero, features, video, FAQ, newsletter)
│   ├── home.php / archive.php / single.php ← blog
│   └── assets/{src,dist}        ← Tailwind (src/input.css → dist/main.css) + js/main.js
└── plugins/flowdesk-toolkit/    ← lógica: CPTs, REST, forms, seguridad
    ├── flowdesk-toolkit.php     ← bootstrap, activation hook, rate-limit compartido
    └── includes/
        ├── class-cpt-case-studies.php
        ├── class-cpt-testimonials.php
        ├── class-widget-testimonials.php
        ├── class-shortcode-pricing.php
        ├── class-rest-newsletter.php
        ├── class-contact-form.php
        └── class-security-hardening.php
```

Separación deliberada: el tema no sabe de lógica de negocio (CPTs, REST, seguridad), el plugin no sabe
de presentación (HTML/Tailwind). Si mañana cambia el tema, el plugin sigue funcionando igual — y
viceversa, es el mismo motivo por el que WordPress separa tema y plugin en primer lugar.

## Decisiones de diseño

### Sin ACF
Case studies y testimonios usan `register_post_meta()` + meta boxes nativas de wp-admin
(`class-cpt-case-studies.php`, `class-cpt-testimonials.php`). Mismo resultado que ACF (campos
estructurados, editables desde el admin) sin depender de un plugin externo que en un proyecto real
sería una licencia o un punto de falla más. Trade-off: la UI de la meta box nativa es menos pulida que
ACF Pro — aceptable para 2 CPTs con 4-5 campos cada uno.

### Sin ACF pero con un filtro de extensión en pricing
`[flowdesk_pricing]` guarda los 3 planes como array en código, no en una pantalla de opciones — no se
justifica una UI de admin para algo que casi no cambia. Si hiciera falta editarlos sin tocar código, el
filtro `flowdesk_pricing_plans` ya permite sobreescribirlos desde `functions.php` o un mu-plugin, sin
tocar el plugin. Es el punto medio entre "hardcodeado sin salida" y "pantalla de opciones que nadie usa".

### REST endpoint propio para newsletter, no un plugin de email marketing
`POST /wp-json/flowdesk/v1/newsletter` (`class-rest-newsletter.php`) valida nonce propio (el endpoint es
público, no usa la autenticación REST estándar), honeypot, rate-limit por IP (5 cada 10 min, comparte la
función `flowdesk_rate_limit_check()` del bootstrap del plugin), valida el email, evita duplicados y
persiste el suscriptor como CPT interno `fd_subscriber` — no una tabla SQL propia, reusa la
infraestructura de posts de WP en vez de reinventarla. Sin UI pública (`publicly_queryable => false`,
`create_posts => do_not_allow`): solo se llega ahí vía REST.

### Contact form vía `admin-post.php`, no AJAX
`class-contact-form.php` usa el flujo estándar de WP (`admin_post_flowdesk_contact` /
`admin_post_nopriv_flowdesk_contact`) con nonce + honeypot + sanitización. Funciona sin JS, se degrada
bien, y es el patrón que cualquier desarrollador WP reconoce de inmediato — no hay razón para armar un
endpoint AJAX custom para un form que solo necesita: validar, mandar mail, redirigir con mensaje.

### SEO propio, no Yoast
`inc/seo.php` genera meta description, Open Graph, Twitter Card y JSON-LD (`Organization`/`Article`
según el contexto) a mano. Cubre lo que un sitio de marketing chico necesita; Yoast/RankMath quedan
como recomendación opcional en `setup-instructions.md` para cuando el sitio crezca (redirects, XML
sitemap avanzado, análisis de legibilidad) — no como dependencia dura del MVP. El sitemap en sí usa
`wp-sitemap.xml` nativo de WP core (desde 5.5), no un generador propio: no hay nada que ganar
reimplementando algo que el core ya resuelve bien.

## Seguridad

- **XML-RPC**: el filtro estándar `xmlrpc_enabled => __return_false` no alcanza — solo bloquea el login
  vía XML-RPC, pero `system.listMethods`/`pingback.*` siguen respondiendo (verificado a mano). El
  hardening real corta el endpoint entero en `init`, con `exit` directo antes de que WP instancie el
  server de IXR — `wp_die()` ahí delega a un handler que espera ese server ya armado y devuelve 200
  vacío en vez de 403.
- **Rate-limit de login**: `authenticate` + transient por IP (`flowdesk_login_attempts_<md5(ip)>`), 5
  intentos por 15 minutos, mismo patrón de `flowdesk_rate_limit_check()` que usa el endpoint de
  newsletter — un solo helper compartido en el bootstrap del plugin, no dos implementaciones de rate
  limit distintas.
- **Versión de WP oculta**: `the_generator` vacío + se remueven `wp_generator`, `rsd_link`,
  `wlwmanifest_link` de `<head>`.
- **`DISALLOW_FILE_EDIT`**: se define si `wp-config.php` no lo hizo, para que el editor de archivos de
  wp-admin quede off incluso en un setup que no tocó el config.
- Todo lo anterior es lo esencial implementado sin dependencias. Wordfence y similares quedan como
  *opcionales recomendados* en `setup-instructions.md` para hardening de producción a mayor escala
  (firewall de aplicación, escaneo de malware) — fuera de alcance de lo que un plugin propio de 80
  líneas puede/debe cubrir.

## Accesibilidad

Detectado con axe-core en la suite Playwright, no a ojo:
- El `h3` de los posts en el grid del blog saltaba un nivel después del `h1` de la página → `h2`.
- El título del form de comentarios (default de WP: `h3`) saltaba nivel cuando el post no tenía
  comentarios todavía → forzado a `h2`.
- El track scrolleable del carrusel de testimonios no era alcanzable por teclado → `tabindex="0"` +
  `role="region"` + `aria-label`.

## Tests

Suite Playwright committeada en `tests/e2e/flowdesk.spec.js` (10 tests), corrida contra el sitio real de
Docker — no unit tests sobre funciones aisladas de WP, que aportan poco comparado con validar el
comportamiento real del sitio (render, formularios, REST, accesibilidad) de punta a punta. Cobertura:
landing (pricing/testimonios/meta SEO), nav mobile, video facade, carrusel de testimonios, blog (grid +
filtro + post + comentarios), REST de newsletter (201/409/400 + honeypot) y axe-core en home y blog.
10/10 en verde. Solo Chromium en este entorno — WebKit/Firefox necesitan paquetes de sistema sin permisos
acá; el resto de los browsers queda documentado en `playwright.config.js` para correr en otra máquina.

## Qué no se hizo (y por qué)

- **Dark mode**: opcional en el brief, se dejó afuera — un tema custom desde cero ya cubre el objetivo
  de mostrar trabajo real sin duplicar cada componente en dos paletas.
- **Bootstrap + Tailwind**: el brief original pedía los dos frameworks. Se resolvió con uno solo
  (Tailwind) — dos librerías de CSS resolviendo el mismo problema no se defiende en una entrevista, y la
  decisión de simplificar está documentada en `.claude/CLAUDE.md`.
- **WordPress core vendoreado en el repo**: solo `wp-content/themes` y `wp-content/plugins` propios
  están en el repo. El core se instala desde Docker en dev y desde el hosting en producción — vendorear
  el core de WP en un repo de portfolio no aporta nada y ensucia el diff.
