/**
 * @return {string}
 */
function Exhibition({ id, image, title, subtitle, time, body }) {
  return `
   <div class="fh5co-project masonry-brick">
            <a href="?page=exhibition&id=${id}">
                <img src="${image}" alt="${subtitle}" />
                <h2>${title}</h2>
            </a>
            <p>${body}</p>
        </div>
  `;
}
