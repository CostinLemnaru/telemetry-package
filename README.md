# Clone
git clone git@github.com:CostinLemnaru/telemetry-package.git
cd telemetry-package

# Build
docker compose build
docker compose up -d

# Install dependecies
docker compose exec php bash
composer install

# Run tests
./vendor/bin/phpunit