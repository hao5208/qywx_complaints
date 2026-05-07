<?php
require_once '../db.php';
$host = $_SERVER['HTTP_HOST'];

// 获取 spt 参数（建议增加过滤）
$spt = $_GET['spt'] ?? '';
$spt = trim($spt);

if (empty($spt)) {
    header("Location: /error.php?type=c");
    exit;
}

// 数据库查询
$stmt = $conn->prepare("SELECT secret_key, km, domainname, expiry_date 
                       FROM keys_table 
                       WHERE random_string = ?");
$stmt->bind_param("s", $spt);
$stmt->execute();
$stmt->store_result();

// 未找到记录跳转
if ($stmt->num_rows === 0) {
    header("Location: /error.php?type=a");
    exit;
}

// 获取查询结果
$stmt->bind_result($secret_key, $km, $domainname, $expiry_date);
$stmt->fetch();

// 过期验证跳转
$current_time = date("Y-m-d H:i:s");
if ($current_time > $expiry_date) {
    header("Location: /error.php?type=b");
    exit;
}

if($host!=$domainname){
    header("Location: /error.php?type=d");
    exit;
}
// 正常业务逻辑继续执行
// ... 后续代码 ...
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=no">
<script src="/js/jquery.min.js"></script>
		<title></title>
	</head>
	<body >
     <style>
       *{
           margin: 0;
          padding: 0
        }
       a{
         text-decoration: none;
        }
        #tsxz {
    display: block !important;
    margin: 0 auto;
    width: fit-content;
    color: #7b869d !important;       /* NEW 字体颜色 */
    font-size: 15px !important;      /* NEW 字体大小 */
    margin-top: 20px !important;     /* NEW 上边距 */
}
#tsxz a {
    color: #5b6b8c !important;  /* 覆盖默认链接颜色 */
}


         .weui-cells__title {
            margin-top: 16px;
            margin-bottom: 3px;
            padding-left: 16px;
            padding-right: 16px;
            color: rgba(0,0,0,.5);
            font-size: 14px;
            line-height: 1.4;
        }
        .weui-cell {
            padding: 16px;
            position: relative;
            display: -webkit-box;
            display: -webkit-flex;
            display: flex;
            -webkit-box-align: center;
            -webkit-align-items: center;
            cursor:pointer;
            align-items: center;
            /*border-bottom: 1px solid rgba(0,0,0,.1);*/
        }
        .weui-cells__title+.weui-cells {
            margin-top: 0;
        }
        .weui-cells {
            margin-top: 8px;
            background-color: #fff;
            line-height: 1.41176471;
            font-size: 17px;
            overflow: hidden;
            position: relative;
        }
        .weui-cells:after, .weui-cells:before {
            content: " ";
            position: absolute;
            left: 0;
            right: 0;
            height: 1px;
            color: rgba(0,0,0,.1);
            z-index: 2;
        }
        
        .weui-cells:before {
            top: 0;
            border-top: 1px solid rgba(0,0,0,.1);
            -webkit-transform-origin: 0 0;
            transform-origin: 0 0;
            -webkit-transform: scaleY(.5);
            transform: scaleY(.5);
        }
        .weui-cell:before {
            content: " ";
            position: absolute;
            left: 0;
            top: 0;
            right: 0;
            height: 1px;
            border-top: 1px solid rgba(0,0,0,.1);
            /*border-top: 1px solid var(--weui-FG-3);*/
            color: #E5E5E5;
            color: var(--weui-FG-3);
            -webkit-transform-origin: 0 0;
            transform-origin: 0 0;
            -webkit-transform: scaleY(.5);
            transform: scaleY(.5);
            left: 16px;
            z-index: 2;
        }
        
        .weui-cell_access {
            -webkit-tap-highlight-color: rgba(0,0,0,0);
            color: inherit;
        }
        .weui-cell__bd {
            -webkit-box-flex: 1;
            -webkit-flex: 1;
            flex: 1;
        }
        .weui-cell_access .weui-cell__ft {
            padding-right: 22px;
            position: relative;
        }
        .weui-cell__ft {
            text-align: right;
            color: rgba(0,0,0,.5);
        }
        .weui-cell_access .weui-cell__ft:after {
            content: " ";
            width: 12px;
            height: 24px;
            -webkit-mask-position: 0 0;
            mask-position: 0 0;
            -webkit-mask-repeat: no-repeat;
            mask-repeat: no-repeat;
            -webkit-mask-size: 100%;
            mask-size: 100%;
            background-color: currentColor;
            color: #B2B2B2;
            -webkit-mask-image: url(data:image/svg+xml,%3Csvg%20width%3D%2212%22%20height%3D%2224%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%3E%3Cpath%20d%3D%22M2.454%206.58l1.06-1.06%205.78%205.779a.996.996%200%20010%201.413l-5.78%205.779-1.06-1.061%205.425-5.425-5.425-5.424z%22%20fill%3D%22%23B2B2B2%22%20fill-rule%3D%22evenodd%22%2F%3E%3C%2Fsvg%3E);
            mask-image: url(data:image/svg+xml,%3Csvg%20width%3D%2212%22%20height%3D%2224%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%3E%3Cpath%20d%3D%22M2.454%206.58l1.06-1.06%205.78%205.779a.996.996%200%20010%201.413l-5.78%205.779-1.06-1.061%205.425-5.425-5.425-5.424z%22%20fill%3D%22%23B2B2B2%22%20fill-rule%3D%22evenodd%22%2F%3E%3C%2Fsvg%3E);
            position: absolute;
            top: 50%;
            right: 0;
            margin-top: -12px;
        }
        .weui-form {
            padding: 56px 0 0;
            padding: calc(56px + constant(safe-area-inset-top)) constant(safe-area-inset-right) constant(safe-area-inset-bottom) constant(safe-area-inset-left);
            padding: calc(56px + env(safe-area-inset-top)) env(safe-area-inset-right) env(safe-area-inset-bottom) env(safe-area-inset-left);
            display: -webkit-box;
            display: -webkit-flex;
            display: flex;
            -webkit-box-orient: vertical;
            -webkit-box-direction: normal;
            -webkit-flex-direction: column;
            flex-direction: column;
            line-height: 1.4;
            min-height: 100%;
            box-sizing: border-box;
            background-color: #fff;
        }
        .weui-form__control-area {
            -webkit-box-flex: 1;
            -webkit-flex: 1;
            flex: 1;
            margin: 48px 0;
        }
        .weui-cells__group_form .weui-cell:not(.weui-cell_link) {
            color: rgba(0,0,0,.9);
        }
        .weui-cells__group_form .weui-cell {
            padding: 16px 32px;
        }
        .weui-cells__group_form .weui-cell__hd {
            padding-right: 16px;
        }
        .weui-cells__group_form .weui-label {
            max-width: 5em;
            margin-right: 8px;
        }
        .weui-label {
            display: block;
            width: 105px;
            word-wrap: break-word;
            word-break: break-all;
        }
        .weui-cell__bd {
            flex: 1;
        }
        .weui-input {
            width: 100%;
            border: 0;
            outline: 0;
            -webkit-appearance: none;
            background-color: transparent;
            font-size: inherit;
            color: inherit;
            height: 1.41176471em;
            line-height: 1.41176471;
        }
        .weui-uploader {
         flex: 1;
        }
        .weui-uploader__hd {
            display: -webkit-box;
            display: -webkit-flex;
            display: flex;
            padding-bottom: 16px;
            -webkit-box-align: center;
            -webkit-align-items: center;
            align-items: center;
        }
        .weui-uploader__title {
            -webkit-box-flex: 1;
            -webkit-flex: 1;
            flex: 1;
        }
        .weui-uploader__info {
            color: rgba(0,0,0,.3);
        }
        .weui-uploader__bd {
            margin-bottom: -8px;
            margin-right: -8px;
            overflow: hidden;
        }
        .weui-uploader__files {
            list-style: none;
        }
        .weui-uploader__input-box {
            float: left;
            position: relative;
            margin-right: 8px;
            margin-bottom: 8px;
            width: 96px;
            height: 96px;
            box-sizing: border-box;
            background-color: #ededed;
        }
        .weui-uploader__input-box:before {
            width: 2px;
            height: 32px;
        }
        .weui-uploader__input-box:after, .weui-uploader__input-box:before {
            content: " ";
            position: absolute;
            top: 50%;
            left: 50%;
            -webkit-transform: translate(-50%,-50%);
            transform: translate(-50%,-50%);
            background-color: #a3a3a3;
        }
        .weui-uploader__input {
            position: absolute;
            z-index: 1;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            -webkit-tap-highlight-color: rgba(0,0,0,0);
        }
        .weui-cells__group_form .weui-cells__title {
            margin-top: 24px;
            margin-bottom: 8px;
            padding: 0 32px;
        }
        .weui-textarea {
            display: block;
            border: 0;
            resize: none;
            background: transparent;
            width: 100%;
            color: inherit;
            font-size: 1em;
            line-height: inherit;
            outline: 0;
        }
        .weui-form__opr-area:last-child {
            margin-bottom: 96px;
        }
        .weui-btn {
            position: relative;
            display: block;
            width: 184px;
            margin-left: auto;
            margin-right: auto;
            padding: 8px 24px;
            box-sizing: border-box;
            font-weight: 700;
            font-size: 17px;
            text-align: center;
            text-decoration: none;
            color: #fff;
            line-height: 1.41176471;
            border-radius: 4px;
            overflow: hidden;
            -webkit-tap-highlight-color: rgba(0,0,0,0);
        }
        .weui-btn_primary {
            background-color: #07c160;
        }
        .weui-uploader__input-box:after {
            width: 32px;
            height: 2px;
        }
        .weui-msg {
            padding-top: 48px;
            padding: calc(48px + constant(safe-area-inset-top)) constant(safe-area-inset-right) constant(safe-area-inset-bottom) constant(safe-area-inset-left);
            padding: calc(48px + env(safe-area-inset-top)) env(safe-area-inset-right) env(safe-area-inset-bottom) env(safe-area-inset-left);
            text-align: center;
            line-height: 1.4;
            min-height: 100%;
            box-sizing: border-box;
            display: -webkit-box;
            display: -webkit-flex;
            display: flex;
            -webkit-box-orient: vertical;
            -webkit-box-direction: normal;
            -webkit-flex-direction: column;
            flex-direction: column;
            background-color: #fff;
        }
        .weui-msg__icon-area {
            margin-bottom: 32px;
        }
       
        .weui-icon-success {
            -webkit-mask-image: url(data:image/svg+xml,%3Csvg%20width%3D%2224%22%20height%3D%2224%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%3E%3Cpath%20d%3D%22M12%2022C6.477%2022%202%2017.523%202%2012S6.477%202%2012%202s10%204.477%2010%2010-4.477%2010-10%2010zm-1.177-7.86l-2.765-2.767L7%2012.431l3.119%203.121a1%201%200%20001.414%200l5.952-5.95-1.062-1.062-5.6%205.6z%22%2F%3E%3C%2Fsvg%3E);
            mask-image: url(data:image/svg+xml,%3Csvg%20width%3D%2224%22%20height%3D%2224%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%3E%3Cpath%20d%3D%22M12%2022C6.477%2022%202%2017.523%202%2012S6.477%202%2012%202s10%204.477%2010%2010-4.477%2010-10%2010zm-1.177-7.86l-2.765-2.767L7%2012.431l3.119%203.121a1%201%200%20001.414%200l5.952-5.95-1.062-1.062-5.6%205.6z%22%2F%3E%3C%2Fsvg%3E);
        }
        .weui-icon-success {
            color: #07c160;
        }

        [class*=" weui-icon-"], [class^=weui-icon-] {
            display: inline-block;
            vertical-align: middle;
            width: 64px;
            height: 64px;
            -webkit-mask-position: 50% 50%;
            mask-position: 50% 50%;
            -webkit-mask-repeat: no-repeat;
            mask-repeat: no-repeat;
            -webkit-mask-size: 100%;
            mask-size: 100%;
            background-color: currentColor;
        }
        .weui-msg__text-area {
            margin-bottom: 32px;
            padding: 0 32px;
            -webkit-box-flex: 1;
            -webkit-flex: 1;
            flex: 1;
            line-height: 1.6;
            word-wrap: break-word;
            -webkit-hyphens: auto;
            hyphens: auto;
        }
        .weui-msg__title {
            margin-bottom: 16px;
            font-weight: 400;
            font-size: 22px;
            color: #191919;
            -webkit-text-stroke: 0.02em;
        }
        .weui-msg__desc {
            font-size: 17px;
            font-weight: 400;
            color: rgba(0,0,0,.9);
            margin-bottom: 16px;
        }
        .weui-msg__opr-area {
            margin-bottom: 16px;
        }
        .imgs {
            float: left;
            margin-right: 8px;
            margin-bottom: 8px;
            width: 96px;
            height: 96px;
            background: no-repeat 50%;
            background-size: cover;
        }
      .weui-cells:after {
            bottom: 0;
            border-bottom: 1px solid rgba(0,0,0,.1);
            -webkit-transform-origin: 0 100%;
            transform-origin: 0 100%;
            -webkit-transform: scaleY(.5);
            transform: scaleY(.5);
        }
        /* WebKit browsers */ 
            input::-webkit-input-placeholder { 
              color: #bbb; 
            } 
            /* Mozilla Firefox 4 to 18 */ 
            input:-moz-placeholder { 
              color: #bbb; 
            } 
            /* Mozilla Firefox 19+ */ 
            input::-moz-placeholder { 
              color: #bbb; 
            } 
            /* Internet Explorer 10+ */ 
            input:-ms-input-placeholder { 
              color: #bbb; 
            }
             textarea::-webkit-input-placeholder { 
              color: #bbb; 
            } 
            /* Mozilla Firefox 4 to 18 */ 
            textarea:-moz-placeholder { 
              color: #bbb; 
            } 
            /* Mozilla Firefox 19+ */ 
            textarea::-moz-placeholder { 
              color: #bbb; 
            } 
            /* Internet Explorer 10+ */ 
            textarea:-ms-input-placeholder { 
              color: #bbb; 
            }
             .weui-cells__group_form .weui-cell:before, .weui-cells__group_form .weui-cells:before {
                left: 32px;
                right: 32px;
            }
            .weui-cells:after, .weui-cells:before {
                content: " ";
                position: absolute;
                left: 0;
                right: 0;
                height: 1px;
                color: rgba(0,0,0,.1);
                z-index: 2;
            }
            .weui-cells:before {
                top: 0;
                border-top: 1px solid rgba(0,0,0,.1);
                -webkit-transform-origin: 0 0;
                transform-origin: 0 0;
                -webkit-transform: scaleY(.5);
                transform: scaleY(.5);
            }
          .weui-cells__group_form .weui-cells:after {
            left: 32px;
            right: 32px;
          }
         .no_enter_weui-msg{
            /*padding-top: 110px;*/
            /*text-align: center;*/
            /*line-height: 1.4;*/
            position: absolute;
            text-align: center;
            /*line-height: 1.4;*/
            top: 32%;
            left: 50%;
            width: 100%;
            transform: translate(-50%, -50%);
        }    
         .no_enter_weui-msg__icon-area {
            margin-bottom: 8px;
        }
         .no_enter_weui-msg__text-area {
            margin-bottom: 32px;
            padding: 0 32px;
            -webkit-box-flex: 1;
            -webkit-flex: 1;
            flex: 1;
            /*line-height: 1.6;*/
            word-wrap: break-word;
            -webkit-hyphens: auto;
            hyphens: auto;
        }
         #weui-msg__title {
            color:#aaa;
            word-break: break-word;
            font-size: 18px;
        }
        #weui-msg__desc{
            color:#ccc;
            word-break: break-word;
        }
        #weui-msg__uid{
            color:#ccc;
            word-break: break-word;
        }
         .no_enter_weui-msg__title {
            font-weight: 500;
            /*font-size: 22px;*/
            margin-bottom: 6px;
            color: #545454;
        }
         .no_enter_weui-msg__desc,.weui-msg__uid {
                font-size: 15px;
                color: #545454;
                margin-bottom: 6px;
            }
    .no_enter_weui-msg__desc, .no_enter_weui-msg__title,.no_enter_weui-msg__uid {
        color: var(--weui-FG-0);
        word-break: break-word;
    }

     </style>
   
		<div id="app">
				<div class="chocie" >
					<div class="weui-cells__title">
						请选择投诉该账号的原因：
					</div>
					<div class="weui-cells ch">
					    <a href="javascript:" class="weui-cell weui-cell_access cho" data-pid = 1>
							<div class="weui-cell__bd">
								<p>
									发布不适当内容对我造成骚扰
								</p>
							</div>
							<div class="weui-cell__ft"></div>
						</a>
						<a href="javascript:" class="weui-cell weui-cell_access cho" data-pid="2">
							<div class="weui-cell__bd">
								<p>
									存在欺诈骗钱行为
								</p>
							</div>
							<div class="weui-cell__ft"></div>
						</a>
						<a href="javascript:" class="weui-cell weui-cell_access cho" data-pid="0" data-type="0">
							<div class="weui-cell__bd">
								<p>
									此账号可能被盗用
								</p>
							</div>
							<div class="weui-cell__ft"></div>
						</a>
						<a href="javascript:" class="weui-cell weui-cell_access cho" data-pid="0" data-type=1>
							<div class="weui-cell__bd">
								<p>
									存在侵权行为
								</p>
							</div>
							<div class="weui-cell__ft"></div>
						</a>
						<a href="javascript:" class="weui-cell weui-cell_access cho" data-pid="0" data-type=2>
							<div class="weui-cell__bd">
								<p>
									发布仿冒品信息
								</p>
							</div>
							<div class="weui-cell__ft"></div>
						</a>
						<a href="javascript:" class="weui-cell weui-cell_access cho" data-pid="0" data-type=3>
							<div class="weui-cell__bd">
								<p>
									冒充他人
								</p>
							</div>
							<div class="weui-cell__ft"></div>
						</a>
						<a href="javascript:" class="weui-cell weui-cell_access cho" data-pid="0" data-type=4>
							<div class="weui-cell__bd">
								<p>
									侵犯未成年人权益
								</p>
							</div>
							<div class="weui-cell__ft"></div>
						</a>
						<a href="javascript:" class="weui-cell weui-cell_access cho" data-pid="0" data-type=22>
							<div class="weui-cell__bd">
								<p>
									粉丝无底线追星行为
								</p>
							</div>
							<div class="weui-cell__ft"></div>
						</a>
					</div>
					<div id="tsxz" class="">
					    <a href="https://szsupport.weixin.qq.com/cgi-bin/mmsupportacctnodeweb-bin/pages/U1xZWEl9hNzJqDID">投诉须知</a>
					</div>
				</div>
				
				<div class="form" style="display:none">
                	<div class="weui-form" style="padding: 0px;">
                			<div class="weui-form__control-area" style="margin: 24px 0px;">
                				<div class="weui-cells__group weui-cells__group_form">
                					<div class="weui-cells weui-cells_form">
                						<div class="weui-cell aa weui-cell_active">
                							<div class="weui-cell__hd"><label class="weui-label">
                									联系方式
                								</label></div>
                							<div class="weui-cell__bd"><input   placeholder="填写联系方式" class="weui-input"></div>
                						</div>
                					</div>
                				</div>
                				<div class="weui-cells__group weui-cells__group_form">
                					<div class="weui-cell weui-cell_uploader">
                						<div class="weui-cell__bd">
                							<div class="weui-uploader">
                								<div class="weui-uploader__hd">
                									<p class="weui-uploader__title">图片上传</p>
                									<div class="weui-uploader__info">0/9</div>
                								</div>
                								<div class="weui-uploader__bd">
                									<ul id="uploaderFiles" class="weui-uploader__files"></ul>
                									<div class="weui-uploader__input-box" id="click">
                									    <input id="uploaderInput" type="file" accept="image/*" multiple="multiple" class="weui-uploader__input"  >
                									    </div>
                								</div>
                							</div>
                						</div>
                					</div>
                				</div>
                				<div class="weui-cells__group weui-cells__group_form">
                					<div class="weui-cells__title">
                						投诉内容
                					</div>
                					<div class="weui-cells weui-cells_form">
                						<div class="weui-cell">
                							<div class="weui-cell__bd"><textarea placeholder="请描述你所发生的问题" rows="3" class="weui-textarea"></textarea></div>
                						</div>
                					</div>
                				</div>
                			</div>
                			<div class="weui-form__opr-area">
                			    <a href="javascript:" class="weui-btn weui-btn_primary btn-sumbit">
                					提交
                				</a>
                			</div>
                		</div>
            	</div>
            	<div class="gb" style="display:none">
                		<div class="weui-msg">
                			<div class="weui-msg__icon-area"><i class="weui-icon-success weui-icon_msg"></i></div>
                			<div class="weui-msg__text-area">
                				<h2 class="weui-msg__title">投诉已提交</h2>
                				<p class="weui-msg__desc">您的投诉内容已提交处理，我们会尽快核实，并通知您审核结果。感谢您的支持</p>
                			</div>
                			<div class="weui-msg__opr-area">
                				<p class="weui-btn-area"><a href="./complaints_blank.html"
                					target="_blank" class="weui-btn weui-btn_primary  " style="cursor:pointer">关闭</a></p>
                			</div>
                			<div class="weui-msg__tips-area"></div>
                			<div class="weui-msg__extra-area">
                				<div class="weui-footer"></div>
                			</div>
                		</div>
            	</div>
		</div>
		<div class="no_enter" style="display:none">
		    <div style="position: relative;height: 100vh;width: 100vw;">
                <div class="no_enter_weui-msg">
                    <div class="no_enter_weui-msg__text-area">
                         <div class="no_enter_weui-msg__icon-area ">
                         <img src="/img/shuaxin.png" width="40" />
                    </div>
                        <h2 class="no_enter_weui-msg__title" id="weui-msg__title">该页面暂时无法访问！</h2>
                        <!--<p class="no_enter_weui-msg__desc" id="weui-msg__desc">该页面暂时无法访问！</p>-->
                        <!--<p class="no_enter_weui-msg__uid" id="weui-msg__uid">该页面暂时无法访问！</p>-->
                    </div>
                   
                </div>
            </div>
		</div>
		<script>
			document.title = '\u200E';
            
            var q={};
             q.spt      = getURLString('spt');
             q.random    = getURLString('random');
			function getURLString(name) {
				var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)", "i");
				var r = window.location.search.substr(1).match(reg);
				if (r != null) return decodeURIComponent(r[2]);
				return null;
			}

			
			
		
			$(document).on('click','.cho',function(){
			      var _this = $(this);
			          var pid =_this.attr('data-pid');
        			     var ary = [
        			            {
            						type: 5,
            					    pid: 0,
            					    parent_pid:1,
            						text: '色情'
        				    	},
        				    	{
            						type: 6,
            						pid: 0,
            						parent_pid:1,
            						text: '违法犯罪及违禁品'
        				    	},
        				    	{
            						type: 7,
            						pid: 0,
            						parent_pid:1,
            						text: '赌博'
        				    	},
        				    	{
            						type: 8,
            						pid: 0,
            						parent_pid:1,
            						text: '政治谣言'
        				    	},
        				    	{
            						type: 9,
            						pid: 0,
            						parent_pid:1,
            						text: '暴恐血腥'
        				    	},
        				    	{
            						type: 10,
            						pid: 0,
            						parent_pid:1,
            						text: '其他违规内容'
        				    	},
        				    	{
            						type: 11,
            						pid: 0,
            						parent_pid:2,
            						text: '金融诈骗（贷款/提额/代开/套现等）'
        				    	},
        				    	{
            						type: 12,
            						pid: 0,
            						parent_pid:2,
            						text: '网络兼职刷单诈骗'
        				    	},
        				    	{
            						type: 13,
            						pid: 0,
            						parent_pid:2,
            						text: '返利诈骗'
        				    	},
        				    	{
            						type: 14,
            						pid: 0,
            						parent_pid:2,
            						text: '网络交友诈骗'
        				    	},
        				    	{
            						type: 15,
            						pid: 0,
            						parent_pid:2,
            						text: '虚假投资理财诈骗'
        				    	},
        				    	{
            						type: 16,
            						pid: 0,
            						parent_pid:2,
            						text: '赌博诈骗'
        				    	},
        				    	{
            						type: 17,
            						pid: 0,
            						parent_pid:2,
            						text: '收款不发货'
        				    	},
        				    	{
            						type: 18,
            						pid: 0,
            						parent_pid:2,
            						text: '仿冒他人诈骗'
        				    	},
        				    	{
            						type: 19,
            						pid: 0,
            						parent_pid:2,
            						text: '免费送诈骗'
        				    	},
        				    	{
            						type: 20,
            						pid: 0,
            						parent_pid:2,
            						text: '游戏相关诈骗（代练/充值等）'
        				    	},
        				    	{
            						type: 21,
            						pid: 0,
            						parent_pid:2,
            						text: '其他诈骗行为'
        				    	},
        					];
        			     if(pid >0){
        			           var str = '';
        			         for(var i in ary){
        			             if(ary[i]['parent_pid'] == pid){
        			                 str+= '<a href="javascript:" class="weui-cell weui-cell_access cho" data-pid = "'+ary[i]['pid']+'" data-type="'+ary[i]['type']+'"><div class="weui-cell__bd"><p>'+ary[i]['text']+'</p></div><div class="weui-cell__ft"></div></a>'
        			             }
        			         }
        			        $('.ch').html(str);
        			       
        			     }else{
        			         var type = _this.attr('data-type');
        			          sessionStorage.setItem('type',type);
        			         $('.form').css({
        			             'display':'block'
        			         });
        			         $('.chocie').css({
        			             'display':'none'
        			         });
        			     }
			          
			          _this.css({
			            'background':'#fff'
			         })    
			   
			    
			     
			})
		    
			$(document).on('change','#uploaderInput',function(){
			    var str = '';
			    var num = parseInt($('.imgs').length);
			   
			  
			     var fd = new FormData();
			    for (var i = 0; i < $(this)[0].files.length; i++) { 
			        //循环获取上传个文件
			        num++;
			         if(num>9){
        			      break;
        			 }
                    fd.append("file", $(this)[0].files[i]);
                     ajaxs(fd,num);
                  }
                //   清空file
                    var input = $(this);
                    var next = this.nextSibling;
                    var parent = input.parent();
                    var form = $("<form></form>");
                    form.append(input);
                    form[0].reset();
                    if (next) {
                        $(next).before(input);
                    } else {
                        parent.append(input);
                  }
			})
			function ajaxs(fd,num){
			      $.ajax({
                    //请求方式
                    url : "/upload.php",
                    type: "post",
                    data: fd,
                    processData: false, // 告诉jQuery不要去处理发送的数据
                    contentType: false, // 告诉jQuery不要去设置Content-Type请求头
                    dataType: 'text',
                    success : function(res) {
                        var re = JSON.parse(res);
                      if(re.status == 1){
                          var url = re.url;
                         var str = '<li class="imgs" data-img="'+re.url+'" style="background-image: url('+url+')"></li>';
                            $('.weui-uploader__files').append(str);
                            $('.weui-uploader__info').html(num+'/9');
                      }else{
                          alert(re.msg);
                          return;
                      }
                    },
                    error : function(e){
                     }
                    });
                   

			    
			}
// 		    
			 $(document).on('click','.btn-sumbit',function(){
			     var phone = $('.weui-input').val();
			     var content = $('.weui-textarea').val();
			     var pic   = '';
			     var length = $('.imgs').length;
			     for(var i = 0 ;i<length;i++){
			         pic+=$('.imgs').eq(i).attr('data-img')+',';
			     }
			     pic = pic.substring(0,pic.length-1);
			     if(phone == ''){
			         alert('请输入联系方式');
			         return
			     }
			     if(content == ''){
			         alert('请输入内容');
			         return
			     }
			     var type = sessionStorage.getItem('type');
			   
			      $.ajax({
                    //请求方式
                    type : "post",
                    url : "/submit.php",
                    data:{
                        type:type,
                        phone:phone,
                        content:content,
                        pic:pic,
                        spt:q.spt,
                        random:q.random,
                        
                    },
                    success : function(res) {
                        if(res.status == 1){
			             //  投诉成功页面
			             $('.gb').css({
			                 'display':'block',
			             })
			             $('.form').css({
			                 'display':'none'
			             })
			           }else{
			               alert(res.msg);
			                return ;
			           }
                    },
                    error : function(e){
                     }
                    });
			 })
		
		
		</script>
	</body>

</html>
