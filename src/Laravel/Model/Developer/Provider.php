<?php

namespace Peak\Laravel\Model\Developer;

use Illuminate\Support\ServiceProvider;

class Provider extends ServiceProvider
{

	public function boot()
	{
		// 创建迁移
		$this->publishes([
			__DIR__.'/migration.php' => database_path('migrations/2018_08_10_104829_create_table9_peak_developer.php'),
		], 'migrate');
	}



}