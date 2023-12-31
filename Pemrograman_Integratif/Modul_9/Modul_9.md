# JSON Web Token (JWT)

## Dasar teori

JSON Web Token
<br> JSON Web Token (JWT) adalah standar terbuka yang mendefinisikan cara ringkas dan mandiri untuk transmisi informasi antar pihak secara aman dalam bentuk objek JSON. Informasi ini dapat diverifikasi karena ditandatangani secara digital menggunakan secret key (dengan algoritma HMAC) atau pasangan kunci publik/pribadi menggunakan RSA atau ECSDA

Penggunaan

- Authorization
  Setelah user masuk, setiap request perlu menyertakan. Hal ini mengizinkan user untuk mengakses route, service, dan resource yang diizinkan menggunakan token.

- Information Exchange
  JWT dapat digunakan untuk mengamankan transmisi data antar pihak. Hal ini dimungkinkan karena JWT dapat ditandatangani untuk memastikan data dikirimkan oleh pengirim yang benar. Penggunaan signature yang dihitung dengan header dan payload dapat memverifikasi data yang dikirimkan tidak diubah di tengah jalan.

Struktur
JSON Web Token menggunakan pola berikut. Header, payload, signature dipisahkan dengan titik.
`xxxxx.yyyyy.zzzzz`

- Header
  Berisi algoritma yang digunakan serta jenis token.

  ```
  {
  "alg": "HS256",
  "typ": "JWT"
  }
  ```

  Data di atas akan di-encode menjadi Base64
  `eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9`

- Payload
  Berisi data yang ditransmisikan. Walaupun JWT memastikan dapat yang dikirim tidak diubah, Base64 yang digunakan dapat
  di-decode. Hal ini membuat JWT tidak dapat digunakan untuk transmisi data rahasia seperti plain text password.

  ```
  {
  "sub": "1234567890",
  "name": "Nilou",
  "iat": 1516239022
  }
  ```

  Data di atas akan di-encode menjadi Base64
  `eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6Ik5pbG91IiwiaWF0IjoxNTE2MjM5MDIyfQ`

- Signature
  Hasil penandatanganan yang dilakukan dengan header dan payload yang sudah di-encode diikuti dengan secret key menggunakan algoritma yang didefinisikan di header.
  Proses penandatanganan menggunakan rumus sebagai berikut
  ```
  HMACSHA256(
  base64UrlEncode(header) + "." +
  base64UrlEncode(payload),
  secret)
  ```
  Yang menghasilkan signature sebagai berikut
  `58_9vUl1BQN7Fpqs7u7r4tyJC_wvFJ5n4GibGTVnGpU`

## Langkah Percobaan

> [!NOTE]
> menggunakan aplikasi lumenapi pada modul 4

Penyesuaian Database

1. Lakukan perubahan pada length kolom token dengan menghapus parameter 72 di belakangnya

   ```
   public function up()
   {
   Schema::table('users', function (Blueprint $table) {
       $table->string('token')->unique()->nullable();
   });
   }
   ```

   <br>![Screenshot register](screenshot/1.jpg)

2. Jalankan perintah di bawah untuk memperbaharui migrasi dan menghapus data yang lama
   `php artisan migrate:fresh`
   <br>![Screenshot register](screenshot/2.jpg)
3. Jalankan aplikasi pada endpoint /auth/register dengan body berikut.

   ```
   {
       "name": "Scaramouche",
       "email": "scaramouche@fatui.org",
       "password": "wanderer"
   }
   ```

   <br>![Screenshot register](screenshot/3.jpg)

### JWT Manual

1. Tambahkan ketiga fungsi berikut pada AuthController.php

   ```
   <?php
   namespace App\Http\Controllers;
   use App\Models\User;
   use Illuminate\Http\Request;
   use Illuminate\Support\Facades\Hash;
   use Illuminate\Support\Str;
   class AuthController extends Controller
   {
   ...
   private function base64url_encode(String $data): String
       {
           $base64 = base64_encode($data); // ubah json string menjadi base64
           $base64url = strtr($base64, '+/', '-_'); // ubah char '+' -> '-' dan '/' -> '_'
           return rtrim($base64url, '='); // menghilangkan '=' pada akhir string
       }

       private function sign(String $header, String $payload, String $secret): String
       {
           $signature = hash_hmac('sha256', "{$header}.{$payload}", $secret, true);
           $signature_base64url = $this->base64url_encode($signature);
           return $signature_base64url;
       }

       private function jwt(array $header, array $payload, String $secret): String
       {
           $header_json = json_encode($header);
           $payload_json = json_encode($payload);
           $header_base64url = $this->base64url_encode($header_json);
           $payload_base64url = $this->base64url_encode($payload_json);
           $signature_base64url = $this->sign($header_base64url, $payload_base64url, $secret);
           $jwt = "{$header_base64url}.{$payload_base64url}.{$signature_base64url}";
           return $jwt;
       }
   }
   ```

   <br>![Screenshot register](screenshot/4.jpg)

2. Lakukan perubahan pada fungsi login

   ```
   <?php
   namespace App\Http\Controllers;
   use App\Models\User;
   use Illuminate\Http\Request;
   use Illuminate\Support\Facades\Hash;
   use Illuminate\Support\Str;
   class AuthController extends Controller
   {
   ...
   public function login(Request $request)
       {
           $email = $request->email;
           $password = $request->password;
           $user = User::where('email', $email)->first();
           if (!$user) {
               return response()->json([
               'status' => 'Error',
               'message' => 'user not exist',
               ],404);
           }
           if (!Hash::check($password, $user->password)) {
               return response()->json([
               'status' => 'Error',
               'message' => 'wrong password',
               ],400);
           }
           $jwt = $this->jwt(
               ['alg' => 'HS256','typ' => 'JWT'],
               ['id' => $user->id,],'secret'
           );
           $user->token = $jwt;
           $user->save();
           return response()->json([
               'status' => 'Success',
               'message' => 'successfully login',
               'data' => [
                   'user' => $user,
               ]
           ],200);
       }
   ...
   }
   ```

   <br>![Screenshot register](screenshot/5.jpg)

3. Tambahkan keempat fungsi berikut pada Middleware/Authorization.php

   ```
   <?php
   namespace App\Http\Middleware;
   use App\Models\User;
   use Closure;
   class Authorization
   {
   ...
   private function base64url_encode(string $data): string
       {
           $base64 = base64_encode($data);
           $base64url = strtr($base64, '+/', '-_');
           return rtrim($base64url, '=');
       }

       private function base64url_decode(string $base64url): string
       {
           $base64 = strtr($base64url, '-_', '+/');
           $json = base64_decode($base64);
           return $json;
       }

       private function sign(string $header_base64url, string $payload_base64url, string $secret): string
       {
           $signature = hash_hmac('sha256', "{$header_base64url}.{$payload_base64url}", $secret, true);
           $signature_base64url = $this->base64url_encode($signature);
           return $signature_base64url;
       }
       private function verify(string $signature_base64url, string $header_base64url, string $payload_base64url, string $secret): bool
       {
           $signature = $this->base64url_decode($signature_base64url);
           $expected_signature = $this->base64url_decode($this->sign($header_base64url, $payload_base64url, $secret));
           return hash_equals($expected_signature, $signature);
       }
   }
   ```

   <br>![Screenshot register](screenshot/6.jpg)

4. Lakukan perubahan pada fungsi handle

   ```
   <?php
   namespace App\Http\Middleware;
   use App\Models\User;
   use Closure;
   class Authorization
   {
   public function handle($request, Closure $next)
       {
           $token = $request->header('token') ?? $request->query('token');
           if (!$token) {
               return response()->json([
               'status' => 'Error',
               'message' => 'token not provided',
               ],400);
           }

           [
           $header_base64url,
           $payload_base64url,
           $signature_base64url
           ] = explode('.', $token);

           $header = $this->base64url_decode($header_base64url);
           $json_header = json_decode($header);
           if (!$json_header->alg || $json_header->alg !== 'HS256') {
               return response()->json([
               'status' => 'Error',
               'message' => 'type of token not valid',
               ],401);
           }
           if (!$json_header->typ || $json_header->typ !== 'JWT') {
               return response()->json([
               'status' => 'Error',
               'message' => 'type of token not valid',
               ],401);
           }
           $payload = $this->base64url_decode($payload_base64url);
           $json_payload = json_decode($payload);
           if (!$json_payload->id) {
               return response()->json([
               'status' => 'Error',
               'message' => 'invalid token',
               ],400);;
           }
           $verified = $this->verify($signature_base64url, $header_base64url, $payload_base64url, 'secret');
           if (!$verified) {
               return response()->json([
               'status' => 'Error',
               'message' => 'invalid sign token',
               ],400);;
           }
           $id = $json_payload->id;
           $user = User::where('id', $id)->first();

           if (!$user) {
               return response()->json([
               'status' => 'Error',
               'message' => 'invalid token',
               ],400);
           }
           $request->user = $user;
           return $next($request);
       }
   ...
   }
   ```

   <br>![Screenshot register](screenshot/7.jpg)

5. Jalankan aplikasi pada endpoint /auth/login dengan body berikut. Salinlah token yang didapat ke notepad

   ```
   {
       "email": "scaramouche@fatui.org",
       "password": "wanderer"
   }
   ```

   <br>![Screenshot register](screenshot/8.jpg)

6. Jalankan aplikasi pada endpoint /home dengan melampirkan nilai token yang didapat setelah login pada header
   <br>![Screenshot register](screenshot/9.jpg)

### JWT Library

1. Lakukan generate jwt key secara online menggunakan website Djecrety ― Django Secret Key Generator
   <br>![Screenshot register](screenshot/10.jpg)
   Setelah mendapatkan secret key kita akan memasukkan secret key tersebut pada file .env dengan membuat variable baru
   bernama JWT_SECRET
   <br>![Screenshot register](screenshot/11.jpg)

2. Lakukan instalasi package jwt firebase dengan menggunakan command berikut
   composer require firebase/php-jwt
   <br>![Screenshot register](screenshot/12.jpg)
3. Tambahkan fungsi berikut pada file AuthController

   ```
   <?php
   use Firebase\JWT\JWT;

   class AuthController extends Controller
   {
       public function __construct(Request $request)
       {
           $this->request = $request;
       }
       protected function jwt(User $user)
       {
           $payload = [
               'iss' => 'lumen-jwt', //issuer of the token
               'sub' => $user->id, //subject of the token
               'iat' => time(), //time when JWT was issued.
               'exp' => time() + 60 * 60 //time when JWT will expire
           ];
           return JWT::encode($payload, env('JWT_SECRET'), 'HS256');
       }
   }
   ```

   <br>![Screenshot register](screenshot/13.jpg)

4. Lakukan perubahan pada fungsi login menjadi seperti berikut

   ```
   <?php
   use Firebase\JWT\JWT;
   class AuthController extends Controller
   {
   ...
   public function login(Request $request)
       {
           $email = $request->email;
           $password = $request->password;
           $user = User::where('email', $email)->first();
           if (!$user) {
               return response()->json([
               'status' => 'Error',
               'message' => 'user not exist',
               ], 404);
           }
           if (!Hash::check($password, $user->password)) {
               return response()->json([
               'status' => 'Error',
               'message' => 'wrong password',
               ], 400);
           }
           $user->token = $this->jwt($user); //
           $user->save();
           return response()->json([
               'status' => 'Success',
               'message' => 'successfully login',
               'data' => [
                   'user' => $user,
               ]
           ], 200);
       }
   }
   ```

   <br>![Screenshot register](screenshot/14.jpg)

5. Buatlah file JwtMiddleware.php dan isikan baris code berikut

   ```
   <?php

   namespace App\Http\Middleware;
   use Closure;
   use Exception;
   use App\Models\User;
   use Firebase\JWT\JWT;
   use Firebase\JWT\Key;
   use Firebase\JWT\ExpiredException;

   class JwtMiddleware
   {
       function handle($request, Closure $next, $guard = null)
       {
           $token = $request->header('token') ?? $request->query('token');
           // $token = $request->get('token');
           if (!$token) {
               //Unauthorized response if token not there
               return response()->json([
               'error' => 'Token not provded.'
               ], 401);
           }
           try {
               $credentials =
               JWT::decode($token, new Key(env('JWT_SECRET'), 'HS256'));
           } catch (ExpiredException $e) {
               return response()->json([
               'error' => 'Provided token is expired.'
               ], 400);
           } catch (Exception $e) {
               return response()->json([
               'error' => 'An error while decoding token.'
               ], 400);
           }
           $user = User::find($credentials->sub);
           $request->user = $user;
           return $next($request);
       }
   }
   ```

   <br>![Screenshot register](screenshot/15.jpg)

6. Daftarkan middleware yang telah dibuat pada bootstrap/app.php

   ```
   $app->routeMiddleware([
   'jwt.auth' => App\Http\Middleware\JwtMiddleware::class,
   ]);
   ```

   <br>![Screenshot register](screenshot/16.jpg)

7. Tambahkan baris berikut pada file web.php

   ```
   $router->get('/home', ['middleware' => 'jwt.auth', 'uses' => 'HomeController@home']);
   ```

   <br>![Screenshot register](screenshot/17.jpg)

8. Jalankan aplikasi pada endpoint /auth/login dengan body berikut. Salinlah token yang didapat ke notepad

   ```
   {
       "email": "scaramouche@fatui.org",
       "password": "wanderer"
   }
   ```

   <br>![Screenshot register](screenshot/18.jpg)

9. Jalankan aplikasi pada endpoint /home dengan melampirkan nilai token yang didapat setelah login pada header
   <br>![Screenshot register](screenshot/19.jpg)
