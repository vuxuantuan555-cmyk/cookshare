# CookShare - Laravel Recipe Sharing Application

## 📋 Yêu cầu hệ thống
- PHP >= 8.1
- Composer
- MySQL/MariaDB
- Node.js & NPM

## 🚀 Cài đặt

### 1. Tạo project Laravel mới
```bash
composer create-project laravel/laravel cookshare
cd cookshare
```

### 2. Copy các file từ thư mục này vào project

### 3. Cấu hình database trong file `.env`
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=cookshare
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Chạy migrations
```bash
php artisan migrate
```

### 5. Tạo symbolic link cho storage
```bash
php artisan storage:link
```




### 7. Chạy server
```bash
php artisan serve
```

## 📁 Cấu trúc thư mục

```
cookshare/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AuthController.php
│   │   │   ├── RecipeController.php
│   │   │   ├── CommentController.php
│   │   │   └── RatingController.php
│   │   └── Requests/
│   │       ├── RegisterRequest.php
│   │       ├── LoginRequest.php
│   │       └── RecipeRequest.php
│   └── Models/
│       ├── User.php
│       ├── Recipe.php
│       ├── Comment.php
│       └── Rating.php
├── database/
│   └── migrations/
├── resources/
│   └── views/
│       ├── layouts/
│       │   └── app.blade.php
│       ├── auth/
│       │   ├── login.blade.php
│       │   └── register.blade.php
│       ├── recipes/
│       │   ├── index.blade.php
│       │   ├── show.blade.php
│       │   ├── create.blade.php
│       │   └── my-recipes.blade.php
│       └── components/
│           └── recipe-card.blade.php
└── routes/
    └── web.php
```

## ✨ Chức năng
- ✅ Đăng ký / Đăng nhập
- ✅ Đăng công thức (thành phần, bước làm, ảnh)
- ✅ Xem và tìm kiếm công thức
- ✅ Lọc theo danh mục
- ✅ Bình luận
- ✅ Đánh giá sao
- ✅ Quản lý công thức cá nhân