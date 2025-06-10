
# 📝 Todo Uygulaması

Kategorili ve öncelikli görev yönetimi sağlayan tam kapsamlı bir **Todo Uygulaması**. Görevleri oluşturabilir, filtreleyebilir, kategorilere ayırabilir, durum ve önceliklere göre yönetebilirsiniz. Uygulama hem **Laravel API (Back-end)** hem de **React (Front-end)** ile geliştirilmiştir.

---

## 🚀 Özellikler

- ✅ Todo listeleme, arama, filtreleme ve sıralama  
- 🗂️ Kategori yönetimi (renk destekli)
- 📆 Bitiş tarihi seçimi ve yaklaşan görevler
- 🔄 Görev durumu güncelleme (Beklemede, Devam Ediyor, Tamamlandı, İptal Edildi)
- ⚡ Öncelik seviyeleri (Düşük, Orta, Yüksek)
- 📊 Dashboard istatistikleri
- ♻️ Soft delete ve duruma göre silme
- 🔒 XSS koruması ve input validation
- 🔁 Repository & Service Layer mimarisi (Laravel)
- 🌈 Tailwind CSS ile şık kullanıcı arayüzü

---

## 🧰 Kullanılan Teknolojiler

### Back-end (Laravel API)
- Laravel 10+
- PHP 8.1+
- MySQL
- Sanctum (JWT Auth alternatifi)
- Repository + Service Layer
- Form Request Validations
- CORS + Middleware + Resource Wrappers

### Front-end (React)
- React 18+
- React Router v6+
- React Hook Form + Yup
- Axios
- Tailwind CSS
- react-datepicker
- react-icons

---

## ⚙️ Kurulum Adımları

### 1. Back-end (Laravel API)

```bash
git clone https://github.com/kullanici/todo-api.git
cd todo-api
cp .env.example .env
composer install
php artisan key:generate
php artisan migrate --seed
php artisan serve
```

> `.env` dosyasına uygun şekilde veritabanı bilgilerini girin.

### 2. Front-end (React)

```bash
git clone https://github.com/kullanici/todo-frontend.git
cd todo-frontend
npm install
npm run dev
```

> `REACT_APP_API_BASE_URL=http://localhost:8000/api` olacak şekilde `.env` dosyası eklemeyi unutma.

---

## ▶️ Uygulamayı Çalıştırma

1. Terminal 1: Laravel API  
   `php artisan serve` → `http://localhost:8000`

2. Terminal 2: React Frontend  
   `npm run dev` → `http://localhost:5173`

---

## 📡 API Dokümantasyonu

Tüm uç noktalar detaylı açıklamalarıyla birlikte aşağıdaki JSON formatında döner:

```json
{
  "status": true,
  "message": "İşlem başarılı",
  "data": { ... },
  "meta": { ... },
  "errors": null
}
```

### Örnek Uç Noktalar:
- `GET /api/todos`
- `POST /api/todos`
- `GET /api/todos/statistics`
- `GET /api/todos/upcoming`
- `GET /api/categories`
- `POST /api/categories`

📝 Daha fazlası için [API Dökümantasyon Sayfası](http://localhost:8000/api/docs) *(varsa Swagger veya Postman linki ekleyebilirsin)*

---

## 💡 Örnek Kullanım Senaryoları

- **Dashboard:** Günlük görev yükünüzü istatistiksel olarak görüntüleyin.
- **Todo Filtreleme:** Tamamlanan görevleri ve yaklaşan bitiş tarihli işleri listeleyin.
- **Kategori Yönetimi:** Renkli etiketlerle görevlerinizi gruplandırın.
- **Durum Değiştirme:** Görevlerinizi hızla "Devam Ediyor" veya "Tamamlandı" durumuna alın.

---

## 📁 Proje Yapısı

```bash
todo-api/            # Laravel API
 └── app/
 └── routes/api.php
 └── database/seeders/
 └── app/Repositories/
 └── app/Services/

todo-frontend/       # React Frontend
 └── src/
     └── components/
     └── pages/
     └── services/
     └── hooks/
     └── store/
```

