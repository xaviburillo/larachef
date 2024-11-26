# LaraChef
Esta es una aplicación de muestra que sirve como demostración de los conocimientos adquiridos.

LaraChef está hecha con:
- [Laravel](https://laravel.com/), framework de PHP 
- Javascript 
- HTML 
- CSS

## Lógica de la aplicación
La aplicación actúa como un CRUD, una web de gestión para ver, interactuar y administrar recetas de cocina.

##### Entre las funciones destacan:
- Fundamentos de un CRUD; creación, visualización, edición y eliminación de recetas.
- Valoración de recetas.
- Favoritos de recetas.
- Búsqueda de recetas.
- Creación y gestión de perfil de usuario.
- Gestión de contenidos (recetas, categorías, valoraciones) mediante roles.
- Gestión de usuarios mediante roles.

## Requisitos
- Mínimo **PHP 7.3** (https://www.php.net/downloads)
- **XAMPP** (https://www.apachefriends.org/es/index.html) o algún software similar para ejectutar aplicaciones en el lado del servidor.
- **npm** (https://docs.npmjs.com/downloading-and-installing-node-js-and-npm)
- Cualquier navegador web.
- (Opcional) **Mailtrap** (https://www.apachefriends.org/es/index.html) o algún software similar para el envío de emails.
- (Opcional) **Git** (https://git-scm.com/)

## Instalación
1. Instalar PHP o comprobar que la versión ya instalada sea superior a la 7.3 ejecutando el comando `php -v` en una línea de comandos.
2. Instalar XAMPP.
3. (Opcional) Crear una cuenta en [Mailtrap](https://mailtrap.io/)
4. Descargar el proyecto haciendo click en el botón "<> Code" y seleccionar la opción "Download ZIP".
5. Extraer el zip.
6. En caso de usar Git, puedes, desde el directorio donde quieras ubicar el proyecto, usar el comando `git clone https://github.com/xaviburillo/larachef.git`

## Requisitos previos a la demostración
1. Navegar mediante la línea de comandos a la carpeta raíz de la aplicación (El directorio donde hayas extraído el zip acabado en \larachef).
2. Instalar [Laravel UI](https://github.com/laravel/ui) en el proyecto:
- Ejecutar los comandos `npm install` y `npm run dev`
3. Configurar el archivo .env:
- Editar  las siguientes líneas:
```
    DB_CONNECTION=mysql
    # DB_HOST=127.0.0.1
    DB_HOST=localhost
    DB_PORT=3306
    DB_DATABASE=larachef
    DB_USERNAME=root
    DB_PASSWORD=
```
#### Los campos DB_USERNAME y DB_PASSWORD suelen tener estos valores por defecto, si al instalarlo los has cambiado, deberías introducir esos cambios en los campos
```
    MAIL_MAILER=smtp
    MAIL_HOST=sandbox.smtp.mailtrap.io
    MAIL_PORT=2525
    MAIL_USERNAME= *Usuario de mailtrap*
    MAIL_PASSWORD= *Contraseña de mailtrap*
    MAIL_ENCRYPTION=tls
    MAIL_FROM_ADDRESS=info@larachef.com
    MAIL_FROM_NAME="${APP_NAME}"
```
#### Los campos MAIL_USERNAME y MAIL_PASSWORD los puedes encontrar en https://mailtrap.io/home > Email Testing > Inboxes > My Inbox > Integration > Credentials

4. Arrancar los servicios de Apache y MySQL en el panel de control de XAMPP.
5. Crear la base de datos con el nombre que hayas especificado en la línea DB_DATABASE en el archivo .env
6. Ejecutar las migraciones: Esto definirá la estructura de la base de datos.
- `php artisan migrate`
7. Ejecutar los seeders: Esto poblará la base de datos de la información necesaria para la demostración.
- `php artisan db:seed`

## Ejecución de la aplicación
1. Arrancar la aplicación:
- `php artisan serve`
2. Abrir el navegador web y visitar http://localhost:8000/ o en su defecto, el puerto que esté configurado en tu máquina.