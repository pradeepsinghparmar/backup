jQuery(document).ready(function() {
        jQuery('.multi_select').selectpicker();
    });
    

$(document).ready(function(){
    $("._sidebar-style li a").on("click", function(){  
         $("._sidebar-style li.active").removeClass("active");  
         $(this).parent().addClass("active");
    }).filter(function(){
        return window.location.href.indexOf($(this).attr('href').trim()) > -1;
    }).click();
});