# Model, Controller dan Request - Response Handler

## Dasar Teori

1. Model
   Model merupakan bagian yang bertugas untuk menyiapkan, mengatur, memanipulasi, dan mengorganisasikan data yang ada di database. Model merepresentasikan kolom apa saja yang ada pada databas, termasuk relasi dan primary key dapat didefinisikan di dalam model. Dengan menggunakan perintah Artisan, pembuatan model pada Laravel dapat dilakukan dengan satu perintah menggunakan `php artisan make:model nama_model`
   Namun karena perintah Artisan yang terbatas pada Lumen, pembuatan model harus dilakukan secara manual.
2. Controller
   Controller merupakan bagian yang menjadi tempat berkumpulnya logika pemrograman yang digunakan untuk memisahkan organisasi data pada database. Dalam beberapa kasus, controller menjadi penghubung antara model dan view pada arsitektur MVC
3. Request Handler
   Request handler adalah fungsi yang digunakan untuk berinteraksi dengan request yang datang. Request handler dapat digunakan untuk melihat apa saja yang dikirimkan oleh user seperti parameter, query, dan body.
4. Response Handler
   Response handler adalah fungsi yang digunakan untuk membentuk output yang diharapkan kepada user dan beberapa properti selain data seperti status code dan header.

## Langkah Praktikum

> [!NOTE]
> menggunakan aplikasi lumenapi pada modul 4

### Model

1. Pastikan terdapat tabel users yang dibuat menggunakan migration pada bab sebelumnya. Berikut informasi kolom yang harus ada
   `id, createdAt, updatedAt, name, email, password`
   <br>![image](https://github.com/alviantaa/Praktikum/blob/main/Pemrograman_Integratif/Modul_6/screenshot/1.jpg)

2. Bersihkan isi app/Models/User.php yang ada sebelumnya dan isi dengan baris kode berikut

   ```
   <?php
   namespace App\Models;
   use Illuminate\Database\Eloquent\Model;
   class User extends Model {
       /**
       * The attributes that are mass assignable.
       *
       * @var array
       */
       protected $fillable = [
           'name', 'email', 'password'
       ];
       /**
       * The attributes excluded from the model's JSON form.
       *
       * @var array
       */
       protected $hidden = [];
   }
   ```

   <br>![image](https://github.com/alviantaa/Praktikum/blob/main/Pemrograman_Integratif/Modul_6/screenshot/2.jpg)

### Controller

1. Buatlah salinan ExampleController.php pada folder app/Http/Controllers dengan nama HomeController.php dan buatlah fungsi index() yang berisi

   ```
   <?php
   namespace App\Http\Controllers;
   class HomeController extends Controller{
       /**
       * Create a new controller instance.
       *
       * @return void
       */
       public function __construct()
       {
           //
       }
       public function index()
       {
           return 'Hello, from lumen!';
       }
   }
   ```

   <br>![image](https://github.com/alviantaa/Praktikum/blob/main/Pemrograman_Integratif/Modul_6/screenshot/3.jpg)

2. Ubah route '/' pada file routes/web.php menjadi seperti ini

   ```
   $router->get('/', function () use ($router) {
       return $router->app->version();
   });

   MENJADI

   $router->get('/', ['uses' => 'HomeController@index']);
   ```

   <br>![image](https://github.com/alviantaa/Praktikum/blob/main/Pemrograman_Integratif/Modul_6/screenshot/4.jpg)

3. Jalankan aplikasi
   <br>![image](https://github.com/alviantaa/Praktikum/blob/main/Pemrograman_Integratif/Modul_6/screenshot/5.jpg)

### request handler

1. Lakukan import library Request dengan menambahkan baris berikut di bagian atas file

   ```
   <?php
   namespace App\Http\Controllers;

   use Illuminate\Http\Request;     // Import Library Request
   ```

   <br>![image](https://github.com/alviantaa/Praktikum/blob/main/Pemrograman_Integratif/Modul_6/screenshot/6.jpg)

2. Ubah fungsi index menjadi

   ```
   <?php
   namespace App\Http\Controllers;
   use Illuminate\Http\Request;
   class HomeController extends Controller{
       /**
       * Create a new controller instance.
       *
       * @return void
       */
       public function __construct()
       {
       //
       }
       public function index (Request $request)
       {
           return 'Hello, from lumen! We got your request from endpoint: ' . $request->path();
       }
   }
   ```

   <br>![image](https://github.com/alviantaa/Praktikum/blob/main/Pemrograman_Integratif/Modul_6/screenshot/7.jpg)

3. Jalankan aplikasi
   <br>![image](https://github.com/alviantaa/Praktikum/blob/main/Pemrograman_Integratif/Modul_6/screenshot/8.jpg)

### Response Handler

1. Lakukan import library Response dengan menambahkan baris berikut di bagian atas file

   ```
   <?php
   namespace App\Http\Controllers;
   use Illuminate\Http\Request;
   use Illuminate\Http\Response;        // import library Response
   ```

   <br>![image](https://github.com/alviantaa/Praktikum/blob/main/Pemrograman_Integratif/Modul_6/screenshot/9.jpg)

2. Tambahkan fungsi hello() dalam controller HomeController.php

   ```
   public function hello()
   {
    $data['status'] = 'Success';
    $data['message'] = 'Hello, from lumen!';
    return (new Response($data, 201))->header('Content-Type', 'application/json');
    }
   ```

   <br>![image](https://github.com/alviantaa/Praktikum/blob/main/Pemrograman_Integratif/Modul_6/screenshot/10.jpg)

3. Tambahkan route /hello pada file routes/web.php

   ```
   $router->get('/hello', ['uses' => 'HomeController@hello']); // route hello
   ```

   <br>![image](https://github.com/alviantaa/Praktikum/blob/main/Pemrograman_Integratif/Modul_6/screenshot/11.jpg)

4. Jalankan aplikasi pada route /hello
   <br>![image](https://github.com/alviantaa/Praktikum/blob/main/Pemrograman_Integratif/Modul_6/screenshot/12.jpg)

## Penerapan

1. Lakukan import model User dengan menambahkan baris berikut di bagian atas file

   ```
   <?php
   namespace App\Http\Controllers;
   use Illuminate\Http\Request;
   use Illuminate\Http\Response;
   use App\Models\User;     // import model User
   ```

   <br>![image](https://github.com/alviantaa/Praktikum/blob/main/Pemrograman_Integratif/Modul_6/screenshot/13.jpg)

2. Tambahkan ketiga fungsi berikut di HomeController.php

   ```
    public function defaultUser()
    {
        $user = User::create([
            'name' => 'Nahida',
            'email' => 'nahida@akademiya.ac.id',
            'password' => 'smol'
        ]);

        return response()->json([
            'status' => 'Success',
            'message' => 'default user created',
            'data' => ['user' => $user,]
        ],200);
    }
    public function createUser(Request $request)
    {
        $name = $request->name;
        $email = $request->email;
        $password = $request->password;
        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => $password
        ]);

        return response()->json([
            'status' => 'Success',
            'message' => 'new user created',
            'data' => [
            'user' => $user,]
        ],200);
    }
    public function getUsers()
    {
        $users = User::all();
        return response()->json([
           'status' => 'Success',
           'message' => 'all users grabbed',
           'data' => [
           'users' => $users,
           ]
        ],200);
    }
   ```

   <br>![image](https://github.com/alviantaa/Praktikum/blob/main/Pemrograman_Integratif/Modul_6/screenshot/14.jpg)

3. Tambahkan ketiga route pada file routes/web.php menggunakan group route

   ```
   $router->group(['prefix' => 'users'], function () use ($router) {
   $router->post('/default', ['uses' => 'HomeController@defaultUser']);
   $router->post('/new', ['uses' => 'HomeController@createUser']);
   $router->get('/all', ['uses' => 'HomeController@getUsers']);
   });
   ```

   <br>![image](https://github.com/alviantaa/Praktikum/blob/main/Pemrograman_Integratif/Modul_6/screenshot/15.jpg)

4. Jalankan aplikasi pada route /users/default menggunakan Postman
   <br>![image](https://github.com/alviantaa/Praktikum/blob/main/Pemrograman_Integratif/Modul_6/screenshot/16.jpg)

5. Jalankan aplikasi pada route /users/new dengan mengisi body sebagai berikut
   <br>`name: cyno`
   <br>`email: cyno@akademiya.ac.id`
   <br>`password: mahamatra`
   <br>![image](https://github.com/alviantaa/Praktikum/blob/main/Pemrograman_Integratif/Modul_6/screenshot/17.jpg)

6. Jalankan aplikasi pada route /users/all
   <br>![image](https://github.com/alviantaa/Praktikum/blob/main/Pemrograman_Integratif/Modul_6/screenshot/18.jpg)
   <br>Data tersimpan dalam database
   <br>![image](https://github.com/alviantaa/Praktikum/blob/main/Pemrograman_Integratif/Modul_6/screenshot/19.jpg)
