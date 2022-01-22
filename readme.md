# feature-consent-dialog

This module builds on WordPress and Modularity.

Provides a consentr dialog modal message to consent to specific script and&or cookie groups.

---

Version: 2.2.4

Author: Matze @ https://modularity.group

License: MIT

---

Set up a consent dialog with ajax powered optional scripts loader (works with static caching) and first-party cookie to save consent selection. Allow user to "Consent none", "Consent selection" or "Consent all". Activate & Setup: "Settings > Consent Dialog".

Selectily activate Consent-Groups width Scripts and Text-Messages: "External Media", "Tracking", "Marketing". Script types: `['essential','external','tracking','marketing']`. 

Create JS init functions to init your components which use "external" sources to load the sources only on init and init them with JS: `if(featureConsentDialog.checkType('external'))` (marketing + tracking the same way). Init on demand with temporary src-attribute `data-is-blocked-src` which will be switched to `src` when external scripts are allowed.

Add the respective blocking-message INSIDE the feature/component tag `<?= consent_dialog_blocked('external') ?>` (marketing + tracking the same way).

**Example 1 init function:**

```
if($('.feature-xyz').length && featureConsentDialog.checkType('external')){
  $.getScript("https://maps.googleapis.com/maps/api/js?key=YOUR-GOOGLEMAPS-API-KEY",function(){
    $('.feature-xyz__map-container').each(function(){
      // init the external script based (google maps) feature 
    });
  });
  $('.feature-xyz .feature-consent-dialog__blocked').remove();
}
```

**Example 2 init function:**

```
function featureXYZInit(){
  $('.feature-xyz[data-is-blocked-src]').each(function(){
    $(this).attr('src',$(this).attr('data-is-blocked-src')).removeAttr('data-is-blocked-src');
  });
  $('.feature-xyz .feature-consent-dialog__blocked').remove();
}

if(featureConsentDialog.checkType('external')){
  featureXYZInit();
}
```

If you need to check for consent-status via PHP you can use this PHP-Method: Please note that this can interfere with your static caching algorythm cause it changes rendered content based on client (dynamic content). Try to exclude the respective subpage from caching if you use this method:

```
if(is_consent_dialog_selected('external')){
  echo render_your_external_script_based_component();
}
```

**Changelog**

2.2.4 (Ben)
- fix php notices on empty user selection

2.2.3 (Ben)
- improve html validity

2.2.2 (Ben)
- fix active functions on deactivated module
- fix json parse error when no optional scripts used

2.2.1 (Ben)
- update core style variables

2.2.0 (Matze)
- reintegrate php $_COOKIE based php-function again for special situations
- improve consent-all consent-group detection
- improve styling
- improve docu in readme
- fix privacy-page detection

2.1.1 (Matze)
- tweaks for bottom-bar display type 

2.1.0 (Matze)
- REMOVE PHP $_COOKIE-based functions because of incompatibility with static cache
- ADD JS function `if(featureConsentDialog.checkType('external'))`

2.0.0 (Matze)
- EXTEND with optional script-group types `external`, `tracking` and `marketing`. Disabled by default.
- ADD function `is_consent_dialog_selected($type)` to check consent state of specific group in PHP
- ADD function `consent_dialog_blocked($type)` to offer blocked content placeholder
- ADD shortcode `[consent_dialog_infotext type="*type*"]` to output specific text on privacy pages

1.0.3 (Ben)
- FIX script version in wp_enqueue_scripts

1.0.2 (Matze)
- CHANGE constants for module_path to wp-specifc functions

1.0.1 (Matze)
- IMPROVE consent redirect to stay an actual (sub)page

