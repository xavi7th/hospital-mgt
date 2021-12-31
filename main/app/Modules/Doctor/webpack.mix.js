const mix = require('laravel-mix');

mix.webpackConfig({
	resolve: {
		extensions: ['.js', '.svelte', '.json'],
		alias: {
			'@doctor-pages': __dirname + '/Resources/js/Pages',
			'@doctor-shared': __dirname + '/Resources/js/Shared',
      '@doctor-assets': __dirname + '/Resources',
		},
	},
})
