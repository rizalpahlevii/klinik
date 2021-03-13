<?php

use App\Models\Module;
use Illuminate\Database\Seeder;

class DefaultModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $input = [
            [
                'name'      => 'Pasien',
                'is_active' => 1,
                'route'     => 'patients.index',
            ],
            [
                'name'      => 'Dokter',
                'is_active' => 1,
                'route'     => 'medics.index',
            ],
            [
                'name'      => 'Pengguna',
                'is_active' => 1,
                'route'     => 'users.index',
            ],
            [
                'name'      => 'Role',
                'is_active' => 1,
                'route'     => 'roles.index',
            ],
            [
                'name'      => 'Supplier',
                'is_active' => 1,
                'route'     => 'suppliers.index',
            ],
            [
                'name'      => 'Obat',
                'is_active' => 1,
                'route'     => 'products.index',
            ],
            [
                'name'      => 'Kategori',
                'is_active' => 1,
                'route'     => 'category.index',
            ],
            [
                'name'      => 'Merek',
                'is_active' => 1,
                'route'     => 'brands.index',
            ],
        ];
        foreach ($input as $data) {
            $module = Module::whereName($data['name'])->first();
            if ($module) {
                $module->update(['route' => $data['route']]);
            } else {
                Module::create($data);
            }
        }
    }
}
