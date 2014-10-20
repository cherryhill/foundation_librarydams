<?php
/**
 * @file
 * This is the template file for the metadata display for an object.
 *
 * Available variables:
 * - $islandora_object: The Islandora object rendered in this template file
 * - $metadata: XSLT output
 *
 * @see template_preprocess_unicorns_are_awesome_display()
 * @see theme_unicorns_are_awesome_display()
 */
?>
<?php if (!empty($abstract)): ?>
  <div class="islandora-metadata-description-title">Description</div>
  <div class="islandora-metadata-description-value"><?php print $abstract; ?></div>
<?php endif; ?>

<dl>
  <?php // name could have multiple values ?>
  <?php if (!empty($names)): ?>
    <dt class="islandora-field-label">Creator:</dt>
    <?php foreach ($names as $name): ?>
      <dd class="islandora-field-value"><?php print $name; ?></dd>
    <?php endforeach; ?>
  <?php endif; ?>

  <?php if (!empty($resourceid)): ?>
    <dt class="islandora-field-label">Resource ID:</dt>
    <dd class="islandora-field-value"><?php print $resourceid; ?></dd>
  <?php endif; ?>

  <?php // subject could have multiple values ?>
  <?php if (!empty($subjects)): ?>
    <dt class="islandora-field-label">Subject:</dt>
    <?php foreach ($subjects as $subject): ?>
      <dd class="islandora-field-value"><?php print $subject; ?></dd>
    <?php endforeach; ?>
  <?php endif; ?>

  <?php // publisher could have multiple values ?>
  <?php if (!empty($publishers)): ?>
    <dt class="islandora-field-label">Publisher:</dt>
    <?php foreach ($publishers as $publisher): ?>
      <dd class="islandora-field-value"><?php print $publisher; ?></dd>
    <?php endforeach; ?>
  <?php endif; ?>

  <?php if (!empty($source)): ?>
    <dt class="islandora-field-label">Source:</dt>
    <dd class="islandora-field-value"><?php print $source; ?></dd>
  <?php endif; ?>

  <?php if (!empty($date)): ?>
    <dt class="islandora-field-label">Date:</dt>
    <dd class="islandora-field-value"><?php print $date; ?></dd>
  <?php endif; ?>

  <?php if (!empty($format)): ?>
    <dt class="islandora-field-label">Format:</dt>
    <dd class="islandora-field-value"><?php print $format; ?></dd>
  <?php endif; ?>

  <?php if (!empty($department)): ?>
    <dt class="islandora-field-label">Department:</dt>
    <dd class="islandora-field-value"><?php print $department_link; ?></dd>
  <?php endif; ?>

  <?php // collection could have multiple values ?>
  <?php if (!empty($collections)): ?>
    <dt class="islandora-field-label">Collection:</dt>
    <?php foreach ($collections as $collection): ?>
      <dd class="islandora-field-value"><?php print $collection; ?></dd>
    <?php endforeach; ?>
  <?php endif; ?>

  <?php if (!empty($location)): ?>
    <dt class="islandora-field-label">Location:</dt>
    <dd class="islandora-field-value"><?php print $location; ?></dd>
  <?php endif; ?>

  <?php // negative could have multiple values ?>
  <?php if (!empty($negatives)): ?>
    <dt class="islandora-field-label">Negative Number:</dt>
    <?php foreach ($negatives as $negative): ?>
      <dd class="islandora-field-value"><?php print $negative; ?></dd>
    <?php endforeach; ?>
  <?php endif; ?>

  <?php // content note could have multiple values ?>
  <?php if (!empty($content_notes)): ?>
    <dt class="islandora-field-label">Content Note:</dt>
    <?php foreach ($content_notes as $content_note): ?>
      <dd class="islandora-field-value"><?php print $content_note; ?></dd>
    <?php endforeach; ?>
  <?php endif; ?>

  <?php if (!empty($restrictions)): ?>
    <dt class="islandora-field-label">Restrictions:</dt>
    <dd class="islandora-field-value"><?php print $restrictions; ?></dd>
  <?php endif; ?>

  <?php if (!empty($copyright)): ?>
    <dt class="islandora-field-label">Copyright:</dt>
    <dd class="islandora-field-value"><?php print $copyright; ?></dd>
  <?php endif; ?>
</dl>
