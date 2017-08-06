<?php
define ( 'RELATIVITY_PATH', '../../' );
define ( 'MODULEID', 60001);
$O_Session = '';
require_once RELATIVITY_PATH . 'include/it_include.inc.php';
$O_Session->ValidModuleForPage ( MODULEID );
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  
  <head>
    <title></title>
    <link href="../../images/org/ui.dynatree.css" rel="stylesheet" type="text/css" />
    <link href="../../theme/default/layout_left.css" rel="stylesheet" type="text/css" />
    <link href="../../theme/default/style.css" rel="stylesheet" type="text/css" />
    <link href="css/style.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="js/ajax.fun.js"></script>
    <script type="text/javascript" src="../../js/ajax.class.js"></script>
    <script type="text/javascript" src="js/control.fun.js"></script>
    <script type="text/javascript" src="../../js/dialog.fun.js"></script>
    <script type="text/javascript" src="../../js/common.fun.js"></script>
  </head>
  
  <body style="padding-top: 10px">
<table>
  <tbody>
    <tr>
      <td id="left">
        <div id="tree">

          <ul class="dynatree-container" style="margin-bottom:10px; padding:0px">
            <li>
              <span class="dynatree-node dynatree-folder dynatree-expanded dynatree-has-children dynatree-exp-e dynatree-ico-ef">
                    <img src="../../images/file_tree/root.png" alt="" align="absmiddle" style="width:32px; height:32px; display:none" />
                    <img src="images/dept.png" alt="" align="absmiddle" style="width:32px; height:32px" />
                    <a href="javascript:;" title="督学科" id="path_0" style="font-size:14px; margin-top:5px;font-weight:normal">督学科</a></span>
              <ul>
                <li>
                  <span class="dynatree-node dynatree-folder dynatree-expanded dynatree-has-children dynatree-exp-e dynatree-ico-ef">
                    <img src="../../images/file_tree/plus.gif" alt="" align="absmiddle" onclick="openPath(this,-1)" />
                    <img src="images/year.png" alt="" align="absmiddle" />
                    <a href="javascript:;" title="2016 年" style=" font-weight:normal" ondblclick="openPath(this,-1)" onclick="nameAddBold(this);openPath(this,-1);">2015年9月至2016年8月</a>
                    <img src="../../images/file_tree/loading.gif" alt="" align="absmiddle" style="display:none" /></span>
                  <ul style="display:none">
					<li>
                      <span class="dynatree-node dynatree-folder dynatree-expanded dynatree-has-children dynatree-exp-e dynatree-ico-ef">
                        <img src="images/user.png" alt="" align="absmiddle" />
                        <a href="javascript:;" title="蔡智杰" style=" font-weight:normal" onclick="nameAddBold(this);goTo('list_explorer.php');">蔡智杰</a>
                        <img src="../../images/file_tree/loading.gif" alt="" align="absmiddle" style="display:none" /></span>
                    </li>
                    <li>
                      <span class="dynatree-node dynatree-folder dynatree-expanded dynatree-has-children dynatree-exp-e dynatree-ico-ef">
                        <img src="images/user.png" alt="" align="absmiddle" />
                        <a href="javascript:;" title="陈俊良" style=" font-weight:normal" onclick="nameAddBold(this);goTo('list_explorer.php');">陈俊良</a>
                        <img src="../../images/file_tree/loading.gif" alt="" align="absmiddle" style="display:none" /></span>
                    </li>
										<li>
                      <span class="dynatree-node dynatree-folder dynatree-expanded dynatree-has-children dynatree-exp-e dynatree-ico-ef">
                        <img src="images/user.png" alt="" align="absmiddle" />
                        <a href="javascript:;" title="陈玲" style=" font-weight:normal" onclick="nameAddBold(this);goTo('list_explorer.php');">陈玲</a>
                        <img src="../../images/file_tree/loading.gif" alt="" align="absmiddle" style="display:none" /></span>
                    </li>
                    <li>
                      <span class="dynatree-node dynatree-folder dynatree-expanded dynatree-has-children dynatree-exp-e dynatree-ico-ef">
                        <img src="images/user.png" alt="" align="absmiddle" />
                        <a href="javascript:;" title="崔锦峰" style=" font-weight:normal" onclick="nameAddBold(this);goTo('list_explorer.php');">崔锦峰</a>
                        <img src="../../images/file_tree/loading.gif" alt="" align="absmiddle" style="display:none" /></span>
                    </li>
										<li>
                      <span class="dynatree-node dynatree-folder dynatree-expanded dynatree-has-children dynatree-exp-e dynatree-ico-ef">
                        <img src="images/user.png" alt="" align="absmiddle" />
                        <a href="javascript:;" title="戴建秋" style=" font-weight:normal" onclick="nameAddBold(this);goTo('list_explorer.php');">戴建秋</a>
                        <img src="../../images/file_tree/loading.gif" alt="" align="absmiddle" style="display:none" /></span>
                    </li>
                    <li>
                      <span class="dynatree-node dynatree-folder dynatree-expanded dynatree-has-children dynatree-exp-e dynatree-ico-ef">
                        <img src="images/user.png" alt="" align="absmiddle" />
                        <a href="javascript:;" title="韩建丽" style=" font-weight:normal" onclick="nameAddBold(this);goTo('list_explorer.php');">韩建丽</a>
                        <img src="../../images/file_tree/loading.gif" alt="" align="absmiddle" style="display:none" /></span>
                    </li>
										<li>
                      <span class="dynatree-node dynatree-folder dynatree-expanded dynatree-has-children dynatree-exp-e dynatree-ico-ef">
                        <img src="images/user.png" alt="" align="absmiddle" />
                        <a href="javascript:;" title="郝新生" style=" font-weight:normal" onclick="nameAddBold(this);goTo('list_explorer.php');">郝新生</a>
                        <img src="../../images/file_tree/loading.gif" alt="" align="absmiddle" style="display:none" /></span>
                    </li>
                    <li>
                      <span class="dynatree-node dynatree-folder dynatree-expanded dynatree-has-children dynatree-exp-e dynatree-ico-ef">
                        <img src="images/user.png" alt="" align="absmiddle" />
                        <a href="javascript:;" title="何新莲" style=" font-weight:normal" onclick="nameAddBold(this);goTo('list_explorer.php');">何新莲</a>
                        <img src="../../images/file_tree/loading.gif" alt="" align="absmiddle" style="display:none" /></span>
                    </li>
										<li>
                      <span class="dynatree-node dynatree-folder dynatree-expanded dynatree-has-children dynatree-exp-e dynatree-ico-ef">
                        <img src="images/user.png" alt="" align="absmiddle" />
                        <a href="javascript:;" title="贾乐群" style=" font-weight:normal" onclick="nameAddBold(this);goTo('list_explorer.php');">贾乐群</a>
                        <img src="../../images/file_tree/loading.gif" alt="" align="absmiddle" style="display:none" /></span>
                    </li>
                    <li>
                      <span class="dynatree-node dynatree-folder dynatree-expanded dynatree-has-children dynatree-exp-e dynatree-ico-ef">
                        <img src="images/user.png" alt="" align="absmiddle" />
                        <a href="javascript:;" title="金菡" style=" font-weight:normal" onclick="nameAddBold(this);goTo('list_explorer.php');">金菡</a>
                        <img src="../../images/file_tree/loading.gif" alt="" align="absmiddle" style="display:none" /></span>
                    </li>
										<li>
                      <span class="dynatree-node dynatree-folder dynatree-expanded dynatree-has-children dynatree-exp-e dynatree-ico-ef">
                        <img src="images/user.png" alt="" align="absmiddle" />
                        <a href="javascript:;" title="李广建" style=" font-weight:normal" onclick="nameAddBold(this);goTo('list_explorer.php');">李广建</a>
                        <img src="../../images/file_tree/loading.gif" alt="" align="absmiddle" style="display:none" /></span>
                    </li>
                    <li>
                      <span class="dynatree-node dynatree-folder dynatree-expanded dynatree-has-children dynatree-exp-e dynatree-ico-ef">
                        <img src="images/user.png" alt="" align="absmiddle" />
                        <a href="javascript:;" title="李桂平" style=" font-weight:normal" onclick="nameAddBold(this);goTo('list_explorer.php');">李桂平</a>
                        <img src="../../images/file_tree/loading.gif" alt="" align="absmiddle" style="display:none" /></span>
                    </li>
										<li>
                      <span class="dynatree-node dynatree-folder dynatree-expanded dynatree-has-children dynatree-exp-e dynatree-ico-ef">
                        <img src="images/user.png" alt="" align="absmiddle" />
                        <a href="javascript:;" title="李幻贞" style=" font-weight:normal" onclick="nameAddBold(this);goTo('list_explorer.php');">李幻贞</a>
                        <img src="../../images/file_tree/loading.gif" alt="" align="absmiddle" style="display:none" /></span>
                    </li>
                    <li>
                      <span class="dynatree-node dynatree-folder dynatree-expanded dynatree-has-children dynatree-exp-e dynatree-ico-ef">
                        <img src="images/user.png" alt="" align="absmiddle" />
                        <a href="javascript:;" title="李淑芬" style=" font-weight:normal" onclick="nameAddBold(this);goTo('list_explorer.php');">李淑芬</a>
                        <img src="../../images/file_tree/loading.gif" alt="" align="absmiddle" style="display:none" /></span>
                    </li>
										<li>
                      <span class="dynatree-node dynatree-folder dynatree-expanded dynatree-has-children dynatree-exp-e dynatree-ico-ef">
                        <img src="images/user.png" alt="" align="absmiddle" />
                        <a href="javascript:;" title="李恕" style=" font-weight:normal" onclick="nameAddBold(this);goTo('list_explorer.php');">李恕</a>
                        <img src="../../images/file_tree/loading.gif" alt="" align="absmiddle" style="display:none" /></span>
                    </li>
                    <li>
                      <span class="dynatree-node dynatree-folder dynatree-expanded dynatree-has-children dynatree-exp-e dynatree-ico-ef">
                        <img src="images/user.png" alt="" align="absmiddle" />
                        <a href="javascript:;" title="李文越" style=" font-weight:normal" onclick="nameAddBold(this);goTo('list_explorer.php');">李文越</a>
                        <img src="../../images/file_tree/loading.gif" alt="" align="absmiddle" style="display:none" /></span>
                    </li>
										<li>
                      <span class="dynatree-node dynatree-folder dynatree-expanded dynatree-has-children dynatree-exp-e dynatree-ico-ef">
                        <img src="images/user.png" alt="" align="absmiddle" />
                        <a href="javascript:;" title="李学宁" style=" font-weight:normal" onclick="nameAddBold(this);goTo('list_explorer.php');">李学宁</a>
                        <img src="../../images/file_tree/loading.gif" alt="" align="absmiddle" style="display:none" /></span>
                    </li>
                    <li>
                      <span class="dynatree-node dynatree-folder dynatree-expanded dynatree-has-children dynatree-exp-e dynatree-ico-ef">
                        <img src="images/user.png" alt="" align="absmiddle" />
                        <a href="javascript:;" title="李晔" style=" font-weight:normal" onclick="nameAddBold(this);goTo('list_explorer.php');">李晔</a>
                        <img src="../../images/file_tree/loading.gif" alt="" align="absmiddle" style="display:none" /></span>
                    </li>
										<li>
                      <span class="dynatree-node dynatree-folder dynatree-expanded dynatree-has-children dynatree-exp-e dynatree-ico-ef">
                        <img src="images/user.png" alt="" align="absmiddle" />
                        <a href="javascript:;" title="李玉兰" style=" font-weight:normal" onclick="nameAddBold(this);goTo('list_explorer.php');">李玉兰</a>
                        <img src="../../images/file_tree/loading.gif" alt="" align="absmiddle" style="display:none" /></span>
                    </li>
                    <li>
                      <span class="dynatree-node dynatree-folder dynatree-expanded dynatree-has-children dynatree-exp-e dynatree-ico-ef">
                        <img src="images/user.png" alt="" align="absmiddle" />
                        <a href="javascript:;" title="梁翠英" style=" font-weight:normal" onclick="nameAddBold(this);goTo('list_explorer.php');">梁翠英</a>
                        <img src="../../images/file_tree/loading.gif" alt="" align="absmiddle" style="display:none" /></span>
                    </li>
										<li>
                      <span class="dynatree-node dynatree-folder dynatree-expanded dynatree-has-children dynatree-exp-e dynatree-ico-ef">
                        <img src="images/user.png" alt="" align="absmiddle" />
                        <a href="javascript:;" title="刘建文" style=" font-weight:normal" onclick="nameAddBold(this);goTo('list_explorer.php');">刘建文</a>
                        <img src="../../images/file_tree/loading.gif" alt="" align="absmiddle" style="display:none" /></span>
                    </li>
                    <li>
                      <span class="dynatree-node dynatree-folder dynatree-expanded dynatree-has-children dynatree-exp-e dynatree-ico-ef">
                        <img src="images/user.png" alt="" align="absmiddle" />
                        <a href="javascript:;" title="刘欣杰" style=" font-weight:normal" onclick="nameAddBold(this);goTo('list_explorer.php');">刘欣杰</a>
                        <img src="../../images/file_tree/loading.gif" alt="" align="absmiddle" style="display:none" /></span>
                    </li>
										<li>
                      <span class="dynatree-node dynatree-folder dynatree-expanded dynatree-has-children dynatree-exp-e dynatree-ico-ef">
                        <img src="images/user.png" alt="" align="absmiddle" />
                        <a href="javascript:;" title="马桂荣" style=" font-weight:normal" onclick="nameAddBold(this);goTo('list_explorer.php');">马桂荣</a>
                        <img src="../../images/file_tree/loading.gif" alt="" align="absmiddle" style="display:none" /></span>
                    </li>
                    <li>
                      <span class="dynatree-node dynatree-folder dynatree-expanded dynatree-has-children dynatree-exp-e dynatree-ico-ef">
                        <img src="images/user.png" alt="" align="absmiddle" />
                        <a href="javascript:;" title="马蕊" style=" font-weight:normal" onclick="nameAddBold(this);goTo('list_explorer.php');">马蕊</a>
                        <img src="../../images/file_tree/loading.gif" alt="" align="absmiddle" style="display:none" /></span>
                    </li>
										<li>
                      <span class="dynatree-node dynatree-folder dynatree-expanded dynatree-has-children dynatree-exp-e dynatree-ico-ef">
                        <img src="images/user.png" alt="" align="absmiddle" />
                        <a href="javascript:;" title="孟迎春" style=" font-weight:normal" onclick="nameAddBold(this);goTo('list_explorer.php');">孟迎春</a>
                        <img src="../../images/file_tree/loading.gif" alt="" align="absmiddle" style="display:none" /></span>
                    </li>
                    <li>
                      <span class="dynatree-node dynatree-folder dynatree-expanded dynatree-has-children dynatree-exp-e dynatree-ico-ef">
                        <img src="images/user.png" alt="" align="absmiddle" />
                        <a href="javascript:;" title="钱明" style=" font-weight:normal" onclick="nameAddBold(this);goTo('list_explorer.php');">钱明</a>
                        <img src="../../images/file_tree/loading.gif" alt="" align="absmiddle" style="display:none" /></span>
                    </li>
										<li>
                      <span class="dynatree-node dynatree-folder dynatree-expanded dynatree-has-children dynatree-exp-e dynatree-ico-ef">
                        <img src="images/user.png" alt="" align="absmiddle" />
                        <a href="javascript:;" title="施月林" style=" font-weight:normal" onclick="nameAddBold(this);goTo('list_explorer.php');">施月林</a>
                        <img src="../../images/file_tree/loading.gif" alt="" align="absmiddle" style="display:none" /></span>
                    </li>
                    <li>
                      <span class="dynatree-node dynatree-folder dynatree-expanded dynatree-has-children dynatree-exp-e dynatree-ico-ef">
                        <img src="images/user.png" alt="" align="absmiddle" />
                        <a href="javascript:;" title="史东辉" style=" font-weight:normal" onclick="nameAddBold(this);goTo('list_explorer.php');">史东辉</a>
                        <img src="../../images/file_tree/loading.gif" alt="" align="absmiddle" style="display:none" /></span>
                    </li>
										<li>
                      <span class="dynatree-node dynatree-folder dynatree-expanded dynatree-has-children dynatree-exp-e dynatree-ico-ef">
                        <img src="images/user.png" alt="" align="absmiddle" />
                        <a href="javascript:;" title="唐正红" style=" font-weight:normal" onclick="nameAddBold(this);goTo('list_explorer.php');">唐正红</a>
                        <img src="../../images/file_tree/loading.gif" alt="" align="absmiddle" style="display:none" /></span>
                    </li>
                    <li>
                      <span class="dynatree-node dynatree-folder dynatree-expanded dynatree-has-children dynatree-exp-e dynatree-ico-ef">
                        <img src="images/user.png" alt="" align="absmiddle" />
                        <a href="javascript:;" title="王继淼" style=" font-weight:normal" onclick="nameAddBold(this);goTo('list_explorer.php');">王继淼</a>
                        <img src="../../images/file_tree/loading.gif" alt="" align="absmiddle" style="display:none" /></span>
                    </li>
										<li>
                      <span class="dynatree-node dynatree-folder dynatree-expanded dynatree-has-children dynatree-exp-e dynatree-ico-ef">
                        <img src="images/user.png" alt="" align="absmiddle" />
                        <a href="javascript:;" title="王克南" style=" font-weight:normal" onclick="nameAddBold(this);goTo('list_explorer.php');">王克南</a>
                        <img src="../../images/file_tree/loading.gif" alt="" align="absmiddle" style="display:none" /></span>
                    </li>
                    <li>
                      <span class="dynatree-node dynatree-folder dynatree-expanded dynatree-has-children dynatree-exp-e dynatree-ico-ef">
                        <img src="images/user.png" alt="" align="absmiddle" />
                        <a href="javascript:;" title="王淑琴" style=" font-weight:normal" onclick="nameAddBold(this);goTo('list_explorer.php');">王淑琴</a>
                        <img src="../../images/file_tree/loading.gif" alt="" align="absmiddle" style="display:none" /></span>
                    </li>
										<li>
                      <span class="dynatree-node dynatree-folder dynatree-expanded dynatree-has-children dynatree-exp-e dynatree-ico-ef">
                        <img src="images/user.png" alt="" align="absmiddle" />
                        <a href="javascript:;" title="郗明" style=" font-weight:normal" onclick="nameAddBold(this);goTo('list_explorer.php');">郗明</a>
                        <img src="../../images/file_tree/loading.gif" alt="" align="absmiddle" style="display:none" /></span>
                    </li>
                    <li>
                      <span class="dynatree-node dynatree-folder dynatree-expanded dynatree-has-children dynatree-exp-e dynatree-ico-ef">
                        <img src="images/user.png" alt="" align="absmiddle" />
                        <a href="javascript:;" title="徐荣庆" style=" font-weight:normal" onclick="nameAddBold(this);goTo('list_explorer.php');">徐荣庆</a>
                        <img src="../../images/file_tree/loading.gif" alt="" align="absmiddle" style="display:none" /></span>
                    </li>
										<li>
                      <span class="dynatree-node dynatree-folder dynatree-expanded dynatree-has-children dynatree-exp-e dynatree-ico-ef">
                        <img src="images/user.png" alt="" align="absmiddle" />
                        <a href="javascript:;" title="杨洸" style=" font-weight:normal" onclick="nameAddBold(this);goTo('list_explorer.php');">杨洸</a>
                        <img src="../../images/file_tree/loading.gif" alt="" align="absmiddle" style="display:none" /></span>
                    </li>
                    <li>
                      <span class="dynatree-node dynatree-folder dynatree-expanded dynatree-has-children dynatree-exp-e dynatree-ico-ef">
                        <img src="images/user.png" alt="" align="absmiddle" />
                        <a href="javascript:;" title="杨丽华" style=" font-weight:normal" onclick="nameAddBold(this);goTo('list_explorer.php');">杨丽华</a>
                        <img src="../../images/file_tree/loading.gif" alt="" align="absmiddle" style="display:none" /></span>
                    </li>
										<li>
                      <span class="dynatree-node dynatree-folder dynatree-expanded dynatree-has-children dynatree-exp-e dynatree-ico-ef">
                        <img src="images/user.png" alt="" align="absmiddle" />
                        <a href="javascript:;" title="叶温温" style=" font-weight:normal" onclick="nameAddBold(this);goTo('list_explorer.php');">叶温温</a>
                        <img src="../../images/file_tree/loading.gif" alt="" align="absmiddle" style="display:none" /></span>
                    </li>
                    <li>
                      <span class="dynatree-node dynatree-folder dynatree-expanded dynatree-has-children dynatree-exp-e dynatree-ico-ef">
                        <img src="images/user.png" alt="" align="absmiddle" />
                        <a href="javascript:;" title="张春华" style=" font-weight:normal" onclick="nameAddBold(this);goTo('list_explorer.php');">张春华</a>
                        <img src="../../images/file_tree/loading.gif" alt="" align="absmiddle" style="display:none" /></span>
                    </li>
                    <li>
                      <span class="dynatree-node dynatree-folder dynatree-expanded dynatree-has-children dynatree-exp-e dynatree-ico-ef">
                        <img src="images/user.png" alt="" align="absmiddle" />
                        <a href="javascript:;" title="张俊华" style=" font-weight:normal" onclick="nameAddBold(this);goTo('list_explorer.php');">张俊华</a>
                        <img src="../../images/file_tree/loading.gif" alt="" align="absmiddle" style="display:none" /></span>
                    </li>
										<li>
                      <span class="dynatree-node dynatree-folder dynatree-expanded dynatree-has-children dynatree-exp-e dynatree-ico-ef">
                        <img src="images/user.png" alt="" align="absmiddle" />
                        <a href="javascript:;" title="张培根" style=" font-weight:normal" onclick="nameAddBold(this);goTo('list_explorer.php');">张培根</a>
                        <img src="../../images/file_tree/loading.gif" alt="" align="absmiddle" style="display:none" /></span>
                    </li>
                    <li>
                      <span class="dynatree-node dynatree-folder dynatree-expanded dynatree-has-children dynatree-exp-e dynatree-ico-ef">
                        <img src="images/user.png" alt="" align="absmiddle" />
                        <a href="javascript:;" title="张淑华" style=" font-weight:normal" onclick="nameAddBold(this);goTo('list_explorer.php');">张淑华</a>
                        <img src="../../images/file_tree/loading.gif" alt="" align="absmiddle" style="display:none" /></span>
                    </li>
										<li>
                      <span class="dynatree-node dynatree-folder dynatree-expanded dynatree-has-children dynatree-exp-e dynatree-ico-ef">
                        <img src="images/user.png" alt="" align="absmiddle" />
                        <a href="javascript:;" title="张新华" style=" font-weight:normal" onclick="nameAddBold(this);goTo('list_explorer.php');">张新华</a>
                        <img src="../../images/file_tree/loading.gif" alt="" align="absmiddle" style="display:none" /></span>
                    </li>
                    <li>
                      <span class="dynatree-node dynatree-folder dynatree-expanded dynatree-has-children dynatree-exp-e dynatree-ico-ef">
                        <img src="images/user.png" alt="" align="absmiddle" />
                        <a href="javascript:;" title="张咏梅" style=" font-weight:normal" onclick="nameAddBold(this);goTo('list_explorer.php');">张咏梅</a>
                        <img src="../../images/file_tree/loading.gif" alt="" align="absmiddle" style="display:none" /></span>
                    </li>
                  </ul>
                </li>
              </ul>
              </li>
          </ul>
        </div>
      </td>
    </tr>
  </tbody>
</table>
</html>