const mix = require( 'laravel-mix' );

mix.webpackConfig({
	resolve: {
		extensions: ['.js', '.svelte', '.json'],
		alias: {
			'@userauth-pages': __dirname + '/Resources/js/Pages',
			'@userauth-phared': __dirname + '/Resources/js/Shared',
      '@userauth-pssets': __dirname + '/Resources',
		},
	},
});
