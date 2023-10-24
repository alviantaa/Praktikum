# Relasi One-to-Many dan Many-to-Many

## Dasar Teori

1. Relasi
   Hubungan antar tabel yang dilakukan dengan pencocokan primary key dengan foreign key untuk mengombinasikan data dari satu tabel dengan tabel lainnya.
2. Foreign Key
   Properti yang digunakan untuk menandai hubungan dua tabel atau lebih. Foreign key pada tabel anak (child) akan menunjuk tabel induk (parent) yang menjadi referensinya (reference).
3. One-to-Many
   Relasi yang menunjukkan hubungan antar tabel dimana baris pada tabel induk dapat terhubung dengan satu atau lebih baris di tabel anak. Sementara baris pada tabel anak hanya dapat terhubung dengan satu baris di tabel induk.
   Contoh penerapan one-to-many

   - Satu tutorial dapat memiliki banyak komentar, namun satu komentar hanya dapat berada di satu tutorial
   - Satu dosbing dapat memiliki banyak mahasiswa, namun mahasiswa hanya dapat dibimbing satu dosen

4. Many-to-Many
   Relasi yang menunjukkan hubungan antar tabel dimana baris pada tabel induk dapat terhubung dengan satu atau lebih baris di tabel anak. Berlaku sebaliknya pada tabel anak yang dapat terhubung dengan satu atau lebih baris di tabel induk.
   Kombinasi baris pada relasi many-to-many diatur dengan junction table.
   Contoh penerapan many-to-many

   - Satu mahasiswa dapat mengambil banyak mata kuliah, namun satu mata kuliah dapat diambil banyak mahasiswa
   - Postingan dapat memiliki banyak tag, namun satu tag dapat dimiliki banyak postingan.

5. Junction Table
   Tabel yang digunakan untuk mengatur kombinasi baris pada relasi many-to-many. Junction table berisi foreign key dari kedua tabel yang memiliki relasi many-to-many.

## Langkah Praktikum

> [!NOTE]
> menggunakan aplikasi lumenapi pada modul 4

### Pembuatan Tabel

Tabel yang akan digunakan
<br>![image](https://github.com/alviantaa/Praktikum/blob/main/Pemrograman_Integratif/Modul_7/screenshot/1.jpg)

1. Sebelum membuat migrasi database atau membuat tabel pastikan server database aktif kemudian pastikan sudah membuat database dengan nama `lumenpost`
   <br>![image](https://github.com/alviantaa/Praktikum/blob/main/Pemrograman_Integratif/Modul_7/screenshot/2.jpg)

2. Kemudian ubah konfigurasi database pada file .env menjadi seperti berikut
   <br>![image](https://github.com/alviantaa/Praktikum/blob/main/Pemrograman_Integratif/Modul_7/screenshot/3.jpg)

3. Setelah mengubah konfigurasi pada file .env, kita juga perlu menghidupkan beberapa library bawaan dari lumen dengan membuka file app.php pada folder bootstrap dan mengubah baris ini
   <br>![image](https://github.com/alviantaa/Praktikum/blob/main/Pemrograman_Integratif/Modul_7/screenshot/4.jpg)

4. Setelah itu jalankan command berikut untuk membuat file migration

   ```
   php artisan make:migration create_posts_table
   php artisan make:migration create_comments_table
   php artisan make:migration create_tags_table
   php artisan make:migration create_post_tag_table
   ```

   <br>![image](https://github.com/alviantaa/Praktikum/blob/main/Pemrograman_Integratif/Modul_7/screenshot/5.jpg)

5. Ubah fungsi up() pada file migrasi create_posts_table

   ```
   public function up()
   {
   Schema::create('posts', function (Blueprint $table) {
           $table->id();
           $table->timestamps();
           $table->string('content');
       });
   }
   ```

   <br>![image](https://github.com/alviantaa/Praktikum/blob/main/Pemrograman_Integratif/Modul_7/screenshot/6.jpg)

6. Ubah fungsi up() pada file create_comments_table

   ```
   public function up()
   {
       Schema::create('comments', function (Blueprint $table) {
           $table->id();
           $table->timestamps();
           $table->string('review');
           $table->foreignId('postId')->unsigned();
       });
   }
   ```

   <br>![image](https://github.com/alviantaa/Praktikum/blob/main/Pemrograman_Integratif/Modul_7/screenshot/7.jpg)

7. Ubah fungsi up() pada file create_tags_table

   ```
   public function up()
       {
           Schema::create('tags', function (Blueprint $table) {
               $table->id();
               $table->timestamps();
               $table->string('name');
           });
       }
   ```

   <br>![image](https://github.com/alviantaa/Praktikum/blob/main/Pemrograman_Integratif/Modul_7/screenshot/8.jpg)

8. Ubah fungsi up() pada file create_post_tag_table

   ```
   public function up()
       {
           Schema::create('post_tag', function (Blueprint $table) {
               $table->id();
               $table->timestamps();
               $table->foreignId('postId')->unsigned();
               $table->foreignId('tagId')->unsigned();
           });
       }
   ```

   <br>![image](https://github.com/alviantaa/Praktikum/blob/main/Pemrograman_Integratif/Modul_7/screenshot/9.jpg)

9. Kemudian jalankan command `php artisan migrate`
   <br>![image](https://github.com/alviantaa/Praktikum/blob/main/Pemrograman_Integratif/Modul_7/screenshot/10.jpg)

### Pembuatan Model

1. Buatlah file dengan nama Post.php dan isi dengan baris kode berikut

   ```
   <?php
   namespace App\Models;
   use Illuminate\Database\Eloquent\Model;
   class Post extends Model
   {
       /**
       * The attributes that are mass assignable.
       *
       * @var string[]
       */
       protected $fillable = [
       'content'
       ];
       /**
       * The attributes excluded from the model's JSON form.
       *
       * @var string[]
       */
       protected $hidden = [];
   }
   ```

   <br>![image](https://github.com/alviantaa/Praktikum/blob/main/Pemrograman_Integratif/Modul_7/screenshot/11.jpg)

2. Buatlah file dengan nama Comment.php dan isi dengan baris kode berikut

   ```
   <?php
   namespace App\Models;
   use Illuminate\Database\Eloquent\Model;
   class Comment extends Model
   {
       /**
       * The attributes that are mass assignable.
       *
       * @var string[]
       */
       protected $fillable = [
       'review'
       ];
       /**
       * The attributes excluded from the model's JSON form.
       *
       * @var string[]
       */
       protected $hidden = [];
   }
   ```

   <br>![image](https://github.com/alviantaa/Praktikum/blob/main/Pemrograman_Integratif/Modul_7/screenshot/12.jpg)

3. Buatlah file dengan nama Tag.php dan isi dengan baris kode berikut

   ```
   <?php
   namespace App\Models;
   use Illuminate\Database\Eloquent\Model;
   class Tag extends Model
   {
       /**
       * The attributes that are mass assignable.
       *
       * @var string[]
       */
       protected $fillable = [
       'name'
       ];
       /**
       * The attributes excluded from the model's JSON form.
       *
       * @var string[]
       */
       protected $hidden = [];
   }
   ```

   <br>![image](https://github.com/alviantaa/Praktikum/blob/main/Pemrograman_Integratif/Modul_7/screenshot/13.jpg)

### Relasi One-to-Many

1. Tambahkan fungsi `comments()` pada file Post.php

   ```
   <?php
   namespace App\Models;
   use Illuminate\Database\Eloquent\Model;
   class Post extends Model
   {
       ...
       // fungsi comments
       public function comments()
       {
           return $this->hasMany(Comment::class, 'postId');
       }
   }
   ```

   <br>![image](https://github.com/alviantaa/Praktikum/blob/main/Pemrograman_Integratif/Modul_7/screenshot/14.jpg)

2. Tambahkan fungsi `post()` dan atribut postId pada $fillable pada file Comment.php

   ```
   <?php
   namespace App\Models;
   use Illuminate\Database\Eloquent\Model;
   class Comment extends Model
   {
       ...
       protected $fillable = [
           'review',
           'postId' // atribut postId
       ];
       /**
       * The attributes excluded from the model's JSON form.
       *
       * @var string[]
       */
       protected $hidden = [];
       public function post()
       {
           return $this->belongsTo(Post::class, 'postId');
       }
   }
   ```

   <br>![image](https://github.com/alviantaa/Praktikum/blob/main/Pemrograman_Integratif/Modul_7/screenshot/15.jpg)

3. Buatlah file PostController.php dan isilah dengan baris kode berikut

   ```
   <?php
   namespace App\Http\Controllers;
   use App\Models\Post;
   use Illuminate\Http\Request;
   class PostController extends Controller
   {
       /**
       * Create a new controller instance.
       *
       * @return void
       */
       public function __construct()
       {
       //
       }
       //
       public function createPost(Request $request)
       {
           $post = Post::create([
               'content' => $request->content,
           ]);
           return response()->json([
               'success' => true,
               'message' => 'New post created',
               'data' => [
               'post' => $post
               ]
           ]);
       }
       public function getPostById(Request $request)
       {
           $post = Post::find($request->id);
           return response()->json([
               'success' => true,
               'message' => 'All post grabbed',
               'data' => [
               'post' => [
               'id' => $post->id,
               'content' => $post->content,
               'comments' => $post->comments,
               ]
               ]
           ]);
       }
   }
   ```

   <br>![image](https://github.com/alviantaa/Praktikum/blob/main/Pemrograman_Integratif/Modul_7/screenshot/16.jpg)

4. Buatlah file CommentController.php dan isilah dengan baris kode berikut

   ```
   <?php
   namespace App\Http\Controllers;
   use App\Models\Comment;
   use Illuminate\Http\Request;
   class CommentController extends Controller
   {
       /**
       * Create a new controller instance.
       *
       * @return void
       */
       public function __construct()
       {
       //
       }
       //
       public function createComment(Request $request)
       {
           $comment = Comment::create([
               'review' => $request->review,
               'postId' => $request->postId,
           ]);
           return response()->json([
               'success' => true,
               'message' => 'New comment created',
               'data' => [
               'comment' => $comment
               ]
           ]);
       }
   }
   ```

   <br>![image](https://github.com/alviantaa/Praktikum/blob/main/Pemrograman_Integratif/Modul_7/screenshot/16a.jpg)

5. Tambahkan baris berikut pada routes/web.php

   ```
   $router->group(['prefix' => 'posts'], function () use ($router) {
       $router->post('/', ['uses' => 'PostController@createPost']);
       $router->get('/{id}', ['uses' => 'PostController@getPostById']);
   });
   $router->group(['prefix' => 'comments'], function () use ($router) {
       $router->post('/', ['uses' => 'CommentController@createComment']);
   });
   ```

   <br>![image](https://github.com/alviantaa/Praktikum/blob/main/Pemrograman_Integratif/Modul_7/screenshot/17.jpg)

6. Buatlah satu post menggunakan Postman
   POST /posts
   `content:Anak bunda sehat selalu`
   <br>![image](https://github.com/alviantaa/Praktikum/blob/main/Pemrograman_Integratif/Modul_7/screenshot/18.jpg)
7. Buatlah satu comment menggunakan Postman
   POST /comments
   `review:MasyaAllah bund`
   `PostId:1`
   <br>![image](https://github.com/alviantaa/Praktikum/blob/main/Pemrograman_Integratif/Modul_7/screenshot/19.jpg)
8. Tampilkan post menggunakan Postman
   GET /posts/1
   <br>![image](https://github.com/alviantaa/Praktikum/blob/main/Pemrograman_Integratif/Modul_7/screenshot/20.jpg)

### Relasi Many-to-Many

1. Tambahkan fungsi tags() pada file Post.php

   ```
   <?php
   namespace App\Models;
   use Illuminate\Database\Eloquent\Model;
   class Post extends Model
   {
       ...
       public function tags()
       {
           return $this->belongsToMany(Tag::class, 'post_tag', 'postId', 'tagId');
       }
   }
   ```

   <br>![image](https://github.com/alviantaa/Praktikum/blob/main/Pemrograman_Integratif/Modul_7/screenshot/21.jpg)

2. Tambahkan fungsi posts() pada file Tag.php

   ```
   <?php
   namespace App\Models;
   use Illuminate\Database\Eloquent\Model;
   class Tag extends Model
   {
       ...
       public function posts()
       {
           return $this->belongsToMany(Post::class, 'post_tag', 'tagId', 'postId');
       }
   }
   ```

   <br>![image](https://github.com/alviantaa/Praktikum/blob/main/Pemrograman_Integratif/Modul_7/screenshot/22.jpg)

3. Buatlah file TagController.php dan isilah dengan baris kode berikut

   ```
   <?php
   namespace App\Http\Controllers;
   use App\Models\Tag;
   use Illuminate\Http\Request;
   class TagController extends Controller
   {
       /**
       * Create a new controller instance.
       *
       * @return void
       */
       public function __construct()
       {
       //
       }
       //
       public function createTag(Request $request)
       {
           $tag = Tag::create([
               'name' => $request->name
           ]);
           return response()->json([
               'success' => true,
               'message' => 'New tag created',
               'data' => [
               'tag' => $tag
               ]
           ]);
       }
   }
   ```

   <br>![image](https://github.com/alviantaa/Praktikum/blob/main/Pemrograman_Integratif/Modul_7/screenshot/23.jpg)

4. Tambahkan fungsi addTag dan response tags pada PostController.php

   ```
   public function getPostById(Request $request)
   {
       $post = Post::find($request->id);
       return response()->json([
           'success' => true,
           'message' => 'All post grabbed',
           'data' => [
           'post' => [
           'id' => $post->id,
           'content' => $post->content,
           'comments' => $post->comments,
           'tags' => $post->tags, //response tags
           ]
           ]
       ]);
   }
   public function addTag(Request $request)
   {
       $post = Post::find($request->id);
       $post->tags()->attach($request->tagId);
       return response()->json([
           'success' => true,
           'message' => 'Tag added to post',
       ]);
   }
   ```

   <br>![image](https://github.com/alviantaa/Praktikum/blob/main/Pemrograman_Integratif/Modul_7/screenshot/24.jpg)

5. Tambahkan baris berikut pada routes/web.php

   ```
   $router->group(['prefix' => 'posts'], function () use ($router) {
       $router->post('/', ['uses' => 'PostController@createPost']);
       $router->get('/{id}', ['uses' => 'PostController@getPostById']);
       $router->put('/{id}/tag/{tagId}', ['uses' => 'PostController@addTag']); //tambahkan
   });
   ...
   $router->group(['prefix' => 'tags'], function () use ($router) {
       $router->post('/', ['uses' => 'TagController@createTag']);
   });
   ```

   <br>![image](https://github.com/alviantaa/Praktikum/blob/main/Pemrograman_Integratif/Modul_7/screenshot/25.jpg)

6. Buatlah satu tag menggunakan Postman
   POST /tags
   `name:Kenangan`
   <br>![image](https://github.com/alviantaa/Praktikum/blob/main/Pemrograman_Integratif/Modul_7/screenshot/26.jpg)

7. Tambahkan tag Kenangan pada post “Anak bunda sehat selalu”
   PUT /posts/1/tag/1
   <br>![image](https://github.com/alviantaa/Praktikum/blob/main/Pemrograman_Integratif/Modul_7/screenshot/27.jpg)

8. Tampilkan post “Anak bunda sehat selalu” menggunakan Postman
   GET /posts/1
   <br>![image](https://github.com/alviantaa/Praktikum/blob/main/Pemrograman_Integratif/Modul_7/screenshot/28.jpg)

9. Buatlah postingan baru menggunakan Postman
   POST /posts
   `content: Tamasya di Singapore`
   <br>![image](https://github.com/alviantaa/Praktikum/blob/main/Pemrograman_Integratif/Modul_7/screenshot/29.jpg)

10. Tambahkan tag "kenangan" pada postingan “Tamasya di Singapore”
    PUT /posts/2/tag/1
    <br>![image](https://github.com/alviantaa/Praktikum/blob/main/Pemrograman_Integratif/Modul_7/screenshot/30.jpg)

11. Buatlah tag "gembira" menggunakan Postman
    POST /tags
    `name:gembira`
    <br>![image](https://github.com/alviantaa/Praktikum/blob/main/Pemrograman_Integratif/Modul_7/screenshot/31.jpg)

12. Tambahkan tag "gembira” pada postingan "Tamasya di Singapore”
    PUT /posts/2/tag/2
    <br>![image](https://github.com/alviantaa/Praktikum/blob/main/Pemrograman_Integratif/Modul_7/screenshot/32.jpg)

13. Tampilkan post pertama
    GET /posts/1
    <br>![image](https://github.com/alviantaa/Praktikum/blob/main/Pemrograman_Integratif/Modul_7/screenshot/33.jpg)

14. Tampilkan post kedua
    GET /posts/2
    <br>![image](https://github.com/alviantaa/Praktikum/blob/main/Pemrograman_Integratif/Modul_7/screenshot/34.jpg)
