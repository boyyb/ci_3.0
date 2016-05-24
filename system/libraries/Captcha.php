<?php
/*
 * 这是自定义的验证码类库
 * */
class CI_Captcha
{
	private $width;
	private $height;
	private $codeNum;
	private $code;
	private $im;

	function __construct($width=80, $height=30, $codeNum=4){
		$this->width = $width;
		$this->height = $height;
		$this->codeNum = $codeNum;
	}

	function showImg(){
		//创建图片
		$this->createImg();
		//设置干扰元素
		$this->setDisturb();
		//设置验证码在画布上
		$this->setCaptcha();
		//输出图片
		$this->outputImg();
	}

	function getCaptcha(){
		$this->createCode();
		return $this->code;
	}

	private function createImg(){
		$this->im = imagecreatetruecolor($this->width, $this->height);
		$bgColor = imagecolorallocate($this->im, 150, 150, 150);
		imagefill($this->im, 0, 0, $bgColor);
	}

	private function setDisturb(){
		$area = ($this->width * $this->height) / 20;
		$disturbNum = ($area > 250) ? 250 : $area;
		//加入点干扰
		for ($i = 0; $i < $disturbNum; $i++) {
			$color = imagecolorallocate($this->im, rand(200, 255), rand(200, 255), rand(200, 255));
			imagesetpixel($this->im, rand(1, $this->width - 2), rand(1, $this->height - 2), $color);
		}
		//加入弧线
		for ($i = 0; $i <= 5; $i++) {
			$color = imagecolorallocate($this->im, rand(200, 255), rand(200, 255), rand(200, 255));
			imagearc($this->im, rand(0, $this->width), rand(0, $this->height), rand(30, 300), rand(20, 200), 50, 30, $color);
		}
	}

	private function createCode(){
		$str = "23456789abcdefghijkmnpqrstuvwxyzABCDEFGHIJKMNPQRSTUVWXYZ";
		$str = str_shuffle($str);
		$str = substr($str,0,4);
		$this -> code = $str;

	}

	private function setCaptcha(){
		for ($i = 0; $i < $this->codeNum; $i++) {
			$color = imagecolorallocate($this->im, rand(0, 80), rand(0, 80), rand(0, 80));
			$size = rand(14,16);
			$angle = rand(-5,5);
			$x = floor($this->width / $this->codeNum) * $i + 2;
			$y = rand(20, $this->height - 5);
			$fontfile = 'C:/Windows/Fonts/msyh.ttc';
			$text = $this->code{$i};
			imagettftext ($this->im,$size,$angle,$x,$y,$color,$fontfile,$text);
		}
	}

	private function outputImg(){
		ob_clean();
		if (imagetypes() & IMG_JPG) {
			header('Content-type:image/jpeg');
			imagejpeg($this->im);
		} elseif (imagetypes() & IMG_GIF) {
			header('Content-type: image/gif');
			imagegif($this->im);
		} elseif (imagetype() & IMG_PNG) {
			header('Content-type: image/png');
			imagepng($this->im);
		} else {
			die("Don't support image type!");
		}
	}

}