<?php
session_start();
require_once("lib/connection.php");

$email= $matkhau= "";
$emailErr= $matkhauErr= "";

if ($_SERVER["REQUEST_METHOD"]== "POST") {
	//Làm sạch thông tin
	$email= strip_tags($email);
	$email= addslashes($email);
	$matkhau= strip_tags($matkhau);
	$matkhau= addslashes($matkhau);

	//Kiểm tra trường TÊN ĐĂNG NHẬP
	if (empty($_POST["email"])) {
		$emailErr= "Bạn chưa điền TÊN ĐĂNG NHẬP.";
	}else{
		$email= test_input($_POST["email"]);
	}

	//Kiểm tra trường MẬT KHẨU
	if (empty($_POST["matkhau"])) {
		$matkhauErr= "Bạn chưa điền MẬT KHẨU.";
	}else{
		$matkhau= test_input($_POST["matkhau"]);
	}
	if ($emailErr== "" && $matkhauErr== "") {
		$matkhau= md5($matkhau);
		$sql= "SELECT * FROM ungvien WHERE email= '$email' AND matkhau = '$matkhau'";
		
		$query= mysqli_query($conn, $sql);
		$num_rows= mysqli_num_rows($query);
		if ($num_rows==0) {
			echo "TÊN ĐĂNG NHẬP hoặc MẬT KHẨU không đúng.";
		}else{
			while ($data= mysqli_fetch_array($query)) {
				$_SESSION["id_user"]= $data["id"];
				$_SESSION['email']= $data["email"];
				$_SESSION["name"]= $data["name"];
				$_SESSION["level"]= $data["level"];
				header('Location: trang-chu.php');
			}
		}
	}
}

	function test_input($data) {
	  $data= trim($data);
	  $data= stripslashes($data);
	  $data= htmlspecialchars($data);
	  return $data;
	}
?>








<!DOCTYPE html>
<html>
<head>
	<title>Đăng nhập dành cho ứng viên</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="css/menu.css">
	<link rel="stylesheet" type="text/css" href="css/so-lieu.css">
	<link rel="stylesheet" type="text/css" href="css/footer.css">
	<link rel="stylesheet" type="text/css" href="css/dang-nhap-uv.css">
    <style type="text/css">
        body{
            font-family: roboto;
            font-size: 14px;
        }
        a{
            text-decoration: none;
        }
        a:hover{
            text-decoration: none;
        }
    </style>
</head>
<body>
<div class="dang-nhap-uv">
	<?php
	include("menu.php");
	?>



	<div class="body-dnuv">
		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
			<div class="body-dnuv">
				<div class="body-dnuv-c">
					<div class="body-dnuv-l">
						<h1>Đăng nhập ứng viên</h1>
						<h3>Tiếp cận hàng triệu công việc hoàn toàn miễn phí</h3>
						<h3>Ứng tuyển nhanh chóng, dễ dàng</h3>
						<h3>Nhận bản tin công việc phù hợp định kỳ</h3>
						<h3>Nâng cao cơ hội tìm việc với chương trình ứng viên năng động</h3>
					</div>

					<div class="body-dnuv-r">
						<a href="trang-chu.php"><img src="img/logo12.png"></a>
						<input type="text" name="email" placeholder="Tài khoản ứng viên" value="<?php echo $email; ?>">
						<p><?php echo $emailErr; ?></p>
						<input type="password" name="matkhau" placeholder="Mật khẩu" value="<?php echo $matkhau; ?>">
						<p><?php echo $matkhauErr; ?></p>
						<input type="submit" name="btn_dn" id="btn_dn" value="Đăng nhập">
						<p>Hoặc</p>
						<input type="submit" name="btn_dn" id="btn_fb" value="Đăng nhập qua Facebook">
						<p>Quên mật khẩu?</p>
					</div>

					<div class="body-dnuv-r1">
						<p>Bạn chưa có tài khoản? <a href="dang-ky.php">Đăng ký</a></p>
					</div>
				</div>
			</div>
		</form>
	</div>




	<?php
	include("footer.php");
	?>
</div>
</body>
</html>