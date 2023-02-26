import random
import chardet

my_array = ['香港佬', '自选', '羊肉拌面', '大碗饭', 'KFC', '黄焖鸡', '重庆小面', '肥牛', '冒菜', '热卤', '鸭腿', '渔']

index = random.randint(0, len(my_array) - 1)

target = my_array[index]

output = "这顿吃：" + target + "\n吃饱记得好好学习天天向上哦!"

print(output)
