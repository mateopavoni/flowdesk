/**
 * FlowDesk — JS mínimo, sin dependencias: toggle de nav mobile, submit de
 * newsletter/contacto contra el REST endpoint del plugin, y controles del
 * carrusel de testimonios (que es CSS scroll-snap, esto solo mueve el scroll).
 */
( function () {
	'use strict';

	// --- Nav mobile toggle -------------------------------------------------
	var toggle = document.getElementById( 'fd-nav-toggle' );
	var menu = document.getElementById( 'fd-nav-menu' );
	if ( toggle && menu ) {
		toggle.addEventListener( 'click', function () {
			var isOpen = menu.classList.toggle( 'hidden' ) === false;
			toggle.setAttribute( 'aria-expanded', isOpen ? 'true' : 'false' );
		} );
	}

	// --- Newsletter forms (puede haber más de una en la página: home + footer) --
	document.querySelectorAll( '.fd-newsletter-form' ).forEach( function ( newsletterForm ) {
		newsletterForm.addEventListener( 'submit', function ( e ) {
			e.preventDefault();
			var status = newsletterForm.parentElement.querySelector( '.fd-newsletter-status' );
			var email = newsletterForm.email.value.trim();
			var nonce = newsletterForm.fd_newsletter_nonce.value;
			var honeypot = newsletterForm.company_website.value;

			if ( status ) status.textContent = '';
			fetch( ( window.flowdeskData && window.flowdeskData.restUrl ) + 'flowdesk/v1/newsletter', {
				method: 'POST',
				headers: { 'Content-Type': 'application/json' },
				body: JSON.stringify( { email: email, nonce: nonce, company_website: honeypot } ),
			} )
				.then( function ( res ) {
					return res.json().then( function ( data ) {
						return { ok: res.ok, data: data };
					} );
				} )
				.then( function ( result ) {
					if ( ! status ) return;
					if ( result.ok ) {
						status.textContent = result.data.message || 'Listo, ya estás suscripto.';
						status.classList.remove( 'text-red-200' );
						newsletterForm.reset();
					} else {
						status.textContent = result.data.message || 'No se pudo suscribir, probá de nuevo.';
						status.classList.add( 'text-red-200' );
					}
				} )
				.catch( function () {
					if ( status ) {
						status.textContent = 'Error de red, probá de nuevo.';
						status.classList.add( 'text-red-200' );
					}
				} );
		} );
	} );

	// --- Contact form ----------------------------------------------------
	var contactForm = document.getElementById( 'fd-contact-form' );
	if ( contactForm ) {
		contactForm.addEventListener( 'submit', function ( e ) {
			e.preventDefault();
			var status = document.getElementById( 'fd-contact-status' );
			var submitBtn = contactForm.querySelector( 'button[type="submit"]' );
			submitBtn.disabled = true;

			var formData = new FormData( contactForm );
			fetch( ( window.flowdeskData && window.flowdeskData.ajaxUrl ) || '/wp-admin/admin-post.php', {
				method: 'POST',
				body: formData,
				headers: { 'X-Requested-With': 'XMLHttpRequest' },
			} )
				.then( function ( res ) {
					return res.json().then( function ( data ) {
						return { ok: res.ok, data: data };
					} );
				} )
				.then( function ( result ) {
					status.textContent = result.data.message;
					status.classList.toggle( 'text-red-600', ! result.ok );
					status.classList.toggle( 'text-green-700', result.ok );
					if ( result.ok ) {
						contactForm.reset();
					}
				} )
				.catch( function () {
					status.textContent = 'Error de red, probá de nuevo.';
					status.classList.add( 'text-red-600' );
				} )
				.finally( function () {
					submitBtn.disabled = false;
				} );
		} );
	}

	// --- Video demo: facade lazy, carga el iframe recién al interactuar -----
	document.querySelectorAll( '[data-fd-video-facade]' ).forEach( function ( facade ) {
		var play = function () {
			var videoId = facade.getAttribute( 'data-video-id' );
			var iframe = document.createElement( 'iframe' );
			iframe.src = 'https://www.youtube-nocookie.com/embed/' + encodeURIComponent( videoId ) + '?autoplay=1';
			iframe.title = 'FlowDesk demo';
			iframe.className = 'w-full h-full';
			iframe.setAttribute( 'allow', 'accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture' );
			iframe.setAttribute( 'allowfullscreen', '' );
			facade.replaceWith( iframe );
		};
		facade.addEventListener( 'click', play );
		facade.addEventListener( 'keydown', function ( e ) {
			if ( e.key === 'Enter' || e.key === ' ' ) {
				e.preventDefault();
				play();
			}
		} );
	} );

	// --- Carrusel de testimonios (scroll-snap + botones) --------------------
	document.querySelectorAll( '[data-fd-carousel]' ).forEach( function ( carousel ) {
		var track = carousel.querySelector( '[data-fd-carousel-track]' );
		var prev = carousel.querySelector( '[data-fd-carousel-prev]' );
		var next = carousel.querySelector( '[data-fd-carousel-next]' );
		if ( ! track ) {
			return;
		}
		var scrollByCard = function ( dir ) {
			var card = track.querySelector( '[data-fd-carousel-item]' );
			var amount = card ? card.getBoundingClientRect().width + 24 : 320;
			track.scrollBy( { left: dir * amount, behavior: 'smooth' } );
		};
		if ( prev ) prev.addEventListener( 'click', function () { scrollByCard( -1 ); } );
		if ( next ) next.addEventListener( 'click', function () { scrollByCard( 1 ); } );
	} );
} )();
