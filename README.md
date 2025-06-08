# chocola

### Project setup
```
docker compose up --build
docker exec -it chocola /bin/bash
php app.php
```

### Tests
```
docker exec -it chocola /bin/bash
vendor/bin/phpunit --coverage-html coverage
```
