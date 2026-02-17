# syntax=docker/dockerfile:1
# Stage 1: Build assets (optimized)
FROM node:18-alpine AS builder

# Set working directory
WORKDIR /var/www

# Copy package files for better caching
COPY package.json package-lock.json ./

# Install dependencies with cache mount (including dev dependencies for build)
RUN --mount=type=cache,target=/root/.npm \
    npm ci

# Copy source code
COPY . .

# Build assets and clean up
RUN npm run build \
    && rm -rf node_modules \
    && npm cache clean --force

# Stage 2: Nginx production image
FROM nginx:alpine

# Install curl for health checks
RUN apk add --no-cache curl

# Copy custom Nginx configuration
COPY ./docker/production/nginx/nginx.conf /etc/nginx/nginx.conf

# Copy built assets from builder stage
COPY --from=builder /var/www/public /var/www/public

# Create nginx user and set permissions
RUN chown -R nginx:nginx /var/www/public \
    && chmod -R 755 /var/www/public

# Add health check
HEALTHCHECK --interval=30s --timeout=3s --start-period=5s --retries=3 \
    CMD curl -f http://localhost/health || exit 1

# Set working directory
WORKDIR /var/www/public

# Expose port 80
EXPOSE 80

# Start Nginx
CMD ["nginx", "-g", "daemon off;"]
