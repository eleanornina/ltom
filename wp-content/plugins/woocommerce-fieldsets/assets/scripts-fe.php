<?php 
echo "jQuery(document).ready(function() {
";
if(isset($_GET['f'])) { $f=$_GET['f'];
echo "
    jQuery('.wooaoi-date').datepicker({
        dateFormat : '".$f."'
    });
	
"; }

if(isset($_GET['c'])) {
echo "
    jQuery('.wooaoi-color').wpColorPicker();
"; }

echo "


});

";
if(isset($_GET['p'])) { $p=$_GET['p'];
echo "
function validatePass(p1, p2) {
	

	var p1=jQuery('input[type=\"password\"]').first().val();


    if (p1 != p2.value || p1 == '' || p2.value == '') {
        p2.setCustomValidity('".$p."');
    } else {
        p2.setCustomValidity('');
    }
}

";
}
?>