🚀 Instalación y Ejecución del Proyecto
🖥️ Requisitos

El proyecto fue desarrollado utilizando:

Laragon

PHP 8.3.16

Composer 2.8.4

MySQL


📦 FRONT (Laravel API)
1️⃣ Clonar el repositorio
    git clone https://github.com/tu-usuario/tu-repositorio.git
    cd tu-repositorio

2️⃣ Instalar dependencias
    composer install

3️⃣ Configurar archivo de entorno

Copiar el archivo .env.example y renombrarlo a .env:
    cp .env.example .env

Configurar las credenciales de la base de datos en el archivo .env:
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=clinica
    DB_USERNAME=root
    DB_PASSWORD=

Configurar también la URL del backend:
    API_URL=http://apirestfull-php.test
    Ajustar la URL según tu entorno local.

4️⃣ Generar la clave de la aplicación
php artisan key:generate

5️⃣ Ejecutar migraciones
    php artisan migrate

6️⃣ Ejecutar seeders
    php artisan db:seed

🔄 Si deseas reiniciar completamente la base de datos
php artisan migrate:fresh --seed

▶️ 7️⃣ Levantar el servidor
    php artisan serve

    Las credencuales para ingresar son:
    usuario:administrador
    pass: 1234567890