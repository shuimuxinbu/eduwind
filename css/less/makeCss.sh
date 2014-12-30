#!/bin/bash

read -p "请在脚本目录执行该脚本，生成的css会保存在: ../style.min.css  按下任意键继续" cmd
rm ../style.min.css
lessc -x ./bootstrap.less >> ../style.min.css

echo "编译完成"
