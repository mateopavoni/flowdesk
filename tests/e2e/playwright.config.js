// @ts-check
const { defineConfig } = require( '@playwright/test' );

module.exports = defineConfig( {
	testDir: '.',
	use: {
		baseURL: process.env.FLOWDESK_URL || 'http://localhost:8080',
	},
	// ponytail: solo Chromium por default (WebKit/Firefox no pudieron
	// instalarse en el sandbox de la fábrica, sin permisos de sistema).
	// Para correr los 3 navegadores: `npx playwright test --project=chromium --project=webkit --project=firefox`
	// después de `npx playwright install`.
	projects: [ { name: 'chromium', use: { browserName: 'chromium' } } ],
} );
