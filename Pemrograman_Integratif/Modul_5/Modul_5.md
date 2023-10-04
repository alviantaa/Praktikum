# Dynamic Route dan Middleware

## Langkah Praktikum

> [!NOTE]
> menggunakan aplikasi lumenapi pada modul 4

### Dynamic Route

Dynamic route adalah route yang dapat berubah-ubah, contohnya pada saat kita membukasuatu halaman web, kadang kita melihat `/users/1` atau `/users/2`, hal ini yang dinamakan dynamic routes.
Untuk menambahkan dynamic routes pada aplikasi lumen kita, kita dapat menggunakan syntax berikut,

```
$router->get('/user/{id}', function ($id) {
    return 'User Id = ' . $id;
});
```

<br>![image](https://github.com/alviantaa/Praktikum/blob/main/Pemrograman_Integratif/Modul_5/screenshot/1.jpg)
<br>![image](https://github.com/alviantaa/Praktikum/blob/main/Pemrograman_Integratif/Modul_5/screenshot/9.jpg)

Saat menambahkan parameter pada routes, kita tidak terbatas pada 1 variable saja, namun kita dapat menambahkan sebanyak yang diperlukan seperti kode berikut,

```
$router->get('/post/{postId}/comments/{commentId}', function ($postId, $commentId) {
    return 'Post ID = ' . $postId . ' Comments ID = ' . $commentId;
});
```

<br>![image](https://github.com/alviantaa/Praktikum/blob/main/Pemrograman_Integratif/Modul_5/screenshot/2.jpg)
<br>![image](https://github.com/alviantaa/Praktikum/blob/main/Pemrograman_Integratif/Modul_5/screenshot/10.jpg)

Pada dynamic routes kita juga bisa menambahkan optional routes, yang mana optional routes tidak mengharuskan kita untuk memberi variable pada endpoint kita, namun saat kita memanggil endpoint, dapat menggunakan parameter variable ataupun tidak, seperti pada kode dibawah ini,

```
$router->get('/users[/{userId}]', function ($userId = null) {
    return $userId === null ? 'Data semua users' : 'Data user dengan id ' . $userId;
});
```

<br>![image](https://github.com/alviantaa/Praktikum/blob/main/Pemrograman_Integratif/Modul_5/screenshot/3.jpg)
hasil ketika mengakses endpoint /users
<br>![image](https://github.com/alviantaa/Praktikum/blob/main/Pemrograman_Integratif/Modul_5/screenshot/11.jpg)
hasil ketika mengakses endpoint /users/1
<br>![image](https://github.com/alviantaa/Praktikum/blob/main/Pemrograman_Integratif/Modul_5/screenshot/12.jpg)

### Aliases Route

Aliases Route digunakan untuk memberi nama pada route yang telah kita buat, hal ini dapat membantu kita, saat kita ingin memanggil route tersebut pada aplikasi kita. Berikut syntax untuk menambahkan aliases route

```
$router->get('/auth/login', ['as' => 'route.auth.login', function ($a) {
    return 'Login page';
}]);
...
$router->get('/profile', function (Request $request) {
    if ($request->isLoggedIn) {
        return redirect()->route('route.auth.login');
    }
});
```

<br>![image](https://github.com/alviantaa/Praktikum/blob/main/Pemrograman_Integratif/Modul_5/screenshot/4.jpg)
ketika mengakses endpoint /profile, otomatis redirect ke /auth/login (a.k.a route.auth.login)
<br>![image](https://github.com/alviantaa/Praktikum/blob/main/Pemrograman_Integratif/Modul_5/screenshot/13.jpg)

### Group Route

Pada lumen, kita juga dapat memberikan grouping pada routes kita agar lebih mudah pada saat penulisan route pada web.php kita. Kita dapat melakukan grouping dengan menggunakan syntax berikut,

```
$router->group(['prefix' => 'users'], function () use ($router) {
    $router->get('/', function () {         #path memiliki prefix, menjadi /users/<endpoint> secara default
        return "GET /users";
    });
});
```

<br>![image](https://github.com/alviantaa/Praktikum/blob/main/Pemrograman_Integratif/Modul_5/screenshot/5.jpg)
<br>![image](https://github.com/alviantaa/Praktikum/blob/main/Pemrograman_Integratif/Modul_5/screenshot/14.jpg)

Selain dapat mengelompokkan prefix, kita juga dapat mengelompokkan middleware dan
namespace pada kelompok routes kita.

### Middleware

Middleware adalah penengah antara komunikasi aplikasi dan client. Middleware biasanya digunakan untuk membatasi siapa yang dapat berinteraksi dengan aplikasi kita dan semacamnya, kita dapat menambahkan middleware dengan menambahkan file pada folder `app/Http/Middleware`. Pada folder tersebut terdapat file `ExampleMiddleware` , kita dapat mencopy file tersebut untuk membuat middleware baru. Pada praktikum kali ini akan dibuat middleware Age dengan isi,

```
<?php
namespace App\Http\Middleware;
use Closure;
class AgeMiddleware{
    /**
    * Handle an incoming request.
    *
    * @param \Illuminate\Http\Request $request
    * @param \Closure $next
    * @return mixed
    */
    public function handle($request, Closure $next){
        if ($request->age < 17)
            return redirect('/fail');
        return $next($request);
    }
}
```

<br>![image](https://github.com/alviantaa/Praktikum/blob/main/Pemrograman_Integratif/Modul_5/screenshot/6.jpg)

Setelah menambahkan filter pada AgeMiddleware , kita harus mendaftarkan
AgeMiddleware pada aplikasi kita, pada file `bootstrap/app.php` seperti berikut ini,

```
...
1   // $app->middleware([
2   //      App\Http\Middleware\ExampleMiddleware::class
3   // ]);
4
5   $app->routeMiddleware([
6       // 'auth' => App\Http\Middleware\Authenticate::class,
7       'age' => App\Http\Middleware\AgeMiddleware::class
8   ]);
```

<br>![image](https://github.com/alviantaa/Praktikum/blob/main/Pemrograman_Integratif/Modul_5/screenshot/7.jpg)

Untuk menambahkan middleware pada aplikasi kita, kita dapat uncomment baris 1-3, kemudian menambahkan age middleware ke dalamnya.
Namun, karena kita hanya ingin menambahkan middleware pada route tertentu, kita akan menghapus comment pada baris 5-7, kemudian menambahkan middleware age di dalamnya.
Lalu, kita dapat menambahkan middleware pada routes kita dengan menambahkan opsi middleware pada salah satu route, contohnya,

```
$router->get('/admin/home/', ['middleware' => 'age', function () {
    return 'Dewasa';
}]);

$router->get('/fail', function () {
    return 'Dibawah umur';
});
```

<br>![image](https://github.com/alviantaa/Praktikum/blob/main/Pemrograman_Integratif/Modul_5/screenshot/8.jpg)
ketika dalam middleware class, age dalam if diubah menjadi lebih dari 17
<br>![image](https://github.com/alviantaa/Praktikum/blob/main/Pemrograman_Integratif/Modul_5/screenshot/16.jpg)
ketika dalam middleware class, age dalam if diubah menjadi kurang dari 17
<br>![image](https://github.com/alviantaa/Praktikum/blob/main/Pemrograman_Integratif/Modul_5/screenshot/16.jpg)
