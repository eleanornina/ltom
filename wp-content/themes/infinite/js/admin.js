jQuery(document).ready(function($) {

    // Color Scheme Options - These array names should match
    // the values in color_scheme of options.php

    var lightBlue = new Array(); lightBlue['link_color']='#26ade5';
    var pink = new Array(); pink['link_color']='#fc51a0';
    var purple = new Array(); purple['link_color']='#51106a';
    var alizarin  = new Array(); alizarin ['link_color'] = '#e84c3d';
    var belizeHole  = new Array(); belizeHole ['link_color'] = '#2a80b9';
    var emerald  = new Array(); emerald ['link_color'] = '#2ecd71';
    var nephritis  = new Array(); nephritis ['link_color'] = '#27ae5f';
    var pumpkin  = new Array(); pumpkin ['link_color'] = '#d25400';



    // When the select box #base_color_scheme changes
    // of_update_color updates each of the color pickers
    $('#section-color_scheme img').click(function() {
        colorscheme = $(this).prev().html();
        if (colorscheme == 'light-blue') { colorscheme = lightBlue; }
        if (colorscheme == 'pink') { colorscheme = pink; }
        if (colorscheme == 'purple') { colorscheme = purple; }
        if (colorscheme == 'alizarin') { colorscheme = alizarin ; }
        if (colorscheme == 'belize-hole') { colorscheme = belizeHole ; }
        if (colorscheme == 'emerald') { colorscheme = emerald ; }
        if (colorscheme == 'nephritis') { colorscheme = nephritis ; }
        if (colorscheme == 'pumpkin') { colorscheme = pumpkin ; }

        for (id in colorscheme) {
            of_update_color(id,colorscheme[id]);
        }
    });
    
    
    function of_update_color(id,hex) {
        $('#'+id).val(hex);
    }

});
