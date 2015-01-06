<?php namespace Prontotype\Plugins\ShortUrls;

use Prontotype\Container;
use League\Event\Event;
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
        
        $this->container->make('prontotype.events')->emit(Event::named('shortUrls.registered'));
    }

}