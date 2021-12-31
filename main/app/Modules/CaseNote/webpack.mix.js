const mix = require('laravel-mix');

mix.webpackConfig({
	resolve: {
		extensions: ['.js', '.svelte', '.json'],
		alias: {
			'@case-note-pages': __dirname + '/Resources/js/Pages',
			'@case-note-shared': __dirname + '/Resources/js/Shared',
      '@case-note-assets': __dirname + '/Resources',
		},
	},
})
