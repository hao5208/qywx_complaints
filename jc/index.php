<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>图文操作指南</title>
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .step-card {
            position: relative;
            padding: 20px;
            margin-bottom: 40px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        
        .step-number {
            width: 40px;
            height: 40px;
            background: #0d6efd;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            position: absolute;
            left: -20px;
            top: 20px;
            font-weight: bold;
        }

        .step-image {
            height: 250px;
            object-fit: cover;
            border-radius: 8px;
        }

        .step-content {
            padding: 15px;
        }

        /* 步骤连接线 */
        .step-card::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: -40px;
            height: 40px;
            width: 2px;
            background: #ddd;
            margin-left: 9px;
        }

        .step-card:last-child::after {
            display: none;
        }

        @media (max-width: 768px) {
            .step-number {
                left: 50%;
                transform: translateX(-50%);
                top: -20px;
            }
            .step-card::after {
                left: 50%;
                margin-left: -1px;
            }
        }
    </style>
</head>
<body class="bg-light">
    <div class="container py-5">
        <h1 class="text-center mb-5">企微投诉系统操作指南</h1>
        
        <p class="display-6 text-danger fw-bold bg-light p-2 rounded shadow-sm">
所有操作按本页面走，不要自己瞎改，视频仅供参考，如果操作后没有入口，请你打开录像从第10步操作一次，全程记录，然后把视频发给客服
</p>
        <!-- 步骤1 -->
        <div class="step-card">
            <div class="step-number">1</div>
            <div class="row align-items-center">
               
                <div class="col-md-6 step-content">
                    <h3 class="text-primary">首先获取企业微信机器人token</h3>
                    <p class="lead">操作方法见如下视频</p>
                   <video autoplay="autoplay" controls style="width: 30%; height: auto;">
                       <source src="./video/1.mp4" type="video/mp4">
                   </video>
                    
                </div>
            </div>
        </div>

        <!-- 步骤2 -->
        <div class="step-card">
            <div class="step-number">2</div>
            <div class="row align-items-center">
                
                <div class="col-md-6 order-md-1 step-content">
                    <h3 class="text-primary">获取企业id</h3>
                    <p>打开：<a href="https://work.weixin.qq.com/" target="_blank">https://work.weixin.qq.com/</a></p>
                    <div class="lead">
                        操作方法见如下视频
                    </div>
					<video autoplay="autoplay" controls style="width: 80%; height: auto;">
					    <source src="./video/2.mp4" type="video/mp4">
					</video>
                </div>
            </div>
        </div>

        <!-- 步骤3 -->
        <div class="step-card">
            <div class="step-number">3</div>
            <div class="row align-items-center">
                
                <div class="col-md-6 step-content">
                    <h3 class="text-primary">获取通讯录同步的密钥</h3>
                    <p> 操作方法见如下视频</p>
                    <video autoplay="autoplay" controls style="width: 80%; height: auto;" >
                        <source src="./video/3.mp4" type="video/mp4">
                    </video>
                </div>
            </div>
        </div>
		<!-- 步骤4 -->
		<div class="step-card">
		    <div class="step-number">4</div>
		    <div class="row align-items-center">
		        
		        <div class="col-md-6 step-content">
		            <h3 class="text-primary">设置操作白名单ip</h3>
		            <p>

<p class="display-6 text-danger fw-bold bg-light p-2 rounded shadow-sm">
<?php
// b.php
$aPhpUrl = 'http://proxy.669222.xyz/ip.php'; // 替换为实际 URL

// 使用 cURL 获取远程 a.php 的内容
$ch = curl_init($aPhpUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // 跟随重定向
curl_setopt($ch, CURLOPT_USERAGENT, 'PHP Proxy');
$content = curl_exec($ch);
curl_close($ch);
echo $content
?>
</p>

		            </p>
					<p> 操作方法见如下视频(ip以本页为准，视频仅供参考)</p>
		            <video autoplay="autoplay" controls style="width: 80%; height: auto;" >
		                <source src="./video/4.mp4" type="video/mp4">
		            </video>
		        </div>
		    </div>
		</div>
		
		<!-- 步骤5 -->
		<div class="step-card">
		    <div class="step-number">5</div>
		    <div class="row align-items-center">
		        
		        <div class="col-md-6 step-content">
		            <h3 class="text-primary">设置入口名为"服务"或者"反馈"</h3>
		            
					<p> 操作方法见如下视频</p>
		            <video autoplay="autoplay" controls style="width: 80%; height: auto;" >
		                <source src="./video/5.mp4" type="video/mp4">
		            </video>
		        </div>
		    </div>
		</div>
		
		
		<!-- 步骤6 -->
		<div class="step-card">
		    <div class="step-number">6</div>
		    <div class="row align-items-center">
		        
		        <div class="col-md-6 step-content">
		            <h3 class="text-primary">解析域名到本服务器(建议使用二级域名)</h3>
		            <p>记录类型:CNAME 记录值:kesu.669222.xyz</p>
		            <p>使用主域名参考左图解析，二级域名参考右图解析(地址以本页面显示为准)</p>
		            <img src="./img/IMG_20250416_195955.jpg" style="width: 80%; height: auto;"/>
		            <p>域名要能在微信打开，不能出现如下情况</p>
		            <img src="./img/IMG_20250329_223924.jpg" style="width: 80%; height: auto;"/>
		            <p>阿里云域名解析教程:https://www.itbulu.com/alidomain-jiexi.html</p>
		            <p>腾讯云域名解析教程:https://www.zhujipingjia.com/tencent-cname.html</p>
		            <p>其他服务商域名解析自行百度搜索，别来问我怎么解析</p>
		        </div>
		    </div>
		</div>
		
		<!-- 步骤6 -->
		<div class="step-card">
		    <div class="step-number">7</div>
		    <div class="row align-items-center">
		        
		        <div class="col-md-6 step-content">
		            <h3 class="text-primary">打开下面链接开始设置</h3>
		            <p><a href="/settoken.php">http://kesu.669222.xyz/settoken.php</a></p>
		          
					<p> 操作方法见如下视频</p>
		            <video autoplay="autoplay" controls style="width: 80%; height: auto;" >
		                <source src="./video/6.mp4" type="video/mp4">
		            </video>
		        </div>
		    </div>
		</div>
		
		<!-- 步骤7 -->
		<div class="step-card">
		    <div class="step-number">8</div>
		    <div class="row align-items-center">
		        
		        <div class="col-md-6 step-content">
		            <h3 class="text-primary">投诉一下，看是否能收到消息</h3>
		           
					<p> 如果收不到请联系管理员</p>
		            <video autoplay="autoplay" controls style="width: 30%; height: auto;" >
		                <source src="./video/7.mp4" type="video/mp4">
		            </video>
		        </div>
		    </div>
		</div>
		
		<!-- 步骤8 -->
		<div class="step-card">
		    <div class="step-number">9</div>
		    <div class="row align-items-center">
		        
		        <div class="col-md-6 step-content">
		            <h3 class="text-primary">关闭接口同步，下次使用再开</h3>
		          
					<p>不关闭有问题别来找我</p>
					
					<img src="./img/8.png" style="width: 80%; height: auto;"/>
					<video autoplay="autoplay" controls style="width: 80%; height: auto;" >
		                <source src="./video/9.mp4" type="video/mp4">
		            </video>
		        </div>
		    </div>
		</div>
		
		<h2>到此，已经设置完毕</h2>
		
		<!-- 步骤9 -->
		<div class="step-card">
		    <div class="step-number">10</div>
		    <div class="row align-items-center">
		        
		        <div class="col-md-6 step-content">
		            <h3 class="text-primary">企业添加新成员后操作</h3>
		          
					<p>把第9步的接口打开，访问以下链接，输入企业微信机器人的token一步一步操作即可，最后关闭接口，如果报错，请参考第四部重新设置ip</p>
					<p class="display-6 text-danger fw-bold bg-light p-2 rounded shadow-sm">
第4步的ip会经常变动，每次使用本系统请检查是否一致
</p>
					<video autoplay="autoplay" controls style="width: 80%; height: auto;" >
		                <source src="./video/10.mp4" type="video/mp4">
		            </video>
					<p>打开：<a href="/key_retrieve.php" target="_blank">http://kesu.669222.xyz/key_retrieve.php</a></p>
		        </div>
		    </div>
		</div>
		
		
		<div class="step-card">
		    <div class="step-number">11</div>
		    <div class="row align-items-center">
		        
		        <div class="col-md-6 step-content">
		            <h3 class="text-primary">如果域名出现以下情况，请及时更换域名</h3>
		          <img src="./img/IMG_20250329_223924.jpg" style="width: 80%; height: auto;"/>
					<p>新域名解析到本服务器后(参考第6步)</p>
					<p>打开链接<a href="/update_domain.php">http://kesu.669222.xyz/update_domain.php</a></p>
					<p>输入旧域名和新域名点击更新</p>
					
					<p>最后重复第10步操作即可</p>
		        </div>
		    </div>
		</div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>