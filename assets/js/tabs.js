document.addEventListener("DOMContentLoaded", () => {

  let tabs_wrapper = document.querySelector('.ba_tabs_wrapper'),
    tabs_content = document.querySelector('.ba_tabs_content'),
    ajaxurl = tabs_arr.adminUrl;

  //set the data for the backend
  function setFormData(key, value) {
    formData = new FormData();
    formData.append('action', 'post-tabs');
    formData.append('security', tabs_arr.nonce);
    formData.append(key, value);
    return formData;
  };

  //send data to the backend. Response display on the frontend
  function insert_data(data) {
    fetch(ajaxurl, {
      method: 'POST',
      body: data,
    })
      .then((response) => response.text())
      .then((response) => {
        tabs_content.innerHTML = response;
      });
  }

  //watching tabs click
  tabs_wrapper.addEventListener('click', (event) => {
    if (event.target.hasAttribute('data-ba-post-id')) {
      let post_id = event.target.getAttribute('data-ba-post-id'),
        el = tabs_wrapper.querySelector('.ba_tabs-active'),
        data = setFormData('post_id', post_id);

      el.classList.remove('ba_tabs-active');
      event.target.classList.add('ba_tabs-active');
      insert_data(data)
    }
  })

});