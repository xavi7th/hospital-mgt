const mix = require( 'laravel-mix' );

mix.webpackConfig({
	resolve: {
		extensions: ['.js', '.svelte', '.json'],
		alias: {
			'@miscellaneous-pages': __dirname + '/Resources/js/Pages',
			'@miscellaneous-shared': __dirname + '/Resources/js/Shared',
			'@miscellaneous-components': __dirname + '/Resources/js/Components',
      '@miscellaneous-assets': __dirname + '/Resources',
		},
	},
})
