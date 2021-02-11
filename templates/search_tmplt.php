    <nav class="nav">
      <ul class="nav__list container">
        <?php foreach($categories as $category): ?>
          <li class="nav__item">
            <a href="all-lots.html"><?= $category['name_ru']; ?></a>
          </li>
        <?php endforeach; ?>
      </ul>
    </nav>
    <div class="container">
      <section class="lots">
        <h2>Результаты поиска по запросу «<span>Union</span>»</h2>
        <ul class="lots__list">
          <?php foreach($lots as $value): ?>
            <li class="lots__item lot">
              <div class="lot__image">
                <img src="<?= esc($value['img']); ?>" width="350" height="260" alt="<?= esc($value["name"]) ?>">
              </div>
              <div class="lot__info">
                <span class="lot__category"><?= esc($value["category"]) ?></span>
                <h3 class="lot__title"><a class="text-link" href="lot.php?id=<?= $value["id"] ?>"><?= esc($value["name"]) ?></a></h3>
                <div class="lot__state">
                  <div class="lot__rate">
                    <span class="lot__amount">Стартовая цена</span>
                    <span class="lot__cost"><?= my_number_format(esc($value["price"])); ?><b class="rub">р</b></span>
                  </div>
                  <div class="lot__timer timer">
                    <?= $value['remaining_time']; ?>
                  </div>
                </div>
              </div>
            </li>
          <?php endforeach; ?>
        </ul>
      </section>
      <ul class="pagination-list">
        <li class="pagination-item pagination-item-prev"><a>Назад</a></li>
        <li class="pagination-item pagination-item-active"><a>1</a></li>
        <li class="pagination-item"><a href="#">2</a></li>
        <li class="pagination-item"><a href="#">3</a></li>
        <li class="pagination-item"><a href="#">4</a></li>
        <li class="pagination-item pagination-item-next"><a href="#">Вперед</a></li>
      </ul>
    </div>