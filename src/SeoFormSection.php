<?php

namespace kirillbdev\PageSeo;

use kirillbdev\IdeaPage\FormSections\PageFormSection;
use kirillbdev\IdeaPage\Services\PageService;
use Illuminate\Support\Facades\DB;

class SeoFormSection extends PageFormSection
{
  /**
   * @param int $pageId
   * @return string
   */
  public function render($pageId)
  {
    $seoMeta = PageService::getMeta($pageId, 'seo_meta');

    $field = idea_field('translate', 'seo_meta')
      ->setFields([
        idea_field('text', 'meta_title')
          ->setTitle('Meta title'),
        idea_field('text', 'meta_description')
          ->setTitle('Meta description'),
        idea_field('text', 'meta_keywords')
          ->setTitle('Meta keywords')
      ]);

    if ($seoMeta) {
      $field->setValue($seoMeta);
    }

    return $field->getHtml();
  }

  /**
   * @param int $pageId
   * @param array $data
   * @return mixed
   */
  public function save($pageId, $data)
  {
    if (isset($data['seo_meta'])) {
      PageService::saveMeta($pageId, 'seo_meta', $data['seo_meta']);
    }
  }

  /**
   * @param int $pageId
   */
  public function delete($pageId)
  {
  	DB::table('page_meta')
		  ->where('page_id', $pageId)
		  ->where('key', 'seo_meta')
		  ->delete();
  }

  /**
   * @param int $pageId
   * @param array $data
   *
   * @return array|bool
   */
  public function validate($pageId, $data)
  {
    return true;
  }
}