        <nav class="nav">
            <ul class="nav__list container">
                <?php foreach ($categories as $category): ?>
                    <li class="nav__item">
                        <a href="all_lots.php?category=<?= $category['name_ru']; ?>"><?= $category['name_ru']; ?></a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </nav>
        <section class="lot-item container">
            <h2><?= $error_number; ?></h2>
            <p><?= $error_message; ?></p>
        </section>