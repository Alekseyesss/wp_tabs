document.addEventListener("DOMContentLoaded", () => {

  let tabs_wrapper = document.querySelector('.tabs_wrapper'),
    tabs_content = document.querySelector('.tabs_content'),
    first_tab = document.querySelector('[data-post-id]'),
    ajaxurl = tabs_arr.adminUrl;

  first_tab = first_tab.getAttribute('data-post-id');
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
    if (event.target.hasAttribute('data-post-id')) {
      let post_id = event.target.getAttribute('data-post-id'),
        data = setFormData('post_id', post_id);
      insert_data(data)
    }
  })

  // creating the first display of the tabs
  insert_data(setFormData('post_id', first_tab));

});