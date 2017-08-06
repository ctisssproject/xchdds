<?php
header ( 'Cache-Control: no-cache' );
header ( 'Pragma: no-cache' );
header ( 'Expires: Thu, 01 Jan 1970 00:00:00 GMT' );
header ( 'Last-Modified:' . gmdate ( 'D, d M Y H:i:s' ) . ' GMT' );
header ( 'content-type:text/html; charset=utf-8' );
require_once RELATIVITY_PATH.'sub/home/include/db_table.class.php';
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title><?php echo($s_title)?></title>
	<meta charset="utf-8" />
    <link type="text/css" rel="stylesheet" href="css/public.css" />
    <link type="text/css" rel="stylesheet" href="css/web_style.css" />
    <script type="text/javascript" src="js/jquery-1.9.1.js"></script>
    <script type="text/javascript">
        var b = false;
        $(function () {
            var len = $(".menu_list").length - 1;
            for (i = 1; i <= len ;i++){
                var m_pos = $(".menu_list").eq(i).position(),
                    sec_menu_l = ($(".menu_list").eq(i).outerWidth()) / 2 + m_pos.left,
                    third_menu_w = ($(".menu_list").eq(i).children(".child_menu").children("ul").outerWidth())/2,
                    third_pos = sec_menu_l - third_menu_w;
                
                $(".menu_list").eq(i).children(".child_menu").css("left", -m_pos.left);

                if (third_pos<0) {
                    $(".menu_list").eq(i).children(".child_menu").children("ul").css("left", "0px");
                } else {
                    $(".menu_list").eq(i).children(".child_menu").children("ul").css("left", third_pos);
                }
            }
            var o = 0;
            $(".link_btn").click(function () {
                if (o == 0) {
                    $(".link_div").addClass("open");
                    o = 1;
                } else {
                    $(".link_div").removeClass("open");
                    o = 0;
                }
            });
        });
    </script>
</head>
<body>
    <div align="center">
        <div class="head_box">
            <div class="head_div">
                <div class="top_box">
                    <h2>欢迎访问北京市西城区人民政府教育督导室！</h2>
                    <h3>关于我们</h3>
                    <h3>网站声明</h3>
                    <h3>平台登录</h3>﻿﻿
                </div>
            </div>
            <div class="head_logo">
                <img class="f_l" alt="" src="images/logo_1.png" />
                <img class="f_r" alt="" src="images/logo_2.png" />
            </div>
        </div>
        <div class="menu_box" align="center">
            <div class="menu_div">
                <div class="menu_list">首页</div>
                <div class="menu_list">
                    工作状态
                    <div class="menu_j"></div>
                    <div class="child_menu">
                        <ul>
                            <li>
                                <div class="sec_menu_div">
                                    <h2>评估标准</h2>
                                    <h3>责任督学</h3>
                                    <h3>督学责任区</h3>
                                </div>
                            </li>
                            <li>
                                <div class="sec_menu_div">
                                    <h2>工作流程</h2>
                                    <h3>责任督学</h3>
                                    <h3>责任督学</h3>
                                    <h3>督学责任区</h3>
                                </div>
                            </li>
                            <li>
                                <div class="sec_menu_div">
                                    <h2>评估标准</h2>
                                    <h3>责任督学</h3>
                                    <h3>督学责任区</h3>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="menu_list">
                    政务公开
                    <div class="menu_j"></div>
                    <div class="child_menu">
                        <ul>
                            <li>
                                <div class="sec_menu_div">
                                    <h2>评估标准</h2>
                                    <h3>责任督学</h3>
                                    <h3>督学责任区</h3>
                                </div>
                            </li>
                            <li>
                                <div class="sec_menu_div">
                                    <h2>工作流程</h2>
                                    <h3>责任督学</h3>
                                    <h3>责任督学</h3>
                                    <h3>督学责任区</h3>
                                </div>
                            </li>
                            <li>
                                <div class="sec_menu_div">
                                    <h2>评估标准</h2>
                                    <h3>责任督学</h3>
                                    <h3>督学责任区</h3>
                                </div>
                            </li>
                            <li>
                                <div class="sec_menu_div">
                                    <h2>综合督导</h2>
                                    <h3>责任督学</h3>
                                    <h3>督学责任区</h3>
                                    <h3>责任督学</h3>
                                    <h3>督学责任区</h3>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="menu_list">
                    督学工作
                    <div class="menu_j"></div>
                    <div class="child_menu">
                        <ul>
                            <li>
                                <div class="sec_menu_div">
                                    <h2>评估标准</h2>
                                    <h3>责任督学</h3>
                                    <h3>督学责任区</h3>
                                </div>
                            </li>
                            <li>
                                <div class="sec_menu_div">
                                    <h2>工作流程</h2>
                                    <h3>责任督学</h3>
                                    <h3>责任督学</h3>
                                    <h3>督学责任区</h3>
                                </div>
                            </li>
                            <li>
                                <div class="sec_menu_div">
                                    <h2>评估标准</h2>
                                    <h3>责任督学</h3>
                                    <h3>督学责任区</h3>
                                </div>
                            </li>
                            <li>
                                <div class="sec_menu_div">
                                    <h2>综合督导</h2>
                                    <h3>责任督学</h3>
                                    <h3>督学责任区</h3>
                                    <h3>责任督学</h3>
                                    <h3>督学责任区</h3>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="menu_list">
                    督政工作
                    <div class="menu_j"></div>
                    <div class="child_menu">
                        <ul>
                            <li>
                                <div class="sec_menu_div">
                                    <h2>评估标准</h2>
                                    <h3>责任督学</h3>
                                    <h3>督学责任区</h3>
                                </div>
                            </li>
                            <li>
                                <div class="sec_menu_div">
                                    <h2>工作流程</h2>
                                    <h3>责任督学</h3>
                                    <h3>责任督学</h3>
                                    <h3>督学责任区</h3>
                                </div>
                            </li>
                            <li>
                                <div class="sec_menu_div">
                                    <h2>评估标准</h2>
                                    <h3>责任督学</h3>
                                    <h3>督学责任区</h3>
                                </div>
                            </li>
                            <li>
                                <div class="sec_menu_div">
                                    <h2>综合督导</h2>
                                    <h3>责任督学</h3>
                                    <h3>督学责任区</h3>
                                    <h3>责任督学</h3>
                                    <h3>督学责任区</h3>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="menu_list">
                    专项督导
                    <div class="menu_j"></div>
                    <div class="child_menu">
                        <ul>
                            <li>
                                <div class="sec_menu_div">
                                    <h2>评估标准</h2>
                                    <h3>责任督学</h3>
                                    <h3>督学责任区</h3>
                                </div>
                            </li>
                            <li>
                                <div class="sec_menu_div">
                                    <h2>工作流程</h2>
                                    <h3>责任督学</h3>
                                    <h3>责任督学</h3>
                                    <h3>督学责任区</h3>
                                </div>
                            </li>
                            <li>
                                <div class="sec_menu_div">
                                    <h2>评估标准</h2>
                                    <h3>责任督学</h3>
                                    <h3>督学责任区</h3>
                                </div>
                            </li>
                            <li>
                                <div class="sec_menu_div">
                                    <h2>综合督导</h2>
                                    <h3>责任督学</h3>
                                    <h3>督学责任区</h3>
                                    <h3>责任督学</h3>
                                    <h3>督学责任区</h3>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="menu_list">
                    科研工作
                    <div class="menu_j"></div>
                    <div class="child_menu">
                        <ul>
                            <li>
                                <div class="sec_menu_div">
                                    <h2>评估标准</h2>
                                    <h3>责任督学</h3>
                                    <h3>督学责任区</h3>
                                </div>
                            </li>
                            <li>
                                <div class="sec_menu_div">
                                    <h2>工作流程</h2>
                                    <h3>责任督学</h3>
                                    <h3>责任督学</h3>
                                    <h3>督学责任区</h3>
                                </div>
                            </li>
                            <li>
                                <div class="sec_menu_div">
                                    <h2>评估标准</h2>
                                    <h3>责任督学</h3>
                                    <h3>督学责任区</h3>
                                </div>
                            </li>
                            <li>
                                <div class="sec_menu_div">
                                    <h2>综合督导</h2>
                                    <h3>责任督学</h3>
                                    <h3>督学责任区</h3>
                                    <h3>责任督学</h3>
                                    <h3>督学责任区</h3>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="menu_list">
                    评估监测
                    <div class="menu_j"></div>
                    <div class="child_menu">
                        <ul>
                            <li>
                                <div class="sec_menu_div">
                                    <h2>评估标准</h2>
                                    <h3>责任督学</h3>
                                    <h3>督学责任区</h3>
                                </div>
                            </li>
                            <li>
                                <div class="sec_menu_div">
                                    <h2>工作流程</h2>
                                    <h3>责任督学</h3>
                                    <h3>责任督学</h3>
                                    <h3>督学责任区</h3>
                                </div>
                            </li>
                            <li>
                                <div class="sec_menu_div">
                                    <h2>评估标准</h2>
                                    <h3>责任督学</h3>
                                    <h3>督学责任区</h3>
                                </div>
                            </li>
                            <li>
                                <div class="sec_menu_div">
                                    <h2>综合督导</h2>
                                    <h3>责任督学</h3>
                                    <h3>督学责任区</h3>
                                    <h3>责任督学</h3>
                                    <h3>督学责任区</h3>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="search_box">
                    <input type="text" placeholder="搜索..." />
                    <div class="search_btn">
                        <img alt="" src="images/search.png" />
                    </div>
                </div>
            </div>
        </div>