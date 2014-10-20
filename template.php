<?php

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
dpm($mods_data);
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
