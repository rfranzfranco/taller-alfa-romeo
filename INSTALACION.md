# 🚗 Sistema de Gestión de Taller Automotriz

## Requisitos Previos
- PHP 8.0 o superior
- MySQL 5.7 o superior / MariaDB 10.3+
- Composer
- Servidor web (Apache/Nginx) o usar el servidor integrado de PHP

---

## 🔧 Instalación en Nueva Computadora

### Paso 1: Clonar o Copiar el Proyecto
```bash
# Si usas Git:
git clone <url-del-repositorio>

# O simplemente copia la carpeta del proyecto
```

### Paso 2: Instalar Dependencias
```bash
cd taller-alfa-romeo
composer install
```

### Paso 3: Configurar Base de Datos

1. **Crear la base de datos en MySQL:**
```sql
CREATE DATABASE taller_alfa_romeo CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
```

2. **Configurar credenciales** en el archivo `.env` (o crea uno copiando `env`):
```env
# Copiar el archivo env a .env
# cp env .env   (Linux/Mac)
# copy env .env (Windows)

# Luego editar .env con tus credenciales:
database.default.hostname = localhost
database.default.database = taller_alfa_romeo
database.default.username = root
database.default.password = tu_contraseña
database.default.DBDriver = MySQLi
database.default.DBPrefix =
database.default.port = 3306
app.baseURL = 'http://localhost:8080'
```

### Paso 4: Ejecutar Migraciones (Crear Tablas)
```bash
php spark migrate
```

Este comando creará todas las tablas necesarias:
- usuarios
- clientes
- empleados
- vehiculos
- servicios
- insumos
- rampas
- reservas
- detalle_reserva
- ordenes_trabajo
- detalle_insumos_orden
- facturas

### Paso 5: Cargar Datos Iniciales (Opcional pero Recomendado)
```bash
php spark db:seed InitialDataSeeder
```

Este comando insertará:
- **Usuario Admin:** `admin` / `admin123`
- **Usuario Recepción:** `recepcion` / `recepcion123`
- **Técnicos:** `tecnico1`, `tecnico2` / `tecnico123`
- 9 servicios predefinidos
- 7 insumos con stock inicial
- 3 rampas

### Paso 6: Iniciar el Servidor de Desarrollo
```bash
php spark serve
```

El sistema estará disponible en: **http://localhost:8080**

---

## 📋 Comandos Útiles

| Comando | Descripción |
|---------|-------------|
| `php spark migrate` | Ejecuta las migraciones pendientes |
| `php spark migrate:rollback` | Revierte la última migración |
| `php spark migrate:refresh` | Elimina todas las tablas y vuelve a migrar |
| `php spark migrate:status` | Muestra el estado de las migraciones |
| `php spark db:seed InitialDataSeeder` | Carga datos iniciales |
| `php spark serve` | Inicia servidor de desarrollo |
| `php spark db:table --show` | Lista todas las tablas |

---

## 🔐 Credenciales por Defecto

| Usuario | Contraseña | Rol |
|---------|------------|-----|
| admin | admin123 | ADMIN |
| recepcion | recepcion123 | RECEPCIONISTA |
| tecnico1 | tecnico123 | EMPLEADO |
| tecnico2 | tecnico123 | EMPLEADO |

**⚠️ Importante:** Cambia las contraseñas en producción.

---

## 🗄️ Estructura de Base de Datos

```
usuarios (autenticación)
    ├── clientes (1:1 con usuarios rol CLIENTE)
    │       └── vehiculos (1:N)
    │               └── reservas (1:N)
    │                       ├── detalle_reserva (servicios de la reserva)
    │                       └── ordenes_trabajo
    │                               ├── detalle_insumos_orden
    │                               └── facturas
    └── empleados (1:1 con usuarios rol EMPLEADO)

servicios (catálogo independiente)
insumos (catálogo independiente)
rampas (recurso del taller)
```

---

## 🐳 Docker (Opcional)

Si prefieres usar Docker:
```bash
docker-compose up -d
```

---

## ❓ Solución de Problemas

### Error de conexión a base de datos
- Verifica que MySQL esté corriendo
- Revisa las credenciales en `.env`
- Asegúrate de que la base de datos exista

### Error en migraciones
```bash
# Ver estado de migraciones
php spark migrate:status

# Si hay problemas, puedes refrescar (¡BORRA TODO!)
php spark migrate:refresh
```

### Permisos en writable/
```bash
# Linux/Mac
chmod -R 777 writable/

# Windows: asegúrate de que la carpeta tenga permisos de escritura
```
