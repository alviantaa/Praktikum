# CRUD MongoDB Compass dan Shell
## MongoDB Compass
> MongoDB Compass adalah tool berbasis Graphical User Interface (GUI) untuk berinteraksi dengan MongoDB yang terpasang secara on-premise dan MongoDB Atlas yang berbasis cloud. Tool ini dapat melakukan aktivitas dasar seperti CREATE, READ, UPDATE, dan DELETE (CRUD) tanpa berhadapan dengan baris perintah (command line).
### Langkah Praktikum
1. Koneksi ke MongoDB menggunakan connection string (local connection)
<br> ![image](https://github.com/alviantaa/Praktikum/blob/main/Pemrograman_Integratif/Modul_2/screenshot/1.png)

3. Buat database dengan melakukan klik "Create Database"
<br> ![image](https://github.com/alviantaa/Praktikum/blob/main/Pemrograman_Integratif/Modul_2/screenshot/2.png)

> [!NOTE]
> MongoDB akan membuat nilai _id secara otomatis, tidak perlu mengikuti nilai _id yang terdapat pada modul

3. Lakukan insert buku pertama dengan melakukan klik “Add Data”, pilih “Insert Document”, isi dengan data yang diinginkan dan
   klik “Insert”
<br> ![image](https://github.com/alviantaa/Praktikum/blob/main/Pemrograman_Integratif/Modul_2/screenshot/3.png)

5. Lakukan insert buku kedua dengan cara yang sama
<br> ![image](https://github.com/alviantaa/Praktikum/blob/main/Pemrograman_Integratif/Modul_2/screenshot/4.png)

6. Lakukan pencarian buku dengan author “Osamu Dazai” dengan mengisi filter yang diinginkan dan klik “Find”
<br> ![image](https://github.com/alviantaa/Praktikum/blob/main/Pemrograman_Integratif/Modul_2/screenshot/5.png)

7. Lakukan perubahan summary pada buku “No Longer Human” menjadi “Buku yang bagus (<NAMA>,<NIM>) dengan melakukan klik “Edit Document” (berlambang pensil), mengisi nilai summary yang baru, dan melakukan klik “Update”
<br> ![image](https://github.com/alviantaa/Praktikum/blob/main/Pemrograman_Integratif/Modul_2/screenshot/6.png)

8. Lakukan penghapusan pada buku “I Am a Cat” dengan melakukan klik “Remove Document” (berlambang tong sampah) dan melakukan klik “Delete”
<br> ![image](https://github.com/alviantaa/Praktikum/blob/main/Pemrograman_Integratif/Modul_2/screenshot/7.png)

## MongoDB Shell
> Digunakan untuk melakukan operasi seperti MongoDB Compass, namun interaksi yang dilakukan MongoDB Shell berbasis Command Line Interface (CLI), sehingga diperlukan baris perintah untuk melakukan aktivitas dasar. MongoDB Shell dapat diakses langsung dari MongoDB Compass (pojok kiri bawah) atau menggunakan mongosh pada Command Prompt.
### Langkah Praktikum
1. Lakukan koneksi ke MongoDB Server dengan menjalankan command ```mongosh``` bagi yang menggunakan terminal build in OS sehingga tampilan terminal kalian akan menjadi seperti berikut
<br> ![image](https://github.com/alviantaa/Praktikum/blob/main/Pemrograman_Integratif/Modul_2/screenshot/8.png)

> [!NOTE]
> Apabila menggunakan MongoDB atlas, silahkan copy connection string dari MongoDB atlas kalian masing-masing dan paste kan di terminal kalian

2. Mencoba melihat list database yang ada di server dengan menjalankan command
   ```
   show dbs
   ```
   ![image](https://github.com/alviantaa/Praktikum/blob/main/Pemrograman_Integratif/Modul_2/screenshot/9.png)

   - Untuk berpindah ke database “bookstore” gunakan command
   ```
   use bookstore
   ```
   - Untuk memastikan telah berpindah ke database yang benar dengan melihat tulisan sebelum tanda “>”
   <br> ![image](https://github.com/alviantaa/Praktikum/blob/main/Pemrograman_Integratif/Modul_2/screenshot/10.png)

   - Cobalah untuk melihat collection yang ada pada database tersebut dengan menggunakan command
   ```
   show collections
   ```
   ![image](https://github.com/alviantaa/Praktikum/blob/main/Pemrograman_Integratif/Modul_2/screenshot/11.png)

   > [!NOTE]
   > Kalian juga bisa berpindah ke database yang belum pernah kalian buat sebelumnya, dengan menggunakan command dan MongoDB akan otomatis membuatkan database dan collections.
   ```
   db.<nama collections>.insert<One/Many>(data kalian)
   ```

3. Lakukan insert buku “Overlord I” dengan menggunakan command
   ```
   db.books.insertOne({"title": "Overlord I", "author": "Kugane Maruyama", "year": 2012, "pages": 548,"summary": "Lorem ipsum dolor sit amet","publisher": "Yen Press"})
   ```
   setelah insert buku berhasil maka MongoDB akan mengembalikan pesan sebagai berikut.
   <br> ![image](https://github.com/alviantaa/Praktikum/blob/main/Pemrograman_Integratif/Modul_2/screenshot/12.png)

4. Lakukan insert buku “The Setting Sun” dan “Hujan” dengan insert many dengan menggunakan command
   ```
   db.books.insertMany([{title: "The Setting Sun", author: "Osamu Dazai", year: 1947, pages: 175, summary: "Lorem ipsum dolor sit amet", publisher: "Yen Press"},{title: "Hujan", author: "Tere Liye", year: 2016, pages: 320, summary: "Lorem ipsum dolor sit amet", publisher: "Gramedia"}])
   ```
   Mengembalikan pesan sebagai berikut.
   <br> ![image](https://github.com/alviantaa/Praktikum/blob/main/Pemrograman_Integratif/Modul_2/screenshot/13.png)

5. Lakukan pencarian semua buku dengan menggunakan command
   ```
   db.books.find()
   ```
   Hasil pencarian semua buku
   <br> ![image](https://github.com/alviantaa/Praktikum/blob/main/Pemrograman_Integratif/Modul_2/screenshot/14.png)

6. Tampilkan seluruh buku dengan author “Osamu Dazai” dengan mengisi argument pada find() dengan menggunakan command
   ```
   db.books.find({author: "Osamu Dazai"})
   ```
   hasil pencarian buku
   <br> ![image](https://github.com/alviantaa/Praktikum/blob/main/Pemrograman_Integratif/Modul_2/screenshot/15.png)

7. Lakukan perubahan summary pada buku “Hujan” menjadi “Buku yang bagus (<NAMA>,<NIM>) dengan mengunakan command
   ```
   db.books.updateOne({title:"Hujan"}, {$set: {summary:"Buku yang bagus (Alvianta Dwi Putra 215150700111053)"}})
   ```
   sehingga output yang dihasilkan oleh MongoDB akan menjadi seperti berikut
   <br> ![image](https://github.com/alviantaa/Praktikum/blob/main/Pemrograman_Integratif/Modul_2/screenshot/16.png)
   <br> Hasil setelah update summary
   <br> ![image](https://github.com/alviantaa/Praktikum/blob/main/Pemrograman_Integratif/Modul_2/screenshot/17.png)

8. Lakukan perubahan publisher menjadi “Yen Press” pada semua buku “Osamu Dazai” dengan menggunakan command
   ```
   db.books.updateMany({author:"Osamu Dazai"}, {$set: {publisher:"Yen Press"}})
   ```
   <br> ![image](https://github.com/alviantaa/Praktikum/blob/main/Pemrograman_Integratif/Modul_2/screenshot/18.png)
   <br> Hasil setelah update publisher
   <br> ![image](https://github.com/alviantaa/Praktikum/blob/main/Pemrograman_Integratif/Modul_2/screenshot/19.png)

9. Lakukan penghapusan pada buku “Overlord I” dengan menggunakan command
   ```
   db.books.deleteOne({title:"Overlord I"})
   ```
   Hasil setelah delete one
   <br> ![image](https://github.com/alviantaa/Praktikum/blob/main/Pemrograman_Integratif/Modul_2/screenshot/20.png)

10. Lakukan penghapusan pada semua buku “Osamu Dazai" dengan menggunakan command
    ```
    db.books.deleteMany({author:"Osamu Dazai"})
    ```
    Hasil setelah delete many
    <br> ![image](https://github.com/alviantaa/Praktikum/blob/main/Pemrograman_Integratif/Modul_2/screenshot/21.png)
