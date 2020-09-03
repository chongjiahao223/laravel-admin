
## vue-laravel后端API
[![PHP Version](https://img.shields.io/badge/PHP-%3E=7.2.5-brightgreen.svg?maxAge=2592000)](https://www.php.net/)
[![Laravel Version](https://img.shields.io/badge/Laravel-%3E=6.2.0-brightgreen.svg?maxAge=2592000)](https://learnku.com/docs/laravel/6.x)
1. 初始化步骤
    - 复制.env.example为.env，并修改.env中相关配置信息
    - composer install
    - php artisan key:generate
    - php artisan jwt:secret
    - 配置好数据库执行！！！
    - php artisan migrate
    - php artisan db:seed
2.  注意事项
    - 由于laravel使用门面模式缘故，在开发过程中会遇到很多对象在IDE中无法追踪，可以执行```php artisan ide-helper:generate```
    - 如果改完配置不生效可以尝试使用
        ```php
        php artisan config:clear && \
        php artisan cache:clear && \
        php artisan optimize
        ```
      
