var container = document.querySelector('#rpfec_container');
var msnry = new Masonry( container, {
  // options
  isFitWidth : false,
  itemSelector: '.rpfec_box'
});
msnry.reloadItems();