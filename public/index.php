<?php
require __DIR__.'/../vendor/autoload.php';

require __DIR__.'/../config/bootstrap.php';

ini_set('session.name', 'VILUSIK');

session_start();

$app = new Slim\App();

$app->get('/', function ($request, $response, $args) {

	/*init template engine*/
    $templates = new League\Plates\Engine(__DIR__.'/../views');

	/*render templete and get html*/
	$variables = [
		'title' => 'Session',
		'user' => getAuthUser(),
	];
    $html = $templates->render('home', $variables);
	/*echo html*/
    return $response->write($html);
});

$app->get('/protected', function ($request, $response, $args) {
    $user = getAuthUser();
    $html = 'You should login';
    if($user) {
		/*init template engine*/
	    $templates = new League\Plates\Engine(__DIR__.'/../views');

		/*render templete and get html*/
		$variables = [
			'title' => 'Protected',
			'user' => $user
		];
	    $html = $templates->render('protected', $variables);
    }

	/*echo html*/
    return $response->write($html);
});

$app->get('/logout', function ($request, $response, $args) {
	if(isset($_SESSION['user_id'])) {
		unset($_SESSION['user_id']);
	}
	header('Location: /');
});

$app->post('/login', function ($request, $response, $args) {

	$username = isset($_POST['username']) ? $_POST['username'] : null;
	$password = isset($_POST['password']) ? $_POST['password'] : null;
	if($username && $password) {
		$db_host =  getenv('DB_HOST');
		$db_username = getenv('DB_USER');
		$db_password = getenv('DB_PASSWORD');
		$db_name = getenv('DB_NAME');

		$mysqli = new mysqli($db_host, $db_username, $db_password, $db_name);
		$query = "SELECT * FROM users WHERE `username` = '{$username}'";
		$query_result = $mysqli->query($query);
		$user = $query_result->fetch_assoc();	
		if($user && md5($password) === $user['password']) {
			$_SESSION['user_id'] = $user['id'];
		}
	}
	header('Location: /');
});

$app->run();