<?php
    require_once 'models/exhibition.php';
    $id = $_GET['id'] ?? null;
    $exhibitonPosts = getExhibition($conn, $id);
    $exhibitonImages = getExhibitionImages($conn, $id);
?>

    <h2 class="mb0">EXHIBITIONS & PUBLISHED WORK</h2>


    <div class="container-fluid pt70 pb70">
        <div class=containerSlide>
            <a href="#" id="lA" class="arrowL">&lt;</a>
            <div id="slidesho">
                <div>
                    <img src="<?= $exhibitonPosts->image ?>" alt=""/>
                </div>
                <?php foreach ($exhibitonImages as $exhibitonImage): ?>
                    <div class="hidden1">
                        <img src="<?= $exhibitonImage->img_path ?>" alt=""/>
                    </div>
                <?php endforeach ?>
            </div>
            <a href="#" id="rA" class="arrowR">&gt;</a>
        </div>
    </div>
    <div id="fh5co-projects-feed" class="fh5co-projects-feed2 clearfix masonry">


    </div>
    <!--END .fh5co-projects-feed-->
    </div>
    <!-- END .container-fluid -->

<?php require_once 'components/footer.php';
			

