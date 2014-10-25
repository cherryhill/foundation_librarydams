<?php

/**
 * Implements template_preprocess_page
 *
 */
function foundation_librarydams_preprocess_page(&$variables) {
  // Add page--node_type.tpl.php suggestions
  if (!empty($variables['node'])) {
    $variables['theme_hook_suggestions'][] = 'page__' . $variables['node']->type;
  }

  $variables['logo_img'] = '';
  if (!empty($variables['logo'])) {
    $variables['logo_img'] = theme('image', array(
      'path'  => $variables['logo'],
      'alt'   => strip_tags($variables['site_name']) . ' ' . t('logo'),
      'title' => strip_tags($variables['site_name']) . ' ' . t('Home'),
      'attributes' => array(
        'class' => array('logo'),
      ),
    ));
  }

  $variables['linked_logo']  = '';
  if (!empty($variables['logo_img'])) {
    $variables['linked_logo'] = l($variables['logo_img'], '<front>', array(
      'attributes' => array(
        'rel'   => 'home',
        'title' => strip_tags($variables['site_name']) . ' ' . t('Home'),
      ),
      'html' => TRUE,
    ));
  }

  $variables['linked_site_name'] = '';
  if (!empty($variables['site_name'])) {
    $variables['linked_site_name'] = l($variables['site_name'], '<front>', array(
      'attributes' => array(
        'rel'   => 'home',
        'title' => strip_tags($variables['site_name']) . ' ' . t('Home'),
      ),
    ));
  }

  // Top bar.
  if ($variables['top_bar'] = theme_get_setting('zurb_foundation_top_bar_enable')) {
    $top_bar_classes = array();

    if (theme_get_setting('zurb_foundation_top_bar_grid')) {
      $top_bar_classes[] = 'contain-to-grid';
    }

    if (theme_get_setting('zurb_foundation_top_bar_sticky')) {
      $top_bar_classes[] = 'sticky';
    }

    if ($variables['top_bar'] == 2) {
      $top_bar_classes[] = 'show-for-small';
    }

    $variables['top_bar_classes'] = implode(' ', $top_bar_classes);
    $variables['top_bar_menu_text'] = check_plain(theme_get_setting('zurb_foundation_top_bar_menu_text'));

    $top_bar_options = array();

    if (!theme_get_setting('zurb_foundation_top_bar_custom_back_text')) {
      $top_bar_options[] = 'custom_back_text:false';
    }

    if ($back_text = check_plain(theme_get_setting('zurb_foundation_top_bar_back_text'))) {
      if ($back_text !== 'Back') {
        $top_bar_options[] = "back_text:'{$back_text}'";
      }
    }

    if (!theme_get_setting('zurb_foundation_top_bar_is_hover')) {
      $top_bar_options[] = 'is_hover:false';
    }

    if (!theme_get_setting('zurb_foundation_top_bar_scrolltop')) {
      $top_bar_options[] = 'scrolltop:false';
    }

    $variables['top_bar_options'] = ' data-options="' . implode('; ', $top_bar_options) . '"';
  }

  // Alternative header.
  // This is what will show up if the top bar is disabled or enabled only for
  // mobile.
  if ($variables['alt_header'] = ($variables['top_bar'] != 1)) {
    // Hide alt header on mobile if using top bar in mobile.
    $variables['alt_header_classes'] = $variables['top_bar'] == 2 ? ' hide-for-small' : '';
  }

  // Menus for alternative header.
  $variables['alt_main_menu'] = '';

  if (!empty($variables['main_menu'])) {
    $variables['alt_main_menu'] = theme('links__system_main_menu', array(
      'links' => $variables['main_menu'],
      'attributes' => array(
        'id' => 'main-menu-links',
        'class' => array('links', 'inline-list', 'clearfix'),
      ),
      'heading' => array(
        'text' => t('Main menu'),
        'level' => 'h2',
        'class' => array('element-invisible'),
      ),
    ));
  }

  $variables['alt_secondary_menu'] = '';

  if (!empty($variables['secondary_menu'])) {
    $variables['alt_secondary_menu'] = theme('links__system_secondary_menu', array(
      'links' => $variables['secondary_menu'],
      'attributes' => array(
        'id' => 'secondary-menu-links',
        'class' => array('links', 'clearfix'),
      ),
      'heading' => array(
        'text' => t('Secondary menu'),
        'level' => 'h2',
        'class' => array('element-invisible'),
      ),
    ));
  }

  // Top bar menus.
  $variables['top_bar_main_menu'] = '';
  if (!empty($variables['main_menu'])) {
    $variables['top_bar_main_menu'] = theme('links__topbar_main_menu', array(
      'links' => $variables['main_menu'],
      'attributes' => array(
        'id' => 'main-menu',
        'class' => array('main-nav'),
      ),
      'heading' => array(
        'text' => t('Main menu'),
        'level' => 'h2',
        'class' => array('element-invisible'),
      ),
    ));
  }

  $variables['top_bar_secondary_menu'] = '';
  if (!empty($variables['secondary_menu'])) {
    $variables['top_bar_secondary_menu'] = theme('links__topbar_secondary_menu', array(
      'links' => $variables['secondary_menu'],
      'attributes' => array(
        'id'    => 'secondary-menu',
        'class' => array('secondary', 'link-list'),
      ),
      'heading' => array(
        'text' => t('Secondary menu'),
        'level' => 'h2',
        'class' => array('element-invisible'),
      ),
    ));
  }

  // Messages in modal.
  $variables['zurb_foundation_messages_modal'] = theme_get_setting('zurb_foundation_messages_modal');

  // Convenience variables
  if (!empty($variables['page']['sidebar_first'])){
    $left = $variables['page']['sidebar_first'];
  }

  if (!empty($variables['page']['sidebar_second'])) {
    $right = $variables['page']['sidebar_second'];
  }

  // Dynamic sidebars
  if (!empty($left) && !empty($right)) {
    $variables['main_grid'] = 'large-4 push-4';
    $variables['sidebar_first_grid'] = 'large-4 pull-4';
    $variables['sidebar_sec_grid'] = 'large-4';
  } elseif (empty($left) && !empty($right)) {
    $variables['main_grid'] = 'large-8';
    $variables['sidebar_first_grid'] = '';
    $variables['sidebar_sec_grid'] = 'large-4';
  } elseif (!empty($left) && empty($right)) {
    $variables['main_grid'] = 'large-8 push-4';
    $variables['sidebar_first_grid'] = 'large-4 pull-8';
    $variables['sidebar_sec_grid'] = '';
  } else {
    $variables['main_grid'] = 'large-12';
    $variables['sidebar_first_grid'] = '';
    $variables['sidebar_sec_grid'] = '';
  }

  // Ensure modal reveal behavior if modal messages are enabled.
  if(theme_get_setting('zurb_foundation_messages_modal')) {
    drupal_add_js(drupal_get_path('theme', 'zurb_foundation') . '/js/behavior/reveal.js');
  }
}

/**
 * Implements hook_preprocess_block()
 */
function foundation_librarydams_preprocess_block(&$variables) {
  // Convenience variable for block headers.
  $title_class = &$variables['title_attributes_array']['class'];

  // Unhide block titles in header region
  if ($variables['block']->region == 'header') {
    $title_class[] = 'eioverride';
  }
}

/**
 * Implements hook_form_FORM_ID_alter()
 */
function foundation_librarydams_form_islandora_solr_simple_search_form_alter(&$form, &$form_state, $form_id) {
  $form['simple']['submit']['#attributes']['class'][] = 'postfix';
}

/**
 * Implements hook_preprocess_theme().
 */
function foundation_librarydams_preprocess_islandora_mods_display_display(&$variables) {
  // You can use preprocess hooks to modify the variables before they are passed
  // to the theme function or template file.
  $object = $variables['islandora_object'];
  _foundation_librarydams_process_mods_data($variables, $object);
}

// TODO: Generalize and add to Islandora MODS Display module.
function _foundation_librarydams_process_mods_data(&$variables, $object) {
  if (islandora_datastream_access(ISLANDORA_VIEW_OBJECTS, $object['MODS'])) {
    try {
      $mods = $object['MODS']->content;
    }
    catch (Exception $e) {
      drupal_set_message(t('Error retrieving object %s %t', array('%s' => $object->id, '%t' => $e->getMessage())), 'error', FALSE);
    }
  }

  if ($mods) {
    $mods_data = new SimpleXMLElement($mods);

    // NAME (title)
    if (!empty($mods_data->titleInfo->title)) {
      $title = $mods_data->titleInfo->title;
      drupal_set_title($title);
    }

    // CREATOR (name)
    // AUTHOR (name)
    // CONTRIBUTOR (name)
    // would be nice to write code that looks at the roleTerm and then
    // groups and labels names by different roles
    if (!empty($mods_data->name)) {
      $names = array();
      foreach ($mods_data->name as $name) {
        if (!empty($name->namePart)) {
          $namePart = $name->namePart;
          $namePart_link = l(
            $namePart,
            'islandora/search',
            array(
              'query' => array(
                'f[0]' => 'mods_name_namePart_ms:' . "\"$namePart\""
              )
            )
          );
          $names[] = $namePart_link;
        }
      }
      $variables['names'] = $names;
    }

    // RESOURCEID
    $resourceid = $mods_data->identifier;
    $variables['resourceid'] = $resourceid;

    // SUBJECT
    if (!empty($mods_data->subject->topic)) {
      $subjects = array();
      foreach ($mods_data->subject as $subject) {
        $topic = $subject->topic;
        $subject_link = l(
          $topic,
          'islandora/search',
          array(
            'query' => array(
              'f[0]' => 'mods_subject_topic_ms:' . "\"$topic\""
            )
          )
        );
        $subjects[] = $subject_link;
      }
      $variables['subjects'] = $subjects;
    }

    // LANGUAGE

    // DESCRIPTION (abstract)
    if (!empty($mods_data->abstract)) {
      $abstract = $mods_data->abstract;
      $variables['abstract'] = $abstract;
    }

    // PUBLISHER
    if (!empty($mods_data->originInfo->publisher)) {
      $publishers = array();
      foreach ($mods_data->originInfo->publisher as $publisher) {
        $publisher_link = l(
          $publisher,
          'islandora/search',
          array(
            'query' => array(
              'f[0]' => 'mods_originInfo_publisher_ms:' . "\"$publisher\""
            )
          )
        );
        $publishers[] = $publisher_link;
      }
      $variables['publishers'] = $publishers;
    }

    // DATE
    if (!empty($mods_data->originInfo->dateIssued)) {
      $date = $mods_data->originInfo->dateIssued;
      $variables['date'] = $date;
    }

    // FORMAT
    if (!empty($mods_data->physicalDescription->extent)) {
      $format = $mods_data->physicalDescription->extent;
      $variables['format'] = $format;
    }

    // DEPARTMENT
    if (!empty($mods_data->location->physicalLocation)) {
      $department = $mods_data->location->physicalLocation;
      $variables['department'] = $department;
      $variables['department_link'] = l(
        $department,
        'islandora/search',
        array(
          'query' => array(
            'f[0]' => 'mods_location_physicalLocation_ms:' . "\"$department\""
          )
        )
      );
    }

    // SOURCE
    $source_publisher = $mods_data->originInfo->publisher;
    // may have to parse dates differently between XSL and SimpleXML
    // if the DATE field exists and a SOURCE field date exists they
    // must be the same
    $source_date = $mods_data->originInfo->dateIssued;

    // COLLECTION
    if (!empty($mods_data->relatedItem->titleInfo->title)) {
      $collections = array();
      foreach ($mods_data->relatedItem as $collection) {
        $collection_title = $collection->titleInfo->title;
        $collection_link = l(
          $collection_title,
          'islandora/search',
          array(
            'query' => array(
              'f[0]' => 'mods_relatedItem_host_titleInfo_title_ms:' . "\"$collection_title\""
            )
          )
        );
        $collections[] =  $collection_link;
      }
      $variables['collections'] = $collections;
    }

    // LOCATION
    if (!empty($mods_data->location->shelfLocator)) {
      $variables['location'] = $mods_data->location->shelfLocator;
    }

    // check for notes
    $negatives = array();
    $content_notes = array();
    foreach ($mods_data->note as $note) {
      // NEGATIVE NUMBERS
      if ((string) $note['type'] == 'negative number') {
        // cast note as string because it is an object
        $note = (string) $note;
        if (!empty($note)) {
          $negatives[] = $note;
        }
      }
      // SOURCE
      elseif ((string) $note['type'] == 'source') {
        // cast note as string because it is an object
        $note = (string) $note;
        if (!empty($note)) {
          $variables['source'] = $note;
        }
      }
      // RELATION
      elseif ((string) $note['type'] == 'content') {
        // cast note as string because it is an object
        $note = (string) $note;
        if (!empty($note)) {
          $content_notes[] = $note;
        }
      }
    }
    $variables['negatives'] = $negatives;
    $variables['content_notes'] = $content_notes;

    foreach ($mods_data->accessCondition as $accessCondition) {
      // RESTRICTIONS
      if ((string) $accessCondition['type'] == 'restriction on access') {
        // cast accessCondition as string because it is an object
        $accessCondition = (string) $accessCondition;
        if (!empty($accessCondition)) {
          $variables['restrictions'] = $accessCondition;
        }
      }
      // COPYRIGHT
      elseif ((string) $accessCondition['type'] == 'use and reproduction') {
        // cast accessCondition as string because it is an object
        $accessCondition = (string) $accessCondition;
        if (!empty($accessCondition)) {
          $variables['copyright'] = $accessCondition;
        }
      }
    }

  }
}
