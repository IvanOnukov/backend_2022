<?php
/**
 * Реализовать возможность входа с паролем и логином с использованием
 * сессии для изменения отправленных данных в предыдущей задаче,
 * пароль и логин генерируются автоматически при первоначальной отправке формы.
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
        setcookie('pass', '', 100000);
        // Выводим сообщение пользователю.
        $messages[] = 'Спасибо, результаты сохранены.';
        // Если в куках есть пароль, то выводим сообщение.
        if (!empty($_COOKIE['pass'])) {
            $messages[] = sprintf('Вы можете <a href="login.php">войти</a> с логином <strong>%s</strong>
        и паролем <strong>%s</strong> для изменения данных.',
                strip_tags($_COOKIE['login']),
                strip_tags($_COOKIE['pass']));
        }
    }

    // Складываем признак ошибок в массив.
    $errors = array();
    $errors['fio'] = !empty($_COOKIE['fio_error']);


    // TODO: тут выдать сообщения об ошибках в других полях.

    // Складываем предыдущие значения полей в массив, если есть.
    // При этом санитизуем все данные для безопасного отображения в браузере.
    $values = array();
    $values['fio'] = empty($_COOKIE['fio_value']) ? '' : strip_tags($_COOKIE['fio_value']);
    $errors['fio'] = !empty($_COOKIE['fio_error']);
    $errors['email'] = !empty($_COOKIE['email_error']);
    $errors['birth_date'] = !empty($_COOKIE['birth_date_error']);
    $errors['gender'] = !empty($_COOKIE['gender_error']);
    $errors['number_of_limbs'] = !empty($_COOKIE['number_of_limbs_error']);
    $errors['consent']  = !empty($_COOKIE['consent_error']);


    // Выдаем сообщения об ошибках.
    if ($errors['fio']) {
        // Удаляем куку, указывая время устаревания в прошлом.
        setcookie('fio_error', '', 100000);
        // Выводим сообщение.
        $messages[] = '<div class="error">Введите корректное имя имя.</div>';
    }
    // TODO: тут выдать сообщения об ошибках в других полях.

    if ($errors['email']) {
        // Удаляем куку, указывая время устаревания в прошлом.
        setcookie('email_error', '', 100000);
        // Выводим сообщение.
        $messages[] = '<div class="error">Заполните email.</div>';
    }

    if ($errors['birth_date']) {
        // Удаляем куку, указывая время устаревания в прошлом.
        setcookie('birth_date_error', '', 100000);
        // Выводим сообщение.
        $messages[] = '<div class="error">Заполните дату рождения.</div>';
    }

    if ($errors['gender']) {
        // Удаляем куку, указывая время устаревания в прошлом.
        setcookie('gender_error', '', 100000);
        // Выводим сообщение.
        $messages[] = '<div class="error">Выберите пол.</div>';
    }

    if ($errors['number_of_limbs']) {
        // Удаляем куку, указывая время устаревания в прошлом.
        setcookie('number_of_limbs_error', '', 100000);
        // Выводим сообщение.
        $messages[] = '<div class="error">Выберите количество конечностей.</div>';
    }

    if ($errors['consent']) {
        setcookie('consent_error', '', 100000);
        $messages[] = '<div class="error"> Не приняты условия контракта.</div>';
    }

    // Складываем предыдущие значения полей в массив, если есть.
    $values = array();
    $values['fio'] = empty($_COOKIE['fio_value']) ? '' : $_COOKIE['fio_value'];
    $values['email'] = empty($_COOKIE['email_value']) ? '' : $_COOKIE['email_value'];
    $values['birth_date'] = empty($_COOKIE['birth_date_value']) ? '' : $_COOKIE['birth_date_value'];
    $values['gender'] = empty($_COOKIE['gender_value']) ? '' : $_COOKIE['gender_value'];
    $values['number_of_limbs'] = empty($_COOKIE['number_of_limbs_value']) ? '' : $_COOKIE['number_of_limbs_value'];
    $values['consent'] = empty($_COOKIE['consent']) ? '' : $_COOKIE['consent'];
    // TODO: аналогично все поля.
    // TODO: аналогично все поля.

    // Если нет предыдущих ошибок ввода, есть кука сессии, начали сессию и
    // ранее в сессию записан факт успешного логина.
    if (empty($errors) && !empty($_COOKIE[session_name()]) &&
        session_start() && !empty($_SESSION['login'])) {
        // TODO: загрузить данные пользователя из БД
        // и заполнить переменную $values,
        // предварительно санитизовав.
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
    $errors = FALSE;
    $pattern_name = "/^[a-zа-я]+$/iu";
    $pattern_email = "/^([a-z0-9_-]+\.)*[a-z0-9_-]+@[a-z0-9_-]+(\.[a-z0-9_-]+)*\.[a-z]{2,6}$/";
    if (empty($_POST['fio']) || !preg_match($pattern_name, $_POST['fio'])) {
        // Выдаем куку на день с флажком об ошибке в поле fio.
        setcookie('fio_error', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
    }
    else {
        // Сохраняем ранее введенное в форму значение на месяц.
        setcookie('fio_value', $_POST['fio'], time() + 30 * 24 * 60 * 60);
    }

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
        setcookie('fio_error', '', 100000);
        // TODO: тут необходимо удалить остальные Cookies.
    }

    if (empty($_POST['fio'])) {
        // Выдаем куку на день с флажком об ошибке в поле fio.
        setcookie('fio_error', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
    }
    else {
        // Сохраняем ранее введенное в форму значение на месяц.
        setcookie('fio_value', $_POST['fio'], time() + 30 * 24 * 60 * 60);
    }

    if (empty($_POST['email'])) {
        // Выдаем куку на день с флажком об ошибке в поле fio.
        setcookie('email_error', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
    }
    else {
        // Сохраняем ранее введенное в форму значение на месяц.
        setcookie('email_value', $_POST['email'], time() + 30 * 24 * 60 * 60);
    }

    if (empty($_POST['birth_date'])) {
        // Выдаем куку на день с флажком об ошибке в поле fio.
        setcookie('birth_date_error', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
    }
    else {
        // Сохраняем ранее введенное в форму значение на месяц.
        setcookie('birth_date_value', $_POST['birth_date'], time() + 30 * 24 * 60 * 60);
    }

    if (empty($_POST['gender'])) {
        // Выдаем куку на день с флажком об ошибке в поле fio.
        setcookie('gender_error', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
    }
    else {
        // Сохраняем ранее введенное в форму значение на месяц.
        setcookie('gender_value', $_POST['gender'], time() + 30 * 24 * 60 * 60);
    }

    if (empty($_POST['number_of_limbs'])) {
        // Выдаем куку на день с флажком об ошибке в поле fio.
        setcookie('number_of_limbs_error', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
    }
    else {
        // Сохраняем ранее введенное в форму значение на месяц.
        setcookie('number_of_limbs_value', $_POST['number_of_limbs'], time() + 30 * 24 * 60 * 60);
    }

    if ($_POST['consent'] == null) {
        setcookie('consent_error', 'off', time() + 24 * 60 * 60);
        $errors = TRUE;

    } else {
        setcookie('consent_value', $_POST['consent'], time() + 30 * 24 * 60 * 60);
    }

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
        setcookie('fio_error', '', 100000);
        setcookie('email_error', '', 100000);
        setcookie('birth_date_error', '', 100000);
        setcookie('gender_error', '', 100000);
        setcookie('number_of_limbs_error', '', 100000);
        setcookie('consent_error', '', 100000);
        // TODO: тут необходимо удалить остальные Cookies.
    }

    // Проверяем меняются ли ранее сохраненные данные или отправляются новые.
    if (!empty($_COOKIE[session_name()]) &&
        session_start() && !empty($_SESSION['login'])) {
        // TODO: перезаписать данные в БД новыми данными,
        // кроме логина и пароля.
    }
    else {
        // Генерируем уникальный логин и пароль.
        // TODO: сделать механизм генерации, например функциями rand(), uniquid(), md5(), substr().
        $login = rand();
        $pass = rand();
        // Сохраняем в Cookies.
        setcookie('login', $login);
        setcookie('pass', $pass);

        // TODO: Сохранение данных формы, логина и хеш md5() пароля в базу данных.
        // ...
    }

    // Сохраняем куку с признаком успешного сохранения.
    setcookie('save', '1');

    // Делаем перенаправление.
    header('Location: ./');
}