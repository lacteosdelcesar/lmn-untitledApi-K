<?php
/**
 * Created by tav0
 * Date: 25/05/16
 * Time: 11:42 AM
 */

namespace App\Providers;


use Illuminate\Support\ServiceProvider;

class CatchAllOptionsRequestsProvider extends ServiceProvider
{
    public function register()
    {
        $request = app('request');
        if ($request->isMethod('OPTIONS'))
        {
            app()->options($request->path(), function() { return response('', 200); });
        }
    }
}