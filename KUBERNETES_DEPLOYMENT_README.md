# راهنمای Deploy کردن در Kubernetes

## مشکل اصلی
در Docker Compose، هر دو سرویس `app` و `nginx` از یک فولدر مشترک `./src` استفاده می‌کنند. اما در Kubernetes، هر Pod باید volume های خودش را داشته باشد.

## راه حل‌های پیشنهادی

### راه حل ۱: استفاده از Init Container
این راه حل از یک init container استفاده می‌کند تا فایل‌های source را کپی کند و سپس هر دو container از آن استفاده کنند.

**مزایا:**
- ساده و قابل فهم
- فایل‌ها در هر restart کپی می‌شوند

**معایب:**
- در هر restart زمان بیشتری می‌گیرد
- از فضای بیشتری استفاده می‌کند

### راه حل ۲: استفاده از Job + PersistentVolume
ابتدا یک Job اجرا می‌کنیم تا فایل‌ها را کپی کند، سپس از PersistentVolume مشترک استفاده می‌کنیم.

**مزایا:**
- فایل‌ها فقط یک بار کپی می‌شوند
- پایدار و قابل اعتماد

**معایب:**
- نیاز به اجرای دستی Job دارد
- پیچیدگی بیشتر

### راه حل ۳: استفاده از StatefulSet
از StatefulSet استفاده می‌کنیم که volume های پایدارتری دارد.

**مزایا:**
- پایدار و قابل اعتماد
- مدیریت بهتر volume ها

**معایب:**
- پیچیدگی بیشتر
- نیاز به تنظیمات اضافی

## ورژن‌بندی Image ها

### 🚀 Laravel App
- **ورژن جدید**: هر بار build، ورژن جدید با فرمت `YYYY.MM.DD-HHMM` ایجاد می‌شود
- **Latest**: همیشه آخرین ورژن build شده
- **مثال**: `2025.01.28-1430`, `2025.01.28-1500`

### 🌐 Nginx
- **ورژن ثابت**: `1.29.1-alpine` (ورژن پایدار)
- **تغییرات**: فقط در صورت نیاز به upgrade امنیتی
- **نکته مهم**: از ورژن دقیق استفاده می‌شود نه `stable` یا `latest`

### 🗄️ MySQL
- **ورژن ثابت**: `8.0` (ورژن پایدار)
- **تغییرات**: فقط در صورت نیاز به upgrade امنیتی

## نحوه استفاده

### مرحله ۱: اجرای Job برای کپی کردن فایل‌ها
```bash
kubectl apply -f k8s-source-copy-job.yaml
```

### مرحله ۲: بررسی تکمیل Job
```bash
kubectl get jobs
kubectl logs job/copy-source-files
```

### مرحله ۳: اجرای Deployment
```bash
# برای راه حل ۱
kubectl apply -f k8s-deployment.yaml

# یا برای راه حل ۳
kubectl apply -f k8s-statefulset.yaml
```

### مرحله ۴: بررسی وضعیت
```bash
kubectl get pods
kubectl get services
kubectl get pvc
```

## مدیریت ورژن‌ها

### 🔄 به‌روزرسانی ورژن‌ها
```bash
# اجرای اسکریپت به‌روزرسانی
./update-versions.sh

# یا دستی
./version-manager.sh
```

### 📋 فایل‌های ورژن
- `k8s-versions.yaml` - تعریف ورژن‌های دقیق
- `k8s-versions.env` - فایل محیطی (توسط version-manager.sh ایجاد می‌شود)

### 🎯 انتخاب ورژن مناسب
- **Development**: از `latest` استفاده کنید
- **Production**: از ورژن دقیق استفاده کنید
- **Nginx & MySQL**: همیشه از ورژن ثابت استفاده کنید

## نکات مهم

1. **Storage Class**: مطمئن شوید که storage class مناسب در cluster شما موجود است
2. **Access Modes**: برای volume مشترک از `ReadWriteMany` استفاده کنید
3. **Resource Limits**: حجم storage مورد نیاز را بر اساس پروژه تنظیم کنید
4. **Backup**: برای فایل‌های مهم backup strategy داشته باشید
5. **ورژن‌بندی**: nginx و mysql همیشه ورژن ثابت داشته باشند

## تنظیمات اضافی

### برای Production
- از `ReadWriteMany` storage class استفاده کنید
- Resource limits و requests مناسب تنظیم کنید
- Health checks اضافه کنید
- Monitoring و logging اضافه کنید
- از ورژن‌های دقیق استفاده کنید

### برای Development
- از `emptyDir` برای تست استفاده کنید
- حجم storage کمتری تنظیم کنید
- Debug mode فعال کنید
- از `latest` برای app استفاده کنید

## ابزارهای کمکی

### 📝 **اسکریپت‌های موجود**
- `build-and-push.sh` - Build و push image ها با ورژن‌بندی
- `version-manager.sh` - مدیریت ورژن‌ها
- `update-versions.sh` - به‌روزرسانی ورژن‌ها در Kubernetes
- `pull-images.sh` - Pull کردن image ها

### 📝 **فایل‌های Kubernetes**
- `k8s-deployment.yaml` - Development deployment
- `k8s-statefulset.yaml` - Production deployment
- `k8s-source-copy-job.yaml` - کپی کردن source files
- `k8s-versions.yaml` - تعریف ورژن‌های دقیق

## Workflow پیشنهادی

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
./update-versions.sh

# بررسی ورژن‌ها
cat k8s-versions.yaml

# Deploy در production
kubectl apply -f k8s-statefulset.yaml
```

## 🔍 Troubleshooting

### مشکلات رایج
1. **Volume mount errors**: بررسی کنید که PVC ها درست ایجاد شده باشند
2. **Image pull errors**: مطمئن شوید که image ها در registry موجود باشند
3. **Permission errors**: بررسی کنید که user و group درست تنظیم شده باشند
4. **Version conflicts**: از ورژن‌های صحیح استفاده کنید

### دستورات مفید
```bash
# بررسی Pod ها
kubectl describe pod <pod-name>

# بررسی Events
kubectl get events --sort-by='.lastTimestamp'

# بررسی Logs
kubectl logs <pod-name> -c <container-name>

# بررسی ConfigMaps
kubectl get configmaps
kubectl describe configmap <configmap-name>
``` 