<?php
namespace App\Modules\Miscellaneous\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ForexChartsTableSeeder extends Seeder
{

  /**
  * Auto generated seed file
  *
  * @return void
  */
  public function run()
  {
    DB::table('forex_charts')->delete();

    DB::table('forex_charts')->insert(array (
      0 =>
      array (
        'chart_slug' => 'price_comparison',
        'chart_name' => 'Price Comparison',
        'chart_content' => '<!-- TradingView Widget BEGIN --><div class="tradingview-widget-container"><div class="tradingview-widget-container__widget"></div><script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-forex-cross-rates.js" async>{"width": "100%","height": "400","theme": "dark","currencies": [	"EUR",	"USD",	"JPY",	"GBP",	"CAD",	"AUD"],"locale": "en"}</script></div><!-- TradingView Widget END -->',
        'created_at' => '2020-04-28 16:22:11',
        'updated_at' => '2020-04-28 16:22:11',
      ),
      1 =>
      array (
        'chart_slug' => 'tokens_chart1',
        'chart_name' => 'Tokens Chart1',
        'chart_content' => '<!-- TradingView Widget BEGIN --><div class="tradingview-widget-container"><div class="tradingview-widget-container__widget"></div><script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-market-quotes.js" async>{"width": "100%","height": "700","symbolsGroups": [{"originalName": "Indices","symbols": [{"name": "INDEX:DOWI","displayName": "Dow 30"},{"name": "INDEX:NKY","displayName": "Nikkei 225"},{	"name": "INDEX:DAX",	"displayName": "DAX Index"},{	"name": "OANDA:UK100GBP",	"displayName": "FTSE 100"}],"name": "Indices"},{"originalName": "Commodities","symbols": [{	"name": "CME:E61!",	"displayName": "Euro"},{	"name": "COMEX:GC1!",	"displayName": "Gold"},{	"name": "NYMEX:CL1!",	"displayName": "Crude Oil"},{	"name": "NYMEX:NG1!",	"displayName": "Natural Gas"},{	"name": "CBOT:ZC1!",	"displayName": "Corn"}],"name": "Commodities"},{"originalName": "Forex","symbols": [	{		"name": "FX:EURUSD"	},	{		"name": "FX:GBPUSD"	},	{		"name": "FX:USDJPY"	},	{	"name": "FX:USDCHF"	},	{		"name": "FX:AUDUSD"	},	{		"name": "FX:USDCAD"	}],"name": "Forex"}],"locale": "en"}</script></div><!-- TradingView Widget END -->',
        'created_at' => '2020-04-28 16:25:34',
        'updated_at' => '2020-04-28 16:25:34',
      ),
      2 =>
      array (
        'chart_slug' => 'forex_rates_chart',
        'chart_name' => 'Forex Rates Chart',
        'chart_content' => '<!-- TradingView Widget BEGIN --> <div class="tradingview-widget-container"> <div id="forex_rates_chart"></div> <script type="text/javascript" src="https://s3.tradingview.com/tv.js"></script> <script type="text/javascript"> new TradingView.widget( { "width": "100%", "height": 500, "symbol": "FX:EURUSD", "interval": "1", "timezone": "Etc/UTC", "theme": "Dark", "style": "1", "locale": "en", "toolbar_bg": "#f1f3f6", "enable_publishing": false, "hide_top_toolbar": true, "allow_symbol_change": true, "container_id": "forex_rates_chart" } ); </script> </div> <!-- TradingView Widget END -->',
        'created_at' => '2020-04-28 16:29:18',
        'updated_at' => '2020-04-28 16:29:18',
      ),
      3 =>
      array (
        'chart_slug' => 'eurusd_analysis',
        'chart_name' => 'EURUSD Analysis',
        'chart_content' => '<!-- TradingView Widget BEGIN --> <div class="tradingview-widget-container"> <div class="tradingview-widget-container__widget"></div> <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-technical-analysis.js" async> { "showIntervalTabs": true, "width": "100%", "colorTheme": "light", "isTransparent": true, "locale": "en", "symbol": "FX:EURUSD", "interval": "1m", "height": "450" } </script> </div> <!-- TradingView Widget END -->',
        'created_at' => '2020-04-28 16:31:18',
        'updated_at' => '2020-04-28 16:31:18',
      ),
      4 =>
      array (
        'chart_slug' => 'eurusd_single_ticker',
        'chart_name' => 'EURUSD Single Ticker',
        'chart_content' => ' <!-- TradingView Widget BEGIN --> <div class="tradingview-widget-container"> <div class="tradingview-widget-container__widget"></div> <div class="tradingview-widget-copyright"></div> <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-single-quote.js" async> { "symbol": "FX:EURUSD", "width": "100%", "colorTheme": "light", "isTransparent": false, "locale": "en" } </script> </div> <div class="tradingview-widget-container"> <div class="tradingview-widget-container__widget"></div> <div class="tradingview-widget-copyright"></div> <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-single-quote.js" async> { "symbol": "TVC:GOLD", "width": "100%", "colorTheme": "light", "isTransparent": false, "locale": "en" } </script> </div> <!-- TradingView Widget END -->',
        'created_at' => '2020-04-28 16:32:17',
        'updated_at' => '2020-04-28 16:32:17',
      ),
      5 =>
      array (
        'chart_slug' => 'btcusd_single_ticker',
        'chart_name' => 'BTCUSD Single Ticker',
        'chart_content' => '<!-- TradingView Widget BEGIN --> <div class="tradingview-widget-container"> <div class="tradingview-widget-container__widget"></div> <div class="tradingview-widget-copyright" style="display:none"></div> <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-single-quote.js" async> { "symbol": "COINBASE:BTCUSD", "width": "100%", "colorTheme": "light", "isTransparent": false, "locale": "en" } </script> </div> <!-- TradingView Widget END -->',
        'created_at' => '2020-04-28 16:33:08',
        'updated_at' => '2020-04-28 16:33:08',
      ),
      6 =>
      array (
        'chart_slug' => 'ticker_bar',
        'chart_name' => 'Ticker Bar',
        'chart_content' => '<!-- TradingView Widget BEGIN --> <div class="tradingview-widget-container"> <div class="tradingview-widget-container__widget"></div> <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-ticker-tape.js" async> { "symbols": [ { "title": "S&P 500", "proName": "INDEX:SPX" }, { "title": "EUR/USD", "proName": "FX_IDC:EURUSD" }, { "title": "BTC/USD", "proName": "BITFINEX:BTCUSD" } ], "colorTheme": "light", "isTransparent": false, "displayMode": "adaptive", "locale": "en" } </script> </div> <!-- TradingView Widget END -->',
        'created_at' => '2020-04-28 16:33:39',
        'updated_at' => '2020-04-28 16:33:39',
      ),
      7 =>
      array (
        'chart_slug' => 'eurusd',
        'chart_name' => 'FX:EURUSD',
        'chart_content' => '<!-- TradingView Widget BEGIN --> <div class=\'tradingview-widget-container\'> <div id=\'analytics-platform\'></div> <script type=\'text/javascript\' src=\'https://s3.tradingview.com/tv.js\'></script> <script type=\'text/javascript\'> new TradingView.widget({ container_id: \'analytics-platform\', width: \'100%\', height: 610, symbol: \'FX:EURUSD\', interval: \'1\', timezone: \'exchange\', theme: \'Dark\', style: \'0\', toolbar_bg: \'#f1f3f6\', withdateranges: true, allow_symbol_change: true, save_image: false, details: true, hotlist: true, calendar: true, news: [\'headlines\'], locale: \'en\', }) </script> </div> <!-- TradingView Widget END -->',
          'created_at' => '2020-04-28 17:05:31',
          'updated_at' => '2020-04-28 17:05:31',
        ),
      8 =>
      array (
        'chart_slug' => 'gbpusd_tech_analysis',
        'chart_name' => 'GBPUSD Tech Analysis',
        'chart_content' => '<!-- TradingView Widget BEGIN --> <div class="tradingview-widget-container"> <div class="tradingview-widget-container__widget"></div> <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-technical-analysis.js" async> { "showIntervalTabs": true, "width": "100%", "colorTheme": "light", "isTransparent": true, "locale": "en", "symbol": "FX:GBPUSD", "interval": "1m", "height": 450 } </script> </div> <!-- TradingView Widget END -->',
        'created_at' => '2020-04-28 17:15:28',
        'updated_at' => '2020-04-28 17:15:28',
      ),
      9 =>
      array (
        'chart_slug' => 'usdjpy_full_charts',
        'chart_name' => 'USDJPY Full Charts',
        'chart_content' => '<!-- TradingView Widget BEGIN --> <div class=\'tradingview-widget-container\'> <div id=\'technical-analysis3\'></div> <div class=\'tradingview-widget-copyright\'> </div> <script type=\'text/javascript\' src=\'https://s3.tradingview.com/tv.js\'></script> <script type=\'text/javascript\'> new TradingView.widget({ container_id: \'technical-analysis3\', width: \'100%\', height: 610, symbol: \'USDJPY\', interval: \'D\', timezone: \'exchange\', theme: \'Light\', style: \'1\', toolbar_bg: \'#f1f3f6\', withdateranges: true, hide_side_toolbar: false, allow_symbol_change: true, save_image: false, studies: [\'ROC@tv-basicstudies\', \'StochasticRSI@tv-basicstudies\', \'MASimple@tv-basicstudies\'], show_popup_button: true, popup_width: \'1000\', popup_height: \'650\', locale: \'en\', }) </script> </div> <!-- TradingView Widget END -->',
        'created_at' => '2020-04-28 17:16:28',
        'updated_at' => '2020-04-28 17:16:28',
      ),
      10 =>
      array (
        'chart_slug' => 'usdjpy',
        'chart_name' => 'FX:USDJPY',
        'chart_content' => ' <!-- TradingView Widget BEGIN --> <div class=\'tradingview-widget-container\'> <div id=\'analytics-platform4\'></div> <script type=\'text/javascript\' src=\'https://s3.tradingview.com/tv.js\'></script> <script type=\'text/javascript\'> new TradingView.widget({ container_id: \'analytics-platform4\', width: \'100%\', height: 610, symbol: \'FX:USDJPY\', interval: \'D\', timezone: \'exchange\', theme: \'Light\', style: \'0\', toolbar_bg: \'#f1f3f6\', withdateranges: true, allow_symbol_change: true, save_image: false, details: true, hotlist: true, calendar: true, news: [\'headlines\'], locale: \'en\', }) </script> </div> <!-- TradingView Widget END -->',
          'created_at' => '2020-04-28 17:36:38',
          'updated_at' => '2020-04-28 17:36:38',
        ),
      11 =>
      array (
        'chart_slug' => 'indices',
        'chart_name' => 'Indices',
        'chart_content' => '<!-- TradingView Widget BEGIN --> <div class=\'tradingview-widget-container\'> <div class=\'tradingview-widget-container__widget\'></div> <script type=\'text/javascript\' src=\'https://s3.tradingview.com/external-embedding/embed-widget-market-quotes.js\' async> { \'width\': \'100%\', \'height\': \'500\', \'symbolsGroups\': [ { \'originalName\': \'Indices\', \'symbols\': [ { \'name\': \'INDEX:DOWI\', \'displayName\': \'Dow 30\' }, { \'name\': \'INDEX:NKY\', \'displayName\': \'Nikkei 225\' }, { \'name\': \'INDEX:DAX\', \'displayName\': \'DAX Index\' }, { \'name\': \'OANDA:UK100GBP\', \'displayName\': \'FTSE 100\' } ], \'name\': \'Indices\' }, { \'originalName\': \'Commodities\', \'symbols\': [ { \'name\': \'CME:E61!\', \'displayName\': \'Euro\' }, { \'name\': \'COMEX:GC1!\', \'displayName\': \'Gold\' }, { \'name\': \'NYMEX:CL1!\', \'displayName\': \'Crude Oil\' }, { \'name\': \'NYMEX:NG1!\', \'displayName\': \'Natural Gas\' }, { \'name\': \'CBOT:ZC1!\', \'displayName\': \'Corn\' } ], \'name\': \'Commodities\' }, { \'originalName\': \'Forex\', \'symbols\': [ { \'name\': \'FX:EURUSD\' }, { \'name\': \'FX:GBPUSD\' }, { \'name\': \'FX:USDJPY\' }, { \'name\': \'FX:USDCHF\' }, { \'name\': \'FX:AUDUSD\' }, { \'name\': \'FX:USDCAD\' } ], \'name\': \'Forex\' } ], \'locale\': \'en\' } </script> </div> <!-- TradingView Widget END -->',
        'created_at' => '2020-04-28 17:37:23',
        'updated_at' => '2020-04-28 17:37:23',
      ),
      12 =>
      array (
        'chart_slug' => 'ticker_bar2',
        'chart_name' => 'Ticker Bar',
        'chart_content' => '
          <!-- TradingView Widget BEGIN -->
          <div class="tradingview-widget-container">
            <div class="tradingview-widget-container__widget"></div>
            <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-ticker-tape.js" async>
              {
                "symbols": [
                  {"title": "S&P 500","proName": "INDEX:SPX"},
                  {"title": "EUR/USD","proName": "FX_IDC:EURUSD"},
                  {"title": "BTC/USD","proName": "BITFINEX:BTCUSD"}
                  {"title": "S&P 500" "proName": "FOREXCOM:SPXUSD",},
                  {"title": "Nasdaq 100"  "proName": "FOREXCOM:NSXUSD",},
                  {"title": "BTC/USD"  "proName": "BITSTAMP:BTCUSD",},
                  {"title": "ETH/USD"  "proName": "BITSTAMP:ETHUSD",}
                ],
                "colorTheme": "light",
                "isTransparent": false,
                "displayMode": "adaptive",
                "locale": "en"
              }
            </script>
          </div>
          <!-- TradingView Widget END -->',
        'created_at' => '2020-05-14 14:19:41',
        'updated_at' => '2020-05-14 14:19:41',
      ),
      13 =>
      array (
        'chart_slug' => 'exotic_pairs',
        'chart_name' => 'Exotic',
        'chart_content' => '<!-- TradingView Widget BEGIN --><div class="tradingview-widget-container"><div class="tradingview-widget-container__widget"></div><script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-market-overview.js" async>{"belowLineFillColorGrowing": "rgba(5, 122, 205, 0.12)","gridLineColor": "rgba(242, 243, 245, 1)","scaleFontColor": "rgba(131, 136, 141, 1)","title": "Currencies","tabs": [{"title_raw": "Major","symbols": [{"s": "FX_IDC:EURUSD"},{"s": "FX_IDC:USDJPY"},{"s": "FX_IDC:GBPUSD"}],"quick_link": {"href": "/markets/currencies/rates-major/","title": "More Majors"},"title": "Major"},{"title_raw": "Minor","symbols": [{"s": "FX_IDC:EURGBP"},{"s": "FX_IDC:EURJPY"},{"s": "FX_IDC:GBPJPY"}],"quick_link": {"href": "/markets/currencies/rates-minor/","title": "More Minors"},"title": "Minor"},{"title_raw": "Exotic","symbols": [{"s": "FX_IDC:USDSEK"},{"s": "FX_IDC:USDMXN"},{"s": "FX_IDC:EURTRY"}],"quick_link": {"href": "/markets/currencies/rates-exotic/","title": "More Exotics"},"title": "Exotic"}],"plotLineColorFalling": "rgba(33, 150, 243, 1)","plotLineColorGrowing": "rgba(33, 150, 243, 1)","showChart": true,"title_link": "/markets/currencies/rates-major/","locale": "en","symbolActiveColor": "rgba(225, 239, 249, 1)","belowLineFillColorFalling": "rgba(5, 122, 205, 0.12)","height": "100%","width": "100%"}</script></div><!-- TradingView Widget END -->',
        'created_at' => '2020-05-14 14:24:41',
        'updated_at' => '2020-05-14 14:24:41',
      ),
      14 =>
      array (
        'chart_slug' => 'ticker_bar_dark',
        'chart_name' => 'Ticker Bar',
        'chart_content' => '	<!-- TradingView Widget BEGIN -->
          <div class="tradingview-widget-container">
              <div class="tradingview-widget-container__widget"></div>
              <script type="text/javascript"
                  src="https://s3.tradingview.com/external-embedding/embed-widget-ticker-tape.js" async>
                  {
                      "symbols": [{
                              "proName": "FOREXCOM:SPXUSD",
                              "title": "S&P 500"
                          },
                          {
                              "proName": "FOREXCOM:NSXUSD",
                              "title": "Nasdaq 100"
                          },
                          {
                              "proName": "FX_IDC:EURUSD",
                              "title": "EUR/USD"
                          },
                          {
                              "proName": "BITSTAMP:BTCUSD",
                              "title": "BTC/USD"
                          },
                          {
                              "proName": "BITSTAMP:ETHUSD",
                              "title": "ETH/USD"
                          }
                      ],
                      "showSymbolLogo": true,
                      "colorTheme": "dark",
                      "isTransparent": false,
                      "displayMode": "adaptive",
                      "locale": "en"
                  }
              </script>
          </div>
          <!-- TradingView Widget END -->',
        'created_at' => '2020-05-14 14:24:41',
        'updated_at' => '2020-05-14 14:24:41',
      ),
      15 =>
      array (
        'chart_slug' => 'pricing_values',
        'chart_name' => 'Pricing And Values',
        'chart_content' => '<!-- TradingView Widget BEGIN --><div class="tradingview-widget-container"><div class="tradingview-widget-container__widget"></div><script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-market-quotes.js" async>{"width": "100%","height": "700","symbolsGroups": [{"originalName": "Indices","symbols": [{"name": "INDEX:DOWI","displayName": "Dow 30"},{"name": "INDEX:NKY","displayName": "Nikkei 225"},{"name": "INDEX:DAX","displayName": "DAX Index"},{"name": "OANDA:UK100GBP","displayName": "FTSE 100"}],"name": "Indices"},{"originalName": "Commodities","symbols": [{"name": "CME:E61!","displayName": "Euro"},{"name": "COMEX:GC1!","displayName": "Gold"},{"name": "NYMEX:CL1!","displayName": "Crude Oil"},{"name": "NYMEX:NG1!","displayName": "Natural Gas"},{"name": "CBOT:ZC1!","displayName": "Corn"}],"name": "Commodities"},{"originalName": "Forex","symbols": [{"name": "FX:EURUSD"},{"name": "FX:GBPUSD"},{"name": "FX:USDJPY"},{"name": "FX:USDCHF"},{"name": "FX:AUDUSD"},{"name": "FX:USDCAD"}],"name": "Forex"}],"locale": "en"}</script></div><!-- TradingView Widget END -->',
        'created_at' => '2020-05-14 14:45:47',
        'updated_at' => '2020-05-14 14:45:47',
      ),
      16 =>
      array (
        'chart_slug' => 'advanced_real_time_charts',
        'chart_name' => 'Advanced Real Time Charts',
        'chart_content' => '
          <!-- TradingView Widget BEGIN -->
          <div class="tradingview-widget-container">
              <div class="tradingview-widget-container__widget"></div>
              <script type="text/javascript"
                  src="https://s3.tradingview.com/external-embedding/embed-widget-tickers.js" async>
                  {
                      "symbols": [{
                              "proName": "FOREXCOM:SPXUSD",
                              "title": "S&P 500"
                          },
                          {
                              "proName": "FOREXCOM:NSXUSD",
                              "title": "Nasdaq 100"
                          },
                          {
                              "proName": "FX_IDC:EURUSD",
                              "title": "EUR/USD"
                          },
                          {
                              "proName": "BITSTAMP:BTCUSD",
                              "title": "BTC/USD"
                          },
                          {
                              "proName": "BITSTAMP:ETHUSD",
                              "title": "ETH/USD"
                          }
                      ],
                      "colorTheme": "dark",
                      "isTransparent": false,
                      "locale": "en"
                  }
              </script>
          </div>
          <!-- TradingView Widget END -->
        ',
        'created_at' => '2020-05-14 14:45:47',
        'updated_at' => '2020-05-14 14:45:47',
      ),
      17 =>
      array (
        'chart_slug' => 'nasdac_aapl',
        'chart_name' => 'Nasdac AAPL',
        'chart_content' => '
          <!-- TradingView Widget BEGIN -->
          <div class="tradingview-widget-container">
              <div id="nasdac_aapl" style="height: 650px !important;"></div>
              <script type="text/javascript" src="https://s3.tradingview.com/tv.js"></script>
              <script type="text/javascript">
                  new TradingView.widget({
                      // "width": 1114,
                      // "height": 610,
                      "autosize": true,
                      "symbol": "NASDAQ:AAPL",
                      "interval": "D",
                      "timezone": "Etc/UTC",
                      "theme": "dark",
                      "style": "1",
                      "locale": "en",
                      "toolbar_bg": "#f1f3f6",
                      "enable_publishing": false,
                      "allow_symbol_change": true,
                      "container_id": "nasdac_aapl"
                  });
              </script>
          </div>
          <!-- TradingView Widget END -->
        ',
        'created_at' => '2020-05-14 14:45:47',
        'updated_at' => '2020-05-14 14:45:47',
      ),
      18 =>
      array (
        'chart_slug' => 'eurusd_rates',
        'chart_name' => 'EURUSD Rates',
        'chart_content' => '
            <!-- TradingView Widget BEGIN -->
            <div class="tradingview-widget-container">
                <div class="tradingview-widget-container__widget"></div>
                <script type="text/javascript"
                    src="https://s3.tradingview.com/external-embedding/embed-widget-mini-symbol-overview.js"
                    async>
                    {
                        "symbol": "FX:EURUSD",
                        "width": "100%",
                        "height": "220",
                        "locale": "en",
                        "dateRange": "12m",
                        "colorTheme": "dark",
                        "trendLineColor": "#37a6ef",
                        "underLineColor": "rgba(55, 166, 239, 0.15)",
                        "isTransparent": false,
                        "autosize": false,
                        "largeChartUrl": ""
                    }
                </script>
            </div>
            <!-- TradingView Widget END -->
        ',
        'created_at' => '2020-05-14 14:45:47',
        'updated_at' => '2020-05-14 14:45:47',
      ),
      19 =>
      array (
        'chart_slug' => 'market_activity',
        'chart_name' => 'Market Activity',
        'chart_content' => '
          <!-- TradingView Widget BEGIN -->
          <div class="tradingview-widget-container">
              <div class="tradingview-widget-container__widget"></div>
              <script type="text/javascript"
                  src="https://s3.tradingview.com/external-embedding/embed-widget-market-overview.js"
                  async>
                  {
                      "colorTheme": "dark",
                      "dateRange": "12m",
                      "showChart": true,
                      "locale": "en",
                      "width": "100%",
                      "height": "600",
                      "largeChartUrl": "",
                      "isTransparent": false,
                      "plotLineColorGrowing": "rgba(106, 168, 79, 1)",
                      "plotLineColorFalling": "rgba(255, 0, 0, 1)",
                      "gridLineColor": "rgba(42, 46, 57, 1)",
                      "scaleFontColor": "rgba(120, 123, 134, 1)",
                      "belowLineFillColorGrowing": "rgba(33, 150, 243, 0.12)",
                      "belowLineFillColorFalling": "rgba(33, 150, 243, 0.12)",
                      "symbolActiveColor": "rgba(33, 150, 243, 0.12)",
                      "tabs": [{
                              "title": "Indices",
                              "symbols": [{
                                      "s": "FOREXCOM:SPXUSD",
                                      "d": "S&P 500"
                                  },
                                  {
                                      "s": "FOREXCOM:NSXUSD",
                                      "d": "Nasdaq 100"
                                  },
                                  {
                                      "s": "FOREXCOM:DJI",
                                      "d": "Dow 30"
                                  },
                                  {
                                      "s": "INDEX:NKY",
                                      "d": "Nikkei 225"
                                  },
                                  {
                                      "s": "INDEX:DEU30",
                                      "d": "DAX Index"
                                  },
                                  {
                                      "s": "FOREXCOM:UKXGBP",
                                      "d": "FTSE 100"
                                  }
                              ],
                              "originalTitle": "Indices"
                          },
                          {
                              "title": "Commodities",
                              "symbols": [{
                                      "s": "CME_MINI:ES1!",
                                      "d": "E-Mini S&P"
                                  },
                                  {
                                      "s": "CME:6E1!",
                                      "d": "Euro"
                                  },
                                  {
                                      "s": "COMEX:GC1!",
                                      "d": "Gold"
                                  },
                                  {
                                      "s": "NYMEX:CL1!",
                                      "d": "Crude Oil"
                                  },
                                  {
                                      "s": "NYMEX:NG1!",
                                      "d": "Natural Gas"
                                  },
                                  {
                                      "s": "CBOT:ZC1!",
                                      "d": "Corn"
                                  }
                              ],
                              "originalTitle": "Commodities"
                          },
                          {
                              "title": "Bonds",
                              "symbols": [{
                                      "s": "CME:GE1!",
                                      "d": "Eurodollar"
                                  },
                                  {
                                      "s": "CBOT:ZB1!",
                                      "d": "T-Bond"
                                  },
                                  {
                                      "s": "CBOT:UB1!",
                                      "d": "Ultra T-Bond"
                                  },
                                  {
                                      "s": "EUREX:FGBL1!",
                                      "d": "Euro Bund"
                                  },
                                  {
                                      "s": "EUREX:FBTP1!",
                                      "d": "Euro BTP"
                                  },
                                  {
                                      "s": "EUREX:FGBM1!",
                                      "d": "Euro BOBL"
                                  }
                              ],
                              "originalTitle": "Bonds"
                          },
                          {
                              "title": "Forex",
                              "symbols": [{
                                      "s": "FX:EURUSD"
                                  },
                                  {
                                      "s": "FX:GBPUSD"
                                  },
                                  {
                                      "s": "FX:USDJPY"
                                  },
                                  {
                                      "s": "FX:USDCHF"
                                  },
                                  {
                                      "s": "FX:AUDUSD"
                                  },
                                  {
                                      "s": "FX:USDCAD"
                                  }
                              ],
                              "originalTitle": "Forex"
                          }
                      ]
                  }
              </script>
          </div>
          <!-- TradingView Widget END -->
        ',
        'created_at' => '2020-05-14 14:45:47',
        'updated_at' => '2020-05-14 14:45:47',
      ),
      20 =>
      array (
        'chart_slug' => 'static_ticker',
        'chart_name' => 'Static Ticker',
        'chart_content' => '
          <!-- TradingView Widget BEGIN -->
          <div class="tradingview-widget-container">
              <script async
                      src="https://s3.tradingview.com/external-embedding/embed-widget-tickers.js"
                      type="text/javascript">
                  {
                      "symbols"
                  :
                      [
                          {
                              "proName": "FOREXCOM:SPXUSD",
                              "title": "S&P 500"
                          },
                          {
                              "proName": "FOREXCOM:NSXUSD",
                              "title": "Nasdaq 100"
                          },
                          {
                              "proName": "FX_IDC:EURUSD",
                              "title": "EUR/USD"
                          },
                          {
                              "proName": "BITSTAMP:BTCUSD",
                              "title": "BTC/USD"
                          },
                          {
                              "proName": "BITSTAMP:ETHUSD",
                              "title": "ETH/USD"
                          }
                      ],
                          "colorTheme"
                  :
                      "light",
                          "isTransparent"
                  :
                      false,
                          "showSymbolLogo"
                  :
                      true,
                          "locale"
                  :
                      "en"
                  }
              </script>
          </div>
          <!-- TradingView Widget END -->
        ',
        'created_at' => '2020-05-14 14:45:47',
        'updated_at' => '2020-05-14 14:45:47',
      ),
      21 =>
      array (
        'chart_slug' => 'basic_studies_chart',
        'chart_name' => 'Basic Studies Chart',
        'chart_content' => '
          <!-- TradingView Widget BEGIN -->
          <div class="tradingview-widget-container">
              <div id="basic_studies_chart" style="height: 750px !important;"></div>
              <script type="text/javascript" src="https://s3.tradingview.com/tv.js"></script>
              <script type="text/javascript">
                  new TradingView.widget({
                      "autosize": true,
                      "symbol": "FX:EURUSD",
                      "timezone": "Etc/UTC",
                      "theme": "dark",
                      "style": "8",
                      "locale": "en",
                      "toolbar_bg": "#f1f3f6",
                      "enable_publishing": false,
                      "withdateranges": true,
                      "range": "YTD",
                      "hide_side_toolbar": false,
                      "allow_symbol_change": true,
                      "details": true,
                      "hotlist": true,
                      "isTransparent": true,
                      "calendar": true,
                      "studies": [
                          "DONCH@tv-basicstudies",
                          "KLTNR@tv-basicstudies",
                          "Volume@tv-basicstudies"
                      ],
                      "container_id": "basic_studies_chart"
                  });

              </script>
          </div>
          <!-- TradingView Widget END -->
        ',
        'created_at' => '2020-05-14 14:45:47',
        'updated_at' => '2020-05-14 14:45:47',
      ),
      22 =>
      array (
        'chart_slug' => 'market_overview',
        'chart_name' => 'Market Overview',
        'chart_content' => '
          <!-- TradingView Widget BEGIN -->
          <div class="tradingview-widget-container">
            <div class="tradingview-widget-container__widget"></div>
            <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-market-overview.js" async>
              {
                "colorTheme" : "dark",
                "dateRange" : "1D",
                "showChart" : true,
                "locale" : "en",
                "width" : "100%",
                "height" : "500",
                "largeChartUrl" : "",
                "isTransparent" : true,
                "showSymbolLogo" : true,
                "plotLineColorGrowing" : "rgba(25, 118, 210, 1)",
                "plotLineColorFalling" : "rgba(25, 118, 210, 1)",
                "gridLineColor" : "rgba(42, 46, 57, 1)",
                "scaleFontColor" : "rgba(120, 123, 134, 1)",
                "belowLineFillColorGrowing" : "rgba(33, 150, 243, 0.12)",
                "belowLineFillColorFalling" : "rgba(33, 150, 243, 0.12)",
                "symbolActiveColor" : "rgba(33, 150, 243, 0.12)",
                "tabs" :[
                  {
                    "title": "Indices",
                    "symbols": [
                        {
                            "s": "FOREXCOM:SPXUSD",
                            "d": "S&P 500"
                        },
                        {
                            "s": "FOREXCOM:NSXUSD",
                            "d": "Nasdaq 100"
                        },
                        {
                            "s": "FOREXCOM:DJI",
                            "d": "Dow 30"
                        },
                        {
                            "s": "INDEX:NKY",
                            "d": "Nikkei 225"
                        },
                        {
                            "s": "INDEX:DEU30",
                            "d": "DAX Index"
                        },
                        {
                            "s": "FOREXCOM:UKXGBP",
                            "d": "FTSE 100"
                        }
                    ],
                    "originalTitle": "Indices"
                  },
                  {
                    "title": "Commodities",
                    "symbols": [
                        {
                            "s": "CME_MINI:ES1!",
                            "d": "S&P 500"
                        },
                        {
                            "s": "CME:6E1!",
                            "d": "Euro"
                        },
                        {
                            "s": "COMEX:GC1!",
                            "d": "Gold"
                        },
                        {
                            "s": "NYMEX:CL1!",
                            "d": "Crude Oil"
                        },
                        {
                            "s": "NYMEX:NG1!",
                            "d": "Natural Gas"
                        },
                        {
                            "s": "CBOT:ZC1!",
                            "d": "Corn"
                        }
                    ],
                    "originalTitle": "Commodities"
                  },
                  {
                    "title": "Bonds",
                    "symbols": [
                        {
                            "s": "CME:GE1!",
                            "d": "Eurodollar"
                        },
                        {
                            "s": "CBOT:ZB1!",
                            "d": "T-Bond"
                        },
                        {
                            "s": "CBOT:UB1!",
                            "d": "Ultra T-Bond"
                        },
                        {
                            "s": "EUREX:FGBL1!",
                            "d": "Euro Bund"
                        },
                        {
                            "s": "EUREX:FBTP1!",
                            "d": "Euro BTP"
                        },
                        {
                            "s": "EUREX:FGBM1!",
                            "d": "Euro BOBL"
                        }
                    ],
                    "originalTitle": "Bonds"
                  },
                  {
                    "title": "Forex",
                    "symbols": [
                        {
                            "s": "FX:EURUSD"
                        },
                        {
                            "s": "FX:GBPUSD"
                        },
                        {
                            "s": "FX:USDJPY"
                        },
                        {
                            "s": "FX:USDCHF"
                        },
                        {
                            "s": "FX:AUDUSD"
                        },
                        {
                            "s": "FX:USDCAD"
                        }
                    ],
                    "originalTitle": "Forex"
                  }
                ]
              }
            </script>
          </div>
          <!-- TradingView Widget END -->
        ',
        'created_at' => '2020-05-14 14:45:47',
        'updated_at' => '2020-05-14 14:45:47',
      ),
      23 =>
      array (
        'chart_slug' => 'pairs_statistics_summary',
        'chart_name' => 'Pairs Statistics Summary',
        'chart_content' => '
          <!-- TradingView Widget BEGIN -->
          <div class="tradingview-widget-container">
            <div id="pairs_statistics_summary"></div>
            <script type="text/javascript" src="https://s3.tradingview.com/tv.js"></script>
            <script type="text/javascript">
              new TradingView.MediumWidget({
                "symbols": [
                  [
                      "EUR/USD",
                      "OANDA:EURUSD|1D"
                  ],
                  [
                      "BTC/USD",
                      "OANDA:BTCUSD|1D"
                  ],
                  [
                      "ETH/USD",
                      "KRAKEN:ETHUSD|1D"
                  ],
                  [
                      "XRP/USD",
                      "BITFINEX:XRPUSD|1D"
                  ],
                  [
                      "LTC/USD",
                      "KRAKEN:LTCUSD|1D"
                  ],
                  [
                      "Nasdaq 100",
                      "NASDAQ:NDAQ|1D"
                  ]
                ],
                "chartOnly": false,
                "width": "100%",
                "height": 500,
                "locale": "en",
                "colorTheme": "dark",
                "gridLineColor": "#2a2e39",
                "trendLineColor": "#1976d2",
                "fontColor": "#787b86",
                "underLineColor": "rgba(55, 166, 239, 0.15)",
                "isTransparent": true,
                "autosize": false,
                "container_id": "pairs_statistics_summary"
              });
            </script>
          </div>
          <!-- TradingView Widget END -->
        ',
        'created_at' => '2020-05-14 14:45:47',
        'updated_at' => '2020-05-14 14:45:47',
      ),
    ));
  }
}
