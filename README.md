# PRACTICA-LARAVEL

Plataforma web de gestión de proyectos colaborativos desarrollada con **Laravel** como proyecto final del módulo de Desarrollo Web en Entorno Servidor (DWES), correspondiente al segundo curso del Ciclo Formativo de Grado Superior en Desarrollo de Aplicaciones Web (DAW).

## Descripción

PRACTICA-LARAVEL es una aplicación web que permite gestionar proyectos y organizar equipos de trabajo desde una única plataforma.

Los usuarios pueden registrarse, iniciar sesión y gestionar sus proyectos, así como incorporar colaboradores y asignarles diferentes responsabilidades dentro de cada proyecto.

La aplicación está desarrollada siguiendo la arquitectura MVC de Laravel, utilizando Blade para generar las vistas en el servidor (SSR).

## Funcionalidades

La aplicación contempla las siguientes funcionalidades:

- **Autenticación de usuarios:** registro, inicio de sesión y cierre de sesión.
- **Gestión de proyectos:** creación, consulta, edición y eliminación de proyectos (CRUD).
- **Gestión de colaboradores:** incorporación de usuarios a proyectos existentes.
- **Asignación de roles:** posibilidad de definir el papel de cada colaborador dentro de un proyecto.
- **Seguimiento de horas:** registro de las horas de contribución de los participantes.
- **Control de permisos:** los propietarios de los proyectos pueden gestionar sus propios proyectos y colaboradores.

## Tecnologías utilizadas

| Tecnología | Utilización |
|---|---|
| PHP 8.3+ | Lenguaje de programación del servidor |
| Laravel 13 | Framework backend |
| Blade | Motor de plantillas |
| MySQL | Sistema gestor de bases de datos |
| Eloquent ORM | Gestión de modelos y relaciones |
| Laravel Sail | Entorno de desarrollo con Docker |
| JavaScript | Interactividad en el cliente |
| Vite | Gestión de recursos frontend |
| CSS | Estilos de la interfaz |

## Modelo de datos

La aplicación utiliza las siguientes entidades principales:

- **Users:** almacena la información de los usuarios registrados.
- **Projects:** almacena los proyectos, incluyendo su título, descripción, fecha límite, estado y propietario.
- **Project_User:** tabla intermedia que establece la relación muchos a muchos entre usuarios y proyectos.

La relación entre usuarios y proyectos permite que:

- Un usuario pueda crear varios proyectos.
- Un proyecto pertenezca a un único usuario propietario.
- Un usuario pueda colaborar en diferentes proyectos.
- Un proyecto pueda tener múltiples colaboradores.

La tabla intermedia `project_user` incorpora información adicional sobre cada participación:

- `role`: función desempeñada por el colaborador.
- `contribution_hours`: horas dedicadas al proyecto.

## Instalación y ejecución

### Requisitos previos

- Git.
- Docker y Docker Compose.
- PHP 8.3 o superior.
- Composer.
- Node.js y npm.

### 1. Clonar el repositorio

```bash
git clone <URL_DEL_REPOSITORIO>
cd PRACTICA-LARAVEL
```

### 2. Instalar dependencias PHP

```bash
composer install
```

### 3. Configurar las variables de entorno

Crear el archivo `.env` a partir del archivo de ejemplo:

```bash
cp .env.example .env
```

Configurar las variables de conexión a la base de datos según el servicio definido en `compose.yaml`.

### 4. Iniciar los contenedores

```bash
./vendor/bin/sail up -d
```

### 5. Generar la clave de aplicación

```bash
./vendor/bin/sail artisan key:generate
```

### 6. Ejecutar las migraciones

```bash
./vendor/bin/sail artisan migrate
```

Si el proyecto dispone de seeders para generar datos de prueba:

```bash
./vendor/bin/sail artisan db:seed
```

### 7. Instalar dependencias frontend

```bash
npm install
```

### 8. Compilar los recursos frontend

Para desarrollo:

```bash
npm run dev
```

Para generar los recursos de producción:

```bash
npm run build
```

Una vez completados estos pasos, la aplicación estará disponible en:

```text
http://localhost
```

Para detener los contenedores:

```bash
./vendor/bin/sail down
```

## Estructura del proyecto

La aplicación sigue la estructura convencional de Laravel:

```text
PRACTICA-LARAVEL/
│
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   └── Requests/
│   ├── Models/
│   └── Policies/
│
├── bootstrap/
├── config/
├── database/
│   ├── migrations/
│   ├── seeders/
│   └── factories/
│
├── public/
├── resources/
│   ├── css/
│   ├── js/
│   └── views/
│
├── routes/
│   └── web.php
│
├── storage/
├── tests/
├── compose.yaml
├── composer.json
├── package.json
└── README.md
```

*La estructura mostrada es orientativa y puede variar según la organización definitiva del código.*

## Seguridad

La aplicación contempla diferentes mecanismos de seguridad:

- Autenticación para proteger las funcionalidades privadas.
- Autorización para limitar las operaciones de gestión de proyectos a sus propietarios.
- Validación de los datos recibidos mediante las herramientas de Laravel.
- Protección CSRF en los formularios.
- Uso del sistema de relaciones de Eloquent para gestionar la integridad de los datos.

## Autor

Proyecto desarrollado individualmente como parte del módulo de Desarrollo Web en Entorno Servidor (DWES).

**Ciclo formativo:** Desarrollo de Aplicaciones Web (DAW)  
**Centro educativo:** IES Celia Viñas  
**Curso académico:** 2026/2027

---

## Licencia

Proyecto desarrollado con fines educativos.
