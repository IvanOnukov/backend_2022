<?php
    if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['birth_date']) && isset($_POST['ability'])){
        // Переменные с формы
        $name = $_POST['name'];
        $email = $_POST['email'];
        $birth_date = $_POST['birth_date'];
        $ability = $_POST['ability'];
        
        // Параметры для подключения
        $db_host = "localhost"; 
        $db_user = "u47648"; // Логин БД
        $db_password = "3363171"; // Пароль БД
        $db_base = 'u47648'; // Имя БД
        $db_table = "application"; // Имя Таблицы БД
        
        try {
            // Подключение к базе данных
            $db = new PDO("mysql:host=$db_host;dbname=$db_base", $db_user, $db_password);
            // Устанавливаем корректную кодировку
            $db->exec("set names utf8");
            // Собираем данные для запроса
            $data = array( 'name' => $name, 'email' => $email, 'birth_date' => $birth_date, 'ability' => $ability ); 
            // Подготавливаем SQL-запрос
            $query = $db->prepare("INSERT INTO $db_table (name, email, birth_date, ability) values (:name, :email, :birth_date, :ability )");
            // Выполняем запрос с данными
            $query->execute($data);
            // Запишим в переменую, что запрос отрабтал
            $result = true;
        } catch (PDOException $e) {
            // Если есть ошибка соединения или выполнения запроса, выводим её
            print "Ошибка!: " . $e->getMessage() . "<br/>";
        }
        
        if ($result) {
            echo "Успех. Информация занесена в базу данных";
        }
    }
?>

