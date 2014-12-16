<?php

/*
switch_to_blog(2);

$shipping_date = "09/01/2014";
			
		$args = array(
					            'posts_per_page' => -1,
					            'post_type' => 'shop_order',
					            'post_status' => array('future', 'publish'),
					            'meta_query' => array(
					                'relation' => 'AND',
					                array(
					                    'key' => '_is_subscription',
					                     'value' => 'true',
					                ),
					                array(
					                    'key' => 'Next Shipment Date',
					                    'value' => $shipping_date
					                ),
					                //array(
					                    //'key' => '_order_total',
					                    //'value' => '52.5'
					                //),
					            ),
					            'tax_query' => array(
					                array(
					                    'taxonomy' => 'shop_order_status',
					                    'field' => 'slug',
					                    'terms' => 'processing'
					                )
					            )
					        );
							
							//$orders = $wpdb->get_results("SELECT post_id FROM cicr_15_postmeta where meta_key = '_order_total' and meta_value like '%99%'");
					
					        $orders = get_posts($args);
							
							echo count($orders);
							
							//var_dump($orders);
							/*
							foreach ($orders as $order) {
								
								echo $order->ID;
								
								$today = "2014-08-29 00:00:00";
								$today_gmt = "2014-08-29 08:00:00"; 
								
								echo $order_shipping_date = get_post_meta($order->ID, 'Next Shipment Date', $single = TRUE), "<br />";
								
								$wp_post = array(
											'ID'		=> $order->ID,
											'post_date'	=> $today,
											'post_date_gmt' => $today_gmt,
											'post_modified' => $today,
											'post_modified_gmt' => $today_gmt,
											);
								
								echo wp_update_post($wp_post);
								
								echo update_post_meta($order->ID, 'Next Shipment Date', "08/29/2014");
								
							}
							 
restore_current_blog();
















/*
global $wpdb; 

$no_coffees_orders = $wpdb->get_results("SELECT bbc_2_woocommerce_order_items.order_id
												FROM bbc_2_woocommerce_order_items 
												JOIN bbc_2_woocommerce_order_itemmeta 
												ON bbc_2_woocommerce_order_items.order_item_id = bbc_2_woocommerce_order_itemmeta.order_item_id 
												WHERE meta_key = '_product_id' and meta_value = ''
												GROUP BY bbc_2_woocommerce_order_items.order_id
												ORDER BY bbc_2_woocommerce_order_items.order_id DESC
												LIMIT 0, 100
												");

//var_dump($no_coffees_orders);

foreach ($no_coffees_orders as $orders) {
	echo "<a href=\"http://rickandbubba.buzzboxcoffee.com/wp-admin/post.php?post=$orders->order_id&action=edit\" target=\"_blank\">$orders->order_id</a></br >";
}



/*
// jSON URL which should be requested
$json_url = "https://prosumertrust.desk.com/api/v2/customers/207193084";

$username = "dan@camanoislandcoffee.com";  // authentication
$password = "Prosumer848Trust";  // authentication

// jSON String for request
//$json_string = json_encode( array( 'id' => '2867'));

// Initializing curl
$ch = curl_init( $json_url );

// Configuring curl options
$options = array(
CURLOPT_RETURNTRANSFER => true,
CURLOPT_USERPWD	=> $username . ":" . $password,  // authentication
CURLOPT_HTTPHEADER => array("Content-type: application/json") ,
//CURLOPT_POSTFIELDS => $json_string
);

// Setting curl options
curl_setopt_array( $ch, $options );

// Getting results
var_dump($result = curl_exec($ch)); // Getting jSON result string
var_dump($json_string);

 * 
 * */

/*

require_once ('/home/buzzbox/public_html/mailchimp-api/src/Mailchimp.php');

$chimpy = new Mailchimp("74d0a87d1cb30df3fad4afe4de5c4d28-us1");

//var_dump($chimpy->lists->getList());

//$list = $chimpy->lists->getList($filters = array('list_id' => '11d55f1455'));

$segments = $chimpy->lists->segments('11d55f1455');

foreach ($segments['saved'] as $status) {
	echo $status['name'] ."<br />";
}

var_dump($members = $chimpy->lists->memberInfo('11d55f1455', array('email' => 'thobinator555@gmail.com')));


//var_dump($campaigns = $chimpy->campaigns->getList($filters = array(), $start = 0, $limit = 115));
//var_dump($campaigns['data'][61]['summary']);
echo "<hr /><br /><hr /><br /><hr />";


// "https://us2.api.mailchimp.com/2.0/lists/list.php"
 
/*





$apikey = '74d0a87d1cb30df3fad4afe4de5c4d28-us1';
$list_id = '11d55f1455';
$chunk_size = 4096; //in bytes
$url = 'http://us1.api.mailchimp.com/export/1.0/list?apikey='.$apikey.'&id='.$list_id;


$handle = @fopen($url,'r');
if (!$handle) {
  echo "failed to access url\n";
} else {
  $i = 0;
  $header = array();
  while (!feof($handle)) {
    $buffer = fgets($handle, $chunk_size);
    if (trim($buffer)!=''){
      $obj = json_decode($buffer);
      if ($i==0){
        //store the header row
        $header = $obj;
      } else {
        //echo, write to a file, queue a job, etc.
        echo $header[0].': '.$obj[0]."\n";
      }
      $i++;
    }
  }
  fclose($handle);
}



//var_dump($chimpy->lists);
//var_dump($list['data']);
/*
if ($chimpy->lists->subscribe('11d55f1455', array('email' => 'lacrossestar555@hotmail.com'), $merge_vars=null, $email_type='html', $double_optin=false)) {
	echo "subscribed!";
} else {
	echo "NOT subscribed!";
}


?>
<!--
<form action="http://requestb.in/txsvcktx" method="POST">
	<input type="text" name="testerrrr" />
	<input type="submit" name="submit" value="submit" />
</form> -->
<?php
    $result = file_get_contents('http://requestb.in/txsvcktx');
    echo $result;


 * 


/*
$ch =  curl_init();

curl_setopt($ch, CURLOPT_URL, "https://prosumertrust.desk.com/api/v2/cases/:2286 -u dan@camanoislandcoffee.com:Prosumer848Trust -H 'Accept: application/json'");
//curl_setopt($ch, CURLOPT_HEADER, 'Accept: application/json');
curl_setopt($ch, CURLOPT_HTTPHEADER, Array("-u dan@camanoislandcoffee.com:Prosumer848Trust","-H 'Accept: application/json'" ));     
    
curl_exec($ch);


curl_close($ch);




// jSON URL which should be requested
$json_url = "https://yoursite.desk.com/api/v2/cases";

$username = "dan@camanoislandcoffee.com";  // authentication
$password = "Prosumer848Trust";  // authentication

// jSON String for request
$json_string = '"status":open}';

// Initializing curl
$ch = curl_init( $json_url );

// Configuring curl options
$options = array(
CURLOPT_RETURNTRANSFER => true,
CURLOPT_USERPWD	=> $username . ":" . $password,  // authentication
CURLOPT_HTTPHEADER => array("Content-type: application/json") ,
CURLOPT_POSTFIELDS => $json_string
);

// Setting curl options
curl_setopt_array( $ch, $options );

// Getting results
var_dump($result = curl_exec($ch)); // Getting jSON result string


*/




/*

var_dump (duplicate_order( 12595 ));

 function duplicate_order( $order_old_id )	{
        	
        $order_old = new WC_Order($order_old_id);

        // Give plugins the opportunity to create an order themselves
        $order_id = apply_filters('woocommerce_create_order', null, $this);

        if (is_numeric($order_id))
            return $order_id;


        // Create Order (send cart variable so we can record items and reduce inventory). Only create if this is a new order, not if the payment was rejected.
        $order_data = apply_filters('woocommerce_new_order_data', array(
            'post_type' => 'shop_order',
            'post_title' => sprintf(__('Order &ndash; %s', 'woocommerce'), strftime(_x('%b %d, %Y @ %I:%M %p', 'Order date parsed by strftime', 'woocommerce'))),
            'post_status' => 'publish',
            'ping_status' => 'closed',
            'post_excerpt' => '',
            'post_author' => 1,
            'post_date'	=> date("Y-m-d H:i:s"),
            'post_password' => uniqid('order_') // Protects the post just in case
        ));

        $order_id = wp_insert_post($order_data);

        if (is_wp_error($order_id)) {
            throw new Exception('Error: Unable to create order. Please try again.');
        } else
            do_action('woocommerce_new_order', $order_id);

        foreach ($order_old->order_custom_fields as $key => $value) {
        	
			if (($key == "_order_total")|| ($key == '_order_shipping')){
				$value[0] = -1 * abs($value[0]);
			}

            update_post_meta($order_id, $key, $value[0]);
        }

        foreach ($order_old->get_items() as $id => $item) {
            // Add line item
            $item_id = woocommerce_add_order_item($order_id, array(
                'order_item_name' => $item['name'],
                'order_item_type' => $item['type']
            ));


            // Add line item meta
            if ($item_id) {
                foreach ($item['item_meta'] as $key => $values) {
                    foreach ($values as $value) {
                        woocommerce_add_order_item_meta($item_id, $key, $value);
                    }
                }
            }
        }


        // mark order as subscription
        //update_post_meta($order_old->id, '_is_subscription', 'true');

        // mark old order as renewed
        //update_post_meta($order_old->id, '_subscription_renewed', 'true');

        // old & new orders ids
        //update_post_meta($order_old->id, '_subscription_order_next', $order_id);
        //update_post_meta($order_id, '_subscription_order_previous', $order_old->id);

        // remove mess from old orders
        //delete_post_meta($order_id, '_subscription_renewed');
        //delete_post_meta($order_id, '_subscription_order_next');
        //delete_post_meta($order_id, '_paid_date');
        //delete_post_meta($order_id, '_wc_authorize_net_cim_trans_id');

        // mark new order as renewed old
        //update_post_meta($order_id, 'renewed_order_id', $order_old->id);

        // Order status
        wp_set_object_terms($order_id, 'refunded', 'shop_order_status');
		
		wp_set_object_terms($order_old_id, 'completed', 'shop_order_status');



        update_post_meta($order_id, '_order_key', apply_filters('woocommerce_generate_order_key', uniqid('order_') ) );
        update_post_meta($order_id, 'Download Permissions Granted', 0 );

        do_action('cs_new_subscription_update_order_meta', $order_id);

        return $order_id;
    }




*/































/*
public function duplicate_order( $order_old_id, $old_is_refunded = false )
    {
        $order_old = new CS_Order($order_old_id);

        // exit if is not subscription
        if ( !$order_old->is_subscription() ) {
            return;
        }
        // Give plugins the opportunity to create an order themselves
        $order_id = apply_filters('woocommerce_create_order', null, $this);

        if (is_numeric($order_id))
            return $order_id;

        $this->logger->addMessage('Started Order #' . $order_old_id . ' renewal.');

        // Create Order (send cart variable so we can record items and reduce inventory). Only create if this is a new order, not if the payment was rejected.
        $order_data = apply_filters('woocommerce_new_order_data', array(
            'post_type' => 'shop_order',
            'post_title' => sprintf(__('Order &ndash; %s', 'woocommerce'), strftime(_x('%b %d, %Y @ %I:%M %p', 'Order date parsed by strftime', 'woocommerce'))),
            'post_status' => 'publish',
            'ping_status' => 'closed',
            'post_excerpt' => isset($this->posted['order_comments']) ? $this->posted['order_comments'] : '',
            'post_author' => 1,
            'post_password' => uniqid('order_') // Protects the post just in case
        ));

        $order_id = wp_insert_post($order_data);

        if (is_wp_error($order_id)) {
            $this->logger->addError('Unable to create order' . $order_id . '. Please try again.')->write();
            throw new Exception('Error: Unable to create order. Please try again.');
        } else
            do_action('woocommerce_new_order', $order_id);

        foreach ($order_old->order_custom_fields as $key => $value) {

            update_post_meta($order_id, $key, $value[0]);
        }

        foreach ($order_old->get_items() as $id => $item) {
            // Add line item
            $item_id = woocommerce_add_order_item($order_id, array(
                'order_item_name' => $item['name'],
                'order_item_type' => $item['type']
            ));


            // Add line item meta
            if ($item_id) {
                foreach ($item['item_meta'] as $key => $values) {
                    foreach ($values as $value) {
                        woocommerce_add_order_item_meta($item_id, $key, $value);
                    }
                }
            }
        }

        $this->update_shipment_date($order_id);

        // mark order as subscription
        update_post_meta($order_old->id, '_is_subscription', 'true');

        // mark old order as renewed
        update_post_meta($order_old->id, '_subscription_renewed', 'true');

        // old & new orders ids
        update_post_meta($order_old->id, '_subscription_order_next', $order_id);
        update_post_meta($order_id, '_subscription_order_previous', $order_old->id);

        // remove mess from old orders
        delete_post_meta($order_id, '_subscription_renewed');
        delete_post_meta($order_id, '_subscription_order_next');
        delete_post_meta($order_id, '_paid_date');
        delete_post_meta($order_id, '_wc_authorize_net_cim_trans_id');

        // mark new order as renewed old
        update_post_meta($order_id, 'renewed_order_id', $order_old->id);

        // Order status
        wp_set_object_terms($order_id, 'processing', 'shop_order_status');
		if ( ! $old_is_refunded ) {
			wp_set_object_terms($order_old_id, 'completed', 'shop_order_status');
		}

        update_post_meta($order_id, '_two_days_prior_mail_sent', 'no');
        update_post_meta($order_id, '_seven_days_prior_mail_sent', 'no');

        update_post_meta($order_id, '_order_key', apply_filters('woocommerce_generate_order_key', uniqid('order_') ) );
        update_post_meta($order_id, 'Download Permissions Granted', 0 );

        $this->logger->addMessage('Finished Order #' . $order_old_id . ' renewal. New order # is' . $order_id)->write();

        do_action('cs_new_subscription_update_order_meta', $order_id);

        return $order_id;
    }










