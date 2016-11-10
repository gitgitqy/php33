<?php

try{
	if($_SERVER['REQUEST_METHOD']==='POST'){
		$username = trim($_POST['username']);
		$password = trim($_POST['password']);
		$reg = '/^\w{6,20}$/';
		if (!preg_match($reg,$username)) {
			throw new Exception('用户名必须为数字，字母，下划线组成的6-20位',100);
		}
		if (!preg_match($reg,$password)) {
			throw new Exception('密码必须为数字，字母，下划线组成的6-20位',100);
		}
		$pdo = new PDO ('mysql:host=localhost;dbname=mvc','root','');
		if ($pdo->exec('set names utf8')===false) {
			throw new Exception('设置字符集有误',100);
		}
		$sql =$pdo -> prepare('INSERT INTO `user`(username,password) VALUES (?,?)');
		if($sql -> execute([$username,md5($password)])===false){
			throw new Exception ('插入数据失败',100);
		}else{
			echo '<meta charset="utf-8">注册成功';
			exit;
		}
	}
}
catch(Exception $e){
	echo '<meta charset="utf-8">Error:'.$e->getMessage();
	echo '<div id=e>3</div>后跳转回注册页面';
	echo '
	<script>
		var i = document.getElementById("e");
		var v =parseInt(i.innerHTML);
		setInterval(function(){
			v--;
			if(v <= 0){
				location . href ="reg.php ";
				}else{
					i.innerHTML=v;
			}
		},1000)

	</script>';
	exit;
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>注册</title>
	<meta charset="utf-8">
</head>
<body>
<h2>注册</h2>
<form method="POST">
	<div>用户名：<input type="text" name="username"></div>
	<div>密　码：<input type="password" name="password"></div>
	<input type="submit" value="注册">
</form>
</body>
</html>