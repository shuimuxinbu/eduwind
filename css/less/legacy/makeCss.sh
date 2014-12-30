#!/bin/bash

if read -t 5 -p "请在脚本目录执行该脚本，生成的css会保存在: ./legacy.min.css  键入 yes 继续: " cmd
then
    ## 成功输入命令
    if [ ${#cmd} -eq 3 ] && [ $cmd = 'yes' ]
    then
        rm ./legacy.min.css
        lessc -x ./style.less > ./legacy.min.css
        echo "编译完成"
    else
        echo "未执行编译"
    fi
else
    ## 输入命令操时
    echo ""
    echo "timeout"
fi
