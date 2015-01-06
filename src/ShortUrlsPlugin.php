<?php namespace Prontotype\Plugins\ShortUrls;

use Prontotype\Container;
use Prontotype\Plugins\AbstractPlugin;
use Prontotype\Plugins\PluginInterface;

class ShortUrlsPlugin extends AbstractPlugin implements PluginInterface
{
    public function getConfig()
    {
        return 'config/config.yml';
    }

    public function register()
    {
        $conf = $this->container->make('prontotype.config');
        $handler = $this->container->make('prontotype.http');

        if ($conf->get('short_urls')) {
            $handler->get('/id:{templateId}', 'Prontotype\Plugins\ShortUrls\ShortUrlsController::redirectById')
                ->name('redirect');
        }
        
        $handler->get('/{templatePath}', 'Prontotype\Http\Controllers\DefaultController::notFound')
                ->name('notfound')
                ->assert('templatePath', '[^:]+:.+');

        $this->container->make('prontotype.events')->emit(Event::named('shortUrls.registered'));
    }

}