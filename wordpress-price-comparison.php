<?php
/**
 * Plugin Name: Wordpress Price Comparison Pro
 * Plugin URI: http://www.affiliatewebdesigners.com
 * Description: Adds price comparison to Woocommerce.
 * Version: 1.0
 * Author: Dave Hilditch
 * Author URI: http://www.affiliatewebdesigners.com	
 * License: GPL
 */
 
 // Display Fields
add_action( 'woocommerce_product_options_general_product_data', 'price_comparison_add_custom_general_fields' );

function price_comparison_add_custom_general_fields() {
 
  global $woocommerce, $post;
  
  echo '<div class="options_group price-comparison-group">';
  
  // Custom fields will be created here...
  
  echo '<div class="pcurl"><div class="price-comparison-url">';
  woocommerce_wp_text_input( 
	array( 
		'id'          => 'producturl1', 
		'label'       => __( 'Product URL 1', 'woocommerce' ), 
		'placeholder' => 'http://',
		'desc_tip'    => 'true',
		'description' => __( 'Enter the URL for this product from any website', 'woocommerce' ) 
	));
	echo '</div></div>';
//	echo '<input class="configure-price-comparison" type="button" value="Configure"></div></div>';
  echo '<div class="pcurl"><div class="price-comparison-url">';
  woocommerce_wp_text_input( 
	array( 
		'id'          => 'producturl2', 
		'label'       => __( 'Product URL 2', 'woocommerce' ), 
		'placeholder' => 'http://',
		'desc_tip'    => 'true',
		'description' => __( 'Enter the URL for this product from any website', 'woocommerce' ) 
	));
	echo '</div></div>';
//	echo '<input class="configure-price-comparison" type="button" value="Configure"></div></div>';
  echo '<div class="pcurl"><div class="price-comparison-url">';
  woocommerce_wp_text_input( 
	array( 
		'id'          => 'producturl3', 
		'label'       => __( 'Product URL 3', 'woocommerce' ), 
		'placeholder' => 'http://',
		'desc_tip'    => 'true',
		'description' => __( 'Enter the URL for this product from any website', 'woocommerce' ) 
	));
	echo '</div></div>';
//	echo '<input class="configure-price-comparison" type="button" value="Configure"></div></div>';
  echo '<div class="pcurl"><div class="price-comparison-url">';
  woocommerce_wp_text_input( 
	array( 
		'id'          => 'producturl4', 
		'label'       => __( 'Product URL 4', 'woocommerce' ), 
		'placeholder' => 'http://',
		'desc_tip'    => 'true',
		'description' => __( 'Enter the URL for this product from any website', 'woocommerce' ) 
	));
	echo '</div></div>';
//	echo '<input class="configure-price-comparison" type="button" value="Configure"></div></div>';
  
  echo '</div>';
	
}
// Save Fields
add_action( 'woocommerce_process_product_meta', 'price_comparison_add_custom_general_fields_save' );

function price_comparison_add_custom_general_fields_save( $post_id ){
	
	// Text Field
	$woocommerce_text_field = $_POST['producturl1'];
	if( !empty( $woocommerce_text_field ) )
		update_post_meta( $post_id, 'producturl1', esc_attr( $woocommerce_text_field ) );
		
	// Number Field
	$woocommerce_text_field = $_POST['producturl2'];
	if( !empty( $woocommerce_text_field ) )
		update_post_meta( $post_id, 'producturl2', esc_attr( $woocommerce_text_field ) );

	$woocommerce_text_field = $_POST['producturl3'];
	if( !empty( $woocommerce_text_field ) )
		update_post_meta( $post_id, 'producturl3', esc_attr( $woocommerce_text_field ) );

	$woocommerce_text_field = $_POST['producturl4'];
	if( !empty( $woocommerce_text_field ) )
		update_post_meta( $post_id, 'producturl4', esc_attr( $woocommerce_text_field ) );
		
}

function pricecomparison_scripts() {
	wp_enqueue_style( 'price-comparison-style', plugins_url('price-comparison-style.css', __FILE__)  );
	wp_enqueue_script( 'price-comparison-script', plugins_url('price-comparison.js', __FILE__));
 }

add_action( 'wp_enqueue_scripts', 'pricecomparison_scripts');
add_action('admin_enqueue_scripts', 'pricecomparison_scripts');

add_action('woocommerce_single_product_summary', 'pricecomparison_productsummary');

function pricecomparison_productsummary() {
	global $product;
	$options = get_option( 'wppc_settings' );

	//todo: load url1,url2,url3,url4 images
	$url1 = get_post_meta( $product->id, 'producturl1', true );
	$url2 = get_post_meta( $product->id, 'producturl2', true );
	$url3 = get_post_meta( $product->id, 'producturl3', true );
	$url4 = get_post_meta( $product->id, 'producturl4', true );
	
	$websiteconfig = json_decode($options['websites']);
	$urls = array (
		array('url' => $url1, 'domain' => parse_url($url1)['host']),
		array('url' => $url2, 'domain' => parse_url($url2)['host']),
		array('url' => $url3, 'domain' => parse_url($url3)['host']),
		array('url' => $url4, 'domain' => parse_url($url4)['host'])
	);

	?>
		<style>
	.pricecomparisonwidget .pcmerchantlogo img {
		max-width:100%;
		max-height:100%;
	}
	.pricecomparisonwidget .pcmerchantlogo {
		height:25px;
		width:70px;
		overflow:hidden;
		display:inline-block;
		background: white;
		padding: 2px 5px 3px 0px;
		text-align: left;		
	}
	.pricecomparisonwidget .pcprice {
		display:inline-block;
		position: absolute;
		top: 8px;
		right:0px;
		font-size: 14px;
		margin-left:10px;
		line-height:14px;
	}
	.pricecomparisonwidget {
		float: right;
		padding: 10px;
		margin-left: 10px;
		margin-bottom: 10px;
		border:1px solid #eee;
		border-radius:5px;
	}
	.pricecomparisonwidget h2 {
		font-size: 18px;
		font-weight: bold;
	}

	.pricecomparisonwidget > div {
		position:relative;
	}
	</style>
	<div class="pricecomparisonwidget"><h2>Price Comparison</h2>
	<?php
	foreach($urls as $url) {
		echo '<div class="pcresult"><a target="_blank" href="http://go.skimlinks.com/?id=' . $options['skimlinksid'] . '&xs=1&url=' . urlencode($url['url']) . '">';
//		echo '<pre>' . print_r($websiteconfig, true) . '</pre>';
		if (isset($websiteconfig->$url['domain']->logourl)) {
			echo '<span class="pcmerchantlogo"><img src="' . $websiteconfig->$url['domain']->logourl . '" ></span>';
		} else {
			echo '<span class="pcmerchantlogo">' . str_replace('www.', '', $url['domain']) . '</span>';
		}
		echo '<span class="pcprice" data-domain="' . $url['domain'] . '">Checking...</span></a></div>';
	}
	echo '</div>';

	?>
	
	<script language="javascript" type="text/javascript">
		var urls = <?php echo json_encode($urls); ?>;
		var pcwebsiteconfig = <?php echo $options['websites']; ?>;
		jQuery.each(urls, function() {
			var data = {};
//			console.log(this.domain);
//			console.log(this.url);
			data.url = this.url;
			data.domain = this.domain;
			var prices = [];
			var priceindex = 0;
			jQuery.ajax(
				{
					url: "<?php echo admin_url('admin-ajax.php'); ?>",
					data: {
						action: "pcfetchprice",
						fetchurl: data.url
					},
					success: function(resultsdata) {

						if (pcwebsiteconfig[data.domain] ) {
//							console.log ("***" + pcwebsiteconfig[data.domain] + "***");
							jQuery('.pcprice[data-domain="' + data.domain + '"]').html( jQuery(resultsdata).find(pcwebsiteconfig[data.domain].priceselector).html() );
						} else { // else use default scraper
							console.log (data.domain + ': using default processor...');
							//get biggest price on the page
/*							jQuery(".price, .main *", resultsdata)
								.filter(function() {
									console.log('.');
									if (jQuery(this).text().trim().charAt(0) == '£') { //todo: check for more currencies - use a library to tell if text is a currency value
										return true;
									} else {
										return false;
									}
								})
								.each(function() {
									console.log('found currency');
									console.log('**' + jQuery(this).text() + ' : ' + jQuery(this).css('font-size') + 'px');
								});
*/
//							jQuery('.pcprice[data-domain="' + data.domain + '"]').html(jQuery("h1", resultsdata).closest(":contains('£')").text());

							var searchcontext = jQuery('h1', resultsdata);
							var maxlevels = 50;
							while (jQuery('*', searchcontext).filter(function() { return jQuery(this).text().trim().charAt(0) == '£'; }).length == 0 && maxlevels > 0) {
								searchcontext = searchcontext.parent();
								maxlevels--;
								console.log ('went up one level');
							}
							var productprice;
							jQuery('*', searchcontext).filter(function() { return jQuery(this).text().trim().charAt(0) == '£'; }).each(function() {
								console.log ("FOUND CURRENCY VALUE");
								console.log (jQuery(this).text().trim());
								if (jQuery(this).css('text-decoration') != 'line-through') {
									productprice = jQuery(this).text().trim();
									return false;
								}
							});
							jQuery('.pcprice[data-domain="' + data.domain + '"]').html(productprice);
							
						}
					}
			});		
		});
	</script>	

	<?php
}
// Same handler function...
add_action('wp_ajax_pcfetchprice', 'pricecomparison_fetchprice');
add_action('wp_ajax_nopriv_pcfetchprice', 'pricecomparison_fetchprice');
function pricecomparison_fetchprice() {
	global $wpdb;
	$url = $_REQUEST['fetchurl'];
//	echo 'HELLo';
	echo file_get_contents($url);	
	die();
}

add_action( 'admin_menu', 'wppc_add_admin_menu' );
add_action( 'admin_init', 'wppc_settings_init' );


function wppc_add_admin_menu(  ) { 

	add_options_page( 'Wordpress Price Comparison', 'Wordpress Price Comparison', 'manage_options', 'wordpress_price_comparison', 'wppc_options_page' );

}


function wppc_settings_init(  ) { 

	register_setting( 'pluginPage', 'wppc_settings' );

	add_settings_section(
		'wppc_pluginPage_section', 
		__( 'Configure the CSS selectors to pull the prices from each website', 'wordpress' ), 
		'wppc_settings_section_callback', 
		'pluginPage'
	);

	$options = get_option('wppc_settings');
	if (!isset($options['websites'])) {
		$options['websites'] = json_encode(
		array(
			"www.amazon.co.uk" => array(
				"logourl" => "http://library.corporate-ir.net/library/17/176/176060/mediaitems/93/a.com_logo_RGB.jpg",
				"priceselector" => "#priceblock_ourprice"
			),
			"www.ebay.co.uk" => array(
				"logourl" => "http://upload.wikimedia.org/wikipedia/commons/thumb/1/1b/EBay_logo.svg/2000px-EBay_logo.svg.png",
				"priceselector" => "#prcIsum"
			),
			"www.maplin.co.uk" => array(
				"logourl" => "http://upload.wikimedia.org/wikipedia/commons/thumb/e/e4/Maplin_Electronics_logo.svg/500px-Maplin_Electronics_logo.svg.png",
				"priceselector" => "#product-ctas .new-price"
			),
			"www.tmart.com" => array(
				"logourl" => "http://static.image-tmart.com/includes/view_controller/tmart/views/static/images/base/logo.gif",
				"priceselector" => "form[name=form5] .J_pprice .font-red"
			)
		));
	}	
	
	update_option('wppc_settings', $options);
}




function wppc_options_page(  ) { 
	$options = get_option( 'wppc_settings' );

	echo "<pre>" . print_r($options,true) . "</pre>";
	?>
	<form action='options.php' method='post'>
		
		<h2>Wordpress Price Comparison</h2>
		<p>Enter your Skimlinks affiliate ID here. Log into your Skimlinks hub, visit Toolbox -> Tools -> Link Generator. Enter any URL (e.g. www.google.com) and you'll see something like the following:</p>
		<pre>http://go.redirectingat.com?id=<strong>76167X1526475</strong>&xs=1&url=http%3A%2F%2Fwww.google.com</pre>
		<p>The part in bold above will be your Skimlinks affiliate ID. Enter it below. If you do not have a Skimlinks account, <a href="http://go.skimlinks.com/?id=76167X1526475&xs=1&url=http://skimlinks.com/signup">sign up here</a>.</p>
		<p><input type="text" id="skimlinksid" placeholder="Skimlinks ID" value="<?php echo $options['skimlinksid']; ?>"></p>
		<p>Add logos for each website and CSS selectors to identify the price for products on the page</p>
			
		<div id="pcwebsites"></div>
		<div style="clear:both"><input type="button" id="pcaddnew" value="Add website"></div>
		<div style="clear:both"><input type="button" id="pcsave" value="Save"></div>
		<style>
			#pcwebsites input {
				float:left;
				width:250px;
				margin-right:20px;
			}
			#pcwebsites input[type=button] {
				width: 25px;
				border-radius: 50%;
				border: none;
				height: 25px;
			}
		</style>
		<script>
			var pcwebsites = <?php echo $options['websites']; ?>;
			console.log (pcwebsites["www.amazon.co.uk"]);
			for (var domain in pcwebsites) {
			  if (pcwebsites.hasOwnProperty(domain)) {
				console.log (domain + " -> " + pcwebsites[domain].logourl + ", " + pcwebsites[domain].priceselector);
				jQuery('#pcwebsites').append('<div><input style="clear:left" type="text" value="' + domain + '"><input type="text" value="' + pcwebsites[domain].logourl + '"><input type="text" value="' + pcwebsites[domain].priceselector + '"><input type="button" class="pcdelete" value="x"></div>');
			  }
			}
			jQuery('#pcaddnew').click(function() {
				jQuery('#pcwebsites').append('<div><input style="clear:left" type="text"><input type="text"><input type="text"><input type="button" class="pcdelete" value="x"></div>');
			});
			jQuery(document).on('click', '.pcdelete', function() {
				jQuery(this).parent().remove();
			});
			jQuery('#pcsave').click(function() {
				var newpcwebsites = {};
				jQuery('#pcwebsites div').each(function() {
					var newpcwebsite = {};
					newpcwebsite.logourl = jQuery(this).find('input:eq(1)').val();
					newpcwebsite.priceselector = jQuery(this).find('input:eq(2)').val();
					newpcwebsites[jQuery(this).find('input:eq(0)').val()] = newpcwebsite;
				});
				console.log (newpcwebsites);
				//todo 1: create ajax function to save the websites to the options
				//todo 2: call ajax function to save the websites to the options
				jQuery.ajax(
					{
						url: "<?php echo admin_url('admin-ajax.php'); ?>",
						data: {
							action: "pcsavewebsiteconfig",
							websiteconfig: newpcwebsites,
							skimlinksid: jQuery('#skimlinksid').val()
						},
						success: function(resultsdata) {
							alert('saved'); // refresh the page?
							//jQuery(data).find('#priceblock_ourprice').html()
						}
				});						
			});
		</script>
	
	</form>
	<?php

}
add_action('wp_ajax_pcsavewebsiteconfig', 'pricecomparison_savewebsiteconfig');
function pricecomparison_savewebsiteconfig() {
	global $wpdb;

	$options = get_option('wppc_settings');
	$options['websites'] = json_encode($_REQUEST['websiteconfig']);
	$options['skimlinksid'] = $_REQUEST['skimlinksid'];

	update_option('wppc_settings', $options);	
	die();
}
