<?php

namespace Database\Seeders;

use App\Models\Criteria;
use App\Models\Category;
use App\Models\Wood;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        // User::factory(10)->create();
        User::create([
            'name'     => 'Operator',
            'username' => 'adminer',
            'email'    => 'admin@spk.com',
            'password' => bcrypt('admin123'),
            'level'    => 'ADMIN'
        ]);

        Category::create([
            'category_name' => 'Kategori Kerajinan Ukir',
            'slug' => 'kategori-kerajinan'
        ]);
        Category::create([
            'category_name' => 'Kategori Furniture Rumah',
            'slug' => 'kategori-Furniture'
        ]);
        Category::create([
            'category_name' => 'Kategori Perkakas',
            'slug' => 'kategori-Perkakas'
        ]);
        

        // Wood::factory(300)->create();

  
       Criteria::create([
    'kode' => 'C1',
    'name' => 'Kepadatan dan Kekuatan',
    'bobot' => 0.15,
    'kategori' => 'BENEFIT',
    'keterangan' => 'Semakin kuat kayu, semakin baik'
]);

Criteria::create([
    'kode' => 'C2',
    'name' => 'Ketahanan terhadap Hama dan Jamur',
    'bobot' => 0.15,
    'kategori' => 'BENEFIT',
    'keterangan' => 'Semakin tahan, semakin baik'
]);

Criteria::create([
    'kode' => 'C3',
    'name' => 'Kandungan Kelembaban',
    'bobot' => 0.10,
    'kategori' => 'COST',
    'keterangan' => 'Semakin tinggi kadar air, semakin buruk, karena bisa menyebabkan penyusutan atau pembengkakan'
]);

Criteria::create([
    'kode' => 'C4',
    'name' => 'Tekstur dan Serat Kayu',
    'bobot' => 0.20,
    'kategori' => 'BENEFIT',
    'keterangan' => 'Semakin bagus serat dan teksturnya, semakin baik'
]);

Criteria::create([
    'kode' => 'C5',
    'name' => 'Daya Tahan terhadap Cuaca',
    'bobot' => 0.15,
    'kategori' => 'BENEFIT',
    'keterangan' => 'Semakin tahan terhadap perubahan cuaca, semakin baik'
]);

Criteria::create([
    'kode' => 'C6',
    'name' => 'Harga dan Ketersediaan',
    'bobot' => 0.10,
    'kategori' => 'COST',
    'keterangan' => 'Semakin mahal atau semakin langka, semakin buruk'
]);

Criteria::create([
    'kode' => 'C7',
    'name' => 'Kemudahan Pengolahan dan Perawatan',
    'bobot' => 0.15,
    'kategori' => 'BENEFIT',
    'keterangan' => 'Semakin mudah diproses dan dibudidaya, semakin baik'
]);

    }
}
