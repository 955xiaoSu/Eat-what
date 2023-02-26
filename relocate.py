from flask import Flask, redirect, url_for

app = Flask(__name__)

@app.route('/')
def index():
    # 重定向到目标网址
    return redirect('http://bkcat.cn/eat/eatwhat.html')

if __name__ == '__main__':
    # 运行应用程序
    app.run(host='0.0.0.0', port=7000)

