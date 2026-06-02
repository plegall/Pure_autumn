<?php
/*
Theme Name: Pure_autumn
Version: auto
Description: Colors of autumn, random sort of colors for thumbnails, "S" blocks... a must have !
Theme URI: http://fr.piwigo.org/ext/extension_view.php?eid=443
Author: flop25
Author URI: http://www.planete-flop.fr
*/

$themeconf = array(
  'name'         => 'Pure_autumn',
  'parent'        => 'Pure_default',
  'icon_dir'      => 'themes/Pure_default/icon',
  'mime_icon_dir' => 'themes/Pure_default/icon/mimetypes/',
  'local_head' => 'local_head.tpl',
  'colorscheme' => 'clear',
);
/** mainpage_categories.tpl **/
add_event_handler('loc_end_index_category_thumbnails', 'Pure_autumn_cat');
function Pure_autumn_cat($tpl_thumbnails_var)
{
    global $template;
    $template->set_prefilter('index_category_thumbnails', 'Pure_autumn_prefilter_cat');
		return $tpl_thumbnails_var;
}
function Pure_autumn_prefilter_cat($content)
{
  $pwgversion=str_replace('.','',PHPWG_VERSION);
  $pwgversion_array=explode('.', PHPWG_VERSION);
  if ($pwgversion_array[0].$pwgversion_array[1]=="23")
  {
    $search = '#<li>[\s]*<div class="thumbnailCategory">#';
    $replacement = '<li class="{cycle values="cat_1,cat_2,cat_3,cat_4"}" >
	<div class="thumbnailCategory">';
  }
  elseif (version_compare(PHPWG_VERSION, '2.6', '>='))
  {
    $search = '#<li class="\{if \$smarty\.foreach.*odd\{else\}even\{/if\}">#s';
    $replacement = '<li class="{cycle values="cat_1,cat_2,cat_3,cat_4"}" >';
  }
  return preg_replace($search, $replacement, $content);
}

/** thumbnails.tpl **/
add_event_handler('loc_end_index_thumbnails', 'Pure_autumn_thumbnails');
function Pure_autumn_thumbnails($tpl_thumbnails_var)
{
    global $template;
    $template->set_prefilter('index_thumbnails', 'Pure_autumn_prefilter_thumbnails');
    $template->set_prefilter('stuffs', 'Pure_autumn_prefilter_thumbnails');

    foreach ($tpl_thumbnails_var as $idx => $thumbnail)
    {
      $tpl_thumbnails_var[$idx]['pure_autumn_random_class_number'] = mt_rand(1, 5);
    }

		return $tpl_thumbnails_var;
}

function Pure_autumn_prefilter_thumbnails($content)
{
  $search = '#<li>[\s]*<span class="wrap1">#';
  
  $replacement = '<li class="thumb_{$thumbnail.pure_autumn_random_class_number}"  >
	<span class="wrap1">';

  return preg_replace($search, $replacement, $content);
}
?>
