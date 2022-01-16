<?php
if(get_field('feature_consent_dialog_active','option')){
  $consent_dialog_style = get_field('feature_consent_dialog_style','option');
  $consent_dialog_link = get_field('feature_consent_dialog_link','option');
  if( $consent_dialog_link ):
    $info_link_url = $consent_dialog_link['url'];
    $info_link_title = $consent_dialog_link['title'];
    $info_link_target = $consent_dialog_link['target'] ? $consent_dialog_link['target'] : '_self';
  endif;
  ?>

  <div class="feature-consent-dialog is-style-<?= $consent_dialog_style; ?>" data-expire="<?php echo get_field('feature_consent_dialog_expire','option'); ?>">
    <form name="feature-consent-dialog">
    <div class="feature-consent-dialog__window">
      <?php if($consent_dialog_style == 'popup'){ ?>
      <h3><?php the_field('feature_consent_dialog_title','option'); ?></h3>
      <?php } ?>
      <div class="feature-consent-dialog__intro">
        <p>
          <?php the_field('feature_consent_dialog_intro','option'); ?>
          <?php if( $consent_dialog_link ){ ?>
            <a class="feature-consent-dialog__privacy-link" href="<?php echo esc_url( $info_link_url ); ?>" target="<?php echo esc_attr( $info_link_target ); ?>"><?php echo esc_html( $info_link_title ); ?></a>
          <?php } ?>
        </p>

      </div>

      <?php if($consent_dialog_style == 'popup'){ ?>
      <div class="feature-consent-dialog__script-groups">
        <ul>
          <li>
            <input type="checkbox" id="essential" name="essential" value="essential" checked disabled>
            <label for="essential">
              <span><?= __('Essentielle Skripte','theme'); ?></span>
              <button id="essential" class="info-toggle">Infos</button>
            </label>
            <div class="info hide"><?= get_field('feature_consent_dialog_essential_text','option') ?></div>
          </li>
          <?php if(get_field('feature_consent_dialog_external_active','option')){ ?>
          <li>
            <input type="checkbox" id="external" name="external" value="external">
            <label for="external">
              <span><?= __('Externe Medien','theme'); ?></span>
              <button id="external" class="info-toggle">Infos</button>
            </label>
            <div class="info hide"><?= get_field('feature_consent_dialog_external_text','option') ?></div>
          </li>
          <?php } ?>
          <?php if(get_field('feature_consent_dialog_tracking_active','option')){ ?>
          <li>
            <input type="checkbox" id="tracking" name="tracking" value="tracking">
            <label for="tracking">
              <span><?= __('Tracking','theme'); ?></span>
              <button id="tracking" class="info-toggle">Infos</button>
            </label>
            <div class="info hide"><?= get_field('feature_consent_dialog_tracking_text','option') ?></div>
          </li>
          <?php } ?>
          <?php if(get_field('feature_consent_dialog_marketing_active','option')){ ?>
          <li>
            <input type="checkbox" id="marketing" name="marketing" value="marketing">
            <label for="marketing">
              <span><?= __('Marketing','theme'); ?></span>
              <button id="marketing" class="info-toggle">Infos</button>
            </label>
            <div class="info hide"><?= get_field('feature_consent_dialog_marketing_text','option') ?></div>
          </li>
          <?php } ?>
        </ul>
      </div>
      <?php } ?>

      <div class="feature-consent-dialog__options">
        <div class="consent-all">
          <button class="theme-button is-style-secondary">
            <?php echo get_field('feature_consent_dialog_consent_all','option'); ?>
          </button>
        </div>
        <?php if($consent_dialog_style == 'popup'){ ?>
          <?php if(get_field('feature_consent_dialog_external_active','option') || get_field('feature_consent_dialog_tracking_active','option') || get_field('feature_consent_dialog_marketing_active','option')){ ?>
          <div class="consent-selection">
            <button class="theme-button is-style-secondary">
              <?php echo get_field('feature_consent_dialog_consent_selection','option'); ?>
            </button>
          </div>
          <?php } ?>
          <div class="consent-none">
            <button class="theme-button is-style-secondary">
              <?php echo get_field('feature_consent_dialog_consent_none','option'); ?>
            </button>
          </div>
        <?php } ?>
      </div>

    </div>
    </form>
  </div>

<?php }
