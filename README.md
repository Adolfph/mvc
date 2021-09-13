# mvc
Prueba MVC con PHP puro y POO.
La estructura de la base de datos y el virtual host se encuentan en la carpeta config/
El archivo es config.php
# Base de datos
Dentro de la carpeta config/ se encuentra el archivo de configuración que debera modificar para establecer la configuración para el acceso a la BD, el nombre del archivo es config.php
La estructura para crear la BD y la tabla se encuentra en el archivo config/bd_menus.
# VirtualHost
Deberá copiar el archivo menus.conf a la carpeta etc/apache2/sites-available/
ejecutar el comando a2ensite menu.conf
ejecutar el comando service apache2 reload
editar el archivo /etc/hosts para agregar la linea: 127.0.1.1       menu.test
para acceder al sitio debera ingresar la URL: http://menu.test/
# mvc
