import smtplib
from email.mime.text import MIMEText

print("Called by crontab")

def send_email(to_email, subject, body):
    smtp_server = 'smtp.qq.com'  # QQ 邮箱的 SMTP 服务器地址
    smtp_port = 465  # QQ 邮箱的 SMTP 服务器端口号
    sender_email = '填入发送方邮箱'  
    sender_password = '填入发送方邮箱授权码' 

    message = MIMEText(body, 'plain', 'utf-8')
    message['Subject'] = subject
    message['From'] = sender_email
    message['To'] = to_email

    try:
        smtp_obj = smtplib.SMTP_SSL(smtp_server, smtp_port)
        smtp_obj.login(sender_email, sender_password)
        smtp_obj.sendmail(sender_email, to_email, message.as_string())
        smtp_obj.quit()
        print('邮件发送成功')
    except Exception as e:
        print('邮件发送失败:', str(e))

# 从本地文件中读取邮箱列表
with open('email_list.txt', 'r') as file:
    email_list = file.read().splitlines()

# 循环发送邮件给每个邮箱
for email in email_list:
    to_email = email.strip()  # 去除首尾空白字符
    subject = '订阅邮箱测试'   # 根据自己的需求修改 subject、body
    body = '这是一封测试邮件。'
    send_email(to_email, subject, body)

