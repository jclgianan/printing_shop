## Running the Project with Docker

This project provides a Docker setup for running the PHP application using PHP-FPM (version 8.2, Alpine-based). All required PHP extensions and Composer dependencies are installed during the build process.

### Requirements
- Docker and Docker Compose installed on your system
- (Optional) `.env` file for environment variables. You can use `.env.example` as a template.

### Build and Run Instructions
1. **Build and start the containers:**
   ```bash
   docker compose up --build
   ```
   This will build the `php-app` service using the provided `Dockerfile` and start it.

2. **Environment Variables:**
   - The container can use environment variables from a `.env` file in the project root. Uncomment the `env_file` line in `docker-compose.yml` if you wish to use it.
   - Review `.env.example` for required variables and copy it to `.env` if needed.

3. **Permissions:**
   - The container sets correct permissions for `storage` and `bootstrap/cache` directories automatically.

### Exposed Ports
- **php-app:**
  - Port `9000` is exposed for PHP-FPM. You can connect a web server (e.g., nginx or apache) to this port if needed.

### Notes
- The application runs as a non-root user (`appuser`) for improved security.
- All PHP dependencies are installed with Composer during the build stage.
- If you need to add a web server, update `docker-compose.yml` accordingly and expose the HTTP port.

For any additional configuration, refer to the `.env.example` file and adjust as needed for your environment.