#!/bin/bash

# اسکریپت به‌روزرسانی ورژن‌ها در فایل‌های Kubernetes
# این اسکریپت ورژن‌های image ها را در فایل‌های deployment به‌روزرسانی می‌کند

# تنظیمات registry
REGISTRY="registry.hamdocker.ir"
USERNAME="mahdi-saberi"

# ورژن جدید
APP_VERSION=$(date +"%Y.%m.%d-%H%M")

# رنگ‌ها برای output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
PURPLE='\033[0;35m'
NC='\033[0m' # No Color

echo -e "${GREEN}🚀 شروع به‌روزرسانی ورژن‌ها در فایل‌های Kubernetes${NC}"
echo -e "${PURPLE}📅 ورژن جدید: ${APP_VERSION}${NC}"
echo ""

# بررسی وجود فایل‌های Kubernetes
echo -e "${BLUE}🔍 بررسی فایل‌های Kubernetes...${NC}"

if [ ! -f "k8s-deployment.yaml" ]; then
    echo -e "${RED}❌ فایل k8s-deployment.yaml یافت نشد${NC}"
    exit 1
fi

if [ ! -f "k8s-statefulset.yaml" ]; then
    echo -e "${RED}❌ فایل k8s-statefulset.yaml یافت نشد${NC}"
    exit 1
fi

if [ ! -f "k8s-versions.yaml" ]; then
    echo -e "${RED}❌ فایل k8s-versions.yaml یافت نشد${NC}"
    exit 1
fi

echo -e "${GREEN}✅ تمام فایل‌های مورد نیاز یافت شدند${NC}"
echo ""

# به‌روزرسانی k8s-deployment.yaml
echo -e "${GREEN}📝 به‌روزرسانی k8s-deployment.yaml...${NC}"

# به‌روزرسانی ورژن image در init container
sed -i "s|image: ${REGISTRY}/${USERNAME}/shokoofeh-app:latest|image: ${REGISTRY}/${USERNAME}/shokoofeh-app:${APP_VERSION}|g" k8s-deployment.yaml

# به‌روزرسانی ورژن image در app container
sed -i "s|image: ${REGISTRY}/${USERNAME}/shokoofeh-app:latest|image: ${REGISTRY}/${USERNAME}/shokoofeh-app:${APP_VERSION}|g" k8s-deployment.yaml

echo -e "${GREEN}✅ k8s-deployment.yaml به‌روزرسانی شد${NC}"

# به‌روزرسانی k8s-statefulset.yaml
echo -e "${GREEN}📝 به‌روزرسانی k8s-statefulset.yaml...${NC}"

# به‌روزرسانی ورژن image در init container
sed -i "s|image: ${REGISTRY}/${USERNAME}/shokoofeh-app:latest|image: ${REGISTRY}/${USERNAME}/shokoofeh-app:${APP_VERSION}|g" k8s-statefulset.yaml

# به‌روزرسانی ورژن image در app container
sed -i "s|image: ${REGISTRY}/${USERNAME}/shokoofeh-app:latest|image: ${REGISTRY}/${USERNAME}/shokoofeh-app:${APP_VERSION}|g" k8s-statefulset.yaml

echo -e "${GREEN}✅ k8s-statefulset.yaml به‌روزرسانی شد${NC}"

# به‌روزرسانی k8s-versions.yaml
echo -e "${GREEN}📝 به‌روزرسانی k8s-versions.yaml...${NC}"

# به‌روزرسانی ورژن shokoofeh-app
sed -i "s|shokoofeh-app-version: \".*\"|shokoofeh-app-version: \"${APP_VERSION}\"|g" k8s-versions.yaml

echo -e "${GREEN}✅ k8s-versions.yaml به‌روزرسانی شد${NC}"

echo ""
echo -e "${GREEN}🎉 تمام فایل‌ها با موفقیت به‌روزرسانی شدند!${NC}"
echo ""
echo -e "${YELLOW}📋 خلاصه تغییرات:${NC}"
echo -e "  • k8s-deployment.yaml: ورژن ${APP_VERSION}"
echo -e "  • k8s-statefulset.yaml: ورژن ${APP_VERSION}"
echo -e "  • k8s-versions.yaml: ورژن ${APP_VERSION}"
echo ""
echo -e "${BLUE}💡 نکات مهم:${NC}"
echo -e "  • برای production از ورژن دقیق استفاده کنید: ${APP_VERSION}"
echo -e "  • برای rollback از ورژن قبلی استفاده کنید"
echo -e "  • فایل‌های backup در git موجود هستند"
echo ""
echo -e "${PURPLE}🚀 دستورات deployment:${NC}"
echo -e "  # Development:"
echo -e "  kubectl apply -f k8s-deployment.yaml"
echo -e ""
echo -e "  # Production:"
echo -e "  kubectl apply -f k8s-statefulset.yaml"
echo -e ""
echo -e "  # بررسی وضعیت:"
echo -e "  kubectl get pods -l app=shokoofeh-app" 