document.addEventListener("DOMContentLoaded", function() {

    function getCookie(cname) {
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
    }

    if(getCookie('consent-dialog').length){

      const $scriptGroups = JSON.parse(getCookie('consent-dialog'));
      $scriptGroups.forEach(function(currentValueType, index, arr){
        jQuery.ajax({
          url: optional_scripts.ajaxurl,
          method: "POST",
          data: {
            'action': 'feature_consent_dialog_load_scripts',
            'nonce' : optional_scripts.nonce,
            'type' : currentValueType
          },
          success:function(data) {
            try {
              jQuery('head').append('<script>'+JSON.parse(data)+'</script>');
            }
            catch (e) {
            }
          },
          error: function(errorThrown){
            console.log(errorThrown);
          }
        });

      });
    }

});


