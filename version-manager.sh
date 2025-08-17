#!/bin/bash

# فایل مدیریت ورژن‌ها
# این فایل برای انتخاب ورژن مناسب برای deployment استفاده می‌شود

# تنظیمات registry
REGISTRY="registry.hamdocker.ir"
USERNAME="mahdi-saberi"

# رنگ‌ها
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
PURPLE='\033[0;35m'
NC='\033[0m'

echo -e "${GREEN}🔍 مدیریت ورژن‌های image ها${NC}"
echo ""

# نمایش ورژن‌های موجود برای app
echo -e "${BLUE}📱 ورژن‌های موجود Laravel App:${NC}"
docker images ${REGISTRY}/${USERNAME}/laravel-app --format "table {{.Tag}}\t{{.CreatedAt}}\t{{.Size}}" | head -10

echo ""

# نمایش ورژن‌های موجود برای nginx
echo -e "${BLUE}🌐 ورژن‌های موجود Nginx:${NC}"
docker images ${REGISTRY}/${USERNAME}/nginx --format "table {{.Tag}}\t{{.CreatedAt}}\t{{.Size}}" | head -10

echo ""

# نمایش ورژن‌های موجود برای mysql
echo -e "${BLUE}🗄️ ورژن‌های موجود MySQL:${NC}"
docker images ${REGISTRY}/${USERNAME}/mysql --format "table {{.Tag}}\t{{.CreatedAt}}\t{{.Size}}" | head -10

echo ""

# انتخاب ورژن برای deployment
echo -e "${YELLOW}💡 برای deployment:${NC}"
echo -e "  • App: از latest یا ورژن خاص استفاده کنید"
echo -e "  • Nginx: از 1.29.1-alpine استفاده کنید"
echo -e "  • MySQL: از 8.0 استفاده کنید"

echo ""

# نمایش آخرین ورژن app
LATEST_APP_VERSION=$(docker images ${REGISTRY}/${USERNAME}/laravel-app --format "{{.Tag}}" | grep -v "latest" | head -1)
if [ ! -z "$LATEST_APP_VERSION" ]; then
    echo -e "${PURPLE}📅 آخرین ورژن app: ${LATEST_APP_VERSION}${NC}"
else
    echo -e "${YELLOW}⚠️ هیچ ورژن app یافت نشد${NC}"
fi

echo ""

# ایجاد فایل ورژن برای Kubernetes
echo -e "${GREEN}📝 ایجاد فایل ورژن برای Kubernetes...${NC}"
cat > k8s-versions.env << EOF
# فایل ورژن‌های Kubernetes
# این فایل به صورت خودکار ایجاد می‌شود

# ورژن Laravel App
APP_VERSION=${LATEST_APP_VERSION:-latest}

# ورژن Nginx
NGINX_VERSION=1.29.1-alpine

# ورژن MySQL
MYSQL_VERSION=8.0

# تاریخ ایجاد
CREATED_AT=$(date)
EOF

echo -e "${GREEN}✅ فایل k8s-versions.env ایجاد شد${NC}"
echo ""

# نمایش محتوای فایل
echo -e "${BLUE}📋 محتوای فایل ورژن:${NC}"
cat k8s-versions.env

echo ""
echo -e "${GREEN}🎯 برای استفاده در Kubernetes:${NC}"
echo -e "  • از فایل k8s-versions.env برای تنظیم ورژن‌ها استفاده کنید"
echo -e "  • یا مستقیماً از ورژن‌های مشخص شده استفاده کنید"
echo -e "  • برای production از ورژن‌های دقیق استفاده کنید"
echo -e "  • برای development از latest استفاده کنید" 