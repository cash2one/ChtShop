<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
	<style type="text/css">
		body, html,#allmap {width: 100%;height: 100%;margin:0;}
	</style>
	<script type="text/javascript" src="http://api.map.baidu.com/api?type=quick&ak=9sE2sS7rMGs1ZGAP6GNsmWM0&v=1.0"></script>
	<title>��ͼ����չʾЧ��</title>
</head>
<body>
	<a id="golist" href="../demolist.htm">����demo�б�ҳ</a>
	<div id="allmap"></div>
</body>
</html>
<script type="text/javascript">
	// �ٶȵ�ͼAPI����
	var map = new BMap.Map("allmap");            // ����Mapʵ��
	var point = new BMap.Point(116.404, 39.915); // ����������
	map.centerAndZoom(point,15);                 // ��ʼ����ͼ,�������ĵ�����͵�ͼ����
	map.addControl(new BMap.ZoomControl());      //��ӵ�ͼ���ſؼ�
</script>