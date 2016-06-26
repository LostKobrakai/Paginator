all: kahlan

composer:
	composer install --quiet

kahlan: composer
	kahlan
processwire: composer
	kahlan --spec=spec/ProcessWire
