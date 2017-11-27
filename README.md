# e瞳用户账户中心

## 功能

* 统一管理用户个人信息
* 提供统一OAuth登录
* 提供个人信息获取接口
* 提供e瞳统一权限管理系统接口

## 后端部署

1. `composer install`
2. `php artisan migrate`
3. `php artisan passport:install`

## 编译前端文件

1. `npm install`
2. `npm run build`（开发过程中使用`npm run watch`持续监控文件修改，即时重新编译）

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
