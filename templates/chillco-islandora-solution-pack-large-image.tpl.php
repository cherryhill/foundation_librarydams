<?php
/**
 * @file
 * This is the template file for the object page for large image
 *
 * Available variables:
 * - $islandora_object: The Islandora object rendered in this template file
 * - $islandora_dublin_core: The DC datastream object
 * - $dc_array: The DC datastream object values as a sanitized array. This
 *   includes label, value and class name.
 * - $islandora_object_label: The sanitized object label.
 * - $parent_collections: An array containing parent collection(s) info.
 *   Includes collection object, label, url and rendered link.
 * - $islandora_thumbnail_img: A rendered thumbnail image.
 * - $islandora_content: A rendered image. By default this is the JPG datastream
 *   which is a medium sized image. Alternatively this could be a rendered
 *   viewer which displays the JP2 datastream image.
 *
 * @see template_preprocess_chillco_islandora_solution_pack_large_image()
 * @see theme_chillco_islandora_solution_pack_large_image()
 */
?>

<div class="chillco-islandora-large-image-object islandora">
  <div class="chillco-islandora-large-image-content-wrapper clearfix">
    <?php if ($islandora_content): ?>
      <?php if (isset($image_clip)): ?>
        <?php print $image_clip; ?>
      <?php endif; ?>
      <div class="chillco-islandora-large-image-content">
        <?php print $islandora_content; ?>
      </div>
    <?php endif; ?>
  <div class="chillco-islandora-large-image-sidebar">
    <?php if (!empty($dc_array['dc:description']['value'])): ?>
      <p><?php print $dc_array['dc:description']['value']; ?></p>
    <?php endif; ?>
  </div>
  </div>
</div>
