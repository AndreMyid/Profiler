<?php namespace Andremyid\Profiler;

use Illuminate\Support\ServiceProvider;

class ProfilerServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->package('andremyid/profiler');

		// Bring the application container instance into the local scope so we can
		// import it into the filters scope.
		$app = $this->app;

		$this->app->finish(function() use ($app)
		{
			//echo $app['profiler']->generateReport(); //default
			
			if ($app['config']->get('profiler::enabled', true)) //if used Config
			{
				echo $app['profiler']->generateReport();
			}
		});
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
        $this->app['profiler'] = $this->app->share(function($app)
        {
		//	return new Profiler;
		//	return new Profiler($app['view']); //untuk menampilkan View pada Vendor
			return new Profiler($app['view'], $app['config']); //untuk menampilkan View dan Config
        });
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array();
	}

}
