<?php
require_once 'models/project.php';

$projectsPosts = getProjects($conn);
?>

    <h2 class="mb0">PROJECTS</h2>
    <div class="meta"><span>In this sections you can read more about my projects, inspirations and painting tehniques that I explore </span>
        </ul>
    </div>

    <div id="projectsContainer" class="container-fluid pt70 pb70">

    </div>

<?php require_once 'components/footer.php';
			




