podman run -d \
  --name caern-laravel \
  --network caern-network \
  -v .:/var/www \
  --security-opt label=disable \
  caern:master

podman run -d \
  --name caern-nginx \
  --network caern-network \
  -p 8004:80 \
  -v .:/var/www \
  --security-opt label=disable \
  caern-nginx:master

podman exec -u root caern-nginx chmod 755 /var/www

podman exec -u root caern-nginx chmod -R 755 /var/www
