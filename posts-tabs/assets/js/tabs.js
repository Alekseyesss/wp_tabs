document.addEventListener("DOMContentLoaded", () => {
  const body = document.querySelector('body');

  //watching tabs click
  body.addEventListener('click', (event) => {
    const tab = event.target;
    if (tab.hasAttribute('data-ba-post-id')
      &&
      !tab.classList.contains('ba_tabs-active')) {

      let new_id = tab.getAttribute('data-ba-post-id'),
        tabs_wrapper = tab.closest('.ba_tabs_wrapper'),
        last_active = tabs_wrapper.querySelector('.ba_tabs-active'),
        last_id = last_active.getAttribute('data-ba-post-id');

      last_active.classList.remove('ba_tabs-active');
      tab.classList.add('ba_tabs-active');
      tabs_wrapper.querySelector(`[data-ba-post-id-content="${last_id}"]`).classList.add('ba_hide');
      tabs_wrapper.querySelector(`[data-ba-post-id-content="${new_id}"]`).classList.remove('ba_hide');
    }
  })
});