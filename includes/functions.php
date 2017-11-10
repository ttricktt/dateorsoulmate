<?php

	function mysql_prep( $value) {
		$magic_quotes_active = get_magic_quotes_gpc();
		$new_enough_php = function_exists( "mysql_real_escape_string" );
		
		if( $new_enough_php ) {
			if ( $magic_quotes_active ) { $value = stripslashes( $value ); }
			$value = mysql_real_escape_string( $value );
		} else {
		
			if (!$magic_quotes_active ) { $value = addslashes( $value ); }
		}
		return $value;
		}

	function confirm_query($result_set) {
		if (!$result_set) {
			die("Database query failed: " . mysql_error());
		}
	}
	
	
	// Check database to see if username exist
	function get_registered_user($result_set) {
	$query = "SELECT username ";
	$query .= "FROM register ";
	$query .= "WHERE username = '{$result_set}' ";
	//echo $query; exit;
	$reg_user = mysql_query($query);
	confirm_query($reg_user);
	return $reg_user;
	
	}
	
	
	function get_member_info($result_set) {
		$query = "select * 
				from userinfo 
				where valid_id = {$result_set}";
				$member_info = mysql_query($query);
				if (!$member_info) {
					die("Datebase query failed: " . mysql_error());
					}
				$sel_member_info = mysql_fetch_array($member_info);
			return $sel_member_info;
	}
	
	function get_member_zip($result_set) {
	//echo "result $result_set <br />";
		$query = "select username, valid_id, age, gender
				from userinfo 
				where zip = {$result_set}";
				//echo "$query <br />";
				$member_info = mysql_query($query);
				if (!$member_info) {
					die("Datebase query failed: " . mysql_error());
					}
				// while ($sel_member_zip = mysql_fetch_array($member_info)) {
				//echo ($sel_member_zip[username]) . "<br />";
				
				return $member_info;
				
				
	}
	
	function get_state($result_set) {
	//echo "Result set " . $result_set;
	$query = "select * 
			from states
 			where id = {$result_set}";
			$state_result=mysql_query($query);
		
		if ($state_result != null) {
		$sel_state=mysql_fetch_array($state_result);
		}
		return $sel_state;
	}
	function get_seeking($result_set) {
		$query = "select * 
			from seeking
 			where id = {$result_set}";
		$seeking_result=mysql_query($query);
		confirm_query($query);
		if ($seeking_result != null) {
		$sel_seeking=mysql_fetch_array($seeking_result);
		}
		return $sel_seeking;
		}	
	function get_picture($result_set) {
		$picture_sql = "select * 
				from pictures
 				where user_id = {$result_set}
				and file_name is not null";
				//echo $picture_sql;
		$picture_result=mysql_query($picture_sql);
		confirm_query($query);
		return $picture_result;
	}
	function get_gender($result_set) {
		$query = "select * 
				from male_female
 				where id = {$result_set}";
		$gender_result = mysql_query($query);
		confirm_query($query);
		if ($gender_result != null) {
		$sel_gender=mysql_fetch_array($gender_result);
		}
		return $sel_gender;
		}
	function get_body_type($result_set) {
		$query = "select * 
				from body_type
 				where id = {$result_set}";		
		$body_type_result = mysql_query($query);
		confirm_query($query);
		if ($body_type_result != null) {
		$sel_body_type=mysql_fetch_array($body_type_result);
		}
		return $sel_body_type;
		}
	function get_do_i_drink($result_set) {
		$query = "select * 
				from drink
 				where id = {$result_set}";		
		$drink_result = mysql_query($query);
		confirm_query($query);
		if ($drink_result != null) {
		$sel_drink=mysql_fetch_array($drink_result);
		}
		return $sel_drink;
	}
	function get_do_i_use_drugs($result_set) {
		$query = "select * 
				from drugs
				where id = {$result_set}";		
		$drug_result = mysql_query($query);
		confirm_query($query);
		if ($drug_result != null) {
		$sel_drugs=mysql_fetch_array($drug_result);
		}
		return $sel_drugs;
	}
	function get_my_ethnicity($result_set) {
		$query = "select * 
				from ethnicity
				where id = {$result_set}";		
		$ethnicity_result = mysql_query($query);
		confirm_query($query);
		if ($ethnicity_result != null) {
		$sel_ethnicity=mysql_fetch_array($ethnicity_result);
		}
		return $sel_ethnicity;
	}
	function get_my_hair($result_set) {
		$query = "select * 
			from hair
			where id = {$result_set}";		
		$hair_result = mysql_query($query);
		confirm_query($query);
		if ($hair_result != null) {
		$sel_hair=mysql_fetch_array($hair_result);
		}
		return $sel_hair;
	}
	function get_height($result_set) {
		$query = "select * 
			from height
			where id = {$result_set}";		
		$height_result = mysql_query($query);
		confirm_query($query);
		if ($height_result != null) {
		$sel_height=mysql_fetch_array($height_result);
		}
		return $sel_height;
	}
	function get_relationship_status($result_set) {
		$query = "select * 
			from married
			where id = {$result_set}";		
		$relationship_result = mysql_query($query);
		confirm_query($query);
		if ($relationship_result != null) {
		$sel_relationship=mysql_fetch_array($relationship_result);
		}
		return $sel_relationship;
	}
	function get_dating($result_set) {
		$query = "select * 
			from relationship
			where id = {$result_set}";		
		$dating_result = mysql_query($query);
		confirm_query($query);
		if ($dating_result != null) {
		$sel_dating=mysql_fetch_array($dating_result);
		}
		return $sel_dating;
	}
	function get_smoking($result_set) {
		$query = "select * 
			from smoke
			where id = {$result_set}";		
		$smoking_result = mysql_query($query);
		confirm_query($query);
		if ($smoking_result != null) {
		$sel_smoking=mysql_fetch_array($smoking_result);
		}
		return $sel_smoking;
	}
	function do_i_have_any_messages($result_set) {
			$query = "select *
				from messages
				where `to` = {$result_set}";
				$message_result = mysql_query($query);
				confirm_query($message_result);
				if (mysql_num_rows($message_result) == 1) {
					$found_message=mysql_fetch_array($message_result);
				return $found_message;
		}		
	}
?>
