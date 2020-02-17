/**
 * @return {string}
 */
function Project({ id, image, title, subtitle }) {
  return ` <div id="fh5co-projects-feed" class="fh5co-projects-feed2 clearfix masonry">
    <div class="fh5co-project1 masonry-brick">
            <a href="?page=project&id=${id}">
                <img src="${image}" alt="${subtitle}">
                <h2>${title}</h2>
            </a>
        </div>  
    </div>`;
}
