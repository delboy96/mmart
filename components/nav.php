<?php $menus = getMenus($conn); ?>

<?php if ($page != ''): ?>
    <nav id="fh5co-header" role="banner">
        <div id="navMeni" class="container text-center">
            <div id="fh5co-logo">
                <!-- <a href="index.php"><img src="images/milica misic logo.png" alt="milica misic logo"></a> -->
                <h3 id="logotekst" class=""><a href="index.php"> Milica Mišić </a></h3>
                <p> Church Artist - Icon Painter </p>
            </div>
            <nav>
                <ul>
                    <?php foreach ($menus as $menu) : ?>
                        <li><a href="?page=<?= strtolower($menu->name) ?>"><?= $menu->fullName ?></a></li>
                    <?php endforeach; ?>

                    <?php if (!userLoggedIn()): ?>
                        <li><a href="?page=login"> Login & Register </a></li>
                    <?php else : ?>
                        <li><a href="php/logout.php"> Logout </a></li>
                    <?php endif ?>
                </ul>
            </nav>
        </div>
    </nav>
<?php endif ?>