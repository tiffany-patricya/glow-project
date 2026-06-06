

SELECT * FROM products;
SELECT * FROM products ORDER BY category, NAME; 
SELECT category, COUNT(*) AS total_produk FROM products GROUP BY category;

-- Untuk mengecek catatan Routine yang masuk ke Diary:
SELECT * FROM diary ORDER BY id DESC;

-- Untuk mengecek barang apa saja yang sudah masuk ke lemari Stash:
SELECT * FROM stash ORDER BY id DESC; 

SHOW TABLES; 

SHOW DATABASES;