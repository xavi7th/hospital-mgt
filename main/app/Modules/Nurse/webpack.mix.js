const mix = require('laravel-mix');

mix.webpackConfig({
	resolve: {
		extensions: ['.js', '.svelte', '.json'],
		alias: {
			'@nurse-pages': __dirname + '/Resources/js/Pages',
			'@nurse-shared': __dirname + '/Resources/js/Shared',
      '@nurse-assets': __dirname + '/Resources',
		},
	},
})
