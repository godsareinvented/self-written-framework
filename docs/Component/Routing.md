# Компонент

## Описание

При построении маршрутов из конфигурации
компонент берёт конфигурацию машрутов из компонента конфигурации, по ключу routing

## Пример конфигурационного файла

```
# routing.yaml:

routing:
  - request_uri: '/'
    default: true
    callable: 'App\Controller\FooController::bar'

  - request_uri: '/foo/baz'
    method: 'post'
    callable: 'App\Controller\FooController::baz'

```
