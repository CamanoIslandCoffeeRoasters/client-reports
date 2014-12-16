<?php 

date_default_timezone_set('America/Los_Angeles');
global $wpdb;

if ($_POST['add_client_submit']) {
	
	$client_subdomain = $_POST['add_client']['client_subdomain'] . ".buzzboxcoffee.com";

	if (!$client_wp_blog_id = $wpdb->get_var("SELECT blog_id FROM bbc_blogs WHERE domain = '$client_subdomain'")) {
		
		echo "<h1 style=\"color:red;\">Client Doesn't Exist!</h1><hr />";
	}
	else { 

		$client_id = "NULL";
		$client_subdomain = $_POST['add_client']['client_subdomain'];
		$client_name = $_POST['add_client']['client_name'];
		$date = date("Y-m-d");
		
			if ($wpdb->insert(
			"" . $wpdb->prefix . "report_client", 
					array(
							'id'					=>	$client_id,
							'client_wp_blog_id'		=>	$client_wp_blog_id,
							'client_subdomain'		=>	$client_subdomain,
							'client_display_name'	=>	$client_name,
							'client_date_added'		=>	$date
							)
						)
				) 
				{														
				echo "<h2 style=\"color:green;\">" . $client_name . " Was Added Successfully</h2><br />";
				}
																	
																	
																	
	}

			$client_insert_id = $wpdb->insert_id;
			
			foreach($_POST['add_client'] as $meta_key => $meta_value) {
			
				$wpdb->insert(
						'' . $wpdb->prefix . 'report_client_meta',
						array(
								'id' => NULL,
								'client_id' => $client_wp_blog_id,
								'client_meta_key' => $meta_key,
								'client_meta_value' => $meta_value
							)
						);
						}


}	


?>
<h1>Add Client:</h1>
<form name="add_client_form" action="" method="POST">
	<table>
		<tbody>
			<thead>
				<tr>
					<td>
						<h2>Client</h2>
					</td>
					<td>
						<input type="text" name="add_client[client_name]" placeholder="Client Name" />
					</td>
				</tr>
				<tr>
					<td>
						<h2>Client Subdomain</h2>
					</td>
					<td>
						<input type="text" name="add_client[client_subdomain]" placeholder="Client Subdomain" />
					</td>
				</tr>
				<tr>
					<td>
						<h2>Prosumer Trust Partner</h2>
					</td>
					<td>
						<input type="text" name="add_client[prosumer_trust_partner_name]" placeholder="Prosumer Trust Partner" />
					</td>
				</tr>
				<tr>
					<td>
						<h2>Ext. Account Executive</h2>
					</td>
					<td>
						<input type="text" name="add_client[account_exec_external_name]" placeholder="Ext. Account Executive" />
					</td>
					<td>
						<input type="text" size="1" name="add_client[account_exec_external_commission]" placeholder="%" />
					</td>
				</tr>
				<tr>
					<td>
						<h2>Account Finder</h2>
					</td>
					<td>
						<input type="text" name="add_client[finder_name]" placeholder="Account Finder" />
					</td>
					<td>
						<input type="text" size="1" name="add_client[finder_commission]" placeholder="%" />
					</td>
				</tr>
				<tr>
					<td>
						<h2>Non-Profit</h2>
					</td>
					<td>
						<input type="text" name="add_client[nonprofit_name]" placeholder="Non-Profit" />
					</td>
					<td>
						<input type="text" size="1" name="add_client[nonprofit_commission]" placeholder="%" />
					</td>
				</tr>
				<tr>
					<td>
						<input type="submit" name="add_client_submit" value="Add Client" class="button-primary" />
					</td>
					
				</tr>
				
				
			</thead>
		</tbody>
	</table>
