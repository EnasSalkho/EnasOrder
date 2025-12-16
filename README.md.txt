📦 Customer Orders CRUD – Laravel API

نظام CRUD بسيط باستخدام Laravel لإدارة:

العملاء (Customers)

الطلبات (Orders)

عناصر الطلب (Order Items)

المشروع مصمم كـ REST API وجاهز للاستخدام مع Flutter.

🛠 المتطلبات

PHP ^8.1

Composer

MySQL

Laravel 10 أو أعلى

⚙️ طريقة التشغيل
1️⃣ استنساخ المشروع
git clone <repository-url>
cd project-name

2️⃣ تثبيت الحزم
composer install

3️⃣ إعداد ملف البيئة
cp .env.example .env
php artisan key:generate


عدّل إعدادات قاعدة البيانات في .env:

DB_DATABASE=your_db_name
DB_USERNAME=your_username
DB_PASSWORD=your_password

4️⃣ تشغيل الـ Migrations
php artisan migrate

5️⃣ تعبئة بيانات وهمية (Seeders)
php artisan db:seed

6️⃣ تشغيل السيرفر
php artisan serve


سيعمل السيرفر على:

http://127.0.0.1:8000

📚 هيكل قاعدة البيانات
customers

id

name

phone (unique)

deleted_at (Soft Delete)

orders

id

customer_id

status (pending, paid, canceled)

total (محسوب تلقائيًا)

order_items

id

order_id

product_name

price

quantity

subtotal (price × quantity)

⚠️ ملاحظات مهمة

لا يمكن تعديل subtotal أو total يدويًا.

يتم حساب subtotal تلقائيًا عند:

إنشاء عنصر

تعديل السعر أو الكمية

يتم تحديث order.total تلقائيًا عند:

إضافة عنصر

تعديل عنصر

حذف عنصر

الحسابات تتم باستخدام Model Events.

تم استخدام Database Transactions لضمان سلامة البيانات.

🔗 أهم الـ API Routes
Customers
GET    /api/customers
POST   /api/customers
GET    /api/customers/{id}
PUT    /api/customers/{id}
DELETE /api/customers/{id}

GET    /api/customers/trashed
POST   /api/customers/{id}/restore
DELETE /api/customers/{id}/force

Orders
GET    /api/orders
POST   /api/orders
GET    /api/orders/{id}
PUT    /api/orders/{id}
DELETE /api/orders/{id}

GET    /api/customers/{customerId}/orders

Order Items
POST   /api/order-items
PUT    /api/order-items/{id}
DELETE /api/order-items/{id}

✅ مميزات المشروع

CRUD كامل

علاقات صحيحة باستخدام Eloquent

Soft Delete

API Resources جاهزة للـ Flutter

كود نظيف ومنظم

مناسب كمشروع تدريبي أو Interview Task

👩‍💻 المطوّر

Enas Salkho : Backend Developer – Laravel