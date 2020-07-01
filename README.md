
# 码蚁免费成绩管理系统

　　坦率地讲，在不久的将来，这也许会是辽东半岛上第二好用的成绩统计系统。

![表情包](https://gitee.com/dlbz/shangma/raw/master/public/examples/timg.jpg)

　　言归正传

　　这是一款注重优化成绩采集方法、丰富成绩分析维度的小学成绩统计系统，力争做到符合教师工作习惯、使用方法简单、数据分析多样、分析结果科学，为教师的试卷分析、教育科研提供数据参考。

　　开发者是一名非计算机专业的小学教师，只因工作遇到了兴趣，才有了这个小项目。为了让自己统计成绩工作变得更优雅，才边学边写这个成绩统计项目。信息录入与输出简单，支持在单条录入和表格录入、表格输出，尽量让所有信息可管理。在操作设计中，遵循 Giles Colborne 的简约至上原则，尽量做到三步便可到达要操作的位置。统计维度参考华东师范大学教育学系王孝玲教授著作的《教育统计学》第五版。前端采用X-adminV2.2，后端采用ThinkPHP V6.0.3框架开发。


　　“情怀”的代言人罗永浩说：“科技的每一次进步，给我们带来的是更好的世界，而不是完美的世界”。因此，这个项目会一直走在奔向完美的路上，让统计成绩不再是一份辛苦的工作，让大家变成成绩分析牛人！



## 主要功能：

* 设置系统信息、单位信息管理、类别管理
* 学期、班级、学科管理
* 管理员、权限、角色管理
* 教师与学生信息管理
* 考试信息设置
* 设置参加考试学科及各学科的满分、优秀、及格分数线。
* 生成学生的考试号
* 生成学生试卷标签
* 生成学生成绩采集表
* 在线录入和修改成绩、表格录入成绩
* 使用扫码枪录入成绩
* 查看成绩列表、成绩图表
* 查看成绩统计结果(表格+统计表)
* 查看学生历次成绩(表格+统计表)


登录界面

![登录界面](https://gitee.com/dlbz/shangma/raw/master/public/examples/denglu.png)

欢迎页面

![欢迎页面](https://gitee.com/dlbz/shangma/raw/master/public/examples/欢迎页面.png)


![考试列表](https://gitee.com/dlbz/shangma/raw/master/public/examples/考试列表.png)

考试设置

![考试设置](https://gitee.com/dlbz/shangma/raw/master/public/examples/考试设置.png)

考试操作一

![考试操作一](https://gitee.com/dlbz/shangma/raw/master/public/examples/考试操作一.png)

考试操作二

![考试操作二](https://gitee.com/dlbz/shangma/raw/master/public/examples/考试操作二.png)

考试操作三

![考试操作三](https://gitee.com/dlbz/shangma/raw/master/public/examples/考试操作三.png)

扫码录入成绩

![扫码录入成绩](https://gitee.com/dlbz/shangma/raw/master/public/examples/扫码录入成绩.png)

表格录入成绩

![表格录入成绩](https://gitee.com/dlbz/shangma/raw/master/public/examples/表格录入成绩.png)

学生成绩列表

![学生成绩列表](https://gitee.com/dlbz/shangma/raw/master/public/examples/学生成绩列表.png)


已录成绩

![已录成绩](https://gitee.com/dlbz/shangma/raw/master/public/examples/已录成绩.png)

系统设置

![系统设置](https://gitee.com/dlbz/shangma/raw/master/public/examples/系统设置.png)

权限分配

![权限分配](https://gitee.com/dlbz/shangma/raw/master/public/examples/20190524164451.png)

平均分

![权限分配](https://gitee.com/dlbz/shangma/raw/master/public/examples/bjavg.png)

优秀率

![权限分配](https://gitee.com/dlbz/shangma/raw/master/public/examples/bjyouxiu.png)

及格率

![权限分配](https://gitee.com/dlbz/shangma/raw/master/public/examples/bjjige.png)

标准差

![权限分配](https://gitee.com/dlbz/shangma/raw/master/public/examples/bjbiaozhuncha.png)

箱体图

![权限分配](https://gitee.com/dlbz/shangma/raw/master/public/examples/bjchayi.png)


学生历次考试成绩

![权限分配](https://gitee.com/dlbz/shangma/raw/master/public/examples/学生成绩.png)



学生历次考试成绩得分率与成绩在班级、学校、全部中排序的大约位置

![权限分配](https://gitee.com/dlbz/shangma/raw/master/public/examples/学生成绩图表.png)


学生单次考试成绩

![权限分配](https://gitee.com/dlbz/shangma/raw/master/public/examples/学生单次考试成绩.png)




## 演示地址
[http://www.dl-sm.cn](http://www.dl-sm.cn) 或 [112.126.57.79](112.126.57.79)

帐号   test1    密码  123456

里面隐藏了两个很实用的功能，如果想了解隐藏功能，请下载。

## 更新内容
    增加表格操作是否参加考试状态，增加相对应的权限。
    修复考号生成错误、考试成绩查看错误
    env 配置文件中增加 session 设置、班级历次成绩查看
    修改删除方法
    全部整理代码重排版，规范字段、方法命名,部分数据操作放到数据模型中、拆分几个控制器
    固定基础数据ID

	更多更新日志（http://www.www.dl-sm.cn.cn/login/log）
## 升级提示
  v1.3.3升级到v1.3.4版本时，为了遵循TP开发规范，修改了数据库字段。需要重新建表。


## 更详细信息请查阅官方手册
https://www.kancloud.cn/llblax/abcd/789222

## 下一步工作
* 继续增加统计项目
* 以更多图表形式呈现统计结果
* 增加教师职务权限验证
* 增加学生自助查询成绩

## 求助
* 如果您觉得这个项目还可以，请在码云上给一个Star。
