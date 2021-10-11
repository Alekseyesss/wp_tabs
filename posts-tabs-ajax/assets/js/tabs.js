document.addEventListener("DOMContentLoaded", () => {

  let body = document.querySelector('body'),
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
  function insert_data(data, content) {
    fetch(ajaxurl, {
      method: 'POST',
      body: data,
    })
      .then((response) => response.json())
      .then((response) => {
        content.innerHTML = response.data;
      });
  }

  //watching tabs click
  body.addEventListener('click', (event) => {
    const tab = event.target;
    if (tab.hasAttribute('data-ba-post-id')) {
      let post_id = tab.getAttribute('data-ba-post-id'),
        tabs_wrapper = tab.closest('.ba_tabs_wrapper'),
        last_active = tabs_wrapper.querySelector('.ba_tabs-active'),
        data = setFormData('post_id', post_id),
        content = tabs_wrapper.querySelector('.ba_tabs_content');

      last_active.classList.remove('ba_tabs-active');
      tab.classList.add('ba_tabs-active');
      insert_data(data, content);
    }
  })

});