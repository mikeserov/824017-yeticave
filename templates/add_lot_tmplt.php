    <nav class="nav">
      <ul class="nav__list container">
        <?php foreach($categories as $value): ?>
          <li class="nav__item">
            <a href="all-lots.html"><?= $value['name_ru']; ?></a>
          </li>
        <?php endforeach; ?>
      </ul>
    </nav>

    <form class="form form--add-lot container <?= isset($errors) ? 'form--invalid' : ''; ?>" action="add.php" method="post" enctype="multipart/form-data"> <!-- form--invalid -->
      <h2>Добавление лота</h2>
      <div class="form__container-two">
        <?php $classname = isset($errors['lot_name']) ? 'form__item--invalid' : ''; ?>
        <div class="form__item <?= $classname; ?>"> <!-- form__item--invalid -->
          <label for="lot_name">Наименование</label>
          <input id="lot_name" type="text" name="lot_name" placeholder="Введите наименование лота" value="<?= isset($new_lot['lot_name']) ? $new_lot['lot_name'] : ''; ?>" <?= $required; ?>>
          <span class="form__error"><?= isset($errors['lot_name']) ? $errors['lot_name'] : ''; ?></span>
        </div>
        <?php $classname = isset($errors['category']) ? 'form__item--invalid' : ''; ?>
        <div class="form__item <?= $classname; ?>">
          <label for="category">Категория</label>
          <select id="category" name="category" <?= $required; ?>>
            <option disabled <?= isset($new_lot['category']) ? '' : 'selected' ?>>Выберите категорию</option>
            <?php foreach($categories as $cat): ?>
              <option value="<?= $cat['id']; ?>" <?php if ($cat['id'] == getPostVal('category')): ?>selected<?php endif; ?>><?= $cat['name_ru']; ?></option>
            <?php endforeach; ?>
          </select>
          <span class="form__error"><?= isset($errors['category']) ? $errors['category'] : ''; ?></span>
        </div>
      </div>
      <?php $classname = isset($errors['description']) ? 'form__item--invalid' : ''; ?>
      <div class="form__item form__item--wide <?= $classname; ?>">
        <label for="description">Описание</label>
        <textarea id="description" name="description" placeholder="Напишите описание лота" <?= $required; ?>><?= isset($new_lot['description']) ? $new_lot['description'] : ''; ?></textarea>
        <span class="form__error"><?= isset($errors['description']) ? $errors['description'] : ''; ?></span>
      </div>
      <div class="form__item form__item--file"> <!-- form__item--uploaded -->
        <label>Изображение</label>
        <div class="preview">
          <button class="preview__remove" type="button">x</button>
          <div class="preview__img">
            <img src="img/avatar.jpg" width="113" height="113" alt="Изображение лота">
          </div>
        </div>
        <?php $classname = isset($errors['lot_img']) ? 'form__item--invalid' : ''; ?>
        <div class="form__input-file <?= $classname; ?>">
          <input class="visually-hidden" name = "lot_img" type="file" id="photo2" value="">
          <label for="photo2">
            <span><?= isset($errors['lot_img']) ? $errors['lot_img'] . '<br>' : '';?>+ Добавить</span>
          </label>
        </div>
      </div>
      <div class="form__container-three">
        <?php $classname = isset($errors['lot_rate']) ? 'form__item--invalid' : ''; ?>
        <div class="form__item form__item--small <?= $classname; ?>">
          <label for="lot_rate">Начальная цена</label>
          <input id="lot_rate" type="number" name="lot_rate" placeholder="0" value="<?= isset($new_lot['lot_rate']) ? $new_lot['lot_rate'] : ''; ?>" <?= $required; ?>>
          <span class="form__error"><?= isset($errors['lot_rate']) ? $errors['lot_rate'] : ''; ?></span>
        </div>
        <?php $classname = isset($errors['lot_step']) ? 'form__item--invalid' : ''; ?>
        <div class="form__item form__item--small <?= $classname; ?>">
          <label for="lot_step">Шаг ставки</label>
          <input id="lot_step" type="number" name="lot_step" placeholder="0" value="<?= isset($new_lot['lot_step']) ? $new_lot['lot_step'] : ''; ?>" <?= $required; ?>>
          <span class="form__error"><?= isset($errors['lot_step']) ? $errors['lot_step'] : ''; ?></span>
        </div>
        <?php $classname = isset($errors['lot_date']) ? 'form__item--invalid' : ''; ?>
        <div class="form__item <?= $classname; ?>">
          <label for="lot_date">Дата окончания торгов</label>
          <input class="form__input-date" id="lot_date" type="date" name="lot_date" value="<?= isset($new_lot['lot_date']) ? $new_lot['lot_date'] : ''; ?>" <?= $required; ?>>
          <span class="form__error"><?= isset($errors['lot_date']) ? $errors['lot_date'] : ''; ?></span>
        </div>
      </div>
      <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
      <button type="submit" class="button">Добавить лот</button>
    </form>