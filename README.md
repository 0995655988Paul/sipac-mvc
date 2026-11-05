# SIPAC · Administración MVC

Administración web del core aprobado de **SIPAC: Sistema de planificación de compras y análisis de riesgos presupuestarios**. Está construido con PHP 8.2+, CodeIgniter 4 y SQLite, siguiendo MVC y separando controladores, modelos, servicios de dominio y vistas.

## Qué se puede demostrar

- Inicio de sesión con sesión regenerada, CSRF y contraseñas con `bcrypt`.
- CRUD de productos con código interno, unidad, stock de seguridad y prioridad.
- Proveedores con RUC ecuatoriano validado en **back-end** antes del `INSERT`; el RUC también tiene índice `UNIQUE` en la base.
- Cotizaciones relacionadas con un proveedor y un producto por dropdowns.
- Inventario con entradas y consumos; el saldo se calcula como entradas menos consumos.
- Presupuestos mensuales y cálculo de monto disponible.
- Generación de un plan de 1 a 8 productos con suavización exponencial simple (`alpha = 0.3`).
- Dropdown dependiente: al elegir un producto, el dropdown de cotizaciones consulta únicamente ofertas vigentes para ese producto. El servidor vuelve a comprobar la relación `detalle_cotizacion_id → producto_id` y su vigencia; nunca se confía en el JavaScript.
- Revisión y aprobación transaccional: se revalidan presupuesto y cotizaciones, se agrupan órdenes por proveedor y se registra el escenario base aprobado.

## Instalación local

Requisitos: PHP 8.2+ con `intl`, `mbstring` y `sqlite3`, Composer y Git.

```bash
cd sipac-mvc
composer install
cp .env.example .env
php spark migrate --all
php spark db:seed DatabaseSeeder
php spark serve --host 127.0.0.1 --port 8080
```

Abre [http://127.0.0.1:8080](http://127.0.0.1:8080).

| Usuario | Valor |
| --- | --- |
| Correo | `admin@sipac.local` |
| Contraseña | `Admin123!` |

La base local se crea en `writable/sipac.db`. El archivo `.env`, la base y las sesiones están excluidos de Git.

## Recorrido para la demostración

1. Entrar al panel con la cuenta de demostración.
2. Abrir **Proveedores → Nuevo proveedor** y probar un RUC inválido. El formulario vuelve con error aunque se manipule o se elimine cualquier validación del navegador. Después guardar un RUC válido.
3. Revisar **Productos** e **Inventario**. Registrar una entrada o un consumo y comprobar que el saldo cambia.
4. En **Cotizaciones → Nueva cotización**, seleccionar proveedor y producto desde dropdowns y registrar una oferta vigente.
5. En **Planificación → Generar plan**, seleccionar presupuesto, producto y entre 3 y 6 consumos mensuales. Al cambiar el producto, observar que el dropdown de cotizaciones se carga de forma dependiente.
6. Generar el borrador. Explicar la fórmula visible: `N = max(0, consumo + stock de seguridad − stock disponible − pendientes a tiempo)`.
7. En el detalle, revisar la necesidad, cobertura, costo y motivo. Pulsar **Revalidar y aprobar**; el servidor crea órdenes por proveedor dentro de una transacción y cambia el estado a `APROBADO`.

## Organización MVC

| Capa | Archivos | Responsabilidad |
| --- | --- | --- |
| Rutas | `app/Config/Routes.php` | URLs, métodos HTTP, CSRF y sesión |
| Controladores | `app/Controllers/` | Recibir formularios, autorizar, validar referencias y coordinar |
| Modelos | `app/Models/` | Persistencia y campos permitidos |
| Servicios | `app/Services/` | RUC, inventario, pronóstico, necesidad y costo |
| Vistas | `app/Views/` | Panel, formularios, tablas y dropdown dependiente |
| Migración | `app/Database/Migrations/20261105000001_CrearTablasSIPAC.php` | Tablas, índices y claves foráneas del core |
| Seeder | `app/Database/Seeds/CatalogoSeeder.php` | Datos ficticios reproducibles para la presentación |

El flujo de planificación está en `Planificacion::guardar`: recibe identificadores de los selects, consulta las entidades relacionadas, verifica que la cotización pertenezca al producto seleccionado, calcula el pronóstico y guarda el plan y sus detalles. `Planificacion::aprobar` vuelve a validar todo dentro de una transacción antes de emitir órdenes.

## Pruebas

```bash
composer test
php -l app/Controllers/Planificacion.php
php -l app/Services/RucEcuador.php
```

Las pruebas unitarias cubren el algoritmo de RUC y la fórmula de necesidad/costo. Además, el recorrido manual anterior comprueba la relación dependiente y la revalidación de back-end.

## Git y despliegue

El proyecto tiene su propio repositorio Git local y debe publicarse en el repositorio remoto de la entrega:

```bash
git init
git add .
git commit -m "feat: administrar core SIPAC con MVC"
git branch -M main
git remote add origin https://github.com/TU_USUARIO/sipac-mvc.git
git push -u origin main
```

Incluí `Dockerfile`, `docker-entrypoint.sh` y `render.yaml` para desplegarlo en cualquier servicio compatible con Docker, incluido Render. El despliegue real necesita que el estudiante conecte su cuenta y defina la URL pública; no se guardan credenciales dentro del proyecto.

```bash
docker build -t sipac-mvc .
docker run --rm -p 8080:8080 sipac-mvc
```

En producción cambia `app.baseURL`, usa HTTPS y reemplaza las credenciales de demostración. SQLite en un servicio efímero sirve para la demostración académica; para datos persistentes conviene migrar el grupo de base a PostgreSQL/MySQL.
