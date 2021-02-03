    <nav class="nav">
      <ul class="nav__list container">
        <?php foreach($categories as $value): ?>
          <li class="nav__item">
            <a href="all-lots.html"><?= $value['name_ru']; ?></a>
          </li>
        <?php endforeach; ?>
      </ul>
    </nav>
    <form class="form form--add-lot container form--invalid" action="add.php" method="post" enctype="multipart/form-data"> <!-- form--invalid -->
      <h2>Добавление лота</h2>
      <div class="form__container-two">
        <div class="form__item form__item--invalid"> <!-- form__item--invalid -->
          <label for="lot_name">Наименование</label>
          <input id="lot_name" type="text" name="lot_name" placeholder="Введите наименование лота" required>
          <span class="form__error">Введите наименование лота</span>
        </div>
        <div class="form__item">
          <label for="category">Категория</label>
          <select id="category" name="category" required>
            <?php foreach($categories as $cat): ?>
              <option value="<?= $cat['id']; ?>"><?= $cat['name_ru']; ?></option>
            <?php endforeach; ?>
          </select>
          <span class="form__error">Выберите категорию</span>
        </div>
      </div>
      <div class="form__item form__item--wide">
        <label for="description">Описание</label>
        <textarea id="description" name="description" placeholder="Напишите описание лота" required></textarea>
        <span class="form__error">Напишите описание лота</span>
      </div>
      <div class="form__item form__item--file"> <!-- form__item--uploaded -->
        <label>Изображение</label>
        <div class="preview">
          <button class="preview__remove" type="button">x</button>
          <div class="preview__img">
            <img src="img/avatar.jpg" width="113" height="113" alt="Изображение лота">
          </div>
        </div>
        <div class="form__input-file">
          <input class="visually-hidden" name = "lot_img" type="file" id="photo2" value="">
          <label for="photo2">
            <span>+ Добавить</span>
          </label>
        </div>
      </div>
      <div class="form__container-three">
        <div class="form__item form__item--small">
          <label for="lot_rate">Начальная цена</label>
          <input id="lot_rate" type="number" name="lot_rate" placeholder="0" required>
          <span class="form__error">Введите начальную цену</span>
        </div>
        <div class="form__item form__item--small">
          <label for="lot_step">Шаг ставки</label>
          <input id="lot_step" type="number" name="lot_step" placeholder="0" required>
          <span class="form__error">Введите шаг ставки</span>
        </div>
        <div class="form__item">
          <label for="lot_date">Дата окончания торгов</label>
          <input class="form__input-date" id="lot_date" type="date" name="lot_date" required>
          <span class="form__error">Введите дату завершения торгов</span>
        </div>
      </div>
      <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
      <button type="submit" class="button">Добавить лот</button>
    </form>