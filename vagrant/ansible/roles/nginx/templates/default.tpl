server {
    listen 80;
 
    server_name conticket.local;
    root /vagrant/web;
 
    error_log /var/log/nginx/symfony2.error.log;
    access_log /var/log/nginx/symfony2.access.log;
 
    location / {
        index app_dev.php;
        try_files $uri /$uri /app_dev.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_split_path_info ^(.+\.php)(/.+)$;
        fastcgi_pass unix:/var/run/php5-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }
}
