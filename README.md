### Requirements
* [Git](https://git-scm.com/downloads)
* [Docker](https://docs.docker.com/engine/install/)

### Dev development
#### Step 1 - build docker image
```bash
docker build --tag skeleton:latest . --target dev --no-cache
```

#### Step 2 - copy generated files (.env, vendor and var) from image to host
```bash
for FILE in {.env,vendor,var};
  do docker cp $(docker create --rm skeleton:latest):/var/www/html/${FILE} ${PWD}/${FILE}
done
```

#### Step 3 - run image
```bash
docker run -v ${PWD}:/var/www/html --publish 80:80 --publish 443:443 --detach skeleton:latest
```

### Step 4 - run command
```bash
docker run --rm --interactive --tty --volume ${PWD}:/var/www/html -w /var/www/html skeleton:latest command
```
