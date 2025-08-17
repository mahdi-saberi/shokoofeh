# راهنمای سیستم ورژن‌بندی

## 🎯 هدف
این سیستم برای مدیریت ورژن‌های مختلف image ها و tracking تغییرات طراحی شده است.

## 📋 استراتژی ورژن‌بندی

### 🚀 Laravel App
- **ورژن جدید**: هر بار build، ورژن جدید با فرمت `YYYY.MM.DD-HHMM` ایجاد می‌شود
- **Latest**: همیشه آخرین ورژن build شده
- **مثال**: `2025.01.28-1430`, `2025.01.28-1500`

### 🌐 Nginx
- **ورژن دقیق**: `1.29.1-alpine` (ورژن پایدار)
- **Stable**: tag شده از ورژن دقیق برای production
- **تغییرات**: فقط در صورت نیاز به upgrade امنیتی

### 🗄️ MySQL
- **ورژن ثابت**: `8.0` (ورژن پایدار)
- **تغییرات**: فقط در صورت نیاز به upgrade امنیتی

## 🔧 نحوه استفاده

### ۱. Build و Push
```bash
# اجرای اسکریپت build و push
./build-and-push.sh
```

**خروجی:**
- `laravel-app:2025.01.28-1430` (ورژن جدید)
- `laravel-app:latest` (آخرین ورژن)
- `nginx:1.29.1-alpine` (ورژن دقیق)
- `nginx:stable` (ورژن پایدار)
- `mysql:8.0` (ورژن ثابت)

### ۲. مدیریت ورژن‌ها
```bash
# نمایش ورژن‌های موجود
./version-manager.sh
```

**خروجی:**
- لیست ورژن‌های موجود
- آخرین ورژن app
- فایل `k8s-versions.env` برای Kubernetes

### ۳. استفاده در Kubernetes

#### برای Development
```yaml
image: registry.hamdocker.ir/mahdi-saberi/laravel-app:latest
image: registry.hamdocker.ir/mahdi-saberi/nginx:1.29.1-alpine
image: registry.hamdocker.ir/mahdi-saberi/mysql:8.0
```

#### برای Production
```yaml
image: registry.hamdocker.ir/mahdi-saberi/laravel-app:2025.01.28-1430
image: registry.hamdocker.ir/mahdi-saberi/nginx:1.29.1-alpine
image: registry.hamdocker.ir/mahdi-saberi/mysql:8.0
```

## 📊 مزایای این سیستم

### ✅ **Tracking تغییرات**
- هر deployment تاریخ دقیق دارد
- امکان rollback به ورژن قبلی
- تاریخچه کامل تغییرات

### ✅ **پایداری**
- nginx و mysql ورژن‌های پایدار دارند
- کاهش ریسک تغییرات ناخواسته
- امنیت بیشتر

### ✅ **انعطاف‌پذیری**
- امکان استفاده از ورژن خاص یا latest
- مناسب برای development و production
- مدیریت آسان ورژن‌ها

## 🚨 نکات مهم

### ⚠️ **برای Production**
- از ورژن‌های دقیق استفاده کنید
- قبل از deployment تست کنید
- backup از ورژن قبلی داشته باشید

### ⚠️ **برای Development**
- از latest استفاده کنید
- تغییرات را track کنید
- ورژن‌های قدیمی را پاک کنید

### ⚠️ **Maintenance**
- ورژن‌های قدیمی را بررسی کنید
- فضای storage را مدیریت کنید
- امنیت ورژن‌ها را چک کنید

## 🔄 Workflow پیشنهادی

### ۱. **Development**
```bash
# تغییرات در کد
git commit -m "feature: add new functionality"

# Build و push
./build-and-push.sh

# Deploy در development
kubectl apply -f k8s-deployment.yaml
```

### ۲. **Production**
```bash
# انتخاب ورژن مناسب
./version-manager.sh

# بررسی ورژن‌ها
cat k8s-versions.env

# Deploy در production با ورژن دقیق
kubectl apply -f k8s-statefulset.yaml
```

## 📈 Monitoring و Analytics

### 📊 **Metrics مهم**
- تعداد ورژن‌های موجود
- حجم storage استفاده شده
- تاریخ آخرین deployment
- وضعیت health check ها

### 📊 **Alerts**
- ورژن‌های قدیمی (بیش از 30 روز)
- خطاهای deployment
- مشکلات امنیتی
- فضای storage کم

## 🛠️ ابزارهای کمکی

### 📝 **اسکریپت‌های موجود**
- `build-and-push.sh` - Build و push image ها
- `version-manager.sh` - مدیریت ورژن‌ها
- `pull-images.sh` - Pull کردن image ها

### 📝 **فایل‌های Kubernetes**
- `k8s-deployment.yaml` - Development deployment
- `k8s-statefulset.yaml` - Production deployment
- `k8s-source-copy-job.yaml` - کپی کردن source files

## 🎉 نتیجه‌گیری

این سیستم ورژن‌بندی به شما امکان می‌دهد:
- **Tracking کامل تغییرات** داشته باشید
- **Rollback آسان** به ورژن‌های قبلی
- **مدیریت بهتر production** داشته باشید
- **امنیت بیشتر** در deployment ها
- **تاریخچه کامل** از تغییرات پروژه 