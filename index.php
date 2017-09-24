<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<link rel="stylesheet" href="css/jquery-ui.css">
	<script src="js/jquery-3.1.0.min.js"></script>
</head>
<body>
<?php 
	include_once('pages/classes.php');
?>
<div class="container adm">
<div class="row">
	<script>$(function(){
		$('#tabs').tabs()
	});</script>
	<div id="tabs">
		<ul>
			<li><a href="#tabs-1">Категории товаров</a></li>
			<li><a href="#tabs-2">Товары</a></li>
			<li><a href="#tabs-3">Картинки</a></li>
		</ul>
			<div id="tabs-1">
				<form action='' method='post'>
				  			<label for="category">Введите категорию</label><br>
				    		<input type="text" name="category"><br><br>
				    		<input type='submit' name='addcat' value='Добавить категорию'>
							<input type='submit' name='delcat' value='Удалить'>
							<?php 
								$db=new ManagerDb('localhost', 'root', '654321', '10474');
								$pdo=$db->connect();
									if (isset($_POST['addcat']))
									{
										$category=$_POST['category'];
										$ps=$pdo->prepare('insert into categories (category) value(:category)');
										$data=array('category'=>$category);
										$ps->execute($data);
									}
							?>
							<br><br>					
				</form>
			</div>
			<div id="tabs-2">
				<form action="" method='post' enctype="multipart/form-data">

		  				<?php include_once('pages/lists.html'); ?>
			    		
						<br><br>
						<label for="itemname">Введите название товара</label><br>
			    		<input type="text" name="itemname"><br><br>
			    		<label for="pricein">Цена закупки</label><br>
			    		<input type="text" name="pricein"><br><br>
			    		<label for="pricesale">Цена продажи</label><br>
			    		<input type="text" name="pricesale"><br><br>
			    		<label for="info">Информация о товаре</label><br>
			    		<textarea name="info" id="" cols="30" rows="10"></textarea>
			    		<br><br>
						<input type="file" name="file" multiple accept="image/*"><br> <!-- картинки любых форматов -->
			    		<input type='submit' name='additem' value='Добавить товар'>
						<input type='submit' name='delitem' value='Удалить'>
					</form>
					<?php 
		  				if (isset($_POST['additem'])) {
		  					if (is_uploaded_file($_FILES['file']['tmp_name'])) {
		  						$path='images/'.$_FILES['file']['name'];
		  						move_uploaded_file($_FILES['file']['tmp_name'], $path);
		  					}
		  					$catid=$_POST['catid'];
		  					$subid=$_POST['subid'];
		  					$pricein=$_POST['pricein'];
		  					$pricesale=$_POST['pricesale'];
		  					$info=trim($_POST['info']);
		  					$itemname=trim($_POST['itemname']);
		  					$data=array('id'=>0,'itemname'=>$itemname,'catid'=>$catid,'subid'=>$subid,'pricein'=>$pricein,'pricesale'=>$pricesale,'info'=>$info,'rate'=>0,'imagepath'=>$path,'action'=>0);

		  					$item=new Item($data);
		  					$item->intoDb();
		  					//чтобы форма повторно не отправлялась
		  					//echo "<script>document.location='http://shop/index.php?page=2'</script>";
		  					//header("Location:".$_SERVER["REQUEST_URI"]);
		  					//exit;
		  				}

		  			?>
			</div>
			<div id="tabs-3">
				333333
			</div>
		
		
	</div>
	
</div>
</div>


<script src="js/jquery-ui.js"></script>
</body>
</html>