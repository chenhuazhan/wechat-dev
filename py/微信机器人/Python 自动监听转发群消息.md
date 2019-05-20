## **需求分析** 



### **1、女神在聊什么**

你可能暗恋公司的某个妹子已久，她的人缘很好常常会在公司群里和大家聊天，所以你一直关注着希望能投其所好，或者产生共鸣，但是作为程序员的你却每天忙成狗，该怎么办？

### **2、老板有什么指示**

在公司大群里，也许老板今天心情买了一些水果犒劳大家，然后在群里说：前台有水果，结果等你看到群消息时，前台只剩下妹子了。为什么吃零食总没有你的份？

### **3、又要改需求**

你好不容易实现了一个功能，结果产品验收不通过，产品经理说已经在项目群里和你说了并且@了你，但是你沉醉于实现功能忘了看。看来今晚又得加班改需求了，心好累怎么办？



![img](https://mmbiz.qpic.cn/mmbiz_png/Pn4Sm0RsAuhSvZMAt2zKcxGQN3l1NV4LwYnW1VvkaHWiaL6W1Mr1yiaNLQpxwhyqice9F1yJzMHticssPX515qyvog/640?wx_fmt=png&tp=webp&wxfrom=5&wx_lazy=1&wx_co=1)

## **功能设计** 



鉴于上面的需求分析，我们来设计一下功能：我们希望在某些群中监听某些人的讲话，如果他说话了不管发了什么，都会被记录下来，最好是能发到微信上这样更方便查看。



![img](https://mmbiz.qpic.cn/mmbiz_png/Pn4Sm0RsAuhSvZMAt2zKcxGQN3l1NV4Lb4ybNEVGnaAvEDwENKzW27LUKFDGZPKcBneWwTaTpaJyG2C3em7libQ/640?wx_fmt=png&tp=webp&wxfrom=5&wx_lazy=1&wx_co=1)

## **功能实现** 



上期为大家详细介绍了[如何用Python创建一个微信机器人与好友聊天功能](http://mp.weixin.qq.com/s?__biz=MzI0OTc0MzAwNA==&mid=2247484716&idx=1&sn=49b1b3c5cf0c14be0f3a2dab3ff2eed3&chksm=e98d96dfdefa1fc9d600b94fcc588cdefc60752058e1f85aa1c1f488d7558b9af1d688d3a1ee&scene=21#wechat_redirect)，今天我们会用wxpy库来一些群聊相关的功能！

### **1、接收群消息**

上次我们实现使用机器人与好友聊天只是实现了接收好友消息，那如何接收群消息呢？请看下图：

![img](https://mmbiz.qpic.cn/mmbiz_png/lbvmSLlcGOibKooX1pXKQwnOqEconpN1EEBn5nMicpMDxWVvhSVF78LxGZO2Cz9LwvsRicYTAupZyyZEicss3FXS3Q/640?wx_fmt=png&tp=webp&wxfrom=5&wx_lazy=1&wx_co=1)
这样我们就接收到群消息了，也可以将机器人引入到群中，让大家调戏。

### **2、过滤有用群消息**

能接收到群消息之后，我们如何过滤我们需要的消息呢？这里我们可以在接收到群消息后比较下这个群是不是我们需要监听的群，然后再比较当前消息发送者在不在我们要监听的对象中，如果两者都满足便实现了消息过滤。

在配置文件中指定需要监听人的名称（最好是备注名，防止微信昵称重名）和需要监听的群：

![img](https://mmbiz.qpic.cn/mmbiz_png/lbvmSLlcGOibKooX1pXKQwnOqEconpN1ESySsN3qVlvbFEiafibaaM1wBfRB48mT4T8YaIAxD9TibM83KPaaibvAtHg/640?wx_fmt=png&tp=webp&wxfrom=5&wx_lazy=1&wx_co=1)

根据配置需要监听的群和人去过滤群消息：

![img](https://mmbiz.qpic.cn/mmbiz_png/lbvmSLlcGOibKooX1pXKQwnOqEconpN1Eo6cUReCa11iamVI7qYPXj7ZqltL0zSbKmEib6ibUBIHicM6O1GDa9Tf6zQ/640?wx_fmt=png&tp=webp&wxfrom=5&wx_lazy=1&wx_co=1)

### **3、转发有用群消息**

在我们拿到有用群消息后，我们如何保存这些信息呢？有很多种保存信息的方式，你可以存文件，存数据库，也可以选择转发。这里猪哥就选择将信息转发，这样有几个优点：简单、实时、永久保存。

那转发给谁？你可以转发到指定好友或者文件助手都行，在猪哥的代码中是转发到机器人管理员那里，如果你没有设置管理员那么就转发到文件助手中。

![img](https://mmbiz.qpic.cn/mmbiz_png/lbvmSLlcGOibKooX1pXKQwnOqEconpN1EasGVw8JicLuuUiaibgtA7ia3TSKu8p0RIaCzxnHiaJO4LGZRnEdTibQFvUew/640?wx_fmt=png&tp=webp&wxfrom=5&wx_lazy=1&wx_co=1)

管理员设置技巧：如果你用小号登录机器人，那么你可以设置你的大号为管理员；如果你没有小号用自己的大号登录，那这个你就空着默认就设置文件助手为管理员，相关信息发送至你的文件助手中。

## 功能演示：

![img](https://mmbiz.qpic.cn/mmbiz_gif/lbvmSLlcGOibKooX1pXKQwnOqEconpN1EibtZhgMN9k6J9opUAsTgdfMoKzteNOwYX9fq3iaia7CyfRDBkWYbY6GLg/640?wx_fmt=gif&tp=webp&wxfrom=5&wx_lazy=1)



![img](https://mmbiz.qpic.cn/mmbiz_png/Pn4Sm0RsAuhSvZMAt2zKcxGQN3l1NV4LLqyf6BY4rMfY2LsU81MibFjicKDLjMjib5R23h8uo6GtGDY8OufWJfpEw/640?wx_fmt=png&tp=webp&wxfrom=5&wx_lazy=1&wx_co=1)

## **总结** 



目前微信机器人第二阶段开发完成，本次不仅仅新增监听模式，还新增了以下以下一些功能：

1. 机器人群聊：让机器人加入群聊，让更多的人来撩~
2. 转发模式：可将老板重要指示转发至其他群。
3. 监控模式：监控群中别人发的分享，这样就可以第一时间发现是否有人在群中发广告。
4. 管理员：指定管理员后可以远程控制机器人的各个开关

大家可以根据自己的日常需求来自由发挥，个性化机器人哦~

资料：

> Github地址：https://github.com/pig6/wxrobot
> wxpy官方文档：https://wxpy.readthedocs.io/zh/latest

代码下载后可以直接运行，不需要修改，最后再送大家一张wxpy速查表！

![img](https://mmbiz.qpic.cn/mmbiz_png/lbvmSLlcGOibKooX1pXKQwnOqEconpN1ES10lS1MGaBybqOnNWYPHApv5JiaNdicdouZNbwl13RH0dj3Xe1MusicDQ/640?wx_fmt=png&tp=webp&wxfrom=5&wx_lazy=1&wx_co=1)