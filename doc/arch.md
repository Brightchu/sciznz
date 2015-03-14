Science Compass Schema Specification
======
_2015-02-03_

架构的特点与目的
------
1. 数据无冗余。订单的状态需要不断更新，有时还需要回滚到之前的状态，因而要保证每次更新订单状态时，只修改一处，即更新了整个系统的状态。
2. 将仪器介绍，细节说明等灵活性较大的部分独立出数据库结构，转而用json存储，牺牲一小部分性能换取灵活性。
3. 动态静态数据分离。性能考虑。

数据库表设计
---
![database-struct](https://gitcafe.com/PillowSky/scicompass/raw/master/doc/img/database-struct.png "database-struct")

[数据库关系图](https://gitcafe.com/PillowSky/scicompass/raw/master/doc/img/database-struct.png)
[SQL文件](https://gitcafe.com/PillowSky/scicompass/raw/master/doc/database-struct.sql)

简单解释：

* `category` 仪器分类索引，如电镜，光谱仪，质谱仪  
* `catalog` 仪器型号索引，如PHILIPS CM120电子显微镜  
* `instrument` 仪器列表，每一条记录就真实地对应了一台仪器。每台仪器都有其归属的`institute`
* `user` 用户列表，用于登陆的账号信息等
* `comment` 评论列表
* `usage` 仪器占用列表，记录了仪器使用的时间段
* `order` 订单列表，融合了`user`和`usage`表，并有状态，费用等信息
* `institute` 单位列表，仪器的所有方，并设定了chief `operator`
* `operator` 操作员列表，每位操作员都有其归属的`institute`

功能实现举例
------
######1. 首页，搜索，查询：
   场地介绍，位置，评分等信息从`instrument`表中选择即可， 联合`catalog`表得到型号，联合`category`表得到分类。如果需要，还可以联合`usage`表过滤掉已经占用的时间段。
######2. 用户预订：
   先向`usage`表插入记录，表示时间段已占用，再向`order`表中插入记录生成订单，并触发通知操作员
######3. 订单状态的更新，修改：
   只要更新`order.status`项即可，用户和操作员共享一个`status`
