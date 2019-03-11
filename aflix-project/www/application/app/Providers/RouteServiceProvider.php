<?php

namespace HelloVideo\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

use Auth;
use View;
use Illuminate\Cookie\CookieJar;
use HelloVideo\Models\Setting;
use HelloVideo\Models\Plugin;
use HelloVideo\Models\PluginData;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'HelloVideo\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
      parent::boot();


      $settings = Setting::first();
      $root_dir = __DIR__ . '/../../../';

            if(\Cookie::get('theme')){
                $theme = \Crypt::decrypt(\Cookie::get('theme'));
                define('THEME', $theme);
            } else {
                if($settings->theme):
                    $theme = $settings->theme;
                  if (!defined('THEME')) define('THEME', $theme);
                endif;
            }


      \Config::set('mail.from', ['address' => $settings->system_email, 'name' => $settings->website_name]);

      @include( $root_dir . 'content/themes/' . $theme . '/functions.php');
      View::addNamespace('Theme', $root_dir . 'content/themes/' . $theme);

      View::addNamespace('plugins', 'content/plugins/');

      try{

        $plugins = Plugin::where('active', '=', 1)->get();

              //print_r($plugins); die();
              foreach($plugins as $plugin){
                  $plugin_name = $plugin->slug;
                  $include_file = 'content/plugins/' . $plugin_name . '/functions.php';

                  // Create Settings Route for Plugin

                  Route::group(array('before' => 'admin'), function(){

                      Route::get( 'admin/plugin/{plugin_name}', function($plugin_name){
                          $plugin_data = PluginData::where('plugin_slug', '=', $plugin_name)->get();

                           $data = array();

                          foreach($plugin_data as $plugin):
                $data[$plugin->key] = $plugin->value;
              endforeach;


                          return View::make( 'plugins::' . $plugin_name . '.settings', $data);
                      });

                      Route::post( 'admin/plugin/{plugin_name}', function($plugin_name){
                          $input = request()->all();
                          foreach($input as $key => $value){
                              $pluginData = PluginData::where('plugin_slug', '=', $plugin_name)->where('key', '=', $key)->first();

                              if(!empty($pluginData->id)){
                                  $pluginData->value = $value;
                                  $pluginData->save();
                              } else {
                                  $pluginData = new PluginData;
                                  $pluginData->plugin_slug = $plugin_name;
                                  $pluginData->key = $key;
                                  $pluginData->value = $value;
                                  $pluginData->save();
                              }
                          }

                          return redirect( '/admin/plugin/' . $plugin_name )->with(array('note' => 'Successfully updated plugin information', 'note_type' => 'success') );
                      });

                  });

                  if(file_exists($include_file)){

                     include($include_file);
                  }

              }

      } catch(Exception $e){
        die('error in RouteServiceProvider.php with plugins');
      }



    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();


    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
             ->namespace($this->namespace)
             ->group(base_path('routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
             ->middleware('api')
             ->namespace($this->namespace)
             ->group(base_path('routes/api.php'));
    }
}
