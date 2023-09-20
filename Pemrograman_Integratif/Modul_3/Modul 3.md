# Integrasi MongoDB dan Express

## Dasar Teori

### Express

> Express.js adalah framework web app untuk Node.js yang ditulis dengan bahasa pemrograman JavaScript. Framework open source ini dibuat oleh TJ Holowaychuk pada tahun 2010 lalu. Express.js adalah framework back end. Artinya, ia bertanggung jawab untuk mengatur fungsionalitas website, seperti pengelolaan routing dan session, permintaan HTTP,penanganan error, serta pertukaran data di server.

### Mongoose

> Mongoose adalah pustaka berbasis Node.js yang digunakan untuk pemodelan data pada MongoDB. Mongoose menyediakan feature diantaranya, model data application berbasis Schema. Dan juga termasuk built-in type casting, validation, query building,business logic hooks dan masih banyak lagi yang menjadi ke andalan mongoose.

### Async Await

> Async sendiri merupakan sebuah fungsi yang mengembalikan sebuah Promise. Await sendiri merupakan fungsi yang hanya berjalan di dalam Async. Await bertujuan untuk menunda jalannya Async hingga proses dari Await tersebut berhasil dieksekusi.

### Model

> Model merupakan bagian yang bertugas untuk menyiapkan, mengatur, memanipulasi, dan mengorganisasikan data yang ada di database.

### Controller

> Controller merupakan bagian yang menjadi tempat berkumpulnya logika pemrograman yang digunakan untuk memisahkan organisasi data pada database. Dalam beberapa kasus, controller menjadi penghubung antara model dan view pada arsitektur MVC

### Route

> Router mengatur pintu masuk yang berupa request pada aplikasi, mereka memilah dan mengolah request url untuk kemudian diproses sesuai dengan tujuan akhir url tersebut. Bisa jadi url tersebut berfungsi untuk mengambil data kemudian menampilkannya,menghapus data, menampilkan form, sampai mengolah session.

## Langkah Praktikum

### Instalasi NodeJS

1. Memeriksa apakah NodeJS telah terinstall menggunakan `node -v`
   <br>![image](https://github.com/alviantaa/Praktikum/blob/main/Pemrograman_Integratif/Modul_3/screenshot/1.png)
2. Apabila belum terdapat NodeJS, dapat di download dan diinstal terlebih dahulu

### Inisiasi project Express dan pemasangan package

1. Lakukan pembuatan folder dengan nama express-mongodb dan masuk ke dalam folder tersebut lalu buka melalui text editor masing-masing
2. Lakukan npm init untuk mengenerate file package.json dengan menggunakan command

   ```
   npm init -y
   ```

   <br>![image](https://github.com/alviantaa/Praktikum/blob/main/Pemrograman_Integratif/Modul_3/screenshot/2.png)

3. Lakukan instalasi express, mongoose, dan dotenv dengan menggunakan command

   ```
   npm i express mongoose dotenv
   ```

   <br>![image](https://github.com/alviantaa/Praktikum/blob/main/Pemrograman_Integratif/Modul_3/screenshot/3.png)

### Koneksi Express ke MongoDB (VSCode)

1. Buatlah file index.js pada root folder dan masukkan kode di bawah ini

   ```
   require('dotenv').config();
   const express = require('express');
   const mongoose = require('mongoose');

   const app = express();

   app.use(express.json());

   app.get('/', (req, res) => {
       res.status(200).json({
           message: '<nama>,<nim>'
       })
   })

   const PORT = 8000;
   app.listen(PORT, () => {
       console.log(`Running on port ${PORT}`);
   })
   ```

   <br>![image](https://github.com/alviantaa/Praktikum/blob/main/Pemrograman_Integratif/Modul_3/screenshot/4.png)

   Kemudian jalankan aplikasi menggunakan command

   ```
   node index.js
   ```

   <br>![image](https://github.com/alviantaa/Praktikum/blob/main/Pemrograman_Integratif/Modul_3/screenshot/5.png)

   > [!NOTE]
   > Dikarenakan tidak menggunakan nodemon, maka setiap terdapat perubahan file, diharuskan untuk melakukan restrart server node terlebih dahulu dengan cara CTRL+C dan jalankan node index.js kembali. 2. Lakukan pembuatan file .env dan masukkan baris berikut

   ```
   PORT=5000
   ```

   <br>![image](https://github.com/alviantaa/Praktikum/blob/main/Pemrograman_Integratif/Modul_3/screenshot/6.png)

   kemudian ubah kode listening port pada file index.env dan jalankan kembali

   ```
   const PORT = process.env.PORT || 8000;
   app.listen(PORT, () => {
       console.log(`Running on port ${PORT}`);
   })
   ```

   <br>![image](https://github.com/alviantaa/Praktikum/blob/main/Pemrograman_Integratif/Modul_3/screenshot/7.png)
   <br>![image](https://github.com/alviantaa/Praktikum/blob/main/Pemrograman_Integratif/Modul_3/screenshot/8.png)

2. Copy connection string yang terdapat pada compas atau atlas dan paste kan pada .env seperti berikut

   ```
   MONGO_URI = Connection string masing-masing
   ```

   <br>![image](https://github.com/alviantaa/Praktikum/blob/main/Pemrograman_Integratif/Modul_3/screenshot/9.png)

3. Tambahkan baris kode berikut pada file index.js

   ```
   require('dotenv').config();
   const express = require('express');
   const mongoose = require('mongoose');

   mongoose.connect(process.env.MONGO_URI);
   const db = mongoose.connection;

   db.on('error', (error) => {
       console.log(error);
   });

   db.once('connected', () => {
       console.log('Mongo connected');
   })
   ...
   ```

   <br>![image](https://github.com/alviantaa/Praktikum/blob/main/Pemrograman_Integratif/Modul_3/screenshot/10.png)
   <br>Coba jalankan aplikasi kembali
   <br>![image](https://github.com/alviantaa/Praktikum/blob/main/Pemrograman_Integratif/Modul_3/screenshot/11.png)

### Pembuatan routing

1. Pembuatan directory routes di tingkat yang sama dengan index.js
2. Buatlah file book.route.js di dalamnya
   <br>![image](https://github.com/alviantaa/Praktikum/blob/main/Pemrograman_Integratif/Modul_3/screenshot/12.png)

3. Tambahkan baris kode berikut untuk fungsi getAllBooks

   ```
   const router = require('express').Router();

   router.get('/', function getAllBooks(req, res) {
       res.status(200).json({
           message: 'mendapatkan semua buku'
       })
   })

   module.exports = router;
   ```

4. Lakukan hal yang sama untuk getOneBook, createBook, updateBook, dan deleteBook

   ```
   const router = require('express').Router();
   ...

   router.get('/:id', function getOneBook(req, res) {
       const id = req.params.id;
       res.status(200).json({
           message: 'mendapatkan satu buku',id,
           })
   })

   router.post('/', function createBook(req, res) {
       res.status(200).json({
           message: 'membuat buku baru'
       })
   })

   router.put('/:id', function updateBook(req, res) {
       const id = req.params.id;
       res.status(200).json({
       message: 'memperbaharui satu buku',id,
       })
   })

   router.delete('/:id', function deleteBook(req, res) {
       const id = req.params.id;
       res.status(200).json({
           message: 'menghapus satu buku',id,
       })
   })

   module.exports = router;
   ```

   <br>![image](https://github.com/alviantaa/Praktikum/blob/main/Pemrograman_Integratif/Modul_3/screenshot/13.png)

5. Lakukan import book.route.js pada file index.js dan tambahkan baris kode berikut

   ```
   require('dotenv').config();
   const express = require('express');
   const mongoose = require('mongoose');
   const bookRoutes = require('./routes/book.route'); //

   ...

   app.get('/', (req, res) => {
       res.status(200).json({
           message: '<nama>,<nim>'
       })
   })

   app.use('/books', bookRoutes); //

   const PORT = process.env.PORT || 8000;
   app.listen(PORT, () => {
       console.log(`Running on port ${PORT}`);
   })
   ```

   <br>![image](https://github.com/alviantaa/Praktikum/blob/main/Pemrograman_Integratif/Modul_3/screenshot/14.png)

6. Uji salah satu endpoint menggunakan Postman
   <br>![image](https://github.com/alviantaa/Praktikum/blob/main/Pemrograman_Integratif/Modul_3/screenshot/15.png)

### Pembuatan controller

1. Lakukan pembuatan direktori controllers di tingkat yang sama dengan index.js
2. Buatlah file book.controller.js di dalamnya
3. Uji salah satu endpoint menggunakan Postman
   <br>![image](https://github.com/alviantaa/Praktikum/blob/main/Pemrograman_Integratif/Modul_3/screenshot/1-1.png)

4. Salin baris kode dari routes untuk fungsi getAllBooks

   ```
   function getAllBooks(req, res) {
       res.status(200).json({
       message: 'mendapatkan semua buku'
       })
   };

   module.exports = {
       getAllBooks,
   }
   ```

5. Lakukan hal yang sama untuk getOneBook, createBook, updateBook, dan deleteBook

   ```
   ...
   function getOneBook(req, res) {
       const id = req.params.id;
       res.status(200).json({
           message: 'mendapatkan satu buku',id,
       })
   }

   function createBook(req, res) {
       res.status(200).json({
           message: 'membuat buku baru'
       })
   }

   function updateBook(req, res) {
       const id = req.params.id;
       res.status(200).json({
           message: 'memperbaharui satu buku',id,
       })
   }

   function deleteBook(req, res) {
       const id = req.params.id;
       res.status(200).json({
           message: 'menghapus satu buku',id,
       })
   }

   module.exports = {
   getAllBooks,
   getOneBook, //
   createBook, //
   updateBook, //
   deleteBook //
   }
   ```

   <br>![image](https://github.com/alviantaa/Praktikum/blob/main/Pemrograman_Integratif/Modul_3/screenshot/1-2.png)

6. Lakukan import book.controller.js pada file book.route.js

   ```
   const router = require('express').Router();
   const book = require('../controllers/book.controller'); //
   ...
   module.exports = router;
   ```

   <br>![image](https://github.com/alviantaa/Praktikum/blob/main/Pemrograman_Integratif/Modul_3/screenshot/1-3.png)

7. Lakukan perubahan pada book.route agar dapat memanggil fungsi dari book.controller.js

   ```
   const router = require('express').Router();
   const book = require('../controllers/book.controller');

   router.get('/', book.getAllBooks);
   router.get('/:id', book.getOneBook);
   router.post('/', book.createBook);
   router.put('/:id', book.updateBook);
   router.delete('/:id', book.deleteBook);
   module.exports = router;
   ```

   <br>![image](https://github.com/alviantaa/Praktikum/blob/main/Pemrograman_Integratif/Modul_3/screenshot/1-4.png)

8. Lakukan pengujian kembali, pastikan response tetap sama
   <br>![image](https://github.com/alviantaa/Praktikum/blob/main/Pemrograman_Integratif/Modul_3/screenshot/1-5.png)

### Pembuatan Model

1. Lakukan pembuatan direktori models di tingkat yang sama dengan index.js
2. Buatlah file book.model.js di dalamnya
3. Tambahkan baris kode berikut sesuai dengan tabel di atas

```
const mongoose = require('mongoose');
const bookSchema = new mongoose.Schema({
    title: {
        type: String
    },
    author: {
        type: String
    },
    year: {
        type: Number
    },
    pages: {
        type: Number
    },
    summary: {
        type: String
    },
    publisher: {
        type: String
    }
})
module.exports = mongoose.model('book', bookSchema);
```

### Operasi CRUD

1. Hapus semua data pada collection books
2. Lakukan import book.model.js pada file book.controller.js

```
const Book = require('../models/book.model');
...
```

3. Lakukan perubahan pada fungsi createBook

```
const Book = require('../models/book.model');
...
async function createBook(req, res) {
    const book = new Book({
        title: req.body.title,
        author: req.body.author,
        year: req.body.year,
        pages: req.body.pages,
        summary: req.body.summary,
        publisher: req.body.publisher,
    })
    try {
        const savedBook = await book.save();
        res.status(200).json({
            message: 'membuat buku baru',
            book: savedBook,
        })
    } catch (error) {
        res.status(500).json({
        message: 'kesalahan pada server',
        error: error.message,
        })
    }
}
...
```

4. Buat dua buah buku dengan data di bawah ini dengan postman

```
{
"title": "Dilan 1990",
"author": "Pidi Baiq",
"year": 2014,
"pages": 332,
"summary": "Mirea, anata wa utsukushī",
"publisher": "Pastel Books"
}
```

```
{
"title": "Dilan 1991",
"author": "Pidi Baiq",
"year": 2015,
"pages": 344,
"summary": "Watashi ga kare o aishite iru to ittara",
"publisher": "Pastel Books"
}
```

5. Lakukan perubahan pada fungsi getAllBooks

```
const Book = require('../models/book.model');
async function getAllBooks(req, res) {
    try {
        const books = await Book.find();
        res.status(200).json({
        message: 'mendapatkan semua buku',books,
        })
    } catch (error) {
    res.status(500).json({
        message: 'kesalahan pada server',
        error: error.message,
        })
    }
}
...
```

6. Lakukan perubahan pada fungsi getOneBook

```
const Book = require('../models/book.model');
...
async function getOneBook(req, res) {
    const id = req.params.id;
    try {
        const book = await Book.findById(id);
        res.status(200).json({
        message: 'mendapatkan satu buku',book,
        })
    } catch (error) {
        res.status(500).json({
        message: 'kesalahan pada server',
        error: error.message,
        })
    }
}
...
```

7. Tampilkan semua buku dengan Postman
8. Tampilkan buku Dilan 1990 dengan Postman
9. Lakukan perubahan pada fungsi updateBook

```
const Book = require('../models/book.model');
...
async function updateBook(req, res) {
    const id = req.params.id;
    try {
        const book = await Book.findByIdAndUpdate(
        id, req.body, { new: true }
        )
        res.status(200).json({
            message: 'memperbaharui satu buku',book,
        })
    } catch (error) {
        res.status(500).json({
        message: 'kesalahan pada server',
        error: error.message,
        })
    }
}
...
```

10. Ubah judul buku Dilan 1991 menjadi “<NAMA PANGGILAN> 1991” dengan Postman
11. Lakukan perubahan pada fungsi deleteBook

```
const Book = require('../models/book.model');
...
async function deleteBook(req, res) {
    const id = req.params.id;
    try {
        const book = await Book.findByIdAndDelete(id);
        res.status(200).json({
            message: 'menghapus satu buku',book,
        })
    } catch (error) {
        res.status(500).json({
        message: 'kesalahan pada server',
        error: error.message,
        })
    }
}
...
```

12. Hapus buku Dilan 1990 dengan Postman
