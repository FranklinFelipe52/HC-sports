
# build images 
podman build -f docker/production/Dockerfile.production -t caern:master .
podman build -f docker/production/nginx/Dockerfile -t caern-nginx:master .
