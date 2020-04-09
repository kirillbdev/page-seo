<?php

namespace kirillbdev\PageSeo;

use Idea\Base\PluginBase;
use Illuminate\Support\Facades\Event;
use kirillbdev\IdeaPage\Services\PageService;

class Plugin extends PluginBase
{
	public function information()
	{
		return [
			'name' => 'kirillbdev/page-seo',
			'title' => 'Base SEO plugin for Idea Page',
			'version' => '1.0.0',
			'author' => 'kirillbdev'
		];
	}

	public function boot()
	{
	  Event::listen('page_edit_form_extend', function (&$sections, $pageId) {
	    $sections['seo'] = new SeoFormSection('SEO');
    });

	  Event::listen('page_render', function (&$data) {
	    $seoMeta = PageService::getMeta($data['page']->id, 'seo_meta');

	    if ($seoMeta && isset($seoMeta[language()->current()->id])) {
	      document()->setTitle($seoMeta[language()->current()->id]['meta_title']);
        document()->setDescription($seoMeta[language()->current()->id]['meta_description']);
        document()->setKeywords($seoMeta[language()->current()->id]['meta_keywords']);
      }
    });
	}
}