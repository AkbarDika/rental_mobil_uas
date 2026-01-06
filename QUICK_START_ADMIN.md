# QUICK START - ADMIN PANEL

## 🚀 Cara Pakai

### 1. Login Admin
```
URL: http://localhost/login
Email: [gunakan email user dengan role_id = 1]
Password: [password user]

Sistem otomatis akan redirect ke /admin setelah login
```

### 2. Akses Dashboard Admin
```
Setelah login, Anda akan melihat:
- Dashboard dengan statistik
- Sidebar navigation
- Quick action buttons
- Recent orders table
```

### 3. Menu Admin
Sidebar memiliki menu:
- 📊 Dashboard
- 🚗 Data Mobil (dengan submenu)
- 📅 Pemesanan
- 💳 Pembayaran
- 👥 Pengguna
- 📄 Laporan

### 4. Fitur Available
✅ Dashboard dengan statistik
✅ Recent orders table
✅ Quick actions
✅ Responsive design
✅ Modern UI

---

## 🔑 Key Features

### Login Redirect
```
role_id = 1 (Admin)  → /admin
role_id ≠ 1 (Other)  → /dashboard
```

### Protection
- Hanya admin yang bisa akses /admin
- Non-admin akan ditolak & redirect
- Middleware IsAdmin melindungi semua rute admin

### URLs
```
/admin                 Dashboard
/admin/mobil           Kelola Mobil
/admin/pemesanan       Kelola Pemesanan
/admin/pembayaran      Kelola Pembayaran
/admin/pengguna        Kelola Pengguna
```

---

## 📋 Database Roles

```
role_id = 1 → Super Admin (Akses Admin Panel)
role_id = 2 → Admin
role_id = 3 → Customer
role_id = 4 → Petugas
```

Pastikan user Anda memiliki `role_id = 1` untuk akses admin.

---

## 🎯 Admin Dashboard Features

### Statistics Cards
- Total Mobil: 150
- Pemesanan Aktif: 45
- Total Pendapatan: Rp 25.5M
- Total Pengguna: 320

### Recent Orders Table
Menampilkan 4 pemesanan terbaru dengan:
- Order ID
- Customer Name
- Car Model
- Date
- Status Badge

### Quick Actions
- Tambah Mobil Baru
- Kelola Pemesanan
- Buat Laporan
- Pengaturan Sistem

### System Information
- App Version: 1.0.0
- Database: MySQL
- Last Update: 06 Jan 2026
- Status: Online

---

## 🔐 Security Notes

1. **Double Protection**
   - Middleware IsAdmin pada setiap rute admin
   - Session validation

2. **Role-Based**
   - Hanya role_id = 1 yang bisa akses
   - Non-admin ditolak dengan error message

3. **Session**
   - Logout clear session & token
   - Auto regenerate setelah login

---

## 📱 Responsive Design

✅ Desktop (1200px+)
✅ Tablet (768px - 1199px)
✅ Mobile (< 768px)

Sidebar akan collapse pada mobile untuk space lebih.

---

## 🎨 UI/UX Features

- Gradient sidebar (purple)
- Clean white cards
- Color-coded stats (primary, success, warning, danger)
- Bootstrap icons
- Smooth transitions
- Professional styling

---

## 📚 Documentation

Untuk dokumentasi lebih lengkap, lihat:
- `ADMIN_DOCUMENTATION.md` - Setup detail & architecture
- `SETUP_ADMIN.txt` - Testing guide
- `IMPLEMENTATION_CHECKLIST.md` - Checklist implementasi

---

## 💬 Support

Jika ada pertanyaan atau issue:
1. Cek dokumentasi files di atas
2. Verify database roles & user role_id
3. Ensure middleware registered di bootstrap/app.php
4. Check routes di routes/web.php

---

## ✨ Develop Further

Untuk menambah CRUD pages untuk mobil, pemesanan, pembayaran, pengguna:

1. Update `AdminController` methods
2. Create view files di `resources/views/admin/`
3. Add routes jika perlu
4. Add database queries dengan Models

Contoh struktur view sudah tersedia di:
- `resources/views/admin/cars/index.blade.php`
- `resources/views/admin/orders/index.blade.php`
- `resources/views/admin/payments/index.blade.php`
- `resources/views/admin/users/index.blade.php`

---

**Status: READY TO USE! ✅**

Admin panel sudah siap. Login dengan role_id=1 untuk test!
