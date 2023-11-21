<?php

/**
** A base module for the following types of tags:
** 	[digital_signature]  # digital_signature
**/

/* form_tag handler */
if (!defined('ABSPATH')){
	exit;
}


// Use for add form tag signature
add_action( 'wpcf7_init' , 'DSCF7_add_form_tag_signature' , 10, 0 );
function DSCF7_add_form_tag_signature() {
	wpcf7_add_form_tag( array( 'signature', 'signature*' ), 'DSCF7_signature_form_tag_handler',array('name-attr' => true) );
}


// Use for add tag generator signature
add_action( 'wpcf7_admin_init' , 'DSCF7_add_tag_generator_signature' , 18, 0);
function DSCF7_add_tag_generator_signature() {
	$tag_generator = WPCF7_TagGenerator::get_instance();
	$tag_generator->add( 'signature', __( 'digital_signature', 'digital-signature-for-contact-form-7' ) , 'DSCF7_tag_generator_signature' );
}


// Use for signature form tag handler
function  DSCF7_signature_form_tag_handler( $tag ) {
	if ( empty( $tag->name ) ) {
    	return '';
 	}

 	$validation_error = wpcf7_get_validation_error( $tag->name );

	$class = wpcf7_form_controls_class( $tag->type );
	$class .= 'wpcf7-validates-as-signature';

 	$atts = array();
	$atts['class'] = $tag->get_class_option( $class );
	$atts['id'] = $tag->get_id_option();

	$value =(string) reset( $tag->values );  

	if ( $tag->has_option( 'placeholder' ) or $tag->has_option( 'watermark' ) ) {
		$atts['placeholder'] = $value;
		$value = '';
	}

	$value = $tag->get_default_option( $value );
	$value = wpcf7_get_hangover( $tag->name, $value );

	$atts['class'] .= "dscf7-signature";
	$atts['value'] = $value;
	$atts['type'] = 'hidden';
	$atts['name'] = $tag->name;
	$atts = wpcf7_format_atts($atts);

	if( !empty($tag->get_option( 'color' )[0])){
		$attsa['color'] = $tag->get_option( 'color' )[0];
	}else{
		$attsa['color'] = "#000000";
	}
	
	if( !empty($tag->get_option( 'backcolor' )[0])){
		$attsa['backcolor'] = $tag->get_option( 'backcolor' )[0];
	}else{
		$attsa['backcolor']= "#dddddd";
	}
      
	if( !empty($tag->get_option( 'width' )[0])){
		$attsa['width'] = $tag->get_option('width')[0];
	}else{
		$attsa['width']= 400;
	}

	if( !empty($tag->get_option( 'height' )[0])){
		$attsa['height'] = $tag->get_option('height')[0];
	}else{
		$attsa['height']= 200;
	}

	$attsa = wpcf7_format_atts( $attsa );

	$atts_attach['value'] = $tag->has_option( 'attachment' );
	$atts_attach['type'] = 'hidden';
	$atts_attach['name'] = $tag->name . "-attachment";
	$atts_attach = wpcf7_format_atts( $atts_attach );

	/* Inline attributes */
	$atts_inline['value'] = $tag->has_option( 'inline' );
	$atts_inline['type'] = 'hidden';
	$atts_inline['name'] = $tag->name . "-inline";
	$atts_inline = wpcf7_format_atts( $atts_inline );

	$html = sprintf(
		'<div class="dscf7_signature">
			<div class="dscf7_signature_inner">
				<canvas id="digital_signature-pad_%1$s" name="%1$s" class="digital_signature-pad" %4$s></canvas>
				<input class="clearButton" type="button" value="+">
			</div>
			<span class="wpcf7-form-control-wrap %1$s" data-name="%1$s">
				<input %2$s/>
				<input %5$s class="wpcf7_input_%1$s_attachment"/>
				<input %6$s class="wpcf7_input_%1$s_inline"/>%3$s
			</span>
		</div>',sanitize_html_class($tag->name) , $atts, $validation_error ,$attsa ,$atts_attach,$atts_inline);
	return $html;
}


// tag generator signature
function DSCF7_tag_generator_signature( $contact_form, $args = '' ) {
	$args = wp_parse_args( $args, array() );
	$wpcf7_contact_form = WPCF7_ContactForm::get_current();
	$contact_form_tags = $wpcf7_contact_form->scan_form_tags();
	$type = 'signature';
	$description = __( "Generate a form-tag for a signature field.", 'digital-signature-for-contact-form-7' );
 	?>
	<div class="control-box">
		<fieldset>
			<legend><?php echo sprintf( esc_html( $description ) ); ?></legend>
			<table class="form-table">
				<tbody>
					<tr>
						<th scope="row">
							<label for="<?php echo esc_attr( $args['content'] . '-filed_type' ); ?>"><?php echo esc_html( __( 'Field type', 'digital-signature-for-contact-form-7' ) ); ?></label>
						</th>
						<td>
							<input type="checkbox" name="required" class=" required_files" required>
							<label><?php echo esc_html( __( 'Required Field', 'digital-signature-for-contact-form-7' ) ); ?></label>
						</td>
					</tr>
					<tr>
						<th scope="row">
							<label for="<?php echo esc_attr( $args['content'] . '-name' ); ?>"><?php echo esc_html( __( 'Name', 'digital-signature-for-contact-form-7' ) ); ?>
							</label>
						</th>
						<td>
							<input type="text" name="name" class="tg-name oneline" id="<?php echo esc_attr( $args['content'] . '-name' ); ?>" />
						</td>
					</tr>
					<tr>
						<th scope="row">
							<label for="<?php echo esc_attr( $args['content'] . '-color' ); ?>"><?php echo esc_html( __( 'Signature Pen color', 'digital-signature-for-contact-form-7' ) ); ?>
							</label>
						</th>
						<td>
						<input type="color" name="color" class="oneline option color-picker" type="text"  data-alpha="true"  id="<?php echo esc_attr( $args['content'] . '-color' ); ?>" />
						</td>
					</tr>
					<tr>
						<th scope="row">
							<label for="<?php echo esc_attr( $args['content'] . '-backcolor' ); ?>"><?php echo esc_html( __( 'Signature-pad background color', 'digital-signature-for-contact-form-7' ) ); ?>
							</label>
						</th>
						<td>
							<input type="color" name="backcolor" name="color"  type="text"  value="#dddddd"  data-alpha="true"  class="oneline option color-picker" id="<?php echo esc_attr( $args['content'] . '-backcolor' ); ?>" />
						</td>
					</tr>
					<tr>
						<th scope="row">
							<label for="<?php echo esc_attr( $args['content'] . '-width' ); ?>"><?php echo esc_html( __( 'Width', 'digital-signature-for-contact-form-7' ) ); ?>
							</label>
						</th>
						<td>
							<input type="number" name="width" min="1"  value="300" class="numeric option"  id="<?php echo esc_attr( $args['content'] . '-width' ); ?>" />
						
						</td>
					</tr>
					<tr>
						<th scope="row">
							<label for="<?php echo esc_attr( $args['content'] . '-height' ); ?>"><?php echo esc_html( __( 'Height', 'digital-signature-for-contact-form-7' ) ); ?>
							</label>
						</th>
						<td>
							<input type="number" name="height" min="1" value="200" class="numeric option"  id="<?php echo esc_attr( $args['content'] . '-height' ); ?>" />
						</td>
					</tr>
					<tr>
						<th scope="row">
							<label for="<?php echo esc_attr( $args['content'] . '-id' ); ?>"><?php echo esc_html( __( 'Id attribute', 'digital-signature-for-contact-form-7' ) ); ?>
							</label>
						</th>
						<td>
							<input type="text" name="id"  class="idvalue oneline option" id="<?php echo esc_attr( $args['content'] . '-id' ); ?>" />
						</td>
					</tr>
					<tr>
						<th scope="row">
							<label for="<?php echo esc_attr( $args['content'] . '-class' ); ?>"><?php echo esc_html( __( 'Class attribute', 'digital-signature-for-contact-form-7' ) ); ?>
							</label>
						</th>
						<td>
							<input type="text" name="class" class="classvalue oneline option" id="<?php echo esc_attr( $args['content'] . '-class' ); ?>" />
						</td>
					</tr>
				</tbody>
			</table>
		</fieldset>
	</div>
	<div class="insert-box">
		<input type="text" name="<?php echo $type; ?>" class="tag code" readonly="readonly" onfocus="this.select()"/>
     	<div class="submitbox">
			<input type="button" class="button button-primary insert-tag" value="<?php echo esc_attr( __( 'Insert Tag', 'digital-signature-for-contact-form-7' ) ); ?>" />
		</div>
    	<br class="clear" />
		<p class="description mail-tag">
			<label for="<?php echo esc_attr( $args['content'] . '-mailtag' ); ?>"><?php echo sprintf( esc_html( __( "To use the value input through this field in a mail field, you need to insert the corresponding mail-tag (%s) into the field on the Mail tab.", 'digital-signature-for-contact-form-7' ) ), '<strong><span class="mail-tag"></span></strong>' ); ?>
				<input type="text" class="mail-tag code hidden" readonly="readonly" id="<?php echo esc_attr( $args['content'] . '-mailtag' ); ?>" />
			</label>
		</p>
	</div>
 	<?php  
}

// Use for manage signature data
add_filter('wpcf7_posted_data', 'DSCF7_manage_signature_data' );
function DSCF7_manage_signature_data ($posted_data) {

	foreach ($posted_data as $key => $data) {
		if (is_string($data) && strrpos($data, "data:image/png;base64", -strlen($data)) !== FALSE){	      
  			$data_pieces = explode(",", $data);
			$encoded_image = $data_pieces[1];
			$decoded_image = base64_decode($encoded_image);
			$filename = sanitize_file_name(wpcf7_canonicalize($key."-".time().".png"));
			$dscf7_signature_dir = trailingslashit(DSCF7_signature_dir());

			// Do we need to treat it as attachement ?
			$is_attachment = $posted_data[$key."-attachment"];

			if (empty($posted_data[$key."-attachment"])){
	        	// Preparing to send signature as attachement
	        	wpcf7_init_uploads(); // Confirm upload dir
				$uploads_dir = wpcf7_upload_tmp_dir();
				$uploads_dir = wpcf7_maybe_add_random_dir( $uploads_dir );
				$filename = wp_unique_filename( $uploads_dir, $filename );
				$filepath = trailingslashit( $uploads_dir ) . $filename;

	       		// Writing signature
	        	if ( $handle = @fopen( $filepath, 'w' ) ) {
					fwrite( $handle, $decoded_image );
					fclose( $handle );
		        	@chmod( $filepath, 0400 ); // Make sure the uploaded file is only readable for the owner process
				}

				if (file_exists($filepath)){
        			$posted_data[$key."-attachment"] = $filepath;
	        	}else{
	        		error_log("Cannot create signature file as attachment : ".$filepath);
	        	}

        		// Sending signature asa server image

	        	if( !file_exists( $dscf7_signature_dir ) ){ // Creating directory and htaccess file
		    		if (wp_mkdir_p( $dscf7_signature_dir )){
		    			$htaccess_file = $dscf7_signature_dir . '.htaccess';
						if ( !file_exists( $htaccess_file ) && $handle = @fopen( $htaccess_file, 'w' ) ) {
							fwrite( $handle, 'Order deny,allow' . "\n" );
							fwrite( $handle, 'Deny from all' . "\n" );
							fwrite( $handle, '<Files ~ "^[0-9A-Za-z_-]+\\.(png)$">' . "\n" );
							fwrite( $handle, '    Allow from all' . "\n" );
							fwrite( $handle, '</Files>' . "\n" );
							fclose( $handle );
						}
		    		}
	        	}

	        	$filepath = wp_normalize_path( $dscf7_signature_dir . $filename );

	       		// Writing signature
         		if ( $handle = @fopen( $filepath, 'w' ) ) {
					fwrite( $handle, $decoded_image );
					fclose( $handle );
	        		@chmod( $filepath, 0644 );
				}

				if (file_exists($filepath)){
				  	$fileurl = DSCF7_signature_url($filename);
					$posted_data[$key] = $fileurl;
				}else{
					error_log("Cannot create signature file : ".$filepath);
				}
        	}   
		}
	}
	return $posted_data;
}

// Use for validate signature
add_filter( 'wpcf7_validate_signature' , 'wpcf7_signature_validation_filter' , 10, 2 );
add_filter( 'wpcf7_validate_signature*' , 'wpcf7_signature_validation_filter' , 10, 2 );	
function wpcf7_signature_validation_filter( $result, $tag ) {

	$dscf7data_image = sanitize_text_field($_POST[$tag->name]);
	$value = isset( $_POST[$tag->name] )	? trim( strtr( (string) $dscf7data_image, "\n", " " ) ) : '';
	if ( 'signature' == $tag->basetype ) {
		if ( $tag->is_required() and '' === $value ) {
			$result->invalidate( $tag, wpcf7_get_message( 'invalid_required' ) );
		}
	}
	return $result;
}


// Use for signature dir path

function DSCF7_signature_dir() {
	return wpcf7_upload_dir( 'dir' ) . '/dscf7_signatures';
}

// Use for signature url
function DSCF7_signature_url( $filename ) {
	return wpcf7_upload_dir( 'url' ) . '/dscf7_signatures/'. $filename;
}
