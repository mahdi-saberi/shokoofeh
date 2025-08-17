#!/bin/bash

# اسکریپت مدیریت ورژن‌های image ها
# این اسکریپت ورژن‌های مختلف image ها را نمایش می‌دهد و مدیریت می‌کند

# تنظیمات registry
REGISTRY="registry.hamdocker.ir"
USERNAME="mahdi-saberi"

# رنگ‌ها برای output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
PURPLE='\033[0;35m'
NC='\033[0m' # No Color

echo -e "${GREEN}🔍 مدیریت ورژن‌های image ها${NC}"
echo -e "${YELLOW}Registry: ${REGISTRY}/${USERNAME}${NC}"
echo ""

# نمایش ورژن‌های shokoofeh-app
echo -e "${BLUE}📱 ورژن‌های shokoofeh-app:${NC}"
docker images ${REGISTRY}/${USERNAME}/shokoofeh-app --format "table {{.Tag}}\t{{.CreatedAt}}\t{{.Size}}" | head -10

if [ $? -ne 0 ]; then
    echo -e "${YELLOW}⚠️ هیچ ورژنی از shokoofeh-app یافت نشد${NC}"
fi

echo ""

# نمایش ورژن‌های mysql
echo -e "${BLUE}🗄️ ورژن‌های mysql:${NC}"
docker images ${REGISTRY}/${USERNAME}/mysql --format "table {{.Tag}}\t{{.CreatedAt}}\t{{.Size}}" | head -10

if [ $? -ne 0 ]; then
    echo -e "${YELLOW}⚠️ هیچ ورژنی از mysql یافت نشد${NC}"
fi

echo ""

# نمایش ورژن‌های nginx
echo -e "${BLUE}🌐 ورژن‌های nginx:${NC}"
docker images ${REGISTRY}/${USERNAME}/nginx --format "table {{.Tag}}\t{{.CreatedAt}}\t{{.Size}}" | head -10

if [ $? -ne 0 ]; then
    echo -e "${YELLOW}⚠️ هیچ ورژنی از nginx یافت نشد${NC}"
fi

echo ""

# یافتن آخرین ورژن shokoofeh-app
echo -e "${GREEN}🔍 یافتن آخرین ورژن shokoofeh-app...${NC}"
LATEST_APP_VERSION=$(docker images ${REGISTRY}/${USERNAME}/shokoofeh-app --format "{{.Tag}}" | grep -v "latest" | head -1)

if [ -n "$LATEST_APP_VERSION" ]; then
    echo -e "${GREEN}✅ آخرین ورژن: ${LATEST_APP_VERSION}${NC}"
else
    echo -e "${YELLOW}⚠️ هیچ ورژن مشخصی یافت نشد${NC}"
fi

echo ""

# نمایش خلاصه
echo -e "${PURPLE}📋 خلاصه ورژن‌ها:${NC}"
echo -e "  • shokoofeh-app: latest, ${LATEST_APP_VERSION:-"بدون ورژن مشخص"}"
echo -e "  • mysql: 8.0"
echo -e "  • nginx: 1.29.1-alpine"
echo ""
echo -e "${BLUE}💡 نکات مهم:${NC}"
echo -e "  • برای production از ورژن دقیق استفاده کنید"
echo -e "  • برای development از latest استفاده کنید"
echo -e "  • unified image شامل Laravel + Nginx + PHP-FPM است"
echo ""
echo -e "${PURPLE}🚀 دستورات مفید:${NC}"
echo -e "  # Pull آخرین ورژن:"
echo -e "  docker pull ${REGISTRY}/${USERNAME}/shokoofeh-app:latest"
echo -e ""
echo -e "  # Pull ورژن مشخص:"
echo -e "  docker pull ${REGISTRY}/${USERNAME}/shokoofeh-app:${LATEST_APP_VERSION:-"VERSION"}"
echo -e ""
echo -e "  # حذف ورژن‌های قدیمی:"
echo -e "  docker rmi ${REGISTRY}/${USERNAME}/shokoofeh-app:OLD_VERSION" 