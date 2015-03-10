<!DOCTYPE HTML>
<html>
<head>
	<meta charset="UTF-8">
	<title>Отзывы</title>
	<!-- Bootstrap -->
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="css/style.css" media="all" />
	<!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
	<div class="container">
            <form action="lib/index.php" method="post" id="comment-form" class="form-horizontal" enctype="multipart/form-data">
		  <div class="form-group">
			<label for="inputEmail" class="col-sm-5 control-label">Введите Ваш имейл</label>
			<div class="col-sm-5">
			  <input type="email" class="form-control" id="inputEmail" name="email" placeholder="username@domain.com">
			</div>
		  </div>
		  <div class="form-group">
			<label for="inputFIO" class="col-sm-5 control-label">Введите Ваше Ф.И.О.</label>
			<div class="col-sm-5">
			  <input type="text" class="form-control" id="inputFIO" name="FIO" placeholder="Иванов Иван Иваныч">
			</div>
		  </div>
		  <div class="form-group">
			<label for="inputphone" class="col-sm-5 control-label">Введите Ваш телефон</label>
			<div class="col-sm-5">
			  <input type="text" class="form-control" id="inputphone" name="phone" placeholder="0441234567">
			</div>
		  </div>
		  <div class="form-group">
			<label for="inputcomment" class="col-sm-5 control-label">Введите Ваш комментарий</label>
			<div class="col-sm-5">
			  <textarea class="form-control" name="comment" id="inputcomment" rows="3"></textarea>
			</div>
		  </div>
		  <div class="form-group">
			<label for="inputget_file" class="col-sm-5 control-label">Прикрепить файл</label>
			<div class="col-sm-5">
                            <input name="get_file[]" id="inputget_file" type="file" multiple=""/>
			</div>
		  </div>
		  <div class="form-group">
			<div class="col-sm-offset-5 col-sm-5">
			  <button type="submit" class="btn btn-primary submit_button">Оставить комментарий</button>
			</div>
		  </div>
                <input type="hidden" name="filename" value=""/> 
		</form>
            <div class="response">
            </div>

	</div>	
	
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="http://scriptjava.net/source/scriptjava/scriptjava.js"></script>
    <script src="js/validate.js"></script>
</body>
</html>