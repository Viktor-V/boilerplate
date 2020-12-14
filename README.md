### Requirements
* [Git](https://git-scm.com/downloads)
* [Docker](https://docs.docker.com/engine/install/)

### Dev development
#### Step 1 - build docker image
```bash
docker-compose build --no-cache
```

#### Step 2 - copy generated files (.env, vendor and var) from image to host
```bash
for FILE in {.env,vendor,var};
  do docker cp $(docker create --rm skeleton:latest):/var/www/html/${FILE} ${PWD}/${FILE}
done
```

#### Step 3 - run image
```bash
docker-compose up -d
```

#### Step 4 - run command
```bash
docker exec web command 
```

### Utils
Reset PHP workers in the container (to reload your PHP source code)
```bash
docker exec web rr -c .rr.dev.yaml http:reset
```
Show PHP workers' status
```bash
docker exec web rr -c .rr.dev.yaml http:workers -i
```

### Auto-Reloading
Auto reloading is enabled by default. RoadRunner detects PHP file changes and reload connected services.
To turn off this feature, remove the `reload` section in .rr.dev.yaml.

see: [Roadrunner : Auto-Reloading](https://roadrunner.dev/docs/beep-beep-reload)
