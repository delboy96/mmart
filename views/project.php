<?php 
    $id = $_GET['id'] ? $_GET['id'] : null;
    $projectPost = getProject($conn, $id);
?>
<div id="projectsContainer" class="container-fluid pt70 pb70">
   
    
</div>
</div>

<?php require_once 'components/footer.php';