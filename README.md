# Phalcon with Beanstalk and PCNTL_FORK
[Phalcon Compose][:phalcon:]에 내장된 Queue(Beanstalk)를 사용하여 병렬처리를 위해 [PCNTL_FORK][:pcntlfork:]을 적용함.

## Start
- docker-compose build
- make up

## Api
- localhost/api/addjob
- localhost/api/queueStatus
- localhost/api/queueDelete

## log
- docker logs -f {container name}