<?php namespace Prontotype\Plugins\ShortUrls;

use Prontotype\Http\Request;
use Prontotype\Http\Controllers\BaseController;
use Prontotype\Exception\NotFoundException;
use Symfony\Component\HttpFoundation\RedirectResponse;

class ShortUrlsController extends BaseController
{    
    public function redirectById($templateId, Request $request)
    {
        $template = $this->fetchTemplate('id:' . $templateId, true);
        $path = preg_replace('/' . '\.' . $this->config->get('templates.extension') . '$/', '', $template->getRelativePathname());
        return new RedirectResponse($path, 301);
    }

}