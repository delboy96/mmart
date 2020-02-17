/**
 * @return {string}
 */
function ExhibitionSingle({ id, image, title, subtitle, time, body }) {
  return `
     <div class="fh5co-project1 masonry-brick gallery">
              <a href="?page=exhibition&id=${image}"
              data-caption="${title}" data-fancybox="gallery" class="fancybox" rel="ligthbox">
                  <h2>${title}</h2>
              </a>
              <p>${body}</p>
          </div>
    `;
}
