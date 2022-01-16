jQuery(function($) {

  var consentDialog = document.querySelector('.feature-consent-dialog');
  var redirect = window.location.protocol + "//" + window.location.host + "/" + window.location.pathname;

  featureConsentDialog = {
    setCookie: function(cname, cvalue, exdays){
      var d = new Date();
      d.setTime(d.getTime() + (exdays*24*60*60*1000));
      var expires = "expires="+ d.toUTCString();
      document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
    },
    getCookie: function(cname){
      var name = cname + "=";
      var decodedCookie = decodeURIComponent(document.cookie);
      var ca = decodedCookie.split(';');
      for(var i = 0; i <ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
          c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
          return c.substring(name.length, c.length);
        }
      }
      return "";
    },
    checkType: function(type){
      if(featureConsentDialog.getCookie('consent-dialog').indexOf(type) != -1){
        return true;
      }
    },
    updateSelection: function(){
      const scriptGroupElements = document.querySelectorAll('.feature-consent-dialog .feature-consent-dialog__script-groups li input');
      scriptGroupElements.forEach(function(currentValueElement, index, arr){
        if(featureConsentDialog.getCookie('consent-dialog').indexOf(currentValueElement.getAttribute('value')) != -1){
          currentValueElement.setAttribute('checked','checked');
        }
      });
    }
  }

  if(consentDialog){

    if(featureConsentDialog.getCookie('consent-dialog')){
      if(!$('[href*="#consent-dialog"]').length && !$('body.privacy-policy').length) {
        consentDialog.remove();
      }
    } else {
      var expireDays = document.querySelector('.feature-consent-dialog').getAttribute("data-expire");
      consentDialog.classList.add('visible');
      featureConsentDialog.updateSelection();
    }

    $('.feature-consent-dialog__options .consent-all button').click(function(event){
      const scriptGroups = [];
      event.preventDefault();
      $('.feature-consent-dialog__script-groups ul li input[type=checkbox]').each(function($index){
        scriptGroups[$index] = $(this).attr('value');
      });
      featureConsentDialog.setCookie('consent-dialog', JSON.stringify(scriptGroups), expireDays);
      window.location.href = redirect;
    });

    $('.feature-consent-dialog__options .consent-none button').click(function(event){
      const scriptGroups = ['essential'];
      event.preventDefault();
      featureConsentDialog.setCookie('consent-dialog', JSON.stringify(scriptGroups), expireDays);
      window.location.href = redirect;
    });

    $('.feature-consent-dialog__options .consent-selection button').click(function(event){
      const scriptGroups = [];
      event.preventDefault();
      $('.feature-consent-dialog__script-groups ul li input[type=checkbox]:checked').each(function($index){
        scriptGroups[$index] = $(this).attr('value');
      });
      //console.log('scriptGroups',scriptGroups);
      featureConsentDialog.setCookie('consent-dialog', JSON.stringify(scriptGroups), expireDays);
      $('.feature-consent-dialog.is-style-popup').addClass('fadeout');
      window.location.href = redirect;
    });

    $('a[href="#consent-dialog"]').click(function(event){
      event.preventDefault();
      consentDialog.classList.add('visible');
      featureConsentDialog.updateSelection();
    });

    $('.feature-consent-dialog__script-groups li .info-toggle').click(function(event){
      event.preventDefault();
      $(this).parent().parent().find('.info').toggleClass('hide');
    });

    $('.feature-consent-dialog__blocked').parent().css('position','relative');
  }

});
