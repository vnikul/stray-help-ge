FROM nginx:stable-alpine

# ADD Custom Config
ADD ./nginx/config/nginx.conf /etc/nginx/nginx.conf
ADD ./nginx/config/default.conf /etc/nginx/conf.d/default.conf

# Make Directory - Workspace
RUN mkdir -p /var/www/html

WORKDIR /var/www/html
