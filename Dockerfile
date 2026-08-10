# Imagen de producción para Dokku (builder-dockerfile, deploy vía `dokku git:from-image`).
# Dev sigue usando docker-compose.yml (wordpress:php8.3-apache + volúmenes) — ver RUN.md.
#
# Notas:
# - El entrypoint oficial copia /usr/src/wordpress -> /var/www/html en cada arranque si el
#   volumen está vacío (no persistimos /var/www/html: el estado real vive en MySQL). Por eso
#   tema, plugin y .htaccess van DENTRO de /usr/src/wordpress, no como volumen.
# - .htaccess estático (no generado por `wp rewrite structure` en runtime): así los permalinks
#   bonitos sobreviven un redeploy sin depender de que /var/www/html persista.
# - wp-cli embebido para poder correr `dokku run flowdesk wp ...` (mismo image, mismos env vars
#   de Dokku) sin necesitar un segundo servicio tipo el `wpcli` de dev.
# - `dist/main.css` está gitignoreado (build artifact) y el deploy es `git push` a Dokku, que
#   construye solo con lo que está commiteado — sin este stage, la imagen de prod quedaba sin CSS
#   compilado (detectado en un redeploy real: home servido en HTML sin estilos).
FROM node:20-alpine AS assets
WORKDIR /src
COPY wp-content wp-content
WORKDIR /src/wp-content/themes/flowdesk-theme/assets
RUN npm ci && npm run build

FROM wordpress:php8.3-apache

RUN curl -o /usr/local/bin/wp -L https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar \
    && chmod +x /usr/local/bin/wp

COPY wp-content/themes/flowdesk-theme /usr/src/wordpress/wp-content/themes/flowdesk-theme
COPY --from=assets /src/wp-content/themes/flowdesk-theme/assets/dist /usr/src/wordpress/wp-content/themes/flowdesk-theme/assets/dist
COPY wp-content/plugins/flowdesk-toolkit /usr/src/wordpress/wp-content/plugins/flowdesk-toolkit
COPY docker/production.htaccess /usr/src/wordpress/.htaccess
