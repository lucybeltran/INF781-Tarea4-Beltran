# Título y descripción del proyecto

Este proyecto implementa un mecanismo de protección anti-bot en una aplicación desarrollada en Laravel 13, utilizando hCaptcha como sistema CAPTCHA alternativo a reCAPTCHA.

Se eligió hCaptcha porque ofrece un equilibrio entre seguridad, privacidad y facilidad de integración. Además, permite verificación obligatoria del lado del servidor, lo cual es un requisito fundamental en aplicaciones seguras.

---

# Requisitos previos

- PHP 8.3 o superior
- Composer
- Node.js y npm
- PostgreSQL
- Cuenta en hCaptcha (https://dashboard.hcaptcha.com/)

---

# Pasos para obtener las claves del proveedor

1. Crear una cuenta en hCaptcha: https://dashboard.hcaptcha.com/
2. Registrar un nuevo sitio en el panel
3. Obtener las claves:
   - Site Key (clave pública para frontend)
   - Secret Key (clave privada para backend)
4. Configurar estas claves en el archivo .env del proyecto

---

# Instrucciones de instalación

Clonar el repositorio:

```bash
git clone <URL_DEL_REPOSITORIO>
cd INF781-Tarea4-Apellido

Instalar dependencias:

composer install
npm install

Configurar entorno:

cp .env.example .env
php artisan key:generate

Configurar base de datos PostgreSQL en .env:

DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=inf781_tarea4
DB_USERNAME=postgres
DB_PASSWORD=tu_password

HCAPTCHA_SITE_KEY=tu_site_key
HCAPTCHA_SECRET_KEY=tu_secret_key

Ejecutar migraciones:

php artisan migrate
Ejecución de la aplicación

Para ejecutar la aplicación localmente:

php artisan serve
npm run dev

La aplicación estará disponible en:

http://127.0.0.1:8000/login

El formulario protegido se encuentra en la pantalla de login, donde se valida el CAPTCHA antes de permitir el acceso.

Ejecución de pruebas

Para ejecutar las pruebas automatizadas:

php artisan test

Resultados esperados:

Test de login con CAPTCHA válido: aprobado
Test de login con CAPTCHA inválido: rechazado
Decisiones de diseño

Se eligió hCaptcha como mecanismo de protección debido a su facilidad de integración y su enfoque en privacidad. A diferencia de otras soluciones más complejas como reCAPTCHA v3, hCaptcha permite una implementación más directa sin necesidad de manejar sistemas de puntuación.

La validación se implementó obligatoriamente en el servidor utilizando una Rule personalizada en Laravel, asegurando que el CAPTCHA no pueda ser falsificado desde el frontend. Esto mejora la seguridad del sistema y evita ataques automatizados.

Se decidió encapsular la lógica en una Rule para seguir buenas prácticas de diseño de software, aplicando el principio de responsabilidad única. Esto permite reutilizar la validación en otros formularios si es necesario.

Durante la implementación, uno de los principales retos fue asegurar la correcta comunicación con la API de hCaptcha y manejar adecuadamente las respuestas de error del servidor.

Capturas de pantalla

Las capturas se encuentran en la carpeta:

/docs/screenshots/
