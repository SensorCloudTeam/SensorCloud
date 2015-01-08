<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gbk" />
<title>SensorCloud</title>
<script type="text/javascript" src="http://api.map.baidu.com/api?v=1.2"></script>
<script type="text/javascript" src="http://api.map.baidu.com/library/MarkerTool/1.2/src/MarkerTool_min.js"></script>
<style type="text/css">
    /* 样式选择面板相关css */
    #divStyle {
        width: 280px;
        height: 160px;
        border: solid 1px gray;
        display:block;
        margin: 2px; 0px;
        display:none;
    }
    #divStyle ul{
        list-style-type: none;
        padding: 2px 2px;
        margin: 2px 2px
    }
    #divStyle ul li a{
        cursor: pointer;
        margin: 2px 2px;
        width: 30px;
        height: 30px;
        display: inline-block;
        border: solid 1px #ffffff;
        text-align: center;
    }

    #divStyle ul li a:hover{
        background:none;
        border: solid 1px gray;     
    }
    
    #divStyle ul li img{
        border: none;
        background:url('http://api.map.baidu.com/library/MarkerTool/1.2/examples/images/icon.gif');
    }

    /* infowindow相关css */
    .common {
        font-size: 12px;
    }
    .star {
        color: #ff0000;
    }
</style>
</head>
<body>
<div style="width:520px;height:340px;border:1px solid gray" id="container"></div>
<input type="button" value="选择标注" onclick="openStylePnl()" />
<input type="button" value="关闭" onclick="mkrTool.close()" />
<div id="divStyle" >
    <ul>
        <li>
            <a onclick="selectStyle(0)" href = 'javascript:void(0)'><img src="http://api.map.baidu.com/library/MarkerTool/1.2/examples/images/transparent.gif" style="width:12px;height:21px;background-position: 0 0" /></a>
            <a onclick="selectStyle(1)" href = 'javascript:void(0)'><img src="http://api.map.baidu.com/library/MarkerTool/1.2/examples/images/transparent.gif" style="width:12px;height:21px;background-position: -23px 0" /></a>
            <a onclick="selectStyle(2)" href = 'javascript:void(0)'><img src="http://api.map.baidu.com/library/MarkerTool/1.2/examples/images/transparent.gif" style="width:12px;height:21px;background-position: -46px 0" /></a>
            <a onclick="selectStyle(3)" href = 'javascript:void(0)'><img src="http://api.map.baidu.com/library/MarkerTool/1.2/examples/images/transparent.gif" style="width:12px;height:21px;background-position: -69px 0" /></a>
            <a onclick="selectStyle(4)" href = 'javascript:void(0)'><img src="http://api.map.baidu.com/library/MarkerTool/1.2/examples/images/transparent.gif" style="width:12px;height:21px;background-position: -92px 0" /></a>
            <a onclick="selectStyle(5)" href = 'javascript:void(0)'><img src="http://api.map.baidu.com/library/MarkerTool/1.2/examples/images/transparent.gif" style="width:12px;height:21px;background-position: -115px 0" /></a>
        </li>
        <li>
            <a onclick="selectStyle(6)" href = 'javascript:void(0)'><img src="http://api.map.baidu.com/library/MarkerTool/1.2/examples/images/transparent.gif" style="width:19px;height:25px;background-position: 0 -21px" /></a>
            <a onclick="selectStyle(7)" href = 'javascript:void(0)'><img src="http://api.map.baidu.com/library/MarkerTool/1.2/examples/images/transparent.gif" style="width:19px;height:25px;background-position: -23px -21px" /></a>
            <a onclick="selectStyle(8)" href = 'javascript:void(0)'><img src="http://api.map.baidu.com/library/MarkerTool/1.2/examples/images/transparent.gif" style="width:19px;height:25px;background-position: -46px  -21px " /></a>
            <a onclick="selectStyle(9)" href = 'javascript:void(0)'><img src="http://api.map.baidu.com/library/MarkerTool/1.2/examples/images/transparent.gif" style="width:19px;height:25px;background-position: -69px  -21px " /></a>
            <a onclick="selectStyle(10)" href = 'javascript:void(0)'><img src="http://api.map.baidu.com/library/MarkerTool/1.2/examples/images/transparent.gif" style="width:19px;height:25px;background-position: -92px  -21px " /></a>
            <a onclick="selectStyle(11)" href = 'javascript:void(0)'><img src="http://api.map.baidu.com/library/MarkerTool/1.2/examples/images/transparent.gif" style="width:19px;height:25px;background-position: -115px  -21px " /></a>
        </li>
        <li>
            <a onclick="selectStyle(12)" href = 'javascript:void(0)'><img src="http://api.map.baidu.com/library/MarkerTool/1.2/examples/images/transparent.gif" style="width:17px;height:21px;background-position: 0 -46px " /></a>
            <a onclick="selectStyle(13)" href = 'javascript:void(0)'><img src="http://api.map.baidu.com/library/MarkerTool/1.2/examples/images/transparent.gif" style="width:17px;height:21px;background-position: -23px  -46px " /></a>
            <a onclick="selectStyle(14)" href = 'javascript:void(0)'><img src="http://api.map.baidu.com/library/MarkerTool/1.2/examples/images/transparent.gif" style="width:17px;height:21px;background-position: -46px  -46px " /></a>
            <a onclick="selectStyle(15)" href = 'javascript:void(0)'><img src="http://api.map.baidu.com/library/MarkerTool/1.2/examples/images/transparent.gif" style="width:17px;height:21px;background-position: -69px  -46px " /></a>
            <a onclick="selectStyle(16)" href = 'javascript:void(0)'><img src="http://api.map.baidu.com/library/MarkerTool/1.2/examples/images/transparent.gif" style="width:17px;height:21px;background-position: -92px  -46px " /></a>
            <a onclick="selectStyle(17)" href = 'javascript:void(0)'><img src="http://api.map.baidu.com/library/MarkerTool/1.2/examples/images/transparent.gif" style="width:17px;height:21px;background-position: -115px  -46px " /></a>
        </li>
        <li>
            <a onclick="selectStyle(18)" href = 'javascript:void(0)'><img src="http://api.map.baidu.com/library/MarkerTool/1.2/examples/images/transparent.gif" style="width:25px;height:25px;background-position: 0 -67px " /></a>
            <a onclick="selectStyle(19)" href = 'javascript:void(0)'><img src="http://api.map.baidu.com/library/MarkerTool/1.2/examples/images/transparent.gif" style="width:25px;height:25px;background-position: -25px  -67px " /></a>
            <a onclick="selectStyle(20)" href = 'javascript:void(0)'><img src="http://api.map.baidu.com/library/MarkerTool/1.2/examples/images/transparent.gif" style="width:25px;height:25px;background-position: -50px  -67px " /></a>
            <a onclick="selectStyle(21)" href = 'javascript:void(0)'><img src="http://api.map.baidu.com/library/MarkerTool/1.2/examples/images/transparent.gif" style="width:25px;height:25px;background-position: -75px  -67px " /></a>
            <a onclick="selectStyle(22)" href = 'javascript:void(0)'><img src="http://api.map.baidu.com/library/MarkerTool/1.2/examples/images/transparent.gif" style="width:25px;height:25px;background-position: -100px  -67px " /></a>
            <a onclick="selectStyle(23)" href = 'javascript:void(0)'><img src="http://api.map.baidu.com/library/MarkerTool/1.2/examples/images/transparent.gif" style="width:19px;height:25px;background-position: -125px  -67px " /></a>
        </li>
    </ul>
</div>
</body>
</html>
<script type="text/javascript">
var map = new BMap.Map("container");
map.centerAndZoom(new BMap.Point(116.404, 39.915), 12);
map.enableScrollWheelZoom();

//拼接infowindow内容字串
var html = [];
html.push('<span style="font-size:12px">节点信息: </span><br/>');
html.push('<table border="0" cellpadding="1" cellspacing="1" >');
html.push('  <tr>'); 
html.push('      <td align="left" class="common">名 称：</td>');
html.push('      <td colspan="2"><input type="text" maxlength="50" size="18"  id="txtName"></td>');
html.push('	     <td valign="top"><span class="star">*</span></td>');
html.push('  </tr>');
html.push('  <tr>');
html.push('      <td align="left" class="common">描 述：</td>');
html.push('      <td colspan="2"><textarea rows="2" cols="15"  id="areaDesc"></textarea></td>');
html.push('	     <td valign="top"></td>');
html.push('  </tr>');
html.push('  <tr>');
html.push('	     <td  align="center" colspan="3">');
html.push('          <input type="button" name="btnOK"  onclick="fnOK()" value="获得设备号">&nbsp;&nbsp;');
html.push('		     <input type="button" name="btnClear" onclick="fnClear();" value="撤销">');
html.push('	     </td>');
html.push('  </tr>');
html.push('</table>');	

var infoWin = new BMap.InfoWindow(html.join(""), {offset: new BMap.Size(0, -10)});
var curMkr = null; // 记录当前添加的Mkr

var mkrTool = new BMapLib.MarkerTool(map, {autoClose: true});
mkrTool.addEventListener("markend", function(evt){ 
    var mkr = evt.marker;
    mkr.openInfoWindow(infoWin);
    curMkr = mkr;
});

//打开样式面板
function openStylePnl(){
    document.getElementById("divStyle").style.display = "block";
}

//选择样式
function selectStyle(index){
    mkrTool.open(); //打开工具 
    var icon = BMapLib.MarkerTool.SYS_ICONS[index]; //设置工具样式，使用系统提供的样式BMapLib.MarkerTool.SYS_ICONS[0] -- BMapLib.MarkerTool.SYS_ICONS[23]
    mkrTool.setIcon(icon); 
    document.getElementById("divStyle").style.display = "none";    
}

function get() 
{ 
   var name=document.getElementById('txtName').value; 
   document.getElementById("txtName").value=name; 
}

//提交数据
function fnOK(){
    var name = encodeHTML(document.getElementById("txtName").value);
    var desc = encodeHTML(document.getElementById("areaDesc").value);

    if(!name){
        alert("名称必须填写");    
        return;
    }

//     var url = 'test.php';
//     var pars =  'name=' + name;
//     var myAjax = new Ajax.Request(
//     	    url,  {method: 'post', parameters: pars, onComplete: showResponse});
       
    if(curMkr){
        //设置label
        var lbl = new BMap.Label(name, {offset: new BMap.Size(1, 1)});
        lbl.setStyle({border: "solid 1px gray"});
        curMkr.setLabel(lbl);        
    }
    if(infoWin.isOpen()){
        map.closeInfoWindow();
    }

    //在此用户可将数据提交到后台数据库中
    <?php
    		$conn = new mysqli("localhost","root","123456","wsn");
    		if(mysqli_connect_errno()){
    		    printf("Connect failed: %s\n", mysqli_connect_error());
    		    exit();
    		}
    		
//    		$name = $_REQUEST["txtName"];
//			mysqli_query($conn, "INSERT INTO sink (id,user_id,name,longitude,latitude) VALUES ('5','liuyize','" + $name + "','111','39')");

    		$conn -> close();
    ?>
}

//输入校验
function encodeHTML(a){
	return a.replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/"/g, "&quot;");
}

//重填数据
function fnClear(){
    document.getElementById("txtName").value = "";
    document.getElementById("areaDesc").value = "";
}
</script>

