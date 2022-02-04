PHP REST FULL API

Uso Basico
1. Clonar el proyecto o descargar el codigo dentro de la carpeta publica de su servidor.
2. Crear una nueva base de datos e importar las tablas proporcionadas en el archivo blog.sql
3. Configurar sus credenciales y nombre de base de datos en app/config/config.php
4. Configurar la carpeta raiz en app/bootstrap/bootstrap.php por ejemplo:
   DEFINE('BASE_URI', $_SERVER["DOCUMENT_ROOT"] . '/blog/');
5. Composer install
