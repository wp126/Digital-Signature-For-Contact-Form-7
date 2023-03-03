jQuery(document).ready(function() {

    // send mail then signature pad is cleard
    document.addEventListener( 'wpcf7mailsent', function( event ) {
        jQuery('.dscf7_signature').each( function(){
            var dsname=jQuery(this).find(".digital_signature-pad").attr("name");
            var bgcolor=jQuery(this).find(".digital_signature-pad").attr("backcolor");
            var pencolor=jQuery(this).find(".digital_signature-pad").attr("color");

            var dsPad = new SignaturePad(document.getElementById("digital_signature-pad_"+dsname), {
                backgroundColor: bgcolor,
                penColor: pencolor,
            });

            var dsname = jQuery(this).find(".digital_signature-pad").attr("name");
            dsPad.clear();
            jQuery("input[name="+dsname+"]").val("");
        });
    }, false );

    // for signature pad
    $x = 1;
    jQuery('.dscf7_signature').each( function(){
        if($x == 1){
            var current = jQuery(this);
            var dsname = current.find(".digital_signature-pad").attr("name");
            var signaturepadheight = current.find(".digital_signature-pad").attr("height");
            var signaturepadwidth = current.find(".digital_signature-pad").attr("width");
            var bgcolor = current.find(".digital_signature-pad").attr("backcolor");
            var pencolor = current.find(".digital_signature-pad").attr("color");
            var canvas = document.getElementById("digital_signature-pad_"+dsname);

            canvas.setAttribute("height", signaturepadheight);
            canvas.setAttribute("width", signaturepadwidth);

            var dsPad = new SignaturePad(document.getElementById("digital_signature-pad_"+dsname), {
                backgroundColor: bgcolor,
                penColor: pencolor,
            });

            jQuery(document).on('touchstart touchend click', "#digital_signature-pad_"+dsname, function(event){
                if(event.handled === false) return
                event.stopPropagation();
                event.preventDefault();
                event.handled = true;
                // Do your magic here
                var dsimgdata = dsPad.toDataURL('image/png');
                jQuery("input[name="+dsname+"]").val(dsimgdata);
            });

            jQuery(current).find(".clearButton").click(function(){
                dsPad.clear();
                jQuery("input[name="+dsname+"]").val("");
            });
        } else {
            jQuery(this).html("<p>Multiple Signaturepad is Valid in pro version of signature contact form 7 <a href='https://www.plugin999.com/plugin/digital-signature-for-contact-form-7/' target='_blank'>Click here Get Pro Version</a></p>");
        }
        $x++;
    });
});