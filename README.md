# Shokoofeh App - Unified Docker Setup

## 🚀 معرفی

این پروژه از **unified Docker setup** استفاده می‌کند که شامل تمام سرویس‌های مورد نیاز در یک container است:

- **Laravel Application** (PHP 8.2)
- **Nginx Web Server** (1.29.1-alpine)
- **PHP-FPM** (8.2)
- **تمام PHP Extensions مورد نیاز**

## 🏗️ مزایای Unified Setup

### ✅ مزایا:
- **یک image واحد** برای deployment
- **کاهش پیچیدگی** در orchestration
- **مدیریت آسان‌تر** version control
- **کاهش احتمال** misconfiguration
- **سریع‌تر** در deployment

### ❌ معایب:
- **حجم image بزرگ‌تر** (اما قابل قبول)
- **کمتر flexible** برای scaling جداگانه

## 📁 ساختار فایل‌ها

### 🐳 **Docker Files:**
- `Dockerfile` - Dockerfile اصلی برای unified image
- `Dockerfile.simple` - نسخه ساده‌تر (اختیاری)
- `docker-compose.yml` - Docker Compose برای unified deployment
- `docker-compose.test.yml` - برای testing

### ☸️ **Kubernetes Files:**
- `k8s-deployment.yaml` - Development deployment
- `k8s-statefulset.yaml` - Production deployment
- `k8s-versions.yaml` - Version management
- `k8s-source-copy-job.yaml` - Source copying job

### 🔧 **Build Scripts:**
- `build.sh` - Build و push unified image
- `build-and-push.sh` - Build و push همه image ها
- `update-versions.sh` - Update version ها در K8s files
- `version-manager.sh` - مدیریت ورژن‌ها

### 📚 **Documentation:**
- `README.md` - این فایل
- `README-REGISTRY.md` - راهنمای registry
- `VERSIONING_README.md` - راهنمای versioning
- `KUBERNETES_DEPLOYMENT_README.md` - راهنمای K8s

## 🔧 نحوه استفاده

### 1. Build کردن Image
```bash
# Build unified image
./build.sh

# یا به صورت دستی
docker build -t shokoofeh-app .
```

### 2. اجرا با Docker Compose

#### Development (پیش‌فرض)
```bash
# اجرای سرویس‌ها (build و اجرا)
docker-compose up -d

# مشاهده logs
docker-compose logs -f

# توقف سرویس‌ها
docker-compose down
```

#### Production
```bash
# اجرای سرویس‌ها از pre-built image
docker-compose -f docker-compose.prod.yml up -d

# مشاهده logs
docker-compose -f docker-compose.prod.yml logs -f

# توقف سرویس‌ها
docker-compose -f docker-compose.prod.yml down
```

### 3. اجرا با Docker
```bash
# اجرای مستقیم container
docker run -d \
  --name shokoofeh-app \
  -p 8080:80 \
  -e DB_HOST=mysql \
  -e DB_DATABASE=toyshop \
  -e DB_USERNAME=laravel \
  -e DB_PASSWORD=laravel \
  shokoofeh-app:latest
```

## 🌐 Ports

- **8080** - Web application (localhost:8080)
- **3307** - MySQL database (localhost:3307)

## 🔍 Health Check

```bash
# بررسی وضعیت سرویس
curl http://localhost:8080/health

# باید "healthy" برگرداند
```

## 📊 Monitoring

### Container Status
```bash
docker ps
docker logs shokoofeh-app
```

### PHP Extensions
```bash
docker exec shokoofeh-app php -m
```

### Database Connection
```bash
docker exec shokoofeh-app php artisan tinker --execute="DB::connection()->getPdo();"
```

## 🚀 Deployment

### Production
```bash
# Build با ورژن مشخص
./build.sh

# استفاده از ورژن دقیق در docker-compose
image: registry.hamdocker.ir/mahdi-saberi/shokoofeh-app:2025.01.17-1430
```

### Development
```bash
# استفاده از latest
image: registry.hamdocker.ir/mahdi-saberi/shokoofeh-app:latest
```

## 🔧 Troubleshooting

### مشکل مجوز فایل‌ها
```bash
docker exec shokoofeh-app chown -R www:www /var/www/storage
docker exec shokoofeh-app chmod -R 775 /var/www/storage
```

### مشکل PHP-FPM
```bash
# بررسی وضعیت PHP-FPM
docker exec shokoofeh-app ps aux | grep php-fpm

# Restart PHP-FPM
docker exec shokoofeh-app pkill php-fpm82
docker exec shokoofeh-app php-fpm82 -D
```

### مشکل Database Connection
```bash
# بررسی اتصال دیتابیس
docker exec shokoofeh-app php artisan tinker --execute="DB::connection()->getPdo();"
```

## 📝 نکات مهم

1. **Unified image شامل nginx است** - نیازی به push کردن جداگانه نیست
2. **PHP-FPM با کاربر www اجرا می‌شود** - برای حل مشکل مجوز
3. **Health check endpoint** در `/health` موجود است
4. **Storage volume** برای persistence داده‌ها
5. **Environment variables** برای تنظیمات دیتابیس

## 🔄 Migration از Separate Images

اگر قبلاً از separate images استفاده می‌کردید:

1. **Stop سرویس‌های قدیمی**
2. **Build unified image جدید**
3. **Update docker-compose.yml**
4. **Start سرویس‌های جدید**

## 📚 منابع بیشتر

- [Docker Multi-stage Builds](https://docs.docker.com/develop/dev-best-practices/multistage-build/)
- [Laravel Docker Best Practices](https://laravel.com/docs/deployment)
- [Nginx Configuration](https://nginx.org/en/docs/)

## 🎯 Quick Start

```bash
# 1. Clone پروژه
git clone <repository-url>
cd shokoofeh

# 2. Build image
./build.sh

# 3. اجرا
docker-compose up -d

# 4. تست
curl http://localhost:8080/health
```

## 📞 پشتیبانی

برای سوالات و مشکلات:
- GitHub Issues
- Documentation در این repository
- Docker logs و health checks 