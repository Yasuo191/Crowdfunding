# 🎗️ Hệ thống Gây quỹ Cộng đồng (Crowdfunding System)

## Giới thiệu

Hệ thống Gây quỹ Cộng đồng là một ứng dụng web được phát triển nhằm hỗ trợ việc tạo, quản lý và quyên góp cho các chiến dịch gây quỹ trực tuyến.

Người dùng có thể tạo chiến dịch, quyên góp, bình luận, lưu chiến dịch yêu thích và theo dõi các hoạt động của mình thông qua Dashboard. Bên cạnh đó, hệ thống cung cấp trang quản trị dành cho quản trị viên để xét duyệt và quản lý các chiến dịch.

---

# Chức năng chính

## Người dùng

- Đăng ký tài khoản
- Đăng nhập / Đăng xuất
- Tạo chiến dịch gây quỹ
- Chỉnh sửa chiến dịch
- Quyên góp cho chiến dịch
- Bình luận
- Thêm / Xóa chiến dịch yêu thích
- Xem Dashboard cá nhân
- Xem lịch sử quyên góp

---

## Quản trị viên

- Đăng nhập với quyền Admin
- Duyệt chiến dịch
- Ẩn chiến dịch
- Quản lý danh sách chiến dịch
- Theo dõi thống kê hệ thống

---

# Công nghệ sử dụng

## Frontend

- React 19
- React Router
- Axios
- React Toastify
- CSS3
- Vite

## Backend

- PHP 8
- REST API
- PDO

## Cơ sở dữ liệu

- MySQL

## Công cụ phát triển

- XAMPP
- Visual Studio Code
- Git
- GitHub

---

# Cấu trúc thư mục

```text
crowdfunding/
│
├── backend/
│   ├── api/
│   ├── config/
│   ├── controllers/
│   ├── models/
│   ├── services/
│   ├── uploads/
│   └── utils/
│
├── frontend/
│
├── database/
│   ├── schema.sql
│   └── seed.sql
│
├── docs/
│   ├── api-spec.md
│   ├── architecture.png
│   └── erd.png
│
├── .vscode/
│   └── settings.json
│
├── README.md
└── .gitignore
```

---

# Hướng dẫn cài đặt

## 1. Clone dự án

```bash
git clone <repository-url>
```

---

## 2. Đưa dự án vào XAMPP

Sao chép thư mục dự án vào:

```
xampp/htdocs/
```

Ví dụ:

```
C:\xampp\htdocs\crowdfunding
```

---

## 3. Cài đặt cơ sở dữ liệu

- Mở phpMyAdmin

```
http://localhost/phpmyadmin
```

- Tạo database

```
crowdfunding
```

- Import file

```
database/schema.sql
```

---

## 4. Khởi động XAMPP

Bật:

- Apache
- MySQL

---

## 5. Cài đặt Frontend

Mở Terminal:

```bash
cd frontend

npm install
```

---

## 6. Chạy React

```bash
npm run dev
```

---

## 7. Truy cập hệ thống

Frontend

```
http://localhost:5173
```

Backend API

```
http://localhost/crowdfunding/backend/api/
```

---

# Cơ sở dữ liệu

Các bảng chính:

- users
- campaigns
- donations
- comments
- favorites

Sơ đồ cơ sở dữ liệu được lưu tại:

```
docs/erd.png
```

---

# Kiến trúc hệ thống

Hệ thống được xây dựng theo mô hình nhiều lớp (Layered Architecture):

```
React Frontend
        │
        ▼
REST API (PHP)
        │
Controllers
        │
Services
        │
Models
        │
PDO
        │
MySQL
```

Sơ đồ chi tiết:

```
docs/architecture.png
```

---

# API

Tài liệu đặc tả API:

```
docs/api-spec.md
```

---

# Một số chức năng nổi bật

- Đăng nhập và phân quyền người dùng
- Quản lý chiến dịch gây quỹ
- Upload ảnh chiến dịch
- Quyên góp trực tuyến
- Bình luận
- Danh sách yêu thích
- Dashboard người dùng
- Dashboard quản trị
- Toast Notification
- Responsive UI

---

# Hướng phát triển

Một số chức năng có thể bổ sung trong tương lai:

- Phân trang (Pagination)
- Protected Route
- Quên mật khẩu
- Xác thực Email
- Tìm kiếm nâng cao
- Thanh toán trực tuyến
- Thông báo thời gian thực

---

# Tác giả

Dự án được thực hiện phục vụ mục đích học tập và nghiên cứu.

---

# Giấy phép

Dự án được phát hành theo giấy phép MIT.