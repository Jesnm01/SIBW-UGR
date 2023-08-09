# Prácticas - Sistemas de Información Basados en Web

El objetivo del proyecto es crear una página web usando HTML + CSS3 + Javascript, de manera básica, sin plantillas estilo Bootstrap o parecidos.  
La página web es un sitio de promoción de festivales, y en cada una de las prácticas se van añadiendo funcionalidades progresivamente (ver los pdf explicativos [aqui](https://github.com/Jesnm01/SIBW-UGR/tree/main/enunciados)).

Las prácticas 1 y 2 son páginas web estáticas que se pueden ver [aqui]() (WIP).

A partir de la práctica 3 son webs dinámicas utilizando php. Para su correcta visualización es necesario tener un entorno LAMP para cargar servir las páginas del lado del servidor.
Se utiliza también un motor de plantillas minimal para separar correctamente el código PHP del código HTML.

## Instalación LAMP
Se recomienda utilizar un entorno docker ya configurado. 
Para ello, instalar docker y docker-compose, y seguir los pasos descritos en el repositorio oficial de [docker-compose-lamp](https://github.com/sprintcube/docker-compose-lamp/tree/master).

En resumen:  

Clonamos el repositorio
```shell
git clone https://github.com/sprintcube/docker-compose-lamp.git
cd docker-compose-lamp/
```

Copiar el fichero de configuración inicial para docker
```shell
cp sample.env .env
// modify sample.env as needed
```

Antes de lanzar docker-compose up, modificamos el fichero Dockerfile y añadimos al final del archivo la instalación de la librería [Twig](https://twig.symfony.com/) con las siguientes líneas:
```shell
# bin/webserver/Dockerfile
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php -r "if (hash_file('sha384', 'composer-setup.php') === '756890a4488ce9024fc62c56153228907f1545c228516cbf63f885e036d37e9a59d27d63f46af1d4d07ee0f76181c7d3') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
RUN php composer-setup.php
RUN php -r "unlink('composer-setup.php');"

RUN cd /usr/local/lib/php && composer require "twig/twig:^3.0"
```

Ahora arrancamos docker:
```shell
docker-compose up
```
  
Una vez termine la configuración inicial de docker, podremos ver la página de ejemplo en localhost.

## Añadir ficheros de prácticas
