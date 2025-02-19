function ada_get_Cookie(name) {


  var nameEQ = name + "=";


  var ca = document.cookie.split(';');


  for (var i = 0; i < ca.length; i++) {


    var c = ca[i];


    while (c.charAt(0) == ' ') {


      c = c.substring(1, c.length);


    }


    if (c.indexOf(nameEQ) == 0) {


      return c.substring(nameEQ.length, c.length);


    }


  }


  return null;


}





function ada_store_Setting() {





  var ada_expires = "";


  if (1) {


    var date = new Date();


    date.setTime(date.getTime() + (365 * 24 * 60 * 60 * 1000));


    ada_expires = "; expires=" + date.toUTCString();


  }


  document.cookie = "ada_Setting=" + (JSON.stringify(ada_menu_setting) || "") + ada_expires + "; path=/";





  //console.log(JSON.stringify(ada_menu_setting));


}





function setMenuHeight(){


 // jQuery("body").css("padding-top", jQuery("#accessibility_settings").css('height'));





  if(jQuery("html").hasClass("text-only")) {


    jQuery("body img").each(function(){


      jQuery(this).parent().attr("style","border:1px solid #000 !important");


    });


    jQuery("body svg").each(function(){


      jQuery(this).parent().attr("style","border:1px solid #000 !important");


    });


  }


  else {


    jQuery("body img").each(function(){


      jQuery(this).parent().attr("style","border:0px solid #000 !important");


    });


    jQuery("body svg").each(function(){


      jQuery(this).parent().attr("style","border:0px solid #000 !important");


    });


  }








}





function ada_currentfontstyle() {


  delete ada_menu_setting.small;


  delete ada_menu_setting.large;


  delete ada_menu_setting.default;


  jQuery(".fontsize").each(function (index) {


    if (jQuery(this).hasClass("active")) {


      switch (index) {


        case 0:





          //console.log(index);


          ada_menu_setting.small = "active";


          ada_menu_setting.font = "small-fonts";


          break;


        case 1:


          //console.log(index);


          ada_menu_setting.default = "active";


          ada_menu_setting.font = "";


          break;


        case 2:





          //console.log(index);


          ada_menu_setting.large = "active";


          ada_menu_setting.font = "large-fonts";


          break;


      }


    }


  })





}





var tags = ["blockquote", "th", "small", "em", "i", "b", "u", "select", "textarea", "button", "del", "div", "header", "a", "li", "span", "h1", "h2", "h3", "h4", "h5", "h6", "p", "td"];








var ada_menu_setting = {};


var ada_existing_setting = ada_get_Cookie("ada_Setting");


if (ada_existing_setting != null) {


  ada_menu_setting = JSON.parse(ada_existing_setting);


  //console.log("Reading:"+JSON.stringify(ada_menu_setting));


  //console.log(ada_menu_setting.font);


  //console.log(ada_menu_setting.html);


}





function setDefaultSize() {


  jQuery.each(tags, function (key, value) {


    //console.log(value);


    jQuery(value).each(function () {


      jQuery(this).attr("data-orgsize", parseFloat(jQuery(this).css('font-size')));


    })


  })


  setMenuHeight()


}





function setsmallSize() {


  jQuery.each(tags, function (key, value) {


    //console.log(value);


    jQuery(value).each(function () {


      jQuery(this).css('font-size', (parseFloat(jQuery(this).attr("data-orgsize")) * 90 / 100) + 'px');


    })


  })


  setMenuHeight()


}





function setlargeSize() {


  jQuery.each(tags, function (key, value) {





    jQuery(value).each(function () {


      jQuery(this).css('font-size', (parseFloat(jQuery(this).attr("data-orgsize")) * 125 / 100) + 'px');


    })


  })


  setMenuHeight()


}





function setorgSize() {


  jQuery.each(tags, function (key, value) {





    jQuery(value).each(function () {


      jQuery(this).css('font-size', jQuery(this).attr("data-orgsize") + 'px');


    })


  })


}








jQuery(document).ready(function () {


  jQuery(".accessibility-trigger button").click(function () {
    jQuery(this).attr("aria-pressed","true");
    jQuery(".accessibility-settings-modal").attr("aria-expanded", "true");
  });

  jQuery(".accessibility-modal-close-button").click(function () {
    jQuery(".accessibility-trigger button").attr("aria-pressed", "false");
    jQuery(".accessibility-settings-modal").attr("aria-expanded", "false");
  });

  jQuery(".accessibility-modal-reset-button").click(function(){
    jQuery(".defaultStyles").trigger("click");
	jQuery(".fontsize-default").trigger("click");
  })
  



  jQuery(".defaultStyles").click(function () {





    jQuery("html").removeClass("high-contrast");


    jQuery("html").removeClass("text-only");


    jQuery(".highContrast").removeClass("active");


    jQuery(".textOnly").removeClass("active");


    jQuery(this).addClass("active");


    jQuery(".accessibility-buttons a").css("background-color","");


    ada_menu_setting = {};


    ada_menu_setting.defaultStyles = "active";


    ada_currentfontstyle();


    ada_store_Setting();


    setMenuHeight()











  });


  jQuery(".highContrast").click(function () {


    jQuery("html").addClass("high-contrast");


    jQuery(this).addClass("active");


    jQuery("html").removeClass("text-only");


    jQuery(".defaultStyles").removeClass("active");


    jQuery(".textOnly").removeClass("active");


    jQuery(".accessibility-buttons a").css("background-color","");





    ada_menu_setting = {};


    ada_menu_setting.html = "high-contrast";


    ada_menu_setting.highContrast = "active";


    ada_currentfontstyle();


    ada_store_Setting()


    setMenuHeight()


  });


  jQuery(".textOnly").click(function () {


    jQuery("html").addClass("text-only");


    jQuery(this).addClass("active");


    jQuery("html").removeClass("high-contrast");


    jQuery(".defaultStyles").removeClass("active");


    jQuery(".highContrast").removeClass("active");


    jQuery(".accessibility-buttons a").css("background-color","");





    ada_menu_setting = {};


    ada_menu_setting.html = "text-only";


    ada_menu_setting.textOnly = "active";


    ada_currentfontstyle();


    ada_store_Setting();


    setMenuHeight()


  })








  jQuery(".fontsize-default").click(function () {


    jQuery("html").removeClass("small-fonts");


    jQuery("html").removeClass("large-fonts");


    jQuery(".fontsize-small").removeClass("active");


    jQuery(".fontsize-large").removeClass("active");


    jQuery(this).addClass("active");


    ada_currentfontstyle();


    ada_store_Setting();


    setorgSize();


    setMenuHeight()





  });





  jQuery(".fontsize-small").click(function () {


    jQuery("html").addClass("small-fonts");


    jQuery("html").removeClass("large-fonts");


    jQuery(".fontsize-default").removeClass("active");


    jQuery(".fontsize-large").removeClass("active");


    jQuery(this).addClass("active");


    ada_currentfontstyle();


    ada_store_Setting();


    setsmallSize();


  });





  jQuery(".fontsize-large").click(function () {


    jQuery("html").removeClass("small-fonts");


    jQuery("html").addClass("large-fonts");


    jQuery(".fontsize-default").removeClass("active");


    jQuery(".fontsize-small").removeClass("active");


    jQuery(this).addClass("active");


    ada_currentfontstyle();


    ada_store_Setting();


    setlargeSize();


  });








  setDefaultSize();





});


jQuery(window).resize(function(){


  setMenuHeight();


})