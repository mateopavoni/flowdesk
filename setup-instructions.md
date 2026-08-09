# setup-instructions.md — Deploy a hosting WordPress real

Para dev local con Docker, ver [`RUN.md`](./RUN.md). Esto es para un hosting WP real (cPanel, VPS con
LEMP/LAMP, etc.).

## 1. Requisitos

- PHP 8.3, MySQL 8 (o MariaDB 10.6+).
- Acceso SSH o FTP para subir `wp-content/themes/flowdesk-theme` y `wp-content/plugins/flowdesk-toolkit`.
- WordPress core ya instalado por el hosting (no está vendoreado en este repo, ver `ARCHITECTURE.md`).

## 2. Instalación

1. Instalar WordPress con **locale `es_AR`** desde el instalador del hosting o `wp core install
   --locale=es_AR`. Si el hosting no lo soporta en el install, correr después:
   ```bash
   wp language core install es_AR
   wp site switch-language es_AR
   ```
   `--locale` solo en el install no alcanza (verificado a mano, `get_locale()` no quedaba en `es_AR` sin
   el paso extra) — sin esto se cuelan strings en inglés (fechas, "Uncategorized") pese a que todo el
   contenido del tema está en español.
2. Subir el contenido de `wp-content/themes/flowdesk-theme` y `wp-content/plugins/flowdesk-toolkit`.
3. Activar el tema y el plugin desde wp-admin (o `wp theme activate flowdesk-theme` / `wp plugin activate
   flowdesk-toolkit`).
4. El activation hook del plugin crea las páginas "Inicio" y "Blog" y configura Ajustes > Lectura
   (`show_on_front = page`, `page_on_front` = Inicio, `page_for_posts` = Blog) automáticamente. Verificar
   en Ajustes > Lectura que haya quedado así — si el hosting corre el activation hook en un contexto raro,
   puede hacer falta setearlo a mano.
5. Borrar el contenido default de WP ("Hello world!", "Sample Page", comentario de ejemplo) si el
   instalador del hosting los creó — no forman parte del contenido de FlowDesk.
6. Importar contenido de ejemplo (opcional, para una demo con datos):
   ```bash
   wp eval-file data/sample-content.php
   ```

## 3. Build de Tailwind

El CSS ya viene compilado en `wp-content/themes/flowdesk-theme/assets/dist/main.css` — no hace falta
Node en el servidor de producción. Para modificar estilos:
```bash
cd wp-content/themes/flowdesk-theme/assets
npm install
npm run build
```
Subir el `dist/main.css` resultante.

## 4. Mail (newsletter + contacto)

`wp_mail()` necesita un transporte real en producción — a diferencia de Docker/dev, donde
`dev/mu-plugins/dev-mail.php` enruta a Mailpit (ese mu-plugin **no se usa en producción**, es solo para
que el `mail()` de sistema no falle en el contenedor). En un hosting real:
- Si el hosting resuelve `mail()`/SMTP por su cuenta, no hace falta nada más.
- Si no, instalar un plugin SMTP (WP Mail SMTP, FluentSMTP) y configurar el proveedor (SendGrid, SES,
  etc.). No forma parte del plugin propio a propósito — es configuración de infraestructura, no lógica
  de negocio del sitio.

## 5. Variables/config específicas de producción

- `NEWSLETTER_NOTIFY_EMAIL` (o el equivalente vía `update_option('flowdesk_newsletter_notify_email',
  ...)`): a qué mail llegan los avisos de nuevo suscriptor. Si no se setea, cae a `admin_email`.
- Confirmar HTTPS y que `WP_URL`/`siteurl`/`home` en la base apuntan al dominio real, no a
  `localhost:8080`.

## 6. Plugins opcionales recomendados (no incluidos)

El plugin propio (`flowdesk-toolkit`) cubre SEO básico (meta/OG/JSON-LD) y hardening esencial (XML-RPC
off, versión oculta, rate-limit de login) sin depender de plugins de terceros — ver `ARCHITECTURE.md`.
Para producción a mayor escala, opcionalmente:
- **Yoast SEO / RankMath**: redirects, sitemap XML avanzado, análisis de legibilidad — más allá de lo
  que necesita un sitio de marketing chico.
- **Wordfence**: firewall de aplicación, escaneo de malware — cubre superficie que un plugin propio de
  hardening básico no debería intentar reemplazar.
- **WP Super Cache / W3 Total Cache**: cache de página si el tráfico lo justifica.

## 7. Verificación post-deploy

1. Home carga con hero/features/pricing/testimonios/FAQ/newsletter.
2. Blog (`/blog`) muestra el grid, búsqueda y filtro por categoría funcionan.
3. Un post individual muestra sidebar de relacionados y el form de comentarios.
4. `POST /wp-json/flowdesk/v1/newsletter` con un email nuevo devuelve 201 y llega el mail de aviso.
5. `curl -I https://tudominio/xmlrpc.php` devuelve 403.
6. `https://tudominio/wp-sitemap.xml` responde.
7. wp-admin: 5 intentos de login fallido seguidos bloquean el 6to (rate-limit).
