    <main>
        <nav class="nav">
            <ul class="nav__list container">
                <?php foreach($categories as $value): ?>
                    <li class="nav__item">
                        <a href="all-lots.html"><?= $value['name_ru']; ?></a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </nav>
        <section class="lot-item container">
            <h2><?= $error_number; ?></h2>
            <p><?= $error_message; ?></p>
        </section>
    </main>