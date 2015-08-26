prepare:
		docker build -t composer docker/utils/composer

# ################################################################################################### #
#                                            COMPOSER                                                 #
# ################################################################################################### #
composer-install:
		docker run --rm -v $(shell pwd):/app --env-file docker/env/dev.env composer install --ignore-platform-reqs

composer-update:
		docker run --rm -v $(shell pwd):/app composer update --ignore-platform-reqs

composer-dump-autoload:
		docker run --rm -v $(shell pwd):/app composer dump-autoload --ignore-platform-reqs

# ################################################################################################### #
#                                              SYMFONY                                                #
# ################################################################################################### #
sf:
		docker exec -ti $(shell docker ps -aq -f name=docker_php_1) php app/console

# ################################################################################################### #
#                                               UTILS                                                 #
# ################################################################################################### #
file-permission:
		sudo chown -Rf $$USER:$$USER \
			app/config/parameters.yml \
			docker/logs docker/data \
			app/logs app/cache

# ################################################################################################### #
#                                            DOCKER-COMPOSE                                           #
# ################################################################################################### #
dc-kill:
		docker-compose -f docker/docker-dev.yml kill

dc-rm:
		docker-compose -f docker/docker-dev.yml rm -f

dc-build:
		docker-compose -f docker/docker-dev.yml build

dc-up:
		docker-compose -f docker/docker-dev.yml up -d

dc-logs:
		docker-compose -f docker/docker-dev.yml logs

dc-ps:
		docker-compose -f docker/docker-dev.yml ps

dc-stop:
		docker-compose -f docker/docker-dev.yml stop

dc-start:
		docker-compose -f docker/docker.dev.yml start

dc-reload: dc-kill dc-rm dc-build dc-up dc-ps

dc-stats:
		docker stats $(shell docker ps -q -f name=docker_)

# ################################################################################################### #
#                                                  GIT                                                #
# ################################################################################################### #
submodule:
		git submodule update --init --recursive
