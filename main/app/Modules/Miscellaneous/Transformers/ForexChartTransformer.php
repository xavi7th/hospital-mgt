<?php

namespace App\Modules\Miscellaneous\Transformers;

use App\Modules\Miscellaneous\Models\ForexChart;

class ForexChartTransformer
{
	public function collectionTransformer($collection, $transformerMethod)
	{
		return $collection->map(function ($v) use ($transformerMethod) {
			return $this->$transformerMethod($v);
		});
	}

	public function transform(ForexChart $forex_chart)
	{
		return [
			'id' => $forex_chart->id,
			'chart_slug' => $forex_chart->chart_slug,
			'chart_name' => $forex_chart->chart_name,
			'chart_content' => $forex_chart->chart_content,
		];
	}

}
