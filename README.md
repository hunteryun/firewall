#用法：
======================

在你想限制访问的网站路径router里加上firewall中间件，如：

```
front.home:
  path: '/'
  defaults:
    _controller: '\Hunter\front\Controller\FrontController::home'
    _title: 'Home'
  requirements:
    _permission: 'firewall'

```
