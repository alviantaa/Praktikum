# CRUD MongoDB Compass dan Shell
## MongoDB Compass
> MongoDB Compass adalah tool berbasis Graphical User Interface (GUI) untuk berinteraksi dengan MongoDB yang terpasang secara on-premise dan MongoDB Atlas yang berbasis cloud. Tool ini dapat melakukan aktivitas dasar seperti CREATE, READ, UPDATE, dan DELETE (CRUD) tanpa berhadapan dengan baris perintah (command line).
### Langkah Praktikum
1. Koneksi ke MongoDB menggunakan connection string (local connection)
<br> ![image](https://github.com/alviantaa/Praktikum/assets/112466435/7effca2f-8527-4a2f-bef5-4cf432432361)

2. Buat database dengan melakukan klik "Create Database"
<br> ![image](https://github.com/alviantaa/Praktikum/assets/112466435/57ae1605-ab42-4679-9d2d-9e2b17cad496)

> [!NOTE]
> MongoDB akan membuat nilai _id secara otomatis, tidak perlu mengikuti nilai _id yang terdapat pada modul

3. Lakukan insert buku pertama dengan melakukan klik “Add Data”, pilih “Insert Document”, isi dengan data yang diinginkan dan
   klik “Insert”
<br> ![image](https://github.com/alviantaa/Praktikum/assets/112466435/a41ccf52-5fee-4cc0-b53e-e451dc91edd1)

5. Lakukan insert buku kedua dengan cara yang sama
<br> ![image](https://github.com/alviantaa/Praktikum/assets/112466435/6979f5a3-ecc7-4af8-855c-f353950a0de1)

6. Lakukan pencarian buku dengan author “Osamu Dazai” dengan mengisi filter yang diinginkan dan klik “Find”
<br> ![image](https://github.com/alviantaa/Praktikum/assets/112466435/b4ac534b-fea1-4b29-8a95-604750b53ef6)

7. Lakukan perubahan summary pada buku “No Longer Human” menjadi “Buku yang bagus (<NAMA>,<NIM>) dengan melakukan klik “Edit Document” (berlambang pensil), mengisi nilai summary yang baru, dan melakukan klik “Update”
<br> ![image](https://github.com/alviantaa/Praktikum/assets/112466435/3f9f39af-37d6-42cb-8b2b-2a5991012f00)

8. Lakukan penghapusan pada buku “I Am a Cat” dengan melakukan klik “Remove Document” (berlambang tong sampah) dan melakukan klik “Delete”
<br> ![image](https://github.com/alviantaa/Praktikum/assets/112466435/da9d948c-05bd-4950-a4e0-2a1708e8efbb)

## MongoDB Shell
> Digunakan untuk melakukan operasi seperti MongoDB Compass, namun interaksi yang dilakukan MongoDB Shell berbasis Command Line Interface (CLI), sehingga diperlukan baris perintah untuk melakukan aktivitas dasar. MongoDB Shell dapat diakses langsung dari MongoDB Compass (pojok kiri bawah) atau menggunakan mongosh pada Command Prompt.
### Langkah Praktikum
1. Lakukan koneksi ke MongoDB Server dengan menjalankan command ```mongosh``` bagi yang menggunakan terminal build in OS sehingga tampilan terminal kalian akan menjadi seperti berikut
<br> ![image](https://github.com/alviantaa/Praktikum/assets/112466435/b4500c75-374a-40b8-bb19-3c2c100fd75a)

> [!NOTE]
> Apabila menggunakan MongoDB atlas, silahkan copy connection string dari MongoDB atlas kalian masing-masing dan paste kan di terminal kalian

2. Mencoba melihat list database yang ada di server dengan menjalankan command
   ```
   show dbs
   ```
   ![image](https://github.com/alviantaa/Praktikum/assets/112466435/4f9b8e02-7c9e-4643-bffc-44bd9f4bd86b)

   - Untuk berpindah ke database “bookstore” gunakan command
   ```
   use bookstore
   ```
   - Untuk memastikan telah berpindah ke database yang benar dengan melihat tulisan sebelum tanda “>”
   <br> ![image](https://github.com/alviantaa/Praktikum/assets/112466435/bd3c1240-7066-4bb7-875c-a207d170e152)

   - Cobalah untuk melihat collection yang ada pada database tersebut dengan menggunakan command
   ```
   show collections
   ```
   ![image](https://github.com/alviantaa/Praktikum/assets/112466435/f9a0dced-5230-4bf3-af98-d8c89c23f436)

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
   <br> ![image](https://github.com/alviantaa/Praktikum/assets/112466435/11d4b40a-f391-4276-95a5-2fa059d7b9b4)

4. Lakukan insert buku “The Setting Sun” dan “Hujan” dengan insert many dengan menggunakan command
   ```
   db.books.insertMany([{title: "The Setting Sun", author: "Osamu Dazai", year: 1947, pages: 175, summary: "Lorem ipsum dolor sit amet", publisher: "Yen Press"},{title: "Hujan", author: "Tere Liye", year: 2016, pages: 320, summary: "Lorem ipsum dolor sit amet", publisher: "Gramedia"}])
   ```
   Mengembalikan pesan sebagai berikut.
   <br> ![image](https://github.com/alviantaa/Praktikum/assets/112466435/7416c8cb-9114-431b-a405-f09fa10174ba)

5. Lakukan pencarian semua buku dengan menggunakan command
   ```
   db.books.find()
   ```
   Hasil pencarian semua buku
   <br> ![image](https://github.com/alviantaa/Praktikum/assets/112466435/e9933857-201d-466c-b0d1-ef935359c977)

6. Tampilkan seluruh buku dengan author “Osamu Dazai” dengan mengisi argument pada find() dengan menggunakan command
   ```
   db.books.find({author: "Osamu Dazai"})
   ```
   hasil pencarian buku
   <br> ![image](https://github.com/alviantaa/Praktikum/assets/112466435/e76e37db-b797-44d6-a516-15578f515ebe)

7. Lakukan perubahan summary pada buku “Hujan” menjadi “Buku yang bagus (<NAMA>,<NIM>) dengan mengunakan command
   ```
   db.books.updateOne({title:"Hujan"}, {$set: {summary:"Buku yang bagus (Alvianta Dwi Putra 215150700111053)"}})
   ```
   sehingga output yang dihasilkan oleh MongoDB akan menjadi seperti berikut
   <br> ![image](https://github.com/alviantaa/Praktikum/assets/112466435/7733a510-d22a-4968-b9bb-13d5812214b6)
   <br> Hasil setelah update summary
   <br> ![image](https://github.com/alviantaa/Praktikum/assets/112466435/93f31565-4074-405c-a9d1-6d85a4efb903)

8. Lakukan perubahan publisher menjadi “Yen Press” pada semua buku “Osamu Dazai” dengan menggunakan command
   ```
   db.books.updateMany({author:"Osamu Dazai"}, {$set: {Publisher:"Yen Press"}})
   ```
   <br> ![image](https://github.com/alviantaa/Praktikum/assets/112466435/dbf28032-e6a7-41ed-89e6-53b42ad346bf)
   <br> Hasil setelah update publisher
   <br> ![image](https://github.com/alviantaa/Praktikum/assets/112466435/84a71b4d-338d-4fd1-87ad-9b75b247b8fd)

9. Lakukan penghapusan pada buku “Overlord I” dengan menggunakan command
   ```
   db.books.deleteOne({title:"Overlord I"})
   ```
   Hasil setelah delete one
   <br> ![image](https://github.com/alviantaa/Praktikum/assets/112466435/a83d126c-4bc2-4422-bfab-d8c9e4760748)

10. Lakukan penghapusan pada semua buku “Osamu Dazai" dengan menggunakan command
    ```
    db.books.deleteMany({author:"Osamu Dazai"})
    ```
    Hasil setelah delete many
    <br> ![image](https://github.com/alviantaa/Praktikum/assets/112466435/590c249a-54a9-417d-a6db-94daef187c27)
