# راهنمای Complete Production Deployment

این راهنما برای deploy کردن اپلیکیشن Shokoofeh در محیط production با kubernetes طراحی شده است.

## 🎯 هدف

راه‌حل کامل برای مسائل:
- ✅ حفظ داده‌ها هنگام update کردن image
- ✅ مدیریت volume ها در kubernetes
- ✅ پشتیبان‌گیری خودکار
- ✅ deployment ایمن و بدون downtime

## 📁 ساختار Volume ها

### Laravel Application Volumes:
```
/data/shokoofeh/
├── storage/           # Laravel storage (logs, cache, sessions)
│   ├── app/
│   ├── framework/
│   │   ├── cache/
│   │   ├── sessions/
│   │   └── views/
│   └── logs/
├── uploads/           # فایل‌های upload شده توسط کاربران
└── config/           # تنظیمات محیط production
```

### MySQL Volumes:
```
/data/mysql/
├── data/             # داده‌های پایگاه داده
├── config/           # تنظیمات MySQL
└── backups/          # پشتیبان‌های خودکار
```

## 🚀 روش‌های Deployment

### 1. استفاده از Docker Compose (ساده‌تر)

#### گام 1: تنظیم اولیه
```bash
# دانلود فایل‌های پروژه
git clone [repository]
cd shokoofeh

# اجرای setup
./deploy-production.sh setup
```

#### گام 2: اولین deployment
```bash
./deploy-production.sh deploy
```

#### گام 3: Update های بعدی
```bash
# build و push image جدید
./build-and-push.sh

# deploy image جدید
./deploy-production.sh deploy
```

### 2. استفاده از Kubernetes (پیشرفته‌تر)

#### گام 1: تنظیم namespace و volumes
```bash
# ایجاد namespace
kubectl apply -f k8s-production.yaml

# بررسی PVC ها
kubectl get pvc -n shokoofeh-prod
```

#### گام 2: Deploy اولیه
```bash
# deploy تمام سرویس‌ها
kubectl apply -f k8s-production.yaml

# بررسی وضعیت
kubectl get pods -n shokoofeh-prod
kubectl get services -n shokoofeh-prod
```

#### گام 3: Update image
```bash
# update image در deployment
kubectl set image deployment/laravel-deployment \
  laravel=registry.hamdocker.ir/mahdi-saberi/shokoofeh-app:new-tag \
  -n shokoofeh-prod

# بررسی rollout
kubectl rollout status deployment/laravel-deployment -n shokoofeh-prod
```

## 🔄 استراتژی Update بدون از دست دادن داده

### 1. Rolling Update (پیشنهادی)
```yaml
spec:
  strategy:
    type: RollingUpdate
    rollingUpdate:
      maxUnavailable: 1
      maxSurge: 1
```

### 2. Blue-Green Deployment
```bash
# ایجاد deployment جدید
kubectl apply -f k8s-production-green.yaml

# تست deployment جدید
kubectl port-forward svc/laravel-service-green 8080:80 -n shokoofeh-prod

# switch traffic
kubectl patch service laravel-service -n shokoofeh-prod \
  -p '{"spec":{"selector":{"version":"green"}}}'
```

## 💾 مدیریت Backup

### Automatic Backup (در docker-compose)
```bash
# پشتیبان‌گیری دستی
./deploy-production.sh backup

# پشتیبان‌گیری خودکار (cron job)
# اضافه کردن به crontab:
0 2 * * * /path/to/deploy-production.sh backup
```

### Kubernetes Backup
```yaml
apiVersion: batch/v1
kind: CronJob
metadata:
  name: backup-job
spec:
  schedule: "0 2 * * *"
  jobTemplate:
    spec:
      template:
        spec:
          containers:
          - name: backup
            image: backup-image
            command: ["/backup-script.sh"]
```

## 🔧 تنظیمات مهم

### Environment Variables
```bash
# Laravel
APP_ENV=production
APP_DEBUG=false
LOG_LEVEL=error
FILESYSTEM_DISK=local

# Database
DB_HOST=mysql-service
DB_DATABASE=toyshop
DB_USERNAME=laravel
DB_PASSWORD=laravel

# Performance
CACHE_DRIVER=file
SESSION_LIFETIME=120
```

### Resource Limits
```yaml
resources:
  requests:
    memory: "256Mi"
    cpu: "250m"
  limits:
    memory: "512Mi"
    cpu: "500m"
```

## 🚨 مسائل مهم امنیتی

### 1. Secrets Management
```bash
# ایجاد secret برای database
kubectl create secret generic mysql-secret \
  --from-literal=username=laravel \
  --from-literal=password=secure-password \
  -n shokoofeh-prod
```

### 2. Network Policies
```yaml
apiVersion: networking.k8s.io/v1
kind: NetworkPolicy
metadata:
  name: laravel-netpol
spec:
  podSelector:
    matchLabels:
      app: laravel
  policyTypes:
  - Ingress
  - Egress
```

### 3. RBAC
```yaml
apiVersion: rbac.authorization.k8s.io/v1
kind: Role
metadata:
  name: shokoofeh-role
rules:
- apiGroups: [""]
  resources: ["pods", "services"]
  verbs: ["get", "list", "watch"]
```

## 📊 Monitoring و Logging

### Health Checks
```yaml
livenessProbe:
  httpGet:
    path: /health
    port: 80
  initialDelaySeconds: 30
  periodSeconds: 10

readinessProbe:
  httpGet:
    path: /health
    port: 80
  initialDelaySeconds: 5
  periodSeconds: 5
```

### Logging
```bash
# مشاهده logs
kubectl logs -f deployment/laravel-deployment -n shokoofeh-prod

# logs تمام container ها
kubectl logs -f -l app=laravel -n shokoofeh-prod
```

## 🔄 Rollback Strategy

### Docker Compose Rollback
```bash
# backup قبل از rollback
./deploy-production.sh backup

# rollback به image قبلی
docker-compose -f docker-compose.prod.yml down
docker tag registry.hamdocker.ir/mahdi-saberi/shokoofeh-app:previous-tag \
  registry.hamdocker.ir/mahdi-saberi/shokoofeh-app:latest
docker-compose -f docker-compose.prod.yml up -d
```

### Kubernetes Rollback
```bash
# مشاهده history
kubectl rollout history deployment/laravel-deployment -n shokoofeh-prod

# rollback به version قبلی
kubectl rollout undo deployment/laravel-deployment -n shokoofeh-prod

# rollback به version مشخص
kubectl rollout undo deployment/laravel-deployment \
  --to-revision=2 -n shokoofeh-prod
```

## 📋 Checklist قبل از Production

### Pre-deployment:
- [ ] تست application در محیط staging
- [ ] بررسی resource requirements
- [ ] تنظیم monitoring و alerting
- [ ] آماده‌سازی backup strategy
- [ ] تنظیم security policies

### Post-deployment:
- [ ] بررسی health checks
- [ ] تست functionality اصلی
- [ ] بررسی performance metrics
- [ ] تست rollback procedure
- [ ] documentation update

## 🆘 Troubleshooting

### مسائل متداول:

#### 1. Pod در حالت Pending
```bash
kubectl describe pod [pod-name] -n shokoofeh-prod
# بررسی PVC binding و resource availability
```

#### 2. Application در حال crash
```bash
kubectl logs [pod-name] -n shokoofeh-prod
# بررسی logs برای خطاهای Laravel
```

#### 3. Database connection issues
```bash
kubectl exec -it [mysql-pod] -n shokoofeh-prod -- mysql -u root -p
# بررسی اتصال مستقیم به MySQL
```

#### 4. Volume mount issues
```bash
kubectl describe pvc [pvc-name] -n shokoofeh-prod
# بررسی وضعیت volume binding
```

## 📞 پشتیبانی

برای مسائل فنی:
1. بررسی logs با دستورات بالا
2. بررسی monitoring dashboards
3. مراجعه به documentation
4. تماس با تیم DevOps

---

**نکته مهم:** همیشه قبل از هر update، backup تهیه کنید! 🔐 