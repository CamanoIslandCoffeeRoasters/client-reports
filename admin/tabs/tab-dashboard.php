<?php

global $wpdb, $woocommerce;
date_default_timezone_set('America/Los_Angeles');
include_once( ABSPATH . 'wp-content/plugins/woocommerce/classes/class-wc-order.php' );
set_time_limit(0);
ini_set('max_execution_time', '3600'); 
ini_set('max_input_time', '3600'); 
flush();
$table = '';

	
	$report_clients = $wpdb->get_results("SELECT * FROM bbc_report_client");



            if (!empty($_POST['dateFrom'])) {
                
               $dateFrom = $_POST['dateFrom'];
            }
            else {
                $dateFrom = date('Y-m-d');    
            }
            
            
            if (!empty ($_POST['dateTo'])) {
                    
                $dateTo = $_POST['dateTo'];
            }
                
            else {
               $dateTo = date('Y-m-d');
            }
            
            

		//class Order extends WC_Order {};
		

?>
<?php

		if (isset($_POST['client_id'])) {
					$client_id = key($_POST['client_id']);
		}
		
		
    // Form controls for start and end date

	
	
    echo "<h2>";
    echo "<form action=\"\" method=\"POST\">";
    print "From: <input type=\"text\" name=\"dateFrom\" value=\"". $dateFrom . "\" size=\"9\" />&nbsp;";
    print "To: <input type=\"text\" name=\"dateTo\" value=\"". $dateTo . "\" size=\"9\" />&nbsp;&nbsp;&nbsp;";

	
	foreach ($report_clients as $client_ids => $client_value) {
			?> 
				<input type="submit" class="button-primary" value="<?= $client_value->client_display_name ?>" name="client_id[<?= $client_value->client_wp_blog_id ?>]" />
			<?php 	
	}
	echo "<input type=\"checkbox\" name=\"export_file\" value=\"download\" />";
	echo "</form></h2><hr />";


	$dateFromSQL = date("Y-m-d", strtotime($dateFrom) - 60 * 60 * 24);
	$dateFromSQL = $dateFromSQL . " 20:45:01";
	
	$dateToSQL = $dateTo . " 20:45:00";

	if (is_multisite()) {
		
	switch_to_blog($client_id);
	}	
	// Print Subdomain
	echo "<h1>", get_option('blogname'), "</h1>";

		// List all orders from subdomain that match dates
	$paid_orders = $wpdb->get_col("SELECT postmeta.post_id FROM {$wpdb->postmeta} postmeta JOIN {$wpdb->posts} posts ON postmeta.post_id = posts.ID WHERE posts.post_status = 'wc-completed' AND postmeta.meta_key = '_paid_date' AND postmeta.meta_value BETWEEN '$dateFromSQL' AND '$dateToSQL'");
		// Populate table with client meta
	$client_meta = $wpdb->get_results("SELECT * FROM bbc_report_client_meta WHERE client_id = '{$client_id}'");
	
	$client_name		 = $client_meta[1]->client_meta_value;
	$partner_name 		 = $client_meta[2]->client_meta_value;
	$external_name 		 = $client_meta[3]->client_meta_value;
	$external_commission = ($client_meta[4]->client_meta_value * 0.01);
	$finder_name 		 = $client_meta[5]->client_meta_value;
	$finder_commission 	 = ($client_meta[6]->client_meta_value * 0.01);
	$nonprofit_name 	 = $client_meta[7]->client_meta_value;
	$nonprofit_commission= ($client_meta[8]->client_meta_value * 0.01);

 

	//var_dump($_POST['client_id']);
	
//echo $client_subdomain = get_option('siteurl');
			$table_head_array = array(
											0 => 'Client',
											1 => 'Order #',      
											2 => 'Date',         
											3 => 'First',     
											4 => 'Last',
											5 => 'Address',         
											6 => 'City',            
											7 => 'State',        
											8 => 'ZIP',          
											9 => 'Phone',               
											10 => 'Email',                       
											11 => 'Activity', 
											12 => 'Type',         
											13 => 'Total',       
											14 => 'Shipping',    
											15 => 'Coffee',      
											16 => $external_name,
											17 => $finder_name,  
											18 => $nonprofit_name
										);
										
			$table = "<table class=\"widefat\">";                        
			$table .= "<tbody>";
			$table .= "<thead>";                        
			$table .= "<tr>";           
			
			foreach ($table_head_array as $column) {
				$table .= "<th>";
				$table .= $column;                        
			 	$table .= "</th>"; 
			}           
			
			$table .= "</tr>";
			$table .= "</thead>";


class Order extends WC_Order {};
  $row = $num_of_orders = $total_orders_amount = $number_of_items = $total_shipping = $order_type = $order_total = 0;
  

		   
           foreach ($paid_orders as $k => $v) {
                            set_time_limit(0);
			  
			  $orderData = new Order;
              $orderData->get_order($paid_orders[$k]);
			  $number_of_items = 0;
					  
					  // if ( $orderData->order_custom_fields['_order_total'][0] > 1 ) {
					  if (( $orderData->free_pound !=  TRUE ) || ($orderData->order_total < 0.01 )) {
                  			
							// Count the number of items in the order
						  foreach ($orderData->get_items($type ='line_item') as $k => $v) {
							    $number_of_items += $v['qty'];
						  }
						  
							if ($orderData->subscription_type) {
								$order_type = "Box";
							} else {
								$order_type = "Retail";
							}
		                  		$orderNumber = $orderData->id;
							  	// Build the string that matches the url of the website, to create link to order
					            $client_subdomain = get_option('siteurl');
								//Manually Set R&B Shipping costs preset to $8.00 dollars
					           	//if (($client_id == 2) && (!$orderData->order_shipping > 0)) {
					           		$orderData->order_shipping = 8.00;
					           	//}
								// Add 
								$total_on_commission = $orderData->order_total - $orderData->order_shipping;
								
			            
									  
                          if ($row % 2 == 0 ) {  
                          	$table .= "<tr valign=\"center\" class=\"alternate\">";
                          }
                          else {
                              $table .= "<tr>";
                          }
				// Client						  
						  	  $table .= "<td><p align=\"center\">";
                              $table .= "<b>$client_name</b>";
                              $table .= "</p></td>";
				// Order ID						  
                              $table .= "<td><p align=\"center\">#";
                              $table .= $orderData->id;
                              $table .= "</p></td>";
				// Date
                              $table .= "<td><p>";
                              $table .= date_format(date_create($orderData->order_date), 'd-M-Y');
                              $table .= "</p></td>";
				// First Name                              
                              $table .= "<td><p>";
                              $table .= ucwords(strtolower($orderData->billing_first_name));
                              $table .= "</p></td>";
				// Last Name							  
							  $table .= "<td><p>";
                              $table .= ucwords(strtolower($orderData->billing_last_name));
                              $table .= "</p></td>";
				// Addres 1 & 2							  
							  $table .= "<td><p>";
                              $table .= ucwords(strtolower($orderData->shipping_address_1)) . " " . ucwords(strtolower($orderData->shipping_address_2));
                              $table .= "</p></td>";
				// City                              
                              $table .= "<td><p>";
                              $table .= ucwords(strtolower($orderData->shipping_city));
                              $table .= "</p></td>";
				// State							  
							  $table .= "<td><p>";
                              $table .= strtoupper($orderData->shipping_state);
                              $table .= "</p></td>";
				// ZIP Code							  
							  $table .= "<td><p>";
                              $table .= substr($orderData->shipping_postcode, 0, 5);
                              $table .= "</p></td>";
				// Phone							  
							  $table .= "<td><p>";
                              $table .= formatPhone($orderData->billing_phone);
                              $table .= "</p></td>";
				// Email							  
							  $table .= "<td><p>";
                              $table .= strtolower($orderData->billing_email);
                              $table .= "</p></td>";
				
				
				// Customer Orders
                              $table .= "<td><p>";
                              $table .= $orderData->customer_orders . " Orders";
                              $table .= "</p></td>";
				// Order Type
                              $table .= "<td><p>";
                              $table .= $number_of_items . "lb " . $order_type;
                              $table .= "</p></td>";				
				// Order Total
                              $table .= "<td><p>$";
                              $table .= number_format($orderData->order_total, 2, '.', ',');
                              $table .= "</p></td>";
				// Order Shipping							  
							  $table .= "<td><p>$";
                              $table .= number_format($orderData->order_shipping, 2, '.', ',');
                              $table .= "</p></td>";
				// Order for Commission
							  $table .= "<td><p>$";
                              $table .= number_format($total_on_commission, 2, '.', ',');
                              $table .= "</p></td>";
				// External Executive Commission
							  $table .= "<td><p>$";
                              $table .= number_format((round(($total_on_commission * $external_commission), 2, PHP_ROUND_HALF_UP)), 2, '.', ',');
                              $table .= "</p></td>";
				// Finder Commission
							  $table .= "<td><p>$";
							  $table .= number_format((round(($total_on_commission * $finder_commission), 2, PHP_ROUND_HALF_UP)), 2, '.', ',');
                              $table .= "</p></td>";
				// Non-profit Commission
							  $table .= "<td><p>$";
							  $table .= number_format((round(($total_on_commission * $nonprofit_commission), 2, PHP_ROUND_HALF_UP)), 2, '.', ',');
                              $table .= "</p></td>";
							
							//Count Orders
							$num_of_orders+=1;
							// Alternate colors of table rows
                           	$row+=1;
							// Count price of orders for total at bottom
							$total_orders_amount += $total_on_commission;
							$total_shipping += $orderData->order_shipping;
						  	$order_total += $orderData->order_total;
			            }


			
			
			}

         			 $table .= "</tr>";
		  
		  			$table_foot_array = array(
		  									0 => $num_of_orders,
											1 => '',                                                           
											2 => '',                                                                         
											3 => '',                                                                         
											4 => '',                                                                         
											5 => '',                                                                         
											6 => '',                                                                         
											7 => '',                                                                         
											8 => '',                                                                         
											9 => '',                                                                         
											10 => '',
											11 => '', 
											12 => '', 
											13 => number_format($order_total, 2, '.', ','),                                  
											14 => number_format($total_shipping, 2, '.', ','),                               
											15 => number_format($total_orders_amount, 2, '.', ','),                          
											16 => number_format(($total_orders_amount * $external_commission), 2, '.', ','), 
											17 => number_format(($total_orders_amount * $finder_commission), 2, '.', ','),  
											18 => number_format(($total_orders_amount * $nonprofit_commission), 2,'.', ',')     
										);
		  
		  	$table .= "<tfoot>";
			$table .= "<tr>";
			
			foreach ($table_foot_array as $column) {
				$table .= "<th>" . $column . "</th>";
			}			
			
			$table .= "</tr>";
			$table .= "</tfoot>";
		  

      $table .= "</tbody>";
      $table .= "</table>";
	  
	  // Print $table to screen
	  echo $table;
	  

	  if (is_multisite()) {
	  restore_current_blog();
	  }
	  
	  
	  
	  function formatPhone($phone = '')
			{
				// If we have not entered a phone number just return empty
				if (empty($phone)) {
					return '';
				}
			 
				// Strip out any extra characters that we do not need only keep letters and numbers
				$phone = preg_replace('/\D/', "", $phone);
			 
			
			 
				// If we have a number longer than 11 digits cut the string down to only 11
				// This is also only ran if we want to limit only to 11 characters
				if ($trim == true && strlen($phone)>11) {
					$phone = substr($phone, 0, 11);
				}						 
			 
				// Perform phone number formatting here
				if (strlen($phone) == 7) {
					return preg_replace("/([0-9a-zA-Z]{3})([0-9a-zA-Z]{4})/", "$1-$2", $phone);
				} elseif (strlen($phone) == 10) {
					return preg_replace("/([0-9a-zA-Z]{3})([0-9a-zA-Z]{3})([0-9a-zA-Z]{4})/", "($1) $2-$3", $phone);
				} elseif (strlen($phone) == 11) {
					return preg_replace("/([0-9a-zA-Z]{1})([0-9a-zA-Z]{3})([0-9a-zA-Z]{3})([0-9a-zA-Z]{4})/", "$1($2) $3-$4", $phone);
				}
			 
				// Return original phone if not 7, 10 or 11 digits long
				return $phone;
			}
	   /*
	 if (isset($_POST['export_file']) && ($_POST['export_file']) == 'download') {
		 		 
		 $filename = "myFile.csv";
		header('Content-type: application/csv');
		header('Content-Disposition: attachment; filename='.$filename);
		
		echo $table;
		exit;
		  */
		  
		  /*
		   * 
		   $filename = "tobin_download.csv";
		   header("Content-Disposition: attachment; filename=\"$filename\"");
		   header("Content-Type: text/csv;");
		  $out = fopen("php://output", 'w');
		
		    fputcsv($out, $table, "<tr");
			
			fclose($out);
		  
			
		  }
		exit;
		  
		  

                //$csv = $this->generate_csv($data);
                
                

                ob_end_clean();
				
				
				$table = str_ireplace(array('<p>','</p>', '<td>', '<th>', '<tr>', '<b>', '</b>', '<p align="center">', '<tr valign="center" class="alternate">'), '', $table);
				
				$table = str_ireplace(array('</td>', '</th>'), ',', $table);
				
				$table = str_ireplace(array('</tr>'), '\r\n', $table);

                //header("Pragma: public");
                //header("Expires: 0");
                //header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
                //header("Cache-Control: private", false);
				header("Content-Type: text/csv");
                //header("Content-Type: application/octet-stream");
                header("Content-Disposition: attachment; filename=\"report.csv\";" );
                //header("Content-Transfer-Encoding: binary");
					
                echo $table;

                exit;
            }
            else
            {
                ob_end_flush();
            }
        */
	  

      ?>