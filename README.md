# e瞳用户账户中心

## 功能

* 统一管理用户个人信息
* 提供统一OAuth登录
* 提供个人信息获取接口
* 提供e瞳统一权限管理系统接口

## 后端部署

```bash
git clone https://github.com/eeyes-net/mcm-2017-11.git
composer install
vi .env
php artisan migrate
php artisan passport:install
php artisan install
php artisan install:admin your_net_id
```

### 注意事项

* 开发过程中可以使用laravel-ide-helper生成PHPDoc帮助IDE解释类
    ```bash
    php artisan ide-helper:generate
    php artisan ide-helper:meta
    php artisan ide-helper:models
    ```

## 编译前端文件

```bash
npm install
npm run production
```

### 注意事项

* 开发过程中使用`npm run build`编译成可调试文件或使用`npm run watch`持续监控文件修改，即时重新编译。
* 使用[vue-devtools](https://github.com/vuejs/vue-devtools)在Chrome中调试Vue.js。
* 使用`mix.sourceMaps();`打开`sourceMaps`功能，可以在Chrome中根据源文件调试，而不是Webpack后的一整个文件。

## LICENSE

    The MIT License (MIT)
    
    Copyright (c) 2017 eeyes.net
    
    Permission is hereby granted, free of charge, to any person obtaining a copy
    of this software and associated documentation files (the "Software"), to deal
    in the Software without restriction, including without limitation the rights
    to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
    copies of the Software, and to permit persons to whom the Software is
    furnished to do so, subject to the following conditions:
    
    The above copyright notice and this permission notice shall be included in
    all copies or substantial portions of the Software.
