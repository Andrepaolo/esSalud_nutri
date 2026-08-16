# Despliegue en Railway

Este proyecto esta preparado para desplegarse en Railway usando el `Dockerfile`.

## 1. Subir el proyecto a GitHub

```bash
git add Dockerfile 000-default.conf Procfile .dockerignore .env.example .env.railway.example RAILWAY.md
git commit -m "Preparar despliegue en Railway"
git push origin main
```

Si tu rama principal no se llama `main`, usa el nombre de tu rama.

## 2. Crear el proyecto en Railway

1. En Railway, crea un proyecto nuevo.
2. Selecciona `Deploy from GitHub repo`.
3. Elige este repositorio.
4. Railway debe detectar el `Dockerfile` y construir la app con Docker.

## 3. Crear la base de datos

1. Dentro del mismo proyecto de Railway, agrega un servicio MySQL.
2. En el servicio de Laravel, abre `Variables`.
3. Copia las variables de `.env.railway.example`.
4. Genera una nueva llave para `APP_KEY`:

```bash
php artisan key:generate --show
```

5. Pega la llave generada como valor de `APP_KEY`.

## 4. Variables importantes

Usa estas referencias para conectar Laravel con MySQL en Railway:

```env
DB_HOST=${{MySQL.MYSQLHOST}}
DB_PORT=${{MySQL.MYSQLPORT}}
DB_DATABASE=${{MySQL.MYSQLDATABASE}}
DB_USERNAME=${{MySQL.MYSQLUSER}}
DB_PASSWORD=${{MySQL.MYSQLPASSWORD}}
```

Cuando Railway te genere el dominio publico, coloca ese dominio en:

```env
APP_URL=https://tu-dominio.railway.app
```

## 5. Migraciones

Despues del primer despliegue correcto, abre la terminal/consola del servicio Laravel en Railway y ejecuta:

```bash
php artisan migrate --force
```

## 6. Notas

- No subas el archivo `.env`.
- `docker-compose.yml` queda solo para desarrollo local.
- `vendor`, `node_modules` y `public/build` se generan durante el build Docker.
- Si usas archivos subidos por usuarios, considera configurar almacenamiento externo porque el filesystem de Railway no debe tratarse como almacenamiento permanente.
