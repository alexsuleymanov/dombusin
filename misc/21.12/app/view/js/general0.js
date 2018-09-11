/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2005 osCommerce

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License v2 (1991)
  as published by the Free Software Foundation.
*/

function updateDatePullDownMenu(objForm, fieldName) {
  var pdmDays = fieldName + "_days";
  var pdmMonths = fieldName + "_months";
  var pdmYears = fieldName + "_years";

  time = new Date(objForm[pdmYears].options[objForm[pdmYears].selectedIndex].text, objForm[pdmMonths].options[objForm[pdmMonths].selectedIndex].value, 1);

  time = new Date(time - 86400000);

  var selectedDay = objForm[pdmDays].options[objForm[pdmDays].selectedIndex].text;
  var daysInMonth = time.getDate();

  for (var i=0; i<objForm[pdmDays].length; i++) {
    objForm[pdmDays].options[0] = null;
  }

  for (var i=0; i<daysInMonth; i++) {
    objForm[pdmDays].options[i] = new Option(i+1);
  }

  if (selectedDay <= daysInMonth) {
    objForm[pdmDays].options[selectedDay-1].selected = true;
  } else {
    objForm[pdmDays].options[daysInMonth-1].selected = true;
  }
}

function rowOverEffect(object) {
  if (object.className == 'moduleRow') object.className = 'moduleRowOver';
}

function rowOutEffect(object) {
  if (object.className == 'moduleRowOver') object.className = 'moduleRow';
}

function checkBox(object) {
  document.account_newsletter.elements[object].checked = !document.account_newsletter.elements[object].checked;
}

function popupWindow(url, name, params) {
  window.open(url, name, params).focus();
}

$(window).bind('load',function(){
  if($('.line').length){
     $('.line').each(function(){
            if($('.tovar-img img',this).length){
                var maxHght = 0;
                var item    = this;
                $('.tovar-img img',item).each(function(){
                    maxHght = this.offsetHeight && this.offsetHeight > maxHght ? this.offsetHeight : maxHght;
                    if(!this.offsetHeight){
                        maxHght = this.height && this.height > maxHght ? this.height : maxHght;
                    };
                });

                maxHght   = !maxHght ? 120 : maxHght;

                if(maxHght){
                  maxHght += 5;
                  $('.tovar-img',item).css('height',maxHght + 'px');

                }

            };

            if($('.tovar-l>p',this).length){
                var maxHght = 0;
                var item    = this;
                $('.tovar-l>p',item).each(function(){
                    maxHght = this.offsetHeight && this.offsetHeight > maxHght ? this.offsetHeight : maxHght;
                });

                if(maxHght){
                  maxHght += 5;
                  $('.tovar-l>p',item).css('height',maxHght + 'px');

                };

            };

            if($('.tovar-l>.productListing-data.name',this).length){
                var maxHght = 0;
                var item    = this;
                $('.tovar-l>.productListing-data.name',item).each(function(){
                    maxHght = this.offsetHeight && this.offsetHeight > maxHght ? this.offsetHeight : maxHght;
                });

                if(maxHght){
                  maxHght += 5;
                  $('.tovar-l>.productListing-data.name',item).css('height',maxHght + 'px');

                };

            };

            if($('.tovar-l>.productListing-data.price',this).length){
                var maxHght = 0;
                var item    = this;
                $('.tovar-l>.productListing-data.price',item).each(function(){
                    maxHght = this.offsetHeight && this.offsetHeight > maxHght ? this.offsetHeight : maxHght;
                });

                if(maxHght){
                  maxHght += 5;
                  $('.tovar-l>.productListing-data.price',item).css('height',maxHght + 'px');

                };

            };
     });
  }
});
