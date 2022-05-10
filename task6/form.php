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


<body>

  <div id="main-aside-wrapper">
    <div id="cont" class="container">
      <div id="form" class="col-12 order-lg-3 order-sm-2">
      <div id="vhod">
          <?php 
          if (empty($_SESSION['login'])){
          ?>
          <a href="login.php" >Войти</a>
          
          <?php 
          }else { ?><a href="login.php" >Выйти</a><?php } ?>
          
        </div>
        <form action="" method="POST">
            <div>
            Имя:
          <label>
            <input name="fio"  <?php if ($errors['fio']) {print 'class="error"';} ?> value="<?php print $values['fio']; ?>" placeholder="Введите ФИО">
          </label>
            </div>
            <div>
          E-mail:
          <label>
            <input type="email" name="email" placeholder="Введите e-mail" <?php if ($errors['email']) {print 'class="error"';} ?> value="<?php print $values['email']; ?>">
          </label>
            </div>
            <p>Дата рождения: <input name="birth_date" type="date" <?php if ($errors['birth_date']) {print 'class="error"';} ?> value="<?php print $values['birth_date']; ?>"></p>
            <p>Пол:</p>

          <label>
            <input type="radio" name="gender" value="M" <?php if($values['gender'] == 'M') {print 'checked';}?> <?php if ($errors['gender']) {print 'class="error"';} ?> />Мужской
          </label>
          <label>
            <input type="radio" name="gender" value="W" <?php if($values['gender'] == 'W') {print 'checked';}?> <?php if ($errors['gender']) {print 'class="error"';} ?> />Женский
          </label>

          <p>Количество конечностей</p>
          <label>
            <input type="radio" name="limbs" value="1" <?php if($values['limbs'] == 1) {print 'checked';}?> <?php if ($errors['limbs']) {print 'class="error"';} ?>/>1
          </label>
          <label>
            <input type="radio" name="limbs" value="2" <?php if($values['limbs'] == 2) {print 'checked';}?> <?php if ($errors['limbs']) {print 'class="error"';} ?>/>2
          </label>
          <label>
            <input type="radio" name="limbs" value="3" <?php if($values['limbs'] == 3) {print 'checked';}?> <?php if ($errors['limbs']) {print 'class="error"';} ?>/>3
          </label>
          <label>
            <input type="radio" name="limbs" value="4" <?php if($values['limbs'] == 4) {print 'checked';}?> <?php if ($errors['limbs']) {print 'class="error"';} ?> />4
          </label>

          <p>Сверхспособности</p>
          <label>
              <select name="ability">
                  <option>бессмертие</option>
                  <option>прохождение сквозь стены</option>
                  <option>левитация</option>
              </select>
          <p id="bio">Биография</p>
          <label>
            <textarea placeholder="Расскажите о себе" name="biography" rows="6" cols="60"  <?php if ($errors['biography']) {print 'class="error"';} ?> ><?php print $values['biography'];?></textarea>
          </label>
          <br>

          <label>
            С контрактом ознакомлен(-a)
            <input type="checkbox" name="ok" >
          </label>
          <br>
          <input type="submit" value="Отправить">
        </form>
      </div>
    </div>
  </div>
</body>

</body>
