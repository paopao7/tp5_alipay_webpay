说明
=====
该demo为ThinkPHP5.0.16版本使用composer集成paopao7/alipay_webpay

>使用说明：

1. 下载后需先配置数据库连接信息，配置文件所在路径为：
tp5_alipay_webpay\application\database.php文件
2. 本地新建数据库alipay_class，并将根目录下的alipay_class.sql导入到alipay_class库
3. 浏览器打开该地址: http://tp5.cn/public/ (该地址为我配置的虚拟主机指向我当前demo，请以实际配置为准)
4. 在打开的页面点击"点此配置"，在配置页面配置好appid、公私钥等信息 
5. 配置完成后在主界面点击"走你"即可实现在线支付功能
6. 若回调地址配置无误，则在支付成功的情况下就会调用该地址并修改订单表对应的状态

>使用说明：

具体使用请参考该链接：http://www.itinfor.cn/archives/1669

>联系方式：(添加请注明技术咨询)

本人QQ：980569038
TP集成支付宝群：594955172