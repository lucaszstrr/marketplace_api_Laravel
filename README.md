# Laravel Project - Motorcycle Shop API

## Accessing phpMyAdmin

With Docker running, you can access phpMyAdmin using the link:

- [http://localhost:8075](http://localhost:8075)

**User:** `root`  
**Password:** `root`

## Accessing the Backend

The base URL to access the backend is:

- [http://localhost:8005/api](http://localhost:8005/api)

## Usage Instructions

### Starting the Container

To start the container, run the following command:

```bash
docker compose up --build -d
```

### Initial Configuration

1. **Create the `.env` file:**  
   Copy the contents of the `.env.example` file into a new `.env` file inside the `/src` folder.

2. **Open the terminal inside the Docker container:**  
   Run the following command to access the container terminal:
   
   ```bash
   docker compose exec --user 1000:1000 php sh
   ```
   
3. **Install dependencies:**  
   Inside the Docker terminal, run the following command to install dependencies:
   
   ```bash
   composer update
   ```

4. **Generate the application key:**  
   Still inside the Docker terminal, run:
   
   ```bash
   php artisan key:generate
   ```

5. **Run the migrations:**  
   In the same terminal, run:
   
   ```bash
   php artisan migrate
   ```

## Important Notes

- Always run Docker commands in the same folder where the `docker-compose.yml` file is located (root folder).
- To run Laravel commands, you need to access the container terminal. For that, run the command:

  ```bash
  docker compose exec --user 1000:1000 php sh
  ```
