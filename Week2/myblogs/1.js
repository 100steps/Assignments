function log(){
	var zhanghao=document.getElementById("text1").value;
	var mima=document.getElementById("text2").value;
	if(zhanghao==""){
		alert("请输入账号")
	}
	else{
		if(mima==""){
			alert("请输入密码")
		}
		else{
			if(zhanghao=="123"){
				if(mima=="321"){
					alert("登录成功！(然并卵)")
					document.getElementById("text1").value=""
					document.getElementById("text2").value=""
				}
				else{
					alert("密码错误！")
					document.getElementById("text1").value=""
					document.getElementById("text2").value=""
				}
			}
			else{
				alert("密码错误！")
				document.getElementById("text1").value=""
				document.getElementById("text2").value=""
			}
		}
	}
}