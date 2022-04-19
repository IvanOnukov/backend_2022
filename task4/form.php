
<html>
  <head>
    <style>
/* Сообщения об ошибках и поля с ошибками выводим с красным бордюром. */
body{
    background-color: #01060f; /* Цвет фона веб-страницы */
    color: aliceblue;
}
.error {
    border: 2px solid red;
}
    </style>
    </style>
  </head>
  <body>

<?php
if (!empty($messages)) {
  print('<div id="messages">');
  // Выводим все сообщения.
  foreach ($messages as $message) {
    print($message);
  }
  print('</div>');
}

// Далее выводим форму отмечая элементы с ошибками классом error
// и задавая начальные значения элементов ранее сохраненными.
?>

    <form action="" method="POST">
      <p>1. Имя: <input name="fio"
              <?php if ($errors['fio']) {
                  print 'class="error"';
              } ?>
              value="<?php print $values['fio']; ?>"
          />
      </p>

      <p>2. Email: <input name="email" type="email"
              <?php if ($errors['email']) {print 'class="error"';} ?>
              value="<?php print $values['email']; ?>"
          />
      </p>

      <p>3. Дата рождения: <input name="birth_date" type="date"
              <?php if ($errors['birth_date']) {print 'class="error"';} ?>
              value="<?php print $values['birth_date']; ?>"
          />
      </p>

      <p>4. Пол:</p>
      <p>
        <input type="radio" name="gender" value="male" checked> Мужской
        <input type="radio" name="gender" value="female"> Женский
      </p>

      <p>5. Количество конечностей</p>
      <p>
        <input type="radio" name="number_of_limbs" value="1"> 1
        <input type="radio" name="number_of_limbs" value="2"> 2
        <input type="radio" name="number_of_limbs" value="3"> 3
        <input type="radio" name="number_of_limbs" value="4" checked> 4
      </p>

        <p>6. Сверхспособности: </p>
      <select name="ability">
          <option>бессмертие</option>
          <option>прохождение сквозь стены</option>
          <option>левитация</option>
      </select>
      <p>7. Биография</p>
      <p>
          <textarea name="comment"></textarea>
      </p>

      <p>8. с контрактом ознакомлен(a)
            <input type="checkbox" name="consent"/>
      </p>
      <input type="submit" value="Отправить" />
    </form>

    <script
  src="https://code.jquery.com/jquery-3.6.0.js"
  integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
  crossorigin="anonymous"></script>

    <script>

    </script>
  </body>
</html>
