var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
	var defaults = {
    color             : '#4b7bc7',
    secondaryColor    : '#fff',
  	jackColor         : '#fff',
  	size              : 'small'
};
elems.forEach(function(html) {
  var switchery = new Switchery(html, defaults);
});
