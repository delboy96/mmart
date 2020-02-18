<?php

require_once 'models/project.php';

$id = $_GET['id'] ? $_GET['id'] : null;
$projectPost = getProject($conn, $id);
?>
    <div id="projectsContainer" class="container-fluid pt70 pb70">

    </div>

<?php require_once 'components/footer.php';