<?php

namespace App\Traits;


trait FiltrableTrait
{
	/**
	 * Add tag to query string filter
	 * @return array
	 */
	public function getQueryFilterAttribute()
	{
		$route = app('router')->currentRouteName();
		$qString = collect(request()->query())->except($this->filtrable, 'page');

		$query = request()->filled($this->filtrable)
			? explode(',', request()->get($this->filtrable)) : [];

		if (!in_array($this->slug, $query)) {
			array_push($query, $this->slug);
		} else {
			$pos = array_search($this->slug, $query);
			array_splice($query, $pos, 1);
		}

		if (count($query)) {
			$query = $qString->put($this->filtrable, implode(',', $query))->sortkeys()->all();
		} else {
			$query = null;
		}

		return urldecode(route($route, $query));
	}
}