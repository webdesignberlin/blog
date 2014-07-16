/* + document ready */
$(document).ready(function() {
    /* + Collapse */
    function loadCollapseScript() {
        if ( $('.collapse').length == 0) {
        }else {
            $.getScript("/assets/js/modules/transition.min.js");
            $.getScript("/assets/js/modules/collapse.min.js", function () {
                //console.log('Load collapse script');
                //$('.collapse').collapse();
            });
        }
    };
    loadCollapseScript();
    /* = Collapse */
});
/* = document ready */