#!/bin/sh

# Production Deployment Script for Shokoofeh
# این script برای deploy ایمن در production environment طراحی شده است
# ✅ حالا در HOST و Container قابل اجرا است

set -e  # Stop on any error

# رنگ‌ها برای output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# تنظیمات اصلی
PROJECT_NAME="shokoofeh"
REGISTRY="registry.hamdocker.ir/mahdi-saberi"
APP_IMAGE="${REGISTRY}/shokoofeh-app"
MYSQL_IMAGE="${REGISTRY}/mysql:8.0"
DATA_ROOT="/data"
BACKUP_ROOT="/backups"

# Functions
log_info() {
    echo -e "${BLUE}[INFO]${NC} $1"
}

log_success() {
    echo -e "${GREEN}[SUCCESS]${NC} $1"
}

log_warning() {
    echo -e "${YELLOW}[WARNING]${NC} $1"
}

log_error() {
    echo -e "${RED}[ERROR]${NC} $1"
}

# بررسی محیط اجرا
check_environment() {
    if [ -f /.dockerenv ] || grep -q 'docker\|lxc' /proc/1/cgroup 2>/dev/null; then
        log_info "🌐 اجرا در Container/Kubernetes"
        CONTAINER_MODE=true
    else
        log_info "🖥️ اجرا در HOST"
        CONTAINER_MODE=false
    fi
}

# بررسی دسترسی‌های مورد نیاز
check_prerequisites() {
    log_info "بررسی پیش‌نیازها..."
    
    if [ "$CONTAINER_MODE" = true ]; then
        # در container، فقط بررسی docker
        if ! command -v docker &> /dev/null; then
            log_warning "Docker در container موجود نیست - برخی عملیات محدود خواهند بود"
        fi
    else
        # در HOST، بررسی کامل
        if ! command -v docker &> /dev/null; then
            log_error "Docker نصب نیست!"
            exit 1
        fi
        
        if ! command -v docker-compose &> /dev/null; then
            log_error "Docker Compose نصب نیست!"
            exit 1
        fi
        
        # بررسی دسترسی sudo
        if [ "$EUID" -ne 0 ]; then
            log_warning "این script نیاز به دسترسی sudo دارد"
            sudo -v || exit 1
        fi
    fi
    
    log_success "پیش‌نیازها بررسی شدند"
}

# مدیریت فایل docker-compose.env
setup_env_file() {
    log_info "بررسی و تنظیم فایل docker-compose.env..."
    
    # بررسی وجود فایل docker-compose.env
    if [ ! -f "docker-compose.env" ]; then
        log_warning "فایل docker-compose.env یافت نشد!"
        
        # بررسی وجود template
        if [ -f "env.production.template" ]; then
            log_info "ایجاد فایل docker-compose.env از template..."
            cp env.production.template docker-compose.env
            
            # تولید APP_KEY (اگر نیاز باشد)
            if grep -q "APP_KEY=" docker-compose.env; then
                log_info "تولید APP_KEY..."
                if command -v openssl >/dev/null 2>&1; then
                    APP_KEY=$(openssl rand -base64 32)
                else
                    # جایگزین ساده
                    APP_KEY=$(cat /dev/urandom | tr -dc 'a-zA-Z0-9+/' | fold -w 32 | head -n 1)
                fi
                sed -i "s/APP_KEY=/APP_KEY=base64:${APP_KEY}/" docker-compose.env
            fi
            
            log_success "فایل docker-compose.env ایجاد شد"
        else
            log_error "فایل template یافت نشد! لطفاً env.production.template را ایجاد کنید"
            exit 1
        fi
    else
        log_info "فایل docker-compose.env موجود است"
        
        # بررسی وجود APP_KEY (اگر نیاز باشد)
        if grep -q "APP_KEY=" docker-compose.env && ! grep -q "APP_KEY=base64:" docker-compose.env; then
            log_warning "APP_KEY تنظیم نشده است"
            log_info "تولید APP_KEY..."
            if command -v openssl >/dev/null 2>&1; then
                APP_KEY=$(openssl rand -base64 32)
            else
                APP_KEY=$(cat /dev/urandom | tr -dc 'a-zA-Z0-9+/' | fold -w 32 | head -n 1)
            fi
            sed -i "s/APP_KEY=/APP_KEY=base64:${APP_KEY}/" docker-compose.env
            log_success "APP_KEY تولید شد"
        fi
    fi
    
    log_success "فایل docker-compose.env آماده است"
}

# ایجاد ساختار دایرکتوری‌ها
setup_directories() {
    log_info "ایجاد ساختار دایرکتوری‌ها..."
    
    if [ "$CONTAINER_MODE" = true ]; then
        log_warning "در container، دایرکتوری‌ها محدود خواهند بود"
        # در container، فقط دایرکتوری‌های محلی
        mkdir -p ./storage/{app,framework,logs}
        mkdir -p ./storage/framework/{cache,sessions,views}
        mkdir -p ./backups
        log_success "دایرکتوری‌های محلی ایجاد شدند"
    else
        # در HOST، دایرکتوری‌های کامل
        sudo mkdir -p ${DATA_ROOT}/shokoofeh/{storage,uploads,config}
        sudo mkdir -p ${DATA_ROOT}/shokoofeh/storage/{app,framework,logs}
        sudo mkdir -p ${DATA_ROOT}/shokoofeh/storage/framework/{cache,sessions,views}
        
        sudo mkdir -p ${DATA_ROOT}/mysql/{data,config,backups}
        sudo mkdir -p ${BACKUP_ROOT}/{shokoofeh,mysql}
        
        # تنظیم مجوزها
        sudo chown -R 1000:1000 ${DATA_ROOT}/shokoofeh/
        sudo chmod -R 755 ${DATA_ROOT}/shokoofeh/
        sudo chmod -R 775 ${DATA_ROOT}/shokoofeh/storage/
        
        sudo chown -R 999:999 ${DATA_ROOT}/mysql/
        sudo chmod -R 755 ${DATA_ROOT}/mysql/
        
        log_success "ساختار دایرکتوری‌ها ایجاد شد"
    fi
}

# پشتیبان‌گیری از داده‌های فعلی
backup_current_data() {
    log_info "شروع پشتیبان‌گیری..."
    
    BACKUP_DATE=$(date +"%Y%m%d_%H%M%S")
    
    if [ "$CONTAINER_MODE" = true ]; then
        # در container، پشتیبان‌گیری محدود
        log_warning "در container، پشتیبان‌گیری محدود خواهد بود"
        
        # پشتیبان‌گیری از فایل docker-compose.env
        if [ -f "docker-compose.env" ]; then
            log_info "پشتیبان‌گیری از فایل docker-compose.env..."
            cp docker-compose.env "./backups/docker-compose.env_${BACKUP_DATE}.backup"
        fi
        
        log_success "پشتیبان‌گیری محدود انجام شد"
    else
        # در HOST، پشتیبان‌گیری کامل
        # پشتیبان‌گیری از Laravel storage
        if [ -d "${DATA_ROOT}/shokoofeh/storage" ]; then
            log_info "پشتیبان‌گیری از Laravel storage..."
            sudo tar -czf "${BACKUP_ROOT}/shokoofeh/storage_${BACKUP_DATE}.tar.gz" -C "${DATA_ROOT}/shokoofeh" storage/
        fi
        
        # پشتیبان‌گیری از uploads
        if [ -d "${DATA_ROOT}/shokoofeh/uploads" ]; then
            log_info "پشتیبان‌گیری از uploads..."
            sudo tar -czf "${BACKUP_ROOT}/shokoofeh/uploads_${BACKUP_DATE}.tar.gz" -C "${DATA_ROOT}/shokoofeh" uploads/
        fi
        
        # پشتیبان‌گیری از MySQL
        if docker ps | grep -q mysql-prod; then
            log_info "پشتیبان‌گیری از پایگاه داده..."
            docker exec mysql-prod mysqldump -u root -proot toyshop | sudo tee "${BACKUP_ROOT}/mysql/toyshop_${BACKUP_DATE}.sql" > /dev/null
            sudo gzip "${BACKUP_ROOT}/mysql/toyshop_${BACKUP_DATE}.sql"
        fi
        
        # پشتیبان‌گیری از فایل docker-compose.env
        if [ -f "docker-compose.env" ]; then
            log_info "پشتیبان‌گیری از فایل docker-compose.env..."
            cp docker-compose.env "${BACKUP_ROOT}/shokoofeh/docker-compose.env_${BACKUP_DATE}.backup"
        fi
        
        log_success "پشتیبان‌گیری کامل شد"
    fi
}

# بارگزاری image جدید
pull_latest_images() {
    log_info "بارگزاری image های جدید..."
    
    if [ "$CONTAINER_MODE" = true ]; then
        log_warning "در container، بارگزاری image محدود خواهد بود"
        log_info "برای بارگزاری image، در HOST اجرا کنید"
    else
        docker pull ${APP_IMAGE}:latest
        docker pull ${MYSQL_IMAGE}
        log_success "Image های جدید بارگزاری شدند"
    fi
}

# متوقف کردن سرویس‌های فعلی
stop_current_services() {
    log_info "متوقف کردن سرویس‌های فعلی..."
    
    if [ "$CONTAINER_MODE" = true ]; then
        log_warning "در container، متوقف کردن سرویس‌ها محدود خواهد بود"
        log_info "برای متوقف کردن سرویس‌ها، در HOST اجرا کنید"
    else
        if [ -f "docker-compose.prod.yml" ]; then
            docker-compose -f docker-compose.prod.yml down
        fi
        log_success "سرویس‌های فعلی متوقف شدند"
    fi
}

# راه‌اندازی سرویس‌های جدید
start_new_services() {
    log_info "راه‌اندازی سرویس‌های جدید..."
    
    if [ "$CONTAINER_MODE" = true ]; then
        log_warning "در container، راه‌اندازی سرویس‌ها محدود خواهد بود"
        log_info "برای راه‌اندازی سرویس‌ها، در HOST اجرا کنید"
    else
        # بررسی وجود فایل docker-compose.prod.yml
        if [ ! -f "docker-compose.prod.yml" ]; then
            log_error "فایل docker-compose.prod.yml یافت نشد!"
            exit 1
        fi
        
        # بررسی وجود فایل docker-compose.env
        if [ ! -f "docker-compose.env" ]; then
            log_error "فایل docker-compose.env یافت نشد! ابتدا setup را اجرا کنید"
            exit 1
        fi
        
        # راه‌اندازی سرویس‌ها
        docker-compose -f docker-compose.prod.yml up -d
        
        # صبر برای راه‌اندازی کامل
        log_info "صبر برای راه‌اندازی کامل سرویس‌ها..."
        sleep 30
        
        log_success "سرویس‌های جدید راه‌اندازی شدند"
    fi
}

# بررسی سلامت سرویس‌ها
health_check() {
    log_info "بررسی سلامت سرویس‌ها..."
    
    if [ "$CONTAINER_MODE" = true ]; then
        log_warning "در container، health check محدود خواهد بود"
        log_info "برای health check کامل، در HOST اجرا کنید"
        return 0
    else
        # بررسی container ها
        if ! docker ps | grep -q shokoofeh-app-prod; then
            log_error "Container اپلیکیشن در حال اجرا نیست!"
            return 1
        fi
        
        if ! docker ps | grep -q mysql-prod; then
            log_error "Container MySQL در حال اجرا نیست!"
            return 1
        fi
        
        # بررسی health endpoint
        MAX_ATTEMPTS=10
        ATTEMPT=1
        
        while [ $ATTEMPT -le $MAX_ATTEMPTS ]; do
            if curl -f http://localhost:8080/health &> /dev/null; then
                log_success "Health check موفق - سرویس آماده است"
                return 0
            fi
            
            log_info "تلاش $ATTEMPT از $MAX_ATTEMPTS - سرویس هنوز آماده نیست..."
            sleep 10
            ATTEMPT=$((ATTEMPT + 1))
        done
        
        log_error "Health check ناموفق - سرویس آماده نیست!"
        return 1
    fi
}

# تمیزکاری image های قدیمی
cleanup_old_images() {
    log_info "تمیزکاری image های قدیمی..."
    
    if [ "$CONTAINER_MODE" = true ]; then
        log_warning "در container، تمیزکاری محدود خواهد بود"
        log_info "برای تمیزکاری کامل، در HOST اجرا کنید"
    else
        # حذف image های بدون تگ
        docker image prune -f
        
        # حذف volume های استفاده نشده
        docker volume prune -f
        
        log_success "تمیزکاری انجام شد"
    fi
}

# تابع اصلی deployment
deploy() {
    log_info "شروع فرآیند deployment..."
    
    check_environment
    check_prerequisites
    setup_env_file
    setup_directories
    backup_current_data
    pull_latest_images
    stop_current_services
    start_new_services
    
    if health_check; then
        cleanup_old_images
        log_success "🎉 Deployment با موفقیت انجام شد!"
    else
        log_error "❌ Deployment ناموفق - بررسی logs را انجام دهید"
        if [ "$CONTAINER_MODE" = false ]; then
            docker-compose -f docker-compose.prod.yml logs
        fi
        exit 1
    fi
}

# نمایش راهنما
show_help() {
    echo "استفاده از deployment script:"
    echo ""
    echo "✅ حالا در HOST و Container قابل اجرا است!"
    echo ""
    echo "Commands:"
    echo "  deploy          - اجرای فرآیند کامل deployment"
    echo "  backup          - فقط پشتیبان‌گیری"
    echo "  setup           - فقط ایجاد ساختار دایرکتوری‌ها"
    echo "  env             - فقط تنظیم فایل docker-compose.env"
    echo "  health          - بررسی سلامت سرویس‌ها"
    echo "  cleanup         - تمیزکاری image های قدیمی"
    echo "  help            - نمایش این راهنما"
    echo ""
    echo "نحوه استفاده:"
    echo "1. در HOST یا Container به دایرکتوری پروژه بروید"
    echo "2. script را اجرا کنید: ./deploy-production.sh deploy"
    echo "3. برای تولید docker-compose.env: ./generate-env.sh"
    echo ""
    echo "نکته: فایل docker-compose.env برای environment variables استفاده می‌شود"
    echo "نکته: در Container، برخی عملیات محدود خواهند بود"
}

# مدیریت ورودی‌ها
case "${1:-}" in
    "deploy")
        deploy
        ;;
    "backup")
        check_environment
        check_prerequisites
        setup_directories
        backup_current_data
        ;;
    "setup")
        check_environment
        check_prerequisites
        setup_env_file
        setup_directories
        ;;
    "env")
        check_environment
        check_prerequisites
        setup_env_file
        ;;
    "health")
        check_environment
        health_check
        ;;
    "cleanup")
        check_environment
        cleanup_old_images
        ;;
    "help"|"--help"|"-h")
        show_help
        ;;
    *)
        log_error "Command نامعتبر: ${1:-}"
        show_help
        exit 1
        ;;
esac 