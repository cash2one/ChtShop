<!DOCTYPE html>
<html>
<head>
    <title></title>
    <meta charset="UTF-8">
    <script type="text/javascript">
        var exampleSocket = new WebSocket("ws://0.0.0.0:9501");
        exampleSocket.onopen = function (event) {
            exampleSocket.send("�װ��ķ�������������������");
        };
        exampleSocket.onmessage = function (event) {
            console.log(event.data);
        }
    </script>
</head>
<body>
<input  type="text" id="content">
<button  onclick="exampleSocket.send( document.getElementById('content').value )">����</button>
</body>
</html>
