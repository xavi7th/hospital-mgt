const mix = require('laravel-mix');

mix.webpackConfig({
	resolve: {
		extensions: ['.js', '.svelte', '.json'],
		alias: {
			'@patient-pages': __dirname + '/Resources/js/Pages',
			'@patient-shared': __dirname + '/Resources/js/Shared',
      '@patient-assets': __dirname + '/Resources',
		},
	},
})
