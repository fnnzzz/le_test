<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>LE Test</title>

	<link rel="stylesheet" href="assets/dist/libs/bower_components/sweetalert/dist/sweetalert.css">
	<link rel="stylesheet" href="assets/dist/css/style.css">

</head>
<body>
	

	<?php 

		class UserList {

		   public function __construct($user, $password, $database, $host = 'localhost') {
		         $this->user = $user;
		         $this->password = $password;
		         $this->database = $database;
		         $this->host = $host;
		   }

		   protected function connect() {
		      return new mysqli($this->host, $this->user, $this->password, $this->database);
		   }

		   public function showUserList() {

				$db = $this->connect();
				$stmt = $db->prepare('SELECT * FROM userlist ORDER BY order_num');
				$stmt->execute();
				$result = $stmt->get_result();
				
				while ($row = $result->fetch_object()) {
				$results[] = $row;
				}
				
				return $results;
		   }


		}

	?>

	<div class="wrap">
		
		<div class="form__wrap">
			
			<div class="form__title-wrap">
				<h1 class="typo__title form__title">
					Registration form
				</h1>
			</div>
			

			<form id="form" action="api.php?api_key=sdgv0ddff7kko3hj" method="POST">

				<div class="form__inner-wrap">

					<input required id="name" name="name" type="text" class="form__input -name" placeholder="Name:">
					<input required id="email" name="email" type="email" class="form__input -email" placeholder="E-Mail:">

				</div>

				<button type="submit" class="form__submit">Send</button>

			</form>

		</div>


		<div class="form__wrap -userlist">
			
			<div class="form__title-wrap -userlist">
				<h1 class="typo__title form__title">
					Users list
				</h1>
			</div>
		

			<div class="form__inner-wrap -userlist">
				<ol class="form__list">

					<?php 

						error_reporting(E_ERROR);

						$userlist = new UserList('root', '', 'le_test');

						$userlist_array = $userlist->showUserList();

						if($userlist_array) {
							foreach ($userlist_array as $user)
							{
								echo '<li class="form__list-item" data-order='.$user->order_num.'>'.$user->name.' ('.$user->email.')<span class="form__list-item-delete">&#10799;</span></li>';
							    // echo $user->name;
							}
						}	

						else {
							echo '<p class="form__list-item -empty">user list is empty</p>';
						}					


					?>

				</ol>
			</div>


		</div>	

	</div>


	<div id="loader">
		
		<div class="sk-folding-cube">
		  <div class="sk-cube1 sk-cube"></div>
		  <div class="sk-cube2 sk-cube"></div>
		  <div class="sk-cube4 sk-cube"></div>
		  <div class="sk-cube3 sk-cube"></div>
		</div>

	</div>

	<div class="spinner-wrap">
		<div class="spinner">
		  <div class="double-bounce1"></div>
		  <div class="double-bounce2"></div>
		</div>
	</div>



	<script src="assets/dist/libs/bower_components/jquery/dist/jquery.min.js"></script>
	<script src="assets/dist/libs/bower_components/sweetalert/dist/sweetalert.min.js"></script>

	<script src="assets/dist/js/combined.js"></script>

</body>
</html>