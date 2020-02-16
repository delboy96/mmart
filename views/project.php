<?php 
    $id = $_GET['id'] ? $_GET['id'] : null;
    $projectPost = getProject($conn, $id);
?>
<div class="container-fluid pt70 pb70">
   
    <div id="fh5co-projects-feed" class="fh5co-projects-feed2 clearfix masonry">
        <div class="fh5co-project1 masonry-brick gallery">
            <a href="<?= $projectPost->image?>" data-caption="<?= $projectPost->title?>" data-fancybox="gallery" class="fancybox" rel="ligthbox">
                <img src="<?= $projectPost->image?>" alt="<?= $projectPost->subtitle?>">
                <h2><?= $projectPost->title?></h2>
            </a>
            <!-- <span> January 14, 2020 </span> -->
            <!-- <p>Description...</p> -->
        </div>  
    </div>
</div>
</div>

<?php require_once 'components/footer.php';