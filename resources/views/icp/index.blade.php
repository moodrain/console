@php
    if (request('oa')) {
    if (request('oa' == 'qq')) {
        $oaData = decrypt(urldecode(request('oa_data')));
        session()->put('avatar', $oaData['figureurl_qq_1']);
        session()->put('name', $oaData['nickname']);
    }
}
if (request('comment')) {
    $comments = cache('icp.comments', []);
    $comments[] = [
        'user' => session('icp.user', '匿名用户'),
        'content' => request('comment'),
        'date' => date('Y-m-d'),
    ];
    cache()->put('icp.comments', $comments);
}
if (! session('icp.user')) {
    echo '<script>window.location.href="/login"</script>';
    exit;
}
@endphp

@extends('layout.app')

@section('title', 'MoodRain')

@section('html')
    <div id="app">

        <el-header style="user-select: none;background-color: #545c64;color: #fff;line-height: 60px;position: fixed;width: 100%;z-index: 9999">

            <el-container style="height: 60px;line-height: 60px;float: left;">
                <p style="color: white;font-size: 1.4em;text-align: center;user-select: none">{{ 'Mood Rain' }}</p>
            </el-container>

            <el-dropdown style="float: right">

                <p style="cursor: pointer;color: #fff">
                    <el-avatar :size="35" src="{{ session('icp.avatar', '/avatar.jpg') }}" fit="contain" style="position: relative;top: 12px;right: 10px"></el-avatar>
                    <span>{{ session('icp.user', '新用户') }} <i class="el-icon-arrow-down el-icon--right"></i></span>
                </p>
                <el-dropdown-menu slot="dropdown">
                    <el-dropdown-item><a href="javascript:" onclick="document.querySelector('#logout').submit()">登出</a></el-dropdown-item>
                </el-dropdown-menu>
            </el-dropdown>

        </el-header>

        <form hidden id="logout" action="/logout" method="POST"></form>

        <br />
        <el-row style="margin-top: 40px">
            <el-col :lg="{span: 12,offset:6}">

                <div>

                    <el-card class="article">
                        <h2 slot="header">简单理解闭包</h2>
                        <p>最近在琢磨闭包到底是什么，终于在 <a href="https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Closures" target="_blank">MDN</a> 上找到了答案</p>
                        <h3>概念</h3>
                        <p>闭包是函数和声明该函数的词法环境的组合</p>
                        <h3>词法作用域</h3>
                        <ul>
                            <li>词法作用域的函数中遇到内部无法解析的局部变量时，去函数定义时的环境中查询</li>
                            <li>在 C 和 PHP 中，函数内变量的值只能来自 内部定义、传参 和 使用全局变量 ，也就是说所有函数都只有一个全局的 词法环境</li>
                            <li>然而在 JS 中由于函数内可以就近原则的访问到外部函数的变量，因此每一个函数都有它的 词法环境</li>
                        </ul>
                        <h3>闭包</h3>
                        <p>JS 中一个函数和它的词法环境是绑定在一起的，无论这个函数被传递到哪，在哪执行，其函数内的变量引用都是固定的。即使函数引用了一个局部变量，而且这个局部变量所在的函数已经执行完毕，这个变量也是驻留在内存中的</p>
                        <h3>用途</h3>
                        <ul>
                            <li>在面向对象编程中，对象的方法可以与对象的属性或者其他方法相关联，而闭包则通过词法环境与其所要操作的数据相关联</li>
                            <li>闭包显而易见的用途是增强了函数的功能，函数可以与不同的词法环境组成闭包，用更少量的代码解决问题</li>
                            <li>在函数是一等公民的语言中，函数通过变量进行传递，闭包将会更加强大</li>
                        </ul>
                        <h3>其他语言的闭包</h3>
                        <p>在一些面向对象的语言 Java 和 PHP 中， 方法能访问到的外部变量是来自于自身实例和类的。一个方法要绑定不同的外部变量，可以通过新建不同的实例来解决。然而新建实例和赋值操作有点繁琐，就新增了 匿名内部类、匿名函数 等方法来解决。PHP 更是直接把 PHP 中的闭包函数与匿名函数等同起来（闭包函数际上是Closure类，一个特殊的内置类），而 Java8 也新增了 Lambda 表达式（本质上是匿名内部类）。这些语法糖掩盖不了闭包在这些语言中功能受限的事实</p>
                        <h3>参考</h3>
                        <ul>
                            <li><a href="https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Closures" target="_blank">闭包 - JavaScript | MDN</a></li>
                            <li><a href="https://www.cnblogs.com/youxin/p/3416508.html" target="_blank">静态作用域与动态作用域 - youxin - 博客园</a></li>
                            <li><a href="https://php.net/manual/zh/class.closure.php" target="_blank">PHP: Closure - Manual</a></li>
                            <li><a href="https://sylvanassun.github.io/2017/07/30/2017-07-30-JavaClosure/" target="_blank">Java中的闭包之争 | SylvanasSun’s Blog</a></li>
                            <li><a href="https://segmentfault.com/a/1190000004863730" target="_blank">Java8 Lambda本质论 - 微程序 - SegmentFault 思否</a></li>
                            <li><a href="https://codeday.me/bug/20170821/56724.html" target="_blank">Javascript闭包和PHP闭包,有什么区别？ - <代码日志></代码日志></a></li>
                        </ul>
                    </el-card>

                    <el-card class="article">
                        <h2 slot="header">在 Spring 使用 Browser sync</h2>
                        <h3>一直觉得java开发网站太麻烦了，每改一下就要restart server来看效果</h3>
                        <p>想念PHP一改就生效…当然因为PHP不常驻内存，java的tomcat和servlet机制是在内存里面的</p>
                        <p>所以java是别想一改就见效了，后端的代码改了就老老实实restart server等个五六秒吧</p>
                        <p>但是前端的代码改了也要update resource也很烦。。这样写java web简直想死了。。。</p>
                        <h3>第一步：用browser-sync做前端静态文件的服务器</h3>
<p><pre>
cd webapp
browser-sync start --server --files "**/*.css, **/*.html, **/*.js"
</pre></p>
                        <p>这样就可以摆脱update resource了，而且用了之后按ctrl + s网页就会自动刷新，很爽</p>
                        <h3>第二步：解决跨域问题</h3>
                        <p>这里分两种情况，如果你不用spring的interceptor或者其他filter，直接在spring配置里加上</p>
                        <p>{{ '<mvc:cors> <mvc:mapping path="/**" /> </mvc:cors>' }}</p>
                        <p>就能跨域了。第二种情况是，由于我作业需求要用到interceptor，然后我发现上面那个配置就失效了。。。</p>
                        <p>应该是interceptor优先于这个配置，不得感叹java和spring的复杂。。。</p>
                        <p>所以要放弃上面的配置，然后再interceptor的preHandle方法加上（跟用配置一样的效果）</p>
<p><pre>
response.addHeader("Access-Control-Allow-Origin", request.getHeader("Origin"));
response.addHeader("Access-Control-Allow-Credentials", "true");
if (request.getMethod().equals("OPTIONS"))
{
    response.addHeader("Access-Control-Allow-Methods", "GET,HEAD,POST");
    response.addHeader("Access-Control-Allow-Headers", "content-type");
    response.addHeader("Access-Control-Max-Age", "1800");
    response.addHeader("vary", "Origin");
    return true;
}
</pre></p>
                        <h3>第三步：前端的跨域</h3>
                        <p>这里也分为两种，一种用jwt，前端和后台都要做很多工作我就没研究了，(我是只会写alert的前端</p>
                        <p>第二种就用session，在ajax请求加上withCredentials: true选项就行了。</p>
                        <p>悲剧的我用layui的数据表格组件时发现他没有跨域选项，看了他官网说是基于jquery的，然后顺藤摸瓜找到table.js改了他的源码然后就可以跨域啦，有一样用layui、要跨域、用session做权限认证的可以采用这种办法。。。</p>
                    </el-card>

                </div>

                <el-card class="article">
                    <p slot="header">{{ session('icp.user') ? '留言' : '请先登录再留言' }}</p>
                    @if(session('icp.user'))
                        <el-input v-model="comment" type="textarea" :autosize="{minRows:2, maxRows:4}"></el-input>
                        <br /><br />
                        <el-button @click="$submit({comment})">留言</el-button>
                    @endif
                </el-card>

                <el-card class="article">
                    <p slot="header">留言板</p>
                    @foreach(cache('icp.comments', []) as $comment)
                        <el-card style="margin-bottom: 10px;">
                            <p slot="header">{{ $comment['user'] }} 在 {{ $comment['date'] }} 留言</p>
                            <p>{{ $comment['content'] }}</p>
                        </el-card>
                    @endforeach
                </el-card>


            </el-col>
        </el-row>

    </div>
@endsection

@section('js')
    @include('layout.js')
    <script>
        new Vue({
            el: '#app',
            data() {
                return {
                    comment: '',
                }
            },
            mounted() {
                @if(request('comment'))
                    document.querySelector('#app').scroll({
                        top: 999999999999,
                        left: 0,
                        behavior: 'smooth'
                    })
                @endif
            }
        })
    </script>
@endsection

@section('css')
    @include('layout.css')
    <style>
        .article {
            margin: 20px;
            padding: 20px;
        }
        .article p {
            margin: 10px 0;
        }
        .article h3 {
            margin: 20px 0;
        }
        .article ul {
            margin: 10px 20px;
        }
        .article ul li {
            margin: 5px 0;
        }
        .article a {
            color: #909399;
        }
        #app {overflow: scroll}
    </style>
@endsection