PHP REST FULL API

Instalación
1. Clonar el proyecto o descargar el codigo dentro de la carpeta publica de su servidor.
2. Crear una nueva base de datos e importar las tablas proporcionadas en el archivo blog.sql
3. Configurar sus credenciales y nombre de base de datos en app/config/config.php
4. Configurar la carpeta raíz en app/bootstrap/bootstrap.php por ejemplo:
   DEFINE('BASE_URI', $_SERVER["DOCUMENT_ROOT"] . '/blog/');
5. Composer install
6. Accesos:

Rol ID - User	- Password - Rol
1 - basico@gmail.com	1234	basico
2 - medio@gmail.com	1234	medio
3 - medioalto@gmail.com	1234	medio_alto
4 - altomedio@gmail.com	1234	alto_medio
5 - alto@gmail.com	1234	alto


Uso Básico:

Login (verbo POST):
1. Logearse en http://localhost/blog/index.php/login para obtener el token de acceso usando una combinación de user/password.
2. En http://localhost/blog/index.php/login "Blog" corresponde al nombre de la carpeta raíz que haya elegido.

Registro (verbo POST):
1. Ruta http://localhost/blog/index.php/register
2. Registrarse con el siguente esquema
   {
    "name": "luis",
    "lastname": "calderon",
    "email": "luis@gmail.com",
    "rol_id": "1",
    "rol": "basico",
    "password": "1234"
}

1 . Consulta
Authorization Bearer Token
GET http://localhost/blog/index.php/post

2. Consulta de una publicación
Authorization Bearer Token
GET http://localhost/blog/index.php/post/1

3. Creación
Authorization Bearer Token
POST http://localhost/blog/index.php/post
{
    "title": "post",
    "status": "published",
    "content": "Lorem Ipsum"
}

4. Actualizar
Authorization Bearer Token
PUT http://localhost/blog/index.php/post/1
{
    "title": "post1",
    "status": "published",
    "content": "Lorem Ipsum"
}

5. Eliminar
Authorization Bearer Token
DELETE http://localhost/blog/index.php/post/1
