<?php
include '../lib/includes.php';
include '../partials/admin_header.php';

function imagecopymerge_alpha($dst_im, $src_im, $dst_x, $dst_y, $src_x, $src_y, $src_w, $src_h, $pct){ 

	// function patch for respecting alpha work find on http://php.net/manual/fr/function.imagecopymerge.php
	$cut = imagecreatetruecolor($src_w, $src_h); 
	imagecopy($cut, $dst_im, 0, 0, $dst_x, $dst_y, $src_w, $src_h);
	imagecopy($cut, $src_im, 0, 0, $src_x, $src_y, $src_w, $src_h);
	imagecopymerge($dst_im, $cut, $dst_x, $dst_y, 0, 0, $src_w, $src_h, $pct); 
} 

if (isset($_POST['cpt_1']) && $_POST['cpt_1'] != "" && isset($_POST['alpha'])) {
	checkCsrf();

	print('bob');
	// get the content of the captured image from the webcam put it in a tmp img
	list($type, $data) = explode(';', $_POST['cpt_1']);
	list(, $data) = explode(',', $data);
	$data = base64_decode($data);
	file_put_contents( IMAGES .'/tmp1.png', $data);

	// creat image from this temporary 
	$im = imagecreatefrompng(IMAGES .'/tmp1.png');

	// get selected alpha
	$alpha = imagecreatefrompng(IMAGES .'/alpha/'.$_POST['alpha'].'.png');
		
	imagecopymerge_alpha($im, $alpha, 0, 0, 0, 0, imagesx($alpha), imagesy($alpha), 100);

	// Create file name and register the image in database
	$user = $_SESSION['Auth'];
	$user_id = $db->quote($user['id']);
	$db->query("INSERT INTO images SET user_id=$user_id");
	$image_id = $db->lastInsertId();
	$image_name = $user['username'].'_'. $image_id . '.png';

	imagepng($im,  IMAGES .'/'. $image_name);
	// free memory
	imagedestroy($im);

	$image_name = $db->quote($image_name);
	$db->query("UPDATE images SET name=$image_name WHERE id=$image_id");
	header('Location:'.WEBROOT.'admin/my_creations.php');
	die();

}

if (isset($_FILES['image']) && isset($_POST['alpha'])) {
	checkCsrf();

	$image = $_FILES['image'];
	$extension = pathinfo($image['name'], PATHINFO_EXTENSION);

	if (in_array($extension, array('jpg', 'png'))){
		
		// Le format du fichier est correct
		$user = $_SESSION['Auth'];
		$user_id = $db->quote($user['id']);
		$db->query("INSERT INTO images SET user_id=$user_id");
		$image_id = $db->lastInsertId();
		
		$image_name = $user['username'].'_'. $image_id . '.' . $extension;
		move_uploaded_file($image['tmp_name'], IMAGES .'/'. $image_name);

		if ($extension == 'jpg')
			$im = imagecreatefromjpeg(IMAGES .'/'. $image_name);
		else if ($extension == 'png')
			$im = imagecreatefrompng(IMAGES .'/'. $image_name);

		$alpha = imagecreatefrompng(IMAGES .'/alpha/'.$_POST['alpha'].'.png');

		imagecopymerge_alpha($im, $alpha, 0, 0, 0, 0, imagesx($alpha), imagesy($alpha), 100);

		imagepng($im,  IMAGES .'/'. $image_name);
		// free memory
		imagedestroy($im);

		$image_name = $db->quote($image_name);
		$db->query("UPDATE images SET name=$image_name WHERE id=$image_id");
	}
	header('Location:'.WEBROOT.'admin/my_creations.php');
	die();
}


?>
	<div>

		<video id="video"></video>
		<button id="startbutton">Prendre une photo</button>
		<canvas style="display: none" id="canvas"></canvas>
		<img id="photo" src="">

		<form action="#" method="post" enctype="multipart/form-data">
			<div>
			<ul class="selection">
				<li><label><img src="<?php echo WEBROOT; ?>img/alpha/alphatest1.png"><input type="radio" name="alpha" value="alphatest1" checked="checked"></label></li>
				<li><label><img src="<?php echo WEBROOT; ?>img/alpha/alphatest2.png"><input type="radio" name="alpha" value="alphatest2"></label></li>
				<li><label><img src="<?php echo WEBROOT; ?>img/alpha/alphatest3.png"><input type="radio" name="alpha" value="alphatest3"></label></li>
			</ul>
			</div>
			<div>
				<input type="file" name="image">
			</div>
			<div>
				<input id="cpt_1" type="hidden" name="cpt_1">
			</div>
			<?php echo csrfInput(); ?>
			<button type="submit">Envoyer</button>
		</form>
	</div>

	<script type="text/javascript">
	(function() {

		var streaming		= false,
			video			= document.querySelector('#video'),
			cover			= document.querySelector('#cover'),
			canvas			= document.querySelector('#canvas'),
			photo			= document.querySelector('#photo'),
			startbutton		= document.querySelector('#startbutton'),
			cpt_1			= document.querySelector('#cpt_1'),
			width			= 320,
			height			= 0;

		navigator.getMedia	= ( navigator.getUserMedia ||
							navigator.webkitGetUserMedia ||
							navigator.mozGetUserMedia ||
							navigator.msGetUserMedia);

		function sleep(milliseconds) {
			var start = new Date().getTime();
				for (var i = 0; i < 1e7; i++) {
					if ((new Date().getTime() - start) > milliseconds){
						break;
				}
			}
		}

		navigator.getMedia(
			{
				video: true,
				audio: false
			},
			function(stream) {
				if (navigator.mozGetUserMedia) {
					video.mozSrcObject = stream;
				} else {
					var vendorURL = window.URL || window.webkitURL;
					video.src = vendorURL.createObjectURL(stream);
				}
				video.play();
			},
			function(err) {
				console.log("An error occured! " + err);
			}
		);

		video.addEventListener('canplay', function(ev){
			if (!streaming) {
				height = video.videoHeight / (video.videoWidth/width);
				video.setAttribute('width', width);
				video.setAttribute('height', height);
				canvas.setAttribute('width', width);
				canvas.setAttribute('height', height);
				streaming = true;
			}
		}, false);

		function takepicture() {
			canvas.width = width;
			canvas.height = height;
			canvas.getContext('2d').drawImage(video, 0, 0, width, height);
			var data = canvas.toDataURL('image/png');
			photo.setAttribute('src', data);
			cpt_1.setAttribute('value', data);
			console.log(data);
		}


		startbutton.addEventListener('click', function(ev){
			takepicture();
		}, false);

	})();
	</script>
<?php include '../partials/footer.php'; 
