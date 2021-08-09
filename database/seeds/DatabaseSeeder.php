<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RoleTableSeeder::class);
        $this->call(PermissionTableSeeder::class);
        $this->call(DefaultModuleSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(SettingsTableSeeder::class);
        /*
        $this->call(BrandSeeder::class);
        $this->call(ProductCategorySeeder::class);
        $this->call(SupplierSeeder::class);
        $this->call(MedicSeeder::class);
        $this->call(PatientSeeder::class);
        $this->call(ProductSeeder::class);
        $this->call(SaleSeeder::class);
        $this->call(GeneralServiceSeeder::class);
        $this->call(PurchaseSeeder::class);*/
    }
}
