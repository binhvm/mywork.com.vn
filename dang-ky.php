<?php
	require_once("lib/connection.php");
	//Định nghĩa biến và gán giá trị rỗng cho các biến
	$ten= $email= $sdt= $matkhau= $rematkhau= $level= "";
	$tenErr= $emailErr= $sdtErr= $matkhauErr= $rematkhauErr= "";

	if ($_SERVER["REQUEST_METHOD"]== "POST") {

		//Kiểm tra trường HỌ VÀ TÊN
		if (empty($_POST["ten"])) {
			$tenErr= "Vui lòng nhập họ và tên.";
		}else{
			$ten= test_input($_POST["ten"]);
		}

		//Kiểm tra trường EMAIL
		if (empty($_POST["email"])) {
			$emailErr= "Vui lòng nhập email.";
		}else{
			$email= test_input($_POST["email"]);
			if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  				$emailErr= "Email không đúng định dạng.";
			}else{
				$sql= "SELECT * FROM ungvien WHERE email= '$email'";
				$kt= mysqli_query($conn, $sql);
				if (mysqli_num_rows($kt)> 0) {
					$emailErr= "Email đã tồn tại.";
				}
			}
		}

		// Kiểm tra trường số điện thoại
		if (empty($_POST["sdt"])) {
			$sdtErr= "Vui lòng nhập số điện thoại.";
		}else{
			$sdt= test_input($_POST["sdt"]);
		}

		//Kiểm tra trường MẬT KHẨU
		if (empty($_POST["matkhau"])) {
			$matkhauErr= "Vui lòng nhập mật khẩu.";
		}else{
			$matkhau= test_input($_POST["matkhau"]);
		}

		//Kiểm tra trường XÁC NHẬN MẬT KHẨU
		if (empty($_POST['rematkhau'])) {
			$rematkhauErr= "Vui lòng nhập xác nhận mật khẩu.";
		}else{
			$rematkhau= test_input($_POST["rematkhau"]);
			if ($rematkhau!= $matkhau) {
				$rematkhauErr= "Xác nhận mật khẩu không trùng khớp.";
			}
		}
		
		//Lưu vào DATABASE
		if ($tenErr== "" && $emailErr== "" && $sdtErr== "" && $matkhauErr== "" && $rematkhauErr== "") {
			$sql= "INSERT INTO ungvien (ten, email, sdt, matkhau, quyen)
					VALUES ('$ten', '$email', '$sdt', md5('$matkhau'), '0')";
			mysqli_query($conn, $sql);
			echo "Chúc mừng, bạn đã đăng ký thành công.";
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
	<title>Đăng ký ứng viên</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="css/menu.css">
	<link rel="stylesheet" type="text/css" href="css/dang-ky.css">
	<link rel="stylesheet" type="text/css" href="css/footer.css">
    <link href="font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet"/>
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
<div class="container_dk">
	<!-- Menu -->
	<?php
	include("menu.php");
	?>



	<!-- Body -->
	<div class="dk_body">
		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method= "POST">
			<div class="dk_content">
				<div class="dk_content_l">
					<h1>Đăng ký ứng viên</h1>
					<h3>Tiếp cận hàng triệu công việc hoàn toàn miễn phí</h3>
					<h3>Ứng tuyển nhanh chóng dễ dàng</h3>
					<h3>Nhận bản tin công việc phù hợp định kỳ</h3>
					<h3>Nâng cao cơ hội tìm việc với chương trình ứng viên năng động</h3>
				</div>





				<div class="dk_content_r">
					<div class="dk_content_r1">
						<a href="trang-chu.php"><img src="img/logo.png" style="width: 100px;"></a>
						<div class="dk_content_r2">
							<a href="#"><h4>Tài khoản</h4></a>
						</div>

						<div class="dk_content_r3">
							<h4>* Họ tên</h4>

							<input type="text" name="ten" value="<?php echo $ten; ?>" placeholder="Vui lòng nhập họ tên">

							<p><?php echo $tenErr; ?></p>
						</div>

						<div class="dk_content_r4">
							<div class="dk_content_r41">
								<h4>* Địa chỉ email</h4>

								<input type="text" name="email" value="<?php echo $email; ?>" placeholder="Vui lòng nhập địa chỉ email">

								<p><?php echo $emailErr; ?></p>

								<h4>* Mật khẩu</h4>

								<input type="password" name="matkhau" value="<?php echo $matkhau; ?>" placeholder="Vui lòng nhập mật khẩu">

								<p><?php echo $matkhauErr; ?></p>
							</div>
							<div class="dk_content_r42">

								<h4>* Số điện thoại</h4>

								<input type="text" name="sdt" value="<?php echo $sdt; ?>" placeholder="Vui lòng nhập số điện thoại">

								<p><?php echo $sdtErr; ?></p>


								<h4>* Xác nhận mật khẩu</h4>

								<input type="password" name="rematkhau" value="<?php echo $rematkhau; ?>"placeholder="Vui lòng nhập xác nhận mật khẩu">

								<p><?php echo $rematkhauErr; ?></p>
							</div>
						</div>

						<div class="dk_content_r5">
							<p>Bằng việc nhấn nút đăng kí bạn đã đồng ý với <a href="#">Thỏa thuận sử dụng</a> của MyWork</p>
							<div class="dk_content_r51">
								<input type="submit" name="btn_dky" value="Đăng ký">
							</div>

							<p>Hoặc</p>

							<div class="dk_content_r51">
								<input type="submit" name="btn_fb" value="Đăng ký nhanh qua Facebook" style="background-color: #476cb8;">
							</div>
						</div>
					</div>
				</div>



				<div class="dk_content_c">
					<p>Bạn đã có tài khoản? <a href="dang-nhap-uv.php">Đăng nhập ngay!</a></p>
				</div>
			</div>
		</form>
	</div>


	<!-- Footer -->
	<?php
	include("footer.php")
	?>
</div>
</body>
</html>