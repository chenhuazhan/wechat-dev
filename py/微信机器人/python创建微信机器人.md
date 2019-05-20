## Python创建微信机器人

原创： 猪哥 [裸睡的猪](javascript:void(0);) *4月20日*

微信，一个日活10亿的超级app，不仅在国内社交独领风骚，在国外社交也同样占有一席之地。今天我们要讲的便是**如何用Python来做一个微信聊天机器人**，突然想起鲁迅先生曾经说过的一句话：
![img](https://mmbiz.qpic.cn/mmbiz_jpg/lbvmSLlcGOibECLLS8PamsA9ZQibmsPw3yIPibyN2QUeW27SNnkrX17pWzZXYhK2EeeRawBmtLuAPJv54Ck5eaFKA/640?wx_fmt=jpeg&tp=webp&wxfrom=5&wx_lazy=1&wx_co=1)

因为是微信机器人系列的第一篇文章，所以猪哥会特别详细的讲解每一个地方，使**零基础**的同学也能顺顺利利的开始，下面就让我们一起来做些有趣的事吧！
![img](https://mmbiz.qpic.cn/mmbiz_png/lbvmSLlcGOibECLLS8PamsA9ZQibmsPw3ycCWKuMAtgR6FkKmCTj7soygBGRO9QtmswMg8BosC11zib553hvUqaSw/640?wx_fmt=png&tp=webp&wxfrom=5&wx_lazy=1&wx_co=1)

## 一、项目介绍

## 1.微信库选择

python关于开发微信的库主要有`itchat`和`wxpy`，而`wxpy`底层是调用的`itchat`，所以如果你只是要使用的话建议使用`wxpy`库，它比其他的库都要优雅，更面向对象，而且深度整合了`图灵机器人`和`小i机器人`；而`itchat`扩展性更好，如果你想自己开发一个自己的微信库那建议选`itchat`。

## 2.实现原理

我相信有不少同学使用过微信的网页版，而`wxpy`（底层使用`itchat`）库就是模拟登录网页端，然后调用微信的api实现操作的，我们可以查看`itchat`源码发现。
![img](https://mmbiz.qpic.cn/mmbiz_jpg/lbvmSLlcGOibECLLS8PamsA9ZQibmsPw3ypSG8COsBgaQSo7oIqg4QjnqNGPyByuYLDiawIlzOphU5GubGSViar5OQ/640?wx_fmt=jpeg&tp=webp&wxfrom=5&wx_lazy=1&wx_co=1)
![img](https://mmbiz.qpic.cn/mmbiz_jpg/lbvmSLlcGOibECLLS8PamsA9ZQibmsPw3yLjELmwOAYf2ibPZugdWaaQyEQ2brKYriaPtlzRRecAqaX2yyz6sCNnfA/640?wx_fmt=jpeg&tp=webp&wxfrom=5&wx_lazy=1&wx_co=1)
总之大家记住，**目前wxpy和itchat都是模拟网页版微信来操作的**。

### 3.图灵机器人

既然可以模拟网页微信了，那又如何做到自动回复呢？这里我们就使用到了`图灵机器人`，大家可以在他们的官网（http://www.tuling123.com）免费注册账号，然后申请一个免费的机器人，每个人最多免费申请五个机器人。
![img](https://mmbiz.qpic.cn/mmbiz_jpg/lbvmSLlcGOibECLLS8PamsA9ZQibmsPw3yZHv8ibaiahYrW5SHTFicib4ichFibxOvhO4JaINJknTDT3xdTqia2jHCf60Sw/640?wx_fmt=jpeg&tp=webp&wxfrom=5&wx_lazy=1&wx_co=1)
我会在项目代码中给一个默认的apikey，让大家不用申请机器人就可以直接运行项目，但是猪哥还是建议同学自己去申请，因为这个默认的apikey有调用次数限制，况且这算是一笔免费的财富呢！

### 4.整体流程

为了方便大家理解，猪哥给大家画了一个时序图
![img](https://mmbiz.qpic.cn/mmbiz_png/lbvmSLlcGOibECLLS8PamsA9ZQibmsPw3yns7Uefd34IiaPIJMUYHiatnPb64tZfzPGzI7LB5FibFbd5xNUezbJjEvA/640?wx_fmt=png&tp=webp&wxfrom=5&wx_lazy=1&wx_co=1)

## 二、项目代码

先来张项目结构图压压惊：
![img](https://mmbiz.qpic.cn/mmbiz_jpg/lbvmSLlcGOibECLLS8PamsA9ZQibmsPw3yDJIbrGESUnTetvOeiaLQd6KdBaVtk7zAoWib2qbBGwpzbUhUTeCUqdUA/640?wx_fmt=jpeg&tp=webp&wxfrom=5&wx_lazy=1&wx_co=1)

### 1.下载项目

猪哥已经把项目放在了GitHub上，群里有小伙伴反馈不会使用github，这里我就详细讲一下如何从github上下载项目。

> 注意：github与git不是同一个东西，github是全球最大的同性恋交友论坛，在这里我们不比颜值与财富，只比谁的项目`star`多，star越多也就说明你越吸引同性的喜欢与爱慕，甚至连你的同事也会爱上你！而git是项目管理工具，github上的项目就是用git来管理，项目管理工具另一派系是svn。

![img](https://mmbiz.qpic.cn/mmbiz_jpg/lbvmSLlcGOibECLLS8PamsA9ZQibmsPw3yLqlu2Hxq5pmWDaCtA4EySXz4afgaGGnHJmia7fXWSCtL4FGaYSP6iaxQ/640?wx_fmt=jpeg&tp=webp&wxfrom=5&wx_lazy=1&wx_co=1)
首先找到你需要下载的项目，然后点击`Clone or download`，然后点击右侧的复制按钮，猪哥这个项目的地址是：https://github.com/pig6/wxrobot(或点击阅读原文)
![img](https://mmbiz.qpic.cn/mmbiz_jpg/lbvmSLlcGOibECLLS8PamsA9ZQibmsPw3y3NViaBXq7ydvJBDPAGLOCMQaLyNSZX2VL015a7ZdBgtr3gjqLrud4ZQ/640?wx_fmt=jpeg&tp=webp&wxfrom=5&wx_lazy=1&wx_co=1)
然后打开你的pycharm，选择`CSV`->`Checkout from version control`->`git`，然后粘贴刚才复制的项目链接。
![img](https://mmbiz.qpic.cn/mmbiz_jpg/lbvmSLlcGOibECLLS8PamsA9ZQibmsPw3yDsxusytkdXhqLcz7AoXMtFOxiajk3bRO2yroV5cC5oxLRFcg8ibgVHVQ/640?wx_fmt=jpeg&tp=webp&wxfrom=5&wx_lazy=1&wx_co=1)
![img](https://mmbiz.qpic.cn/mmbiz_jpg/lbvmSLlcGOibECLLS8PamsA9ZQibmsPw3yk4eUicq2nSAy8Z9yI3U95KXIn14BeoYd5ytzpkA9j1d7xjnO6UKV2mg/640?wx_fmt=jpeg&tp=webp&wxfrom=5&wx_lazy=1&wx_co=1)
最后pycharm可能会提示你使用 新窗口打开 还是用 当前窗口 打开，猪哥一般习惯使用 新窗口(New Window) 打开，这样可以避免多个项目开发时造成混乱。

### 2.下载wxpy库

项目下载下来之后，因为没有安装必须的库`wxpy`，pycharm可能会有如下提示，这时我们点一下install就可以。
![img](https://mmbiz.qpic.cn/mmbiz_jpg/lbvmSLlcGOibECLLS8PamsA9ZQibmsPw3y535ABQK9TibqiaCH92EvZxB4qXlicmT6aGhYSHoPH3tsg6eakBznXYMlw/640?wx_fmt=jpeg&tp=webp&wxfrom=5&wx_lazy=1&wx_co=1)
如果没有出现安装库提示的话，我们可以在`Setting`->`Project`->`Project Interpreter`里面添加`wxpy`库。
![img](https://mmbiz.qpic.cn/mmbiz_jpg/lbvmSLlcGOibECLLS8PamsA9ZQibmsPw3ymWpkHFfYsJ6CHDZWeKj1ogSuw5Cq7xKFsF4yI5Bb9AledaHMWbpyEQ/640?wx_fmt=jpeg&tp=webp&wxfrom=5&wx_lazy=1&wx_co=1)
或者使用以下命令安装wxpy库，如果你是pip3则替换下面的pip。

> pip install -U wxpy -i “https://pypi.doubanio.com/simple/“

### 3.运行项目

你可以按右上角的绿色三角形按钮，也可以右键项目然后点击`run`。
![img](https://mmbiz.qpic.cn/mmbiz_jpg/lbvmSLlcGOibECLLS8PamsA9ZQibmsPw3yqEn9zf2a7C9qZJxRANErYZk9VDDmQUpeRHUNSic5ZiakOHq2Dzt83J4w/640?wx_fmt=jpeg&tp=webp&wxfrom=5&wx_lazy=1&wx_co=1)
运行之后弹出登录二维码，手机微信扫一扫点击确定登录即可和好友聊天。
![img](https://mmbiz.qpic.cn/mmbiz_jpg/lbvmSLlcGOibECLLS8PamsA9ZQibmsPw3yYJs5Muvm4he4eK38hqyicXjibvzcy43GETOz77rASzC2aV6xrR7PIUdw/640?wx_fmt=jpeg&tp=webp&wxfrom=5&wx_lazy=1&wx_co=1)

## 三、总结

首先感谢大家的耐心阅读，考虑到有很多零基础的同学所以文章有点长。

猪哥来总结下这几天使用`wxpy`库开发微信机器人的一些感受吧！

1. 猪哥用自己的大号测试了一周，也没有出现被封的迹象，只要不发送大量的相同信息就没问题
2. 即使出现被封也只是会限制你微信登录网页版，手机端不影响使用，正常使用大概一两周就自动解封
3. 最好用小号测试，据说2018年及以后注册的微信号都不可以登微信网页版，也就是说不能用测试
4. 微信网页版有些功能被阉割了，比如：添加好友，拉人入群等，因为怕微商使用机器人到处作恶所以才阉割
5. 目前只开发了一个功能，先让大家入门，后面的功能会慢慢丰富起来
6. 目前wxpy基于微信网页登录，很多功能无法实现，后期考虑跟换成iPad登录
7. 图灵机器人智商有待提高
8. 最后感谢武亚飞同学提供的微信小号



Github项目地址：https://github.com/pig6/wxrobot(或点击阅读原文)
wxpy官方文档：https://wxpy.readthedocs.io/zh/latest