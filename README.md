# 1ra Iteracion Diseño Web - Instrucciones de instalación y ejecución

Este proyecto está desarrollado con el framework [Laravel](https://laravel.com/) y puede ejecutarse localmente siguiendo los pasos que se detallan a continuación.

## Requisitos

- PHP 8.1 o superior
- [Composer](https://getcomposer.org/)
- MySQL o cualquier otro motor de base de datos compatible
- Navegador web

---

## 1. Instalación de Composer

Para instalar Composer:

1. Ingresar a: https://getcomposer.org/download/
2. Descargar el instalador correspondiente a tu sistema operativo.
3. Una vez instalado, verificar su correcta instalación ejecutando en una terminal:

```bash
composer --version
```

---

## 2. Instalación del proyecto

1. Descomprimir la carpeta del proyecto en cualquier ubicación de tu computadora.
2. Abrir una terminal en la raíz del proyecto descomprimido.
3. Ejecutar el siguiente comando para instalar las dependencias:

```bash
composer update
```

---

## 3. Configuración de la base de datos

Antes de continuar, es necesario configurar correctamente la conexión a la base de datos.

1. Acceder a la carpeta `config/`.
2. Abrir el archivo `database.php`.
3. Configurar los datos de acceso a tu base de datos local:

```php
'mysql' => [
    'driver' => 'mysql',
    'host' => '127.0.0.1', // o 'localhost'
    'port' => '3306',
    'database' => 'nombre_de_tu_base',
    'username' => 'usuario',
    'password' => 'contraseña',
    ...
],
```

> Asegurarse de que la base de datos exista antes de continuar. El sistema se encargará de crear las tablas.

---

## 4. Migraciones y carga de datos

Con la configuración de base de datos ya hecha, ejecutar en la terminal:

```bash
php artisan migrate --seed
```

Este comando:

- Crea todas las tablas necesarias.
- Inserta datos iniciales mediante los *seeders*.

---

## 5. Ejecutar el servidor

Finalmente, levantar el servidor de desarrollo de Laravel con:

```bash
php artisan serve
```

Esto abrirá el proyecto en:

```
http://127.0.0.1:8000
```

Ingresá desde tu navegador para utilizar el sistema.

---

## Notas

- Si se desea reiniciar la base de datos completamente, se puede usar:

```bash
php artisan migrate:fresh --seed
```

- Verificá tener habilitadas las extensiones `pdo` y `pdo_mysql` en tu archivo `php.ini`.

---

**Siguiendo estos pasos deberia de poder ejecutar y probar el sistema sin problemas!**