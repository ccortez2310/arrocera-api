<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [

            //Categories
            ['name' => 'Listar', 'value' => 'category:access'],
            ['name' => 'Crear', 'value' => 'category:create'],
            ['name' => 'Editar', 'value' => 'category:edit'],
            ['name' => 'Detalles', 'value' => 'category:show'],
            ['name' => 'Borrar', 'value' => 'category:delete'],
            ['name' => 'Cambiar estado', 'value' => 'category:change_status'],
            ['name' => 'Destacar', 'value' => 'category:change_featured'],
            ['name' => 'Gestionar Ofertas', 'value' => 'category:offer_management'],

            //Roles
            ['name' => 'Listar', 'value' => 'role:access'],
            ['name' => 'Crear', 'value' => 'role:create'],
            ['name' => 'Editar', 'value' => 'role:edit'],
            ['name' => 'Detalles', 'value' => 'role:show'],
            ['name' => 'Borrar', 'value' => 'role:delete'],

            //Admins
            ['name' => 'Listar', 'value' => 'user:access'],
            ['name' => 'Crear', 'value' => 'user:create'],
            ['name' => 'Editar', 'value' => 'user:edit'],
            ['name' => 'Detalles', 'value' => 'user:show'],
            ['name' => 'Borrar', 'value' => 'user:delete'],
            ['name' => 'Cambiar estado', 'value' => 'user:change_status'],

            //Customers
            ['name' => 'Listar', 'value' => 'customer:access'],
            ['name' => 'Detalles', 'value' => 'customer:show'],
            ['name' => 'Borrar', 'value' => 'customer:delete'],
            ['name' => 'Cambiar estado', 'value' => 'customer:change_status'],

            //Slider
            ['name' => 'Listar', 'value' => 'slider:access'],
            ['name' => 'Crear', 'value' => 'slider:create'],
            ['name' => 'Editar', 'value' => 'slider:edit'],
            ['name' => 'Detalles', 'value' => 'slider:show'],
            ['name' => 'Borrar', 'value' => 'slider:delete'],
            ['name' => 'Cambiar estado', 'value' => 'slider:change_status'],

            //Pedidos
            ['name' => 'Listar', 'value' => 'order:access'],
            ['name' => 'Detalles', 'value' => 'order:show'],
            ['name' => 'Borrar', 'value' => 'order:delete'],
            ['name' => 'Cambiar estado', 'value' => 'order:change_status'],

            //Settings
            ['name' => 'Ver', 'value' => 'general-setting:access'],
            ['name' => 'Editar', 'value' => 'general-setting:edit'],
            ['name' => 'Ver', 'value' => 'commerce-setting:access'],
            ['name' => 'Editar', 'value' => 'commerce-setting:edit'],

            //Reports
            ['name' => 'Ventas', 'value' => 'sales-report:access'],
            ['name' => 'Productos', 'value' => 'product-report:access'],
            ['name' => 'Clientes', 'value' => 'customer-report:access'],


        ];

        foreach ($permissions as $permission) {
            Permission::create([
                'name' => $permission['name'],
                'value' => $permission['value']
            ]);
        }
    }
}
