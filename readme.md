##数据库迁移
    php artisan migrate
##数据库填充
    php artisan make:factory Linkfactory创建工厂
    composer dump-autoload 
    php artisan make:seeder LinkTableSeeder    
    php artisan db:seed填充数据
    php artisan db:seed --class=UserSeeder 指定填充数据类
##git使用
    git add .
    git commit -m '提交内容'
    git push 提交线上
    git pull 把线上分支拉到线下
    git checkout marter 切换分支
    git meger 切换到主分支后，合并到主分支，功能开发完
    