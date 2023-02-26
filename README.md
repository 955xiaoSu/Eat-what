### 前言
idea 来源于每日三省吾身，“今天吃啥”，与其纠结不如写个“Eat-what”来决定吧！（顺便折腾一下脚本，探索新领域的过程总是跌宕起伏、妙趣横生~）

效果：访问 url，得到推荐吃饭地点。

demo: https://bkcat.cn:7000 || https://bkcat.cn/eat/eatwhat.html

### 架构变迁
**html + js** &rarr; **.sh + .py + .txt + .html**

#### 各文件功能说明
| 文件名 | 功能 |
| ---- | ---- |
| eatwhat.html | 结果呈现 | 
| eatwhat.py| 生成推荐吃饭地点 |
| eatwhat.txt| 存储 .py 生成的推荐吃饭地点，供 .html 调用 | 
| eatwhat.sh | 调用 .py 并将结果重定向至 .txt脚本 |
| relocate.py | 重定向至 ./eatwhat.html |
| index.js | node.js 起的 http 服务 |
| flask.log、record.log | .py 运行日志 |

过程：`eatwhat.sh` 调用 `eatwhat.py` 并将生成结果重定向至 `eatwhat.txt`，`eatwhat.html` 引用 `eatwhat.txt`内容。

#### 设计想法说明
1. 遇到了编码问题。当调用 .py 返回对应编码为 utf-8 的字符串时，chrome 访问 demo url 却又采用了 GBK 编码。当我将字符串编码为 GBK 时，chrome 却又采用了奇怪的 window-xxx 编码。
思索半天没有合适的解决方案，只能暂时搁置，采用**迂回**策略来实现最终目的；
2. 想折腾。最开始想用纯前端 html + js 实现，后面觉得这样不够酷，就放弃了这个想法。而后改用前后端的设计，前端 html 请求 + 后端响应（过程：html 请求运行本地脚本，脚本先调用 `eatwhat.py`
更新 `eatwhat.txt`，而后跳转访问 `eatwhat.html`）。为了发送 html 请求，在服务器上用 node.js 起了http 服务，监听 7000 端口，当检测到访问时运行 `eatwhat.sh`。在后端利用
flask 框架实现重定向，。但这么做也有问题。首先，当发送 html 请求时会报 `SSL_ERROR` 导致请求发送失败，原因在于 `index.js` 只能提供 http 连接；其次，出于便捷性考虑，浏览器
肯定一次只访问一个端口，因此必须一步到位，将服务集成到一个端口。而如果将前后端的端口统一成一个，又会出现端口占用的冲突，因此该方案也只能放弃；再者，无论是用 `curl / wget` 在脚本中
实现跳转，都只能得到网页源码，而非浏览器渲染后的效果。
3. **最终方案**：通过 Caddy 配置，将 7000 端口重定向至 `https://bkcat.cn/eat/eatwhat.html`。编辑 `/etc/crontab`实现每分钟调用一次 `eatwhat.sh`，从而使推荐吃饭地点每分钟更新
一次。

### 技术细节
1. 为实现 http 服务后台持续监听（不至于断开 ssh 连接后服务中止），可以使用 pm2；
2. 当利用 flask 框架时，可以通过 `nohup python3 xxx.py xxx > xxx &` 命令实现后台持续监听；
3. 通过 `vim /etc/crontab`，实现定时执行脚本；![image](https://user-images.githubusercontent.com/93633273/221429862-c713beb0-c552-4ee4-8d81-a3a9dab055f2.png)
4. 遇到 `github access deny` 问题时，可以考虑是否是因为本地存在多个密钥，而默认调用了 id_rsa。审计方法：`ssh -vT git@github.com`。解决方法：配置`config`文件，示例如下：
![image](https://user-images.githubusercontent.com/93633273/221429474-c207e695-81f4-479a-b3e3-e9e4e2825aff.png)


### 展望
1. 实现用户登录接口；
2. 美化界面设计。
>“我们为什么喜欢计算机？是因为当我们理解它的时候，我们就是自己世界里的国王”   --稚晖君
