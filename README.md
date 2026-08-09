# FlowDesk

Sitio de marketing (landing + blog) para **FlowDesk**, un SaaS de productividad ficticio. WordPress
con tema y plugin 100% custom — sin builder tipo Elementor, sin ACF — para demostrar desarrollo WP
"real": CPTs, REST endpoint propio, shortcode, widget, hardening de seguridad y SEO on-page a mano.

![stack](https://img.shields.io/badge/stack-WordPress%20%C2%B7%20PHP%208.3%20%C2%B7%20MySQL%208%20%C2%B7%20Tailwind-2b2b2b)
![tests](https://img.shields.io/badge/e2e-10%2F10%20verde-brightgreen)
![license](https://img.shields.io/badge/license-proprietary-red)

## Qué tiene

- **Landing**: hero, features, video demo (facade — el iframe de YouTube carga recién al hacer click),
  pricing de 3 planes vía shortcode `[flowdesk_pricing]`, testimonios (CPT + widget con carrusel CSS
  scroll-snap), FAQ, newsletter.
- **Blog**: índice con grid + búsqueda/filtro por categoría, archivo por categoría, post individual con
  sidebar de relacionados y comentarios nativos de WP.
- **Plugin `flowdesk-toolkit`**: CPTs de case studies y testimonios (meta nativos, sin ACF), REST
  endpoint propio de newsletter, formulario de contacto vía `admin-post.php`, hardening de seguridad
  (XML-RPC off, versión de WP oculta, rate-limit de login).
- **SEO propio**: meta description, Open Graph, Twitter Card y JSON-LD en `inc/seo.php`, sin depender
  de Yoast. Sitemap nativo de WP core (`wp-sitemap.xml`).

Ver [`ARCHITECTURE.md`](./ARCHITECTURE.md) para el detalle técnico y las decisiones de diseño.

## Correr en local

```bash
cp .env.example .env
docker compose up -d
```

El script de `wpcli` en `docker-compose.yml` instala WordPress (locale `es_AR`), activa tema y plugin,
importa contenido de ejemplo (8 posts, 5 testimonios, 3 case studies) y limpia el contenido default
("Hello world!"). Paso a paso completo, incluida la razón de cada flag, en [`RUN.md`](./RUN.md).

- Sitio: http://localhost:8080
- Admin: http://localhost:8080/wp-admin (`admin` / `changeme_admin`)
- Mailpit (newsletter/contacto en dev, no hay SMTP real): http://localhost:8025

## Tests

```bash
cd tests/e2e && npx playwright test
```

Suite Playwright real (no scripts sueltos): 10 tests — home, nav mobile, video facade, carrusel de
testimonios, blog (grid + filtro + post + comentarios), REST de newsletter (201/409/400 + honeypot) y
accesibilidad con axe-core. 10/10 en verde contra el sitio de Docker. Solo Chromium instalado en este
entorno (WebKit/Firefox necesitan permisos de sistema que no están disponibles acá); queda documentado
en `playwright.config.js` para correrlos en otra máquina si hace falta.

## Deploy a hosting real

Ver [`setup-instructions.md`](./setup-instructions.md).

## Changelog

| Versión | Fecha | Cambio |
|---------|-------|--------|
| v1.0.0  | 2026-08-09 | Portfolio pack: README, ARCHITECTURE, PORTFOLIO, setup-instructions, commit-plan. |
| v0.1.0  | 2026-08-09 | Scaffold inicial: tema + plugin completos, contenido de ejemplo, suite E2E, hardening y SEO verificados de punta a punta con Docker real. |

## Licencia

Proyecto de portfolio — código propietario, ver [`LICENSE`](./LICENSE).
