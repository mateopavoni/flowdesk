# Cómo levantar FlowDesk

## Requisitos
- Docker + Docker Compose

## Variables de entorno
- Copiá `.env.example` a `.env` (los defaults ya sirven para desarrollo local, no hace falta tocar nada
  para levantarlo).

## Levantar
```bash
docker compose up -d
docker compose exec wpcli wp core install \
  --url="http://localhost:8080" \
  --title="FlowDesk" \
  --admin_user="admin" \
  --admin_password="changeme_admin" \
  --admin_email="admin@example.com" \
  --locale=es_AR \
  --skip-email

docker compose exec wpcli wp language core install es_AR
docker compose exec wpcli wp site switch-language es_AR
docker compose exec wpcli wp theme activate flowdesk-theme
docker compose exec wpcli wp plugin activate flowdesk-toolkit
docker compose exec wpcli wp rewrite structure '/%postname%/' --hard
docker compose exec wpcli wp eval-file /var/www/html/fd-data/sample-content.php
```
- Sitio: http://localhost:8080
- Admin: http://localhost:8080/wp-admin (`admin` / `changeme_admin` — credencial de desarrollo local,
  cambiarla antes de subir a un hosting real)
- Mails de dev (contacto/newsletter): http://localhost:8025 (Mailpit — ver `.claude/CLAUDE.md`, no existe en producción)

## Build del tema (Tailwind)
```bash
cd wp-content/themes/flowdesk-theme/assets && npm install && npm run build
```

## Tests
```bash
# lint de sintaxis PHP
find wp-content -name "*.php" -exec php -l {} \;

# E2E (con el sitio ya levantado en :8080, contenido de ejemplo ya importado)
cd tests/e2e && npm install && npx playwright install chromium && npm test
```
