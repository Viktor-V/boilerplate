## Requirements
* [Git](https://git-scm.com/downloads)
* [Docker](https://docs.docker.com/engine/install/)
* [Docker Compose](https://docs.docker.com/compose/install/)
* [WSL2](https://docs.microsoft.com/en-us/windows/wsl/install-win10) - only Windows 10

## Dev development
#### Step 1 - build docker image
```bash
cd /path/to/project

docker-compose build --no-cache --pull
```

#### Step 2 - run image
```bash
docker-compose up -d
```

You are done and ready to create your best application. Visit [https://localhost/doc](https://localhost/doc)

### Troubleshooting
If website is not started check that application and traefik are running:
```bash
docker ps
```

If they are running check logs:
```bash
docker logs caddy
docker logs php
```

## Helpful
Exec `php`, `composer`, `node` and etc.
Create aliases to be able to run commands as `php`, `composer`, `node`, etc.

```bash
docker exec -it php php
docker exec -it php composer
```
