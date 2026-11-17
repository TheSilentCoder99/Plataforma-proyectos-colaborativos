# Plataforma de Proyectos Colaborativos (PRACTICA-LARAVEL)

Plataforma web de gestión de proyectos colaborativos desarrollada con **Laravel** como proyecto final del módulo de Desarrollo Web en Entorno Servidor (DWES), correspondiente al segundo curso del Ciclo Formativo de Grado Superior en Desarrollo de Aplicaciones Web (DAW).

## Descripción

Aplicación web que permite gestionar proyectos y organizar equipos de trabajo desde una única plataforma. 

Los usuarios pueden registrarse, iniciar sesión, administrar sus proyectos, buscar tanto proyectos como usuarios mediante filtros, e incorporar o eliminar colaboradores asignándoles responsabilidades y horas de dedicación. Además, la plataforma cuenta con un sistema de administración y control de permisos basado en políticas (*Policies*).

La aplicación está desarrollada siguiendo la arquitectura MVC de Laravel, utilizando Blade para generar las vistas en el servidor (SSR).

## Funcionalidades

La aplicación contempla las siguientes funcionalidades principales:

- **Autenticación y gestión de perfil:** registro, inicio de sesión, cierre de sesión y modificación de datos de usuario (incluyendo actualización directa de correo electrónico sin verificación previa).
- **Gestión de usuarios (Administración):** operaciones CRUD sobre usuarios restringidas exclusivamente a perfiles con rol de administrador (`is_admin`).
- **Gestión de proyectos:** creación, consulta, edición y eliminación de proyectos (CRUD) con confirmaciones de seguridad mediante JavaScript antes del borrado.
- **Gestión de equipos y colaboradores:** vista dedicada y controlador específico para incorporar o eliminar usuarios en proyectos existentes, visualizando los miembros desde la vista detalle de cada proyecto.
- **Asignación de roles y horas:** posibilidad de definir el papel (`role`) y las horas de contribución (`contribution_hours`) de cada participante dentro del proyecto.
- **Buscador avanzado:** filtrado dinámico de usuarios y búsqueda de proyectos por criterio y por estado del proyecto.
- **Control de permisos (Policies):** autorización granular que devuelve errores `403 Forbidden` ante intentos de acceso o modificación no autorizados.

## Tecnologías utilizadas

| Tecnología | Utilización |
|---|---|
| PHP 8.3+ | Lenguaje de programación del servidor |
| Laravel 13 | Framework backend |
| Blade | Motor de plantillas |
| MySQL | Sistema gestor de bases de datos |
| Eloquent ORM | Gestión de modelos y relaciones |
| Laravel Sail | Entorno de desarrollo con Docker |
| JavaScript | Interactividad y confirmaciones de borrado en cliente |
| Vite | Gestión y compilación de recursos frontend |
| CSS | Estilos personalizados e identidad visual de la interfaz |

## Modelo de datos

La aplicación utiliza las siguientes entidades principales:

- **Users:** almacena la información de los usuarios registrados, incluyendo el campo booleano `is_admin` para distinguir a los administradores de los usuarios estándar.
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
git clone https://github.com/TheSilentCoder99/Plataforma-proyectos-colaborativos.git
cd Plataforma-proyectos-colaborativos
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

### 6. Ejecutar las migraciones y seeders

Para crear las tablas y poblar la base de datos con los factories y usuarios de prueba por defecto (administrador y usuario estándar):

```bash
./vendor/bin/sail artisan migrate --seed
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

## Usuarios de prueba (Seeders)

Al ejecutar las migraciones con `--seed`, el sistema genera datos iniciales mediante *Factories* y crea dos cuentas por defecto para facilitar las pruebas de permisos y roles:

- **Usuario Administrador (`is_admin = true`):** con acceso completo a la gestión CRUD de todos los usuarios y supervisión de la plataforma.
- **Usuario Estándar (`is_admin = false`):** para validar las restricciones de acceso (`403`) y el flujo normal de creación de proyectos y colaboración en equipos.

*(Consultar `database/seeders/DatabaseSeeder.php` para ver las credenciales exactas configuradas).*

## Estructura del proyecto

La aplicación sigue la estructura convencional de Laravel:

```text
Plataforma-proyectos-colaborativos/
│
├── app/
│   ├── Http/
│   │   ├── Controllers/   # Controladores de Proyectos, Usuarios y Equipos
│   │   └── Requests/
│   ├── Models/            # Modelos User y Project con relaciones Eloquent
│   └── Policies/          # Políticas de autorización (UserPolicy, ProjectPolicy)
│
├── bootstrap/
├── config/
├── database/
│   ├── factories/         # Factories para generación de proyectos y usuarios
│   ├── migrations/        # Migraciones (users, is_admin, projects, project_user)
│   └── seeders/           # Seeders con usuarios de prueba y datos iniciales
│
├── public/
├── resources/
│   ├── css/               # Estilos personalizados y logotipo
│   ├── js/                # Scripts de confirmación de acciones
│   └── views/             # Vistas Blade (proyectos, usuarios, equipos)
│
├── routes/
│   └── web.php            # Definición organizada de rutas web
│
├── storage/
├── tests/
├── compose.yaml
├── composer.json
├── package.json
└── README.md
```

## Seguridad

La aplicación contempla diferentes mecanismos de seguridad:

- **Autenticación:** protección de rutas y funcionalidades privadas mediante middleware de sesión.
- **Autorización basada en Policies:**
  - Solo los usuarios con rol administrador (`is_admin`) pueden realizar operaciones CRUD sobre otros usuarios.
  - Solo los propietarios de un proyecto pueden editarlo, eliminarlo o gestionar su equipo de colaboradores.
  - Respuesta HTTP `403 Forbidden` ante cualquier intento de acción no autorizada.
- **Validación y protección de formularios:** validación de datos en el servidor y protección CSRF activa en todos los formularios.
- **Integridad referencial:** uso de relaciones Eloquent y claves foráneas en las migraciones.

## Autor

Proyecto desarrollado individualmente como parte del módulo de Desarrollo Web en Entorno Servidor (DWES).

**Desarrollador:** Alan Sepúlveda (`TheSilentCoder99`)  
**Ciclo formativo:** Desarrollo de Aplicaciones Web (DAW)  
**Centro educativo:** IES Celia Viñas  
**Curso académico:** 2026/2027

---

## Licencia

Proyecto desarrollado con fines educativos.