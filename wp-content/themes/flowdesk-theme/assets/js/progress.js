( function () {
	'use strict';
	var bar = document.querySelector( '[data-fd-progress-bar]' );
	var article = document.querySelector( 'article' );
	if ( ! bar || ! article ) return;

	var ticking = false;
	function update() {
		var rect = article.getBoundingClientRect();
		var scrollable = rect.height - window.innerHeight;
		var scrolled = -rect.top;
		var pct = scrollable > 0 ? Math.min( 100, Math.max( 0, ( scrolled / scrollable ) * 100 ) ) : 0;
		bar.style.width = pct + '%';
		ticking = false;
	}
	function onScroll() {
		if ( ticking ) return;
		window.requestAnimationFrame( update );
		ticking = true;
	}
	window.addEventListener( 'scroll', onScroll, { passive: true } );
	window.addEventListener( 'resize', onScroll );
	update();
} )();
