# Компонент

## Описание

Компонент берёт конфигурацию сервисов всегда из компонента конфигурации, по ключу services

## Пример конфигурационного файла

```
# services.yaml:

services:
  App\Service\C:
    arguments:
      $b: 'App\Service\B'
  
  App\Service\B:
    arguments:
      $a: 'App\Service\A'
  
  App\Service\A: ~
```
