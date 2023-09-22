## Descripción del Proyecto

Ejecuta en orden las siguientes opciones:

- Copia el archivo .env.example.
- Edita el archivo .env con las configuraciones de la base de datos y el servidor de Redis.
- Ejecuta `php artisan migrate --seed` para ejecutar las migraciones de la base de datos y los seeders.
- Ejecuta `php artisan test` para ejecutar las pruebas unitarias.
- Utiliza los siguientes usuarios de prueba:

        Permisos de Manager: ['username' => 'tester', 'active' => true, 'role' => 1];
        Permisos de Agente: ['username' => 'usuario', 'active' => true, 'role' => 2];
        Usuarios Inactivos: ['username' => 'test', 'active' => false, 'role' => 2];

- El proyecto incluye las siguientes rutas:

        Autenticación: POST /api/auth
        Obtener Todos los Leads: GET /api/lead
        Obtener Lead por ID: GET /api/lead/{id}
        Registrar Lead: POST /api/lead

- Los tokens deben enviarse en los encabezados utilizando la opción Bearer.
- Los datos deben enviarse en formato JSON.

Para cualquier contacto requerido, comunícate a través de cualquiera de estos medios:

        Teléfono: +584245387921
        WhatsApp: +584245387921
        Correo Electrónico: campos.luis19@gmail.com