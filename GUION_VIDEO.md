# Guion breve para el video

Duración sugerida: 4–6 minutos. Habla mientras señalas el navegador y, cuando convenga, el archivo indicado.

## 1. Presentación

“Mi proyecto es SIPAC, un sistema de planificación de compras y análisis de riesgos presupuestarios. La administración está construida con PHP, CodeIgniter 4 y MVC. El administrador alimenta productos, inventario, proveedores, cotizaciones y presupuesto; después genera y aprueba un plan de compras.”

## 2. Recorrido MVC

“La ruta está en `app/Config/Routes.php`. El controlador recibe la petición y valida; por ejemplo, `Planificacion` coordina la creación del plan. Los modelos de `app/Models` solo representan persistencia. Los servicios de `app/Services` contienen reglas de negocio como `RucEcuador`, `InventarioService`, `PronosticoService` y `PlanificacionService`. Las vistas de `app/Views` muestran formularios y tablas, pero no hacen consultas directas.”

## 3. Validación sensible en back-end

“En Proveedores, el RUC es un dato sensible. No confío solamente en `required`, `maxlength` o JavaScript. `Proveedores::persistir` normaliza el valor y llama a `RucEcuador::esValido` antes de insertar. Se valida longitud, provincia, dígito verificador y terminación 001. Además, la migración tiene un índice `UNIQUE`. Para demostrarlo, intento guardar un RUC incorrecto: el servidor devuelve el error y no se registra.”

## 4. Relaciones con dropdown dependiente

“En Cotizaciones, proveedor y producto son selects; nunca escribo una clave foránea manualmente. En Planificación, selecciono un producto y el segundo dropdown consulta `GET /api/productos/{id}/cotizaciones`. Solo aparecen cotizaciones vigentes de ese producto. Aunque alguien manipule el HTML, `Planificacion::guardar` vuelve a consultar el detalle y comprueba que su `producto_id` coincida y que la oferta siga vigente.”

## 5. Cálculo y aprobación

“El plan acepta de tres a seis consumos mensuales. `PronosticoService` aplica suavización exponencial simple con alpha 0.3. Luego `PlanificacionService` calcula la necesidad con `max(0, consumo + stock de seguridad - stock - pendientes)`. El plan primero queda como borrador. Al aprobar, el controlador vuelve a validar presupuesto y cotizaciones dentro de una transacción, agrupa las órdenes por proveedor y cambia el plan a aprobado.”

## 6. Git y deploy

“El proyecto está versionado en Git con un README reproducible. La migración y el seeder permiten levantarlo desde cero. Incluí Dockerfile, entrypoint y `render.yaml` para desplegarlo; la URL pública y las credenciales se configuran en la plataforma y no se guardan en el repositorio.”

## Cierre

“Con esto la administración no es solo un CRUD: alimenta el core, protege un dato sensible en servidor, respeta las relaciones entre tablas, conserva trazabilidad y evita aprobar compras fuera del presupuesto.”
