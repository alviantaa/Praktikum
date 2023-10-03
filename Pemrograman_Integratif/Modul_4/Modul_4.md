# Basic Routing dan Migration

## Langkah Praktikum

### Basic Routing

1. GET
   Gunakan aplikasi `lumenapi` yang sebelumnya telah dibuat
   Untuk menambahkan endpoint dengan method GET pada aplikasi kita, kita dapat mengunjungi file web.php pada folder routes. Kemudian tambahkan baris ini pada akhir file

   ```
   $router->get('/get', function () {
       return 'GET';
   });
   ```

   <br>![image](https://github.com/alviantaa/Praktikum/blob/main/Pemrograman_Integratif/Modul_4/screenshot/1.jpg)

   jalankan aplikasi menggunakan command

   > [!NOTE]
   > Pastikan buka terminal pada folder aplikasi

   ```
   php -S localhost:8000 -t public
   ```

   <br>![image](https://github.com/alviantaa/Praktikum/blob/main/Pemrograman_Integratif/Modul_4/screenshot/2.jpg)

   Setelah aplikasi berhasil dijalankan, path default berbentuk http://{BASE_URL}{PATH}, jika BASE_URL kita adalah localhost:8000 dan PATH kita adalah /get, maka url akan berbentuk http://localhost:8000/get.
   <br>![image](https://github.com/alviantaa/Praktikum/blob/main/Pemrograman_Integratif/Modul_4/screenshot/3.jpg)

2. POST, PUT, PATCH, DELETE, dan OPTIONS
   Sama halnya saat menambahkan method GET, kita dapat menambahkan methode POST, PUT, PATCH, DELETE, dan OPTIONS pada file web.php dengan code seperti ini,

   ```
   $router->post('/post', function () {
        return 'POST';
    });
    $router->put('/put', function () {
        return 'PUT';
    });
    $router->patch('/patch', function () {
        return 'PATCH';
    });
    $router->delete('/delete', function () {
        return 'DELETE';
    });
    $router->options('/options', function () {
        return 'OPTIONS';
    });
   ```

   <br>![image](https://github.com/alviantaa/Praktikum/blob/main/Pemrograman_Integratif/Modul_4/screenshot/4.jpg)

   Setelah selesai menambahkan route untuk method POST, PUT, PATCH, DELETE, dan OPTIONS, kita dapat menjalankan server seperti pada saat percobaan GET. Setelah server berhasil menyala, kita dapat membuka aplikasi Postman atau Insomnia atau kita juga dapat menggunakan PowerShell (Windows) / Terminal (Linux atau Mac) untuk melakukan request ke server. Namun, pada percobaan kali ini kita akan menggunakan extensions pada VSCode yaitu Thunder Client.

   instalasi thunder client
   <br>![image](https://github.com/alviantaa/Praktikum/blob/main/Pemrograman_Integratif/Modul_4/screenshot/5.jpg)

   - membuka panel extensions, cari "thunder client"
   - setelah install, dapat membuka logo petir pada bar sebelah kiri
   - membuat request dengan "New Request"
     > [!NOTE]
     > thunder client tidak dapat terhubung dengan localhost, maka menggunakan url khusus yaitu

   ```
   http://[::1]:8000/post
   ```

   <br>![image](https://github.com/alviantaa/Praktikum/blob/main/Pemrograman_Integratif/Modul_4/screenshot/6.jpg)

### Migration Database

1. Sebelum melakukan migrasi database pastikan server database aktif kemudian pastikan sudah membuat database dengan nama `lumenapi`

<br>![image](https://github.com/alviantaa/Praktikum/blob/main/Pemrograman_Integratif/Modul_4/screenshot/8.jpg)

2. Kemudian ubah konfigurasi database pada file .env menjadi seperti ini

   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=lumenapi
   DB_USERNAME=root
   DB_PASSWORD=<<password masing-masing>>
   ```

   <br>![image](https://github.com/alviantaa/Praktikum/blob/main/Pemrograman_Integratif/Modul_4/screenshot/9.jpg)

3. Setelah mengubah konfigurasi pada file .env, kita juga perlu menghidupkan beberapa library bawaan dari lumen dengan membuka file app.php pada folder bootstrap dan mengubah baris ini,

   ```
   # sebelumnya
   ...
   //$app->withFacades();
   //$app->withEloquent();
   ...

   # diubah menjadi
   ...
   $app->withFacades();
   $app->withEloquent();
   ...

   ```

   <br>![image](https://github.com/alviantaa/Praktikum/blob/main/Pemrograman_Integratif/Modul_4/screenshot/10.jpg)

4. Setelah itu jalankan command berikut untuk membuat file migration,

   ```
   php artisan make:migration create_users_table # membuat migrasi untuk tabel users
   php artisan make:migration create_products_table # membuat migrasi untuk tabel products
   ```

   <br>![image](https://github.com/alviantaa/Praktikum/blob/main/Pemrograman_Integratif/Modul_4/screenshot/11.jpg)

   Setelah menjalankan 2 syntax diatas, akan terbuat 2 file baru pada folder database/migrations dengan format YYYY_MM_DD_HHmmss_nama_migrasi.
   <br>![image](https://github.com/alviantaa/Praktikum/blob/main/Pemrograman_Integratif/Modul_4/screenshot/12.jpg)
   Pada file migrasi kita akan menemukan fungsi up() dan fungsi down(), fungsi up() akan digunakan pada saat kita melakukan migrasi, fungsi down() akan digunakan saat kita ingin me-rollback migrasi.

5. Ubah fungsi up pada file migrasi create_users_table
   ```
   # sebelumnya
   ...
   public function up(){
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
        });
    }
   ...
   # diubah menjadi
   ...
   public function up(){
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name');
            $table->string('email');
            $table->string('password');
        });
    }
   ...
   ```
   <br>![image](https://github.com/alviantaa/Praktikum/blob/main/Pemrograman_Integratif/Modul_4/screenshot/13.jpg)
6. Ubah fungsi up pada file migrasi create_products_table

   ```
   # sebelumnya
   ...
   public function up(){
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
        });
    }
   ...
   # diubah menjadi
   ...
   public function up(){
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name');
            $table->integer('category_id');
            $table->string('slug');
            $table->integer('price');
            $table->integer('weight');
            $table->text('description');
        });
    }
   ...
   ```

   <br>![image](https://github.com/alviantaa/Praktikum/blob/main/Pemrograman_Integratif/Modul_4/screenshot/14.jpg)

7. Jalankan command,
   ```
   php artisan migrate
   ```
   <br>![image](https://github.com/alviantaa/Praktikum/blob/main/Pemrograman_Integratif/Modul_4/screenshot/15.jpg)
   tabel products telah terbuat
   <br>![image](https://github.com/alviantaa/Praktikum/blob/main/Pemrograman_Integratif/Modul_4/screenshot/16.jpg)
   tabel users telah terbuat
   <br>![image](https://github.com/alviantaa/Praktikum/blob/main/Pemrograman_Integratif/Modul_4/screenshot/17.jpg)
