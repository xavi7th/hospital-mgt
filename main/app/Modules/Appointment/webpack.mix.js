const mix = require('laravel-mix');

mix.webpackConfig({
	resolve: {
		extensions: ['.js', '.svelte', '.json'],
		alias: {
			'@appointment-pages': __dirname + '/Resources/js/Pages',
			'@appointment-shared': __dirname + '/Resources/js/Shared',
      '@appointment-assets': __dirname + '/Resources',
		},
	},
})
