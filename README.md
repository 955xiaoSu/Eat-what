### 前言
期末周啦也没啥事，就把本学期开头的这个 Eat-what 再加以完善一下。

效果：访问 url，体验三种功能。1）随机地点推荐；2）周边美食推荐；3）跟 AI 聊聊天

demo: https://kaisuping.cn/Eat-what/index.html

### 架构设计
前端：html

后端：php + python

#### 各文件功能说明
`index.html` 作为主入口

`menu.html` 实现了随机地点推荐的功能，同时附带了“邮箱订阅”功能（由 `email_subscribe.html` & `email_subscribe.php` 具体实现），

遗憾的是 crontab 有点 bug，不能实现定时发送（发送邮件由 `send_email.py` 负责具体实现），即目前只能手动定时发送了。

### 实现过程中的一些想法
1. 对于“随机地点推荐”这一功能，原本设想的是实现用户的个性化定制菜单推荐，然而涉及到数据库和 token 的调用，小尝试了一下，感觉复杂度偏高遂放弃（根本原因是自己既菜又懒）；
2. 对于“邮箱订阅”比我想象中的简单许多，只需要选择某官方邮箱的设置中，打开 SMTP，获取相应的服务器地址、端口号、授权码即可；
3. 对于页面布局的设计，还得依靠个人的审美，这方面 ChatGPT 确实还有待提高；
4. 对于“周边美食推荐”功能，原本设想的是接入美团的某个 API，后面一查，申请流程太过于繁琐（既要信息安全资质核验，还要交保证金），所以直接偷懒，唤醒本地的美团 app / 跳转到美团网页端结束了事；
5. 对于“AI 聊天”，原本设想的是基于 openai key，搭一个对话式的在线网页，试了半天不行才发觉自己是没有“科学上网”。出于风险，打算给个国内可用的类 ChatGPT 网站算了，后面无法忍受该网站的首页某元素，就用 vercel 平替。

### 展望
希望自己的 github 能尽快绿起来，好好动手开发一些有意思的东西，体会学以致用的乐趣。
