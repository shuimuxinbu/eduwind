# EduWind less style
===========================================



## 使用
### 编译为一个css文件，并在浏览器中载入它   
在当前目录执行makeCss.sh, 便可把所有less编译成一个min.css文件   
文件名为style.min.css，保存在上一级目录   

### 开发环境使用
先载入bootstrap.less文件，再载入less-1.7.1.min.js文件   
```
example
```


## 目录结构
/
├── README.md                               自述文件
├── makeCss.sh                            !!把less编译成一个min.css
├── modules                                 模块目录
│   └── *
├── components                              组件目录
│   └── *
├── variable.less                         !!统一定义less变量
├── bootstrap.less                        !!less引导文件，它加载了需要使用的less，
└── less-1.7.1.min.js                     !!less的js脚本，用于在浏览器中实时编译less，建议在开发环境使用



##
