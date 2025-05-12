FROM nginx:alpine

# Copy the custom Nginx configuration file
COPY nginx.conf /etc/nginx/conf.d/default.conf

# Copy the application files
COPY . /usr/share/nginx/html

EXPOSE 81