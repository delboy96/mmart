<?php
require_once 'models/gallery.php';
$galeryPosts = getGalleryPosts($conn)
    ?>
<div class="container-fluid pt70 pb70">
    <div id="fh5co-projects-feed" class="fh5co-projects-feed clearfix masonry">
        <div id="galleryCon" class="meta"><span>All the works exhibited in the gallery are available for purchasing unless it's written otherwise. <br/> <br/> If you see something you like, feel free to <a
                        href="index.php?page=contact">contact me</a>.</span><br/><br/>
            </ul>
        </div>
        <?php foreach ($galeryPosts as $galeryPost): ?>
            <div class="fh5co-project masonry-brick gallery">
                <a href="<?= $galeryPost->image ?>" data-caption="<?= $galeryPost->title ?>" data-fancybox="gallery"
                   class="fancybox" rel="ligthbox">
                    <img src="<?= $galeryPost->image ?>" alt="<?= $galeryPost->title ?>">
                    <h2><?= $galeryPost->title ?></h2>
                </a>
                <span><?= $galeryPost->subtitle ?></span>
                <!-- <br/><br/>
            <span><?= $galeryPost->body ?></span> -->
            </div>
        <?php endforeach ?>
        <!--END .fh5co-projects-feed-->
    </div>
    <!-- END .container-fluid -->

