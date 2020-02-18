<!-- </div> -->
<footer id="fh5co-footer" role="contentinfo">
    <div class="container-fluid1">
        <div class="footer-content">
            <div class="copyrightOld"><p>&copy; 2019 All Rights Milica Mišić <br>Designed by <a
                            href="https://www.linkedin.com/in/danilo-milo%C5%A1evi%C4%87/">Данило Милошевић</a></p>
            </div>
            <div class="social">
                <a href="https://www.facebook.com/milica.misic.923171"><i class="icon-facebook3"></i></a>
                <a href="https://www.facebook.com/milica.misic.923171"><i class="icon-instagram2"></i></a>
                <a href="https://rs.linkedin.com/in/milica-misic-28b29716a"><i class="icon-linkedin2"></i></a>
            </div>
        </div>
    </div>
</footer>
<!-- END #fh5co-footer -->

<!-- jQuery -->
<script src="js/jquery.min.js"></script>
<!-- Bootstrap -->
<!-- <script src="js/bootstrap.min.js"></script> -->
<!-- masonry -->
<script src="js/jquery.masonry.min.js"></script>
<!-- MAIN JS -->
<script src="js/main.js"></script>
<!-- js za newsfeed -->
<script src="js/jquery1.min.js"></script>
<script src="js/wow.min.js"></script>
<script src="js/bootstrap1.min.js"></script>
<script src="js/slick.min.js"></script>
<script src="js/jquery.li-scroller.1.0.js"></script>
<script src="js/jquery.newsTicker.min.js"></script>
<script src="js/jquery.fancybox.pack.js"></script>
<script src="js/custom.js"></script>
<script src="js/respond1.min.js"></script>

<?php
switch ($page) {
    case 'exhibitions':
        echo '<script src="js/components/Exhibition.js"></script>';
        echo '<script src="js/exhibitions.js"></script>';
        break;

    case 'projects':
        echo '<script src="js/components/Project.js"></script>';
        echo '<script src="js/projects.js"></script>';
        break;

    case 'exhibition':
        echo '<script src="js/components/ExhibitionSingle.js"></script>';
        echo '<script src="js/exhibition.js"></script>';
        break;

    case 'project':
        echo '<script src="js/components/ProjectSingle.js"></script>';
        echo '<script src="js/project.js"></script>';
        break;

    case 'login':
        echo '<script src="js/loginReg.js"></script>';
        break;
}
?>
</body>
</html>