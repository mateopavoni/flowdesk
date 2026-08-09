// @ts-check
const { test, expect } = require( '@playwright/test' );
const AxeBuilder = require( '@axe-core/playwright' ).default;

test.describe( 'Home', () => {
	test( 'landing renderiza pricing, testimonios y meta SEO', async ( { page } ) => {
		await page.goto( '/' );
		await expect( page.locator( '#pricing .rounded-2xl' ) ).toHaveCount( 3 );
		await expect( page.locator( '[data-fd-carousel]' ) ).toBeVisible();
		await expect( page.locator( 'meta[property="og:title"]' ) ).toHaveCount( 1 );
		await expect( page.locator( 'script[type="application/ld+json"]' ) ).toHaveCount( 1 );
	} );

	test( 'nav mobile: el toggle abre y cierra el menú', async ( { page } ) => {
		await page.setViewportSize( { width: 375, height: 800 } );
		await page.goto( '/' );
		const menu = page.locator( '#fd-nav-menu' );
		await expect( menu ).toBeHidden();
		await page.locator( '#fd-nav-toggle' ).click();
		await expect( menu ).toBeVisible();
	} );

	test( 'video demo: el facade carga el iframe recién al hacer click', async ( { page } ) => {
		await page.goto( '/' );
		await expect( page.locator( '#video iframe' ) ).toHaveCount( 0 );
		await page.locator( '[data-fd-video-facade]' ).click();
		await expect( page.locator( '#video iframe' ) ).toHaveCount( 1 );
	} );

	test( 'carrusel de testimonios: el botón "siguiente" scrollea el track', async ( { page } ) => {
		await page.goto( '/' );
		const track = page.locator( '[data-fd-carousel-track]' );
		const before = await track.evaluate( ( el ) => el.scrollLeft );
		await page.locator( '[data-fd-carousel-next]' ).click();
		await expect.poll( () => track.evaluate( ( el ) => el.scrollLeft ) ).toBeGreaterThan( before );
	} );

	test( 'accesibilidad (axe): sin violaciones', async ( { page } ) => {
		await page.goto( '/' );
		const results = await new AxeBuilder( { page } ).analyze();
		expect( results.violations ).toEqual( [] );
	} );
} );

test.describe( 'Blog', () => {
	test( 'índice: grid de posts + filtro de categorías', async ( { page } ) => {
		await page.goto( '/blog/' );
		await expect( page.locator( 'article' ) ).toHaveCount( 8 );
		const filterNav = page.getByRole( 'navigation', { name: 'Filtrar por categoría' } );
		await expect( filterNav.getByRole( 'link', { name: 'Productividad', exact: true } ) ).toBeVisible();
	} );

	test( 'post individual: sidebar de relacionados + form de comentarios', async ( { page, request } ) => {
		const posts = await ( await request.get( '/wp-json/wp/v2/posts?per_page=1' ) ).json();
		await page.goto( new URL( posts[ 0 ].link ).pathname );
		await expect( page.getByRole( 'heading', { name: 'Relacionados' } ) ).toBeVisible();
		await expect( page.getByRole( 'heading', { name: 'Dejá tu comentario' } ) ).toBeVisible();
	} );

	test( 'accesibilidad (axe) en el blog: sin violaciones', async ( { page } ) => {
		await page.goto( '/blog/' );
		const results = await new AxeBuilder( { page } ).analyze();
		expect( results.violations ).toEqual( [] );
	} );
} );

test.describe( 'Newsletter (REST)', () => {
	async function getNonce( page ) {
		await page.goto( '/' );
		return page.locator( '.fd-newsletter-form input[name="fd_newsletter_nonce"]' ).first().inputValue();
	}

	test( 'suscripción válida devuelve 201, duplicada 409, inválida 400', async ( { page, request } ) => {
		const nonce = await getNonce( page );
		const email = `e2e-${ Date.now() }@example.com`;

		const ok = await request.post( '/wp-json/flowdesk/v1/newsletter', {
			data: { email, nonce, company_website: '' },
		} );
		expect( ok.status() ).toBe( 201 );

		const dup = await request.post( '/wp-json/flowdesk/v1/newsletter', {
			data: { email, nonce, company_website: '' },
		} );
		expect( dup.status() ).toBe( 409 );

		const bad = await request.post( '/wp-json/flowdesk/v1/newsletter', {
			data: { email: 'no-es-un-email', nonce, company_website: '' },
		} );
		expect( bad.status() ).toBe( 400 );
	} );

	test( 'honeypot lleno responde éxito falso sin crear el suscriptor', async ( { page, request } ) => {
		const nonce = await getNonce( page );
		const res = await request.post( '/wp-json/flowdesk/v1/newsletter', {
			data: { email: `bot-${ Date.now() }@example.com`, nonce, company_website: 'relleno-de-bot' },
		} );
		expect( res.status() ).toBe( 201 );
	} );
} );
