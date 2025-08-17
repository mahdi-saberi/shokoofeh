#!/bin/bash

# اسکریپت به‌روزرسانی ورژن‌ها
# این اسکریپت ورژن‌های جدید را در فایل‌های Kubernetes اعمال می‌کند

# تنظیمات
REGISTRY="registry.hamdocker.ir"
USERNAME="mahdi-saberi"

# ورژن‌های ثابت
NGINX_VERSION="1.29.1-alpine"
MYSQL_VERSION="8.0"

# رنگ‌ها
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
PURPLE='\033[0;35m'
RED='\033[0;31m'
NC='\033[0m'

echo -e "${GREEN}🔄 به‌روزرسانی ورژن‌ها در فایل‌های Kubernetes${NC}"
echo ""

# دریافت ورژن جدید app
echo -e "${BLUE}📱 ورژن جدید Laravel App را وارد کنید:${NC}"
echo -e "${YELLOW}💡 برای استفاده از latest، فقط Enter بزنید${NC}"
read -p "ورژن (مثال: 2025.01.28-1430): " APP_VERSION

if [ -z "$APP_VERSION" ]; then
    APP_VERSION="latest"
    echo -e "${GREEN}✅ استفاده از latest${NC}"
else
    echo -e "${GREEN}✅ ورژن انتخاب شده: ${APP_VERSION}${NC}"
fi

echo ""

# به‌روزرسانی فایل‌های Kubernetes
echo -e "${BLUE}📝 به‌روزرسانی فایل‌های Kubernetes...${NC}"

# ۱. به‌روزرسانی k8s-deployment.yaml
if [ -f "k8s-deployment.yaml" ]; then
    echo -e "${GREEN}📄 به‌روزرسانی k8s-deployment.yaml...${NC}"
    
    # به‌روزرسانی ورژن app
    if [ "$APP_VERSION" != "latest" ]; then
        sed -i "s|image: ${REGISTRY}/${USERNAME}/laravel-app:latest|image: ${REGISTRY}/${USERNAME}/laravel-app:${APP_VERSION}|g" k8s-deployment.yaml
        echo -e "  ✅ ورژن app به ${APP_VERSION} تغییر یافت"
    fi
    
    # بررسی ورژن nginx
    if grep -q "image: ${REGISTRY}/${USERNAME}/nginx:1.29.1-alpine" k8s-deployment.yaml; then
        echo -e "  ✅ ورژن nginx صحیح است (1.29.1-alpine)"
    else
        echo -e "  ⚠️ ورژن nginx نیاز به بررسی دارد"
    fi
    
    # بررسی ورژن mysql
    if grep -q "image: ${REGISTRY}/${USERNAME}/mysql:8.0" k8s-deployment.yaml; then
        echo -e "  ✅ ورژن mysql صحیح است (8.0)"
    else
        echo -e "  ⚠️ ورژن mysql نیاز به بررسی دارد"
    fi
else
    echo -e "${YELLOW}⚠️ فایل k8s-deployment.yaml یافت نشد${NC}"
fi

# ۲. به‌روزرسانی k8s-statefulset.yaml
if [ -f "k8s-statefulset.yaml" ]; then
    echo -e "${GREEN}📄 به‌روزرسانی k8s-statefulset.yaml...${NC}"
    
    # به‌روزرسانی ورژن app
    if [ "$APP_VERSION" != "latest" ]; then
        sed -i "s|image: ${REGISTRY}/${USERNAME}/laravel-app:latest|image: ${REGISTRY}/${USERNAME}/laravel-app:${APP_VERSION}|g" k8s-statefulset.yaml
        echo -e "  ✅ ورژن app به ${APP_VERSION} تغییر یافت"
    fi
    
    # بررسی ورژن nginx
    if grep -q "image: ${REGISTRY}/${USERNAME}/nginx:1.29.1-alpine" k8s-statefulset.yaml; then
        echo -e "  ✅ ورژن nginx صحیح است (1.29.1-alpine)"
    else
        echo -e "  ⚠️ ورژن nginx نیاز به بررسی دارد"
    fi
    
    # بررسی ورژن mysql
    if grep -q "image: ${REGISTRY}/${USERNAME}/mysql:8.0" k8s-statefulset.yaml; then
        echo -e "  ✅ ورژن mysql صحیح است (8.0)"
    else
        echo -e "  ⚠️ ورژن mysql نیاز به بررسی دارد"
    fi
else
    echo -e "${YELLOW}⚠️ فایل k8s-statefulset.yaml یافت نشد${NC}"
fi

# ۳. به‌روزرسانی k8s-versions.yaml
if [ -f "k8s-versions.yaml" ]; then
    echo -e "${GREEN}📄 به‌روزرسانی k8s-versions.yaml...${NC}"
    
    # به‌روزرسانی ورژن app
    sed -i "s|laravel-app-version: \".*\"|laravel-app-version: \"${APP_VERSION}\"|g" k8s-versions.yaml
    echo -e "  ✅ ورژن app به ${APP_VERSION} تغییر یافت"
    
    # به‌روزرسانی تاریخ
    CURRENT_DATE=$(date +"%Y-%m-%d")
    sed -i "s|last-updated: \".*\"|last-updated: \"${CURRENT_DATE}\"|g" k8s-versions.yaml
    echo -e "  ✅ تاریخ به‌روزرسانی به ${CURRENT_DATE} تغییر یافت"
else
    echo -e "${YELLOW}⚠️ فایل k8s-versions.yaml یافت نشد${NC}"
fi

echo ""

# نمایش خلاصه تغییرات
echo -e "${GREEN}🎉 به‌روزرسانی ورژن‌ها تکمیل شد!${NC}"
echo ""
echo -e "${YELLOW}📋 خلاصه ورژن‌های فعلی:${NC}"
echo -e "  • Laravel App: ${APP_VERSION}"
echo -e "  • Nginx: ${NGINX_VERSION}"
echo -e "  • MySQL: ${MYSQL_VERSION}"
echo ""

# نمایش دستورات deployment
echo -e "${BLUE}🚀 دستورات deployment:${NC}"
echo -e "  # برای development:"
echo -e "  kubectl apply -f k8s-deployment.yaml"
echo -e ""
echo -e "  # برای production:"
echo -e "  kubectl apply -f k8s-statefulset.yaml"
echo -e ""
echo -e "  # برای اعمال ورژن‌های جدید:"
echo -e "  kubectl apply -f k8s-versions.yaml"
echo ""

# بررسی تغییرات
echo -e "${BLUE}🔍 بررسی تغییرات انجام شده:${NC}"
echo -e "  # نمایش diff فایل‌ها:"
echo -e "  git diff k8s-deployment.yaml"
echo -e "  git diff k8s-statefulset.yaml"
echo -e "  git diff k8s-versions.yaml" 