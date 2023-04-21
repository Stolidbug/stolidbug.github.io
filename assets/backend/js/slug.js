window.addEventListener('DOMContentLoaded', function() {

  let controller;

  const title = document.querySelector('.input-slug-transform');
  const slug = document.querySelector('.output-slug-transform');

  if (slug) {
   const url = slug.dataset.url.replace('__data__', '');

    if (controller) {
      controller.abort();
    }

    title.addEventListener('keyup', function() {
      const name = this.value;

      controller = new AbortController();

      fetch(url + encodeURIComponent(name), { signal: controller.signal })
        .then(response => {
          if (response.ok) {
            return response.json();
          } else {
            throw new Error('Request failed. Returned status of ' + response.status);
          }
        })
        .then(data => {
          slug.value = data.slug;
        })
        .catch(error => {
          console.error(error);
        });
    });
  }
});
