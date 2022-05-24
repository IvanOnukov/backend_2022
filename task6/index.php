<?php
/**
 * Реализовать проверку заполнения обязательных полей формы в предыдущей
 * с использованием Cookies, а также заполнение формы по умолчанию ранее
 * введенными значениями.
 */

// Отправляем браузеру правильную кодировку,
// файл index.php должен быть в кодировке UTF-8 без BOM.
header('Content-Type: text/html; charset=UTF-8');

// В суперглобальном массиве $_SERVER PHP сохраняет некторые заголовки запроса HTTP
// и другие сведения о клиненте и сервере, например метод текущего запроса $_SERVER['REQUEST_METHOD'].
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  // Массив для временного хранения сообщений пользователю.
  $messages = array();

  // В суперглобальном массиве $_COOKIE PHP хранит все имена и значения куки текущего запроса.
  // Выдаем сообщение об успешном сохранении.
  if (!empty($_COOKIE['save'])) {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('save', '', 100000);
    setcookie('login', '', 100000); 
    setcookie('password', '', 100000); 
    // Если есть параметр save, то выводим сообщение пользователю.
    $messages[] = 'Спасибо, результаты сохранены.';
  }
    if (!empty($_COOKIE['password'])) {
        $messages[] = sprintf('Вы можете <a href="login.php">войти</a> с логином <strong>%s</strong>
          и паролем <strong>%s</strong> для изменения данных.',
          strip_tags($_COOKIE['login']),
          strip_tags($_COOKIE['password']));
  }

  // Складываем признак ошибок в массив.
  $errors = array();
  $errors['name'] = !empty($_COOKIE['name_error']);
  $errors['email'] = !empty($_COOKIE['email_error']);
  $errors['number_of_limbs'] = !empty($_COOKIE['number_of_limbs_error']);
  $errors['gender'] = !empty($_COOKIE['gender_error']);
  $errors['ability'] = !empty($_COOKIE['ability_error']);
  $errors['ok'] = !empty($_COOKIE['ok_error']);
  // TODO: аналогично все поля.

  // Выдаем сообщения об ошибках.
  if ($errors['name']) {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('name_error', '', 100000);
    // Выводим сообщение.
    $messages[] = '<div class="error">Заполните имя корректно.</div>';
  }
  if ($errors['email']) {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('email_error', '', 100000);
    // Выводим сообщение.
    $messages[] = '<div class="error">Заполните email корректно.</div>';
  }

  if ($errors['number_of_limbs']) {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('number_of_limbs_error', '', 100000);
    // Выводим сообщение.
    $messages[] = '<div class="error">Укажите количество ваших конечностей.</div>';
  }

  if ($errors['gender']) {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('gender_error', '', 100000);
    // Выводим сообщение.
    $messages[] = '<div class="error">Укажите свой пол.</div>';
  }

  if ($errors['ability']) {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('ability_error', '', 100000);
    // Выводим сообщение.
    $messages[] = '<div class="error">Укажите свои суперспособности.</div>';
  }

  if ($errors['ok']) {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('ok_error', '', 100000);
    // Выводим сообщение.
    $messages[] = '<div class="error">Поставьте галочку.</div>';
  }

  // TODO: тут выдать сообщения об ошибках в других полях.

  // Складываем предыдущие значения полей в массив, если есть.
  $values = array();
  $values['name'] = empty($_COOKIE['name_value']) ? '' : strip_tags($_COOKIE['name_value']);
  $values['email'] = empty($_COOKIE['email_value']) ? '' : strip_tags($_COOKIE['email_value']);
  $values['birth_date'] = empty($_COOKIE['birth_date_value']) ? '' : $_COOKIE['birth_date_value'];
  $values['gender'] = empty($_COOKIE['gender_value']) ? '' : $_COOKIE['gender_value'];
  $values['number_of_limbs'] = empty($_COOKIE['number_of_limbs_value']) ? '' : $_COOKIE['number_of_limbs_value'];
  $values['ability'] = empty($_COOKIE['ability_value']) ? '' : $_COOKIE['ability_value'];

  // Если нет предыдущих ошибок ввода, есть кука сессии, начали сессию и
  // ранее в сессию записан факт успешного логина.
  $er=false;
  foreach($errors as $el)
    if ($el == true)
      $er = true;
  if (empty($er) && !empty($_COOKIE[session_name()]) && 
  session_start() && !empty($_SESSION['login'])) {
// TODO: загрузить данные пользователя из БД
// и заполнить переменную $values,
// предварительно санитизовав.
  $user = 'root';
  $password = 'Yfcnhjtybt1597533';
  $db = new PDO('mysql:host=localhost;dbname=my_db', $user, $password, array(PDO::ATTR_PERSISTENT => true));
  $uid = $_SESSION['uid'];
  $res= $db->query("SELECT name, email, birth_date, gender, number_of_limbs FROM application WHERE id = $uid");
  foreach($res as $el){
    $values['name']=strip_tags($el['name']);
    $values['email']=strip_tags($el['email']);
    $values['birth_date']=strip_tags($el['birth_date']);
    $values['gender']=strip_tags($el['gender']);
    $values['number_of_limbs']=strip_tags($el['number_of_limbs']);
  }
  $res= $db->query("SELECT nom_spw FROM spw WHERE id = $uid");
  $sup = array();
  foreach($res as $el){
    $sup[]=(int)strip_tags($el['nom_spw']);
  }
  $sp = implode('',$sup);
  $values['ability'] =$sp;
printf('Вход с логином %s, uid %d', $_SESSION['login'], $_SESSION['uid']);
}
  

  // Включаем содержимое файла form.php.
  // В нем будут доступны переменные $messages, $errors и $values для вывода 
  // сообщений, полей с ранее заполненными данными и признаками ошибок.
  include('form.php');
}
// Иначе, если запрос был методом POST, т.е. нужно проверить данные и сохранить их в XML-файл.
else {
  // Проверяем ошибки.
  setlocale(LC_ALL, "ru_RU.UTF-8");
  $errors = FALSE;
  if (empty($_POST['name']) || preg_match('/[^(\x7F-\xFF)|(\s)]/', $_POST['name'])) {
    // Выдаем куку на день с флажком об ошибке в поле name.
    setcookie('name_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    // Сохраняем ранее введенное в форму значение на месяц.
    setcookie('name_value', $_POST['name'], time() + 30 * 24 * 60 * 60);
  }


  if (empty($_POST['email'])) {
    // 
    setcookie('email_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    // Сохраняем ранее введенное в форму значение на месяц.
    setcookie('email_value', $_POST['email'], time() + 30 * 24 * 60 * 60);
  }

  if (empty($_POST['gender'])) {
    // 
    setcookie('gender_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    // Сохраняем ранее введенное в форму значение на месяц.
    setcookie('gender_value', $_POST['gender'], time() + 30 * 24 * 60 * 60);
  }

  if (empty($_POST['number_of_limbs'])) {
    // 
    setcookie('number_of_limbs_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    // Сохраняем ранее введенное в форму значение на месяц.
    setcookie('number_of_limbs_value', $_POST['number_of_limbs'], time() + 30 * 24 * 60 * 60);
  }

  if (empty($_POST['ability'])) {
    // 
    setcookie('ability_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    $sp = implode('',$_POST['ability']);
    // Сохраняем ранее введенное в форму значение на месяц.
    setcookie('ability_value', $sp, time() + 30 * 24 * 60 * 60);
  }

  if (empty($_POST['ok'])) {
    // 
    setcookie('ok_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }

  setcookie('birth_date_value', $_POST['birth_date'], time() + 30 * 24 * 60 * 60);
  
// *************
// TODO: тут необходимо проверить правильность заполнения всех остальных полей.
// Сохранить в Cookie признаки ошибок и значения полей.
// *************

  if ($errors) {
    // При наличии ошибок перезагружаем страницу и завершаем работу скрипта.
    header('Location: index.php');
    exit();
  }
  else {
    // Удаляем Cookies с признаками ошибок.
    setcookie('name_error', '', 100000);
    setcookie('email_error', '', 100000);
    setcookie('gender_error', '', 100000);
    setcookie('number_of_limbs_error', '', 100000);
    setcookie('ability_error', '', 100000);
    setcookie('ok_error', '', 100000);
    
    // TODO: тут необходимо удалить остальные Cookies.
  }

  $user = 'u47648';
  $password = '3363171';
  $db = new PDO('mysql:host=localhost;dbname=u47648', $user, $password, array(PDO::ATTR_PERSISTENT => true));

// Проверяем меняются ли ранее сохраненные данные или отправляются новые.
    if (!empty($_COOKIE[session_name()]) &&
  session_start() && !empty($_SESSION['login'])) {
// TODO: перезаписать данные в БД новыми данными,
// кроме логина и пароля.
try {
  $uid = $_SESSION['uid'];
  $stmt = $db->prepare("UPDATE application SET name = ?, email = ?, birth_date = ?, gender = ?, number_of_limbs = ? WHERE id = $uid");
  $stmt -> execute([$_POST['name'],$_POST['email'],$_POST['birth_date'],$_POST['gender'],$_POST['number_of_limbs']]);
  
  $db->query("DELETE FROM spw WHERE id = $uid");
  $stmt = $db->prepare("INSERT INTO spw SET id = ?, nom_spw = ?");
  foreach($_POST['ability'] as $el)
    $stmt -> execute([$uid,$el]);
}
catch(PDOException $e){
  print('Error : ' . $e->getMessage());
  
  exit();
}
}
  else {
// Генерируем уникальный логин и пароль.
// TODO: сделать механизм генерации, например функциями rand(), uniquid(), md5(), substr().
$login = substr(uniqid(time()),1,8);
$password = substr(md5($_POST['email']),5,8);
// Сохраняем в Cookies.
setcookie('login', $login);
setcookie('password', $password);

// TODO: Сохранение данных формы, логина и хеш md5() пароля в базу данных.
// ...


  // Сохранение в XML-документ.


try {
  $str = implode(',',$_POST['ability']);
  
  $stmt = $db->prepare("INSERT INTO application SET name = ?, email = ?, birth_date = ?, gender = ?, number_of_limbs = ?");
  $stmt -> execute([$_POST['name'],$_POST['email'],$_POST['birth_date'],$_POST['gender'],$_POST['number_of_limbs']]);

  $id = $db->lastInsertId();
  $stmt = $db->prepare("INSERT INTO baza SET id = ?, login = ?, password = ?");
  $stmt -> execute([$id,$login,md5($password)]);

  $stmt = $db->prepare("INSERT INTO spw SET id = ?, nom_spw = ?");
  foreach($_POST['ability'] as $el)
    $stmt -> execute([$id,$el]);
}
catch(PDOException $e){
  print('Error : ' . $e->getMessage());
  exit();
}
}

  // Сохраняем куку с признаком успешного сохранения.
  setcookie('save', '1');

  // Делаем перенаправление.
  header('Location: index.php');
}
