<?php 
    $id = $_GET['id'] ? $_GET['id'] : null;
    // $comments = null;
    $exhibitonPosts = getExhibition($conn, $id);
    $exhibitonImages = getExhibitionImages($conn, $id);

    // $comments = getCommentsForPost($conn, $id);
    // $msg = $_SESSION['success'];
    
    // if (isset($_POST["commentBtn"])) {
    //     $body = $_POST["comment"];
    //     $userID = auth()->id; 
        
    //     try {
    //         addCommentToPost($conn, $userID, $id, $body);
    //         $_SESSION['success'] = 'You have successfully added a new comment';
    //     } catch(PDOException $e) {
    //         echo $e->getMessage();
    //     }
    // }
?>

<h2 class="mb0">EXHIBITIONS & PUBLISHED WORK</h2>
<!-- <div class="meta"><span>Further exhibitions...</span>  -->
</ul>
</div>

<div class="container-fluid pt70 pb70">
<div class=containerSlide>
		<a href="#" id="lA" class="arrowL">&lt;</a>
		<div id="slidesho">
			<div><img src="<?= $exhibitonPosts->image?>"/></div>
            <?php foreach ($exhibitonImages as $exhibitonImage):?>
			<div class="hidden1"><img src="<?=              $exhibitonImage->img_path?>"/></div>
            <?php endforeach ?>
		</div>
		<a href="#" id="rA" class="arrowR">&gt;</a>
</div></div>
    <div id="fh5co-projects-feed" class="fh5co-projects-feed2 clearfix masonry">
    
            
    </div>
    <!--END .fh5co-projects-feed-->
</div>
<!-- END .container-fluid -->



<!-- <div class=containerSlide>
		<a href="#" class="arrowL">&lt;</a>
		<div id="slidesho">
			<div><img src="images/radovi/cover.jpg"/></div>
			<div class="hidden1"><img src="images/radovi/ill.jpg"/></div>
			<div class="hidden1"><img src="images/radovi/preo.jpg"/></div>
			<div class="hidden1"><img src="images/radovi/sl.jpg"/></div>
		</div>
		<a href="#" id="rA" class="arrowR">&gt;</a>
</div></div> -->
<!-- //https://codepen.io/tym0/pen/KwrOKX

drugi:
https://codepen.io/ainalem/pen/rGvaaO
https://codepen.io/Reklino/pen/wawopV -->

<?php require_once 'components/footer.php';
			

