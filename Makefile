build:
	docker-compose up --build -d

up:	
	docker-compose up -d

down:
	docker-compose down

sh:
	docker-compose exec php sh