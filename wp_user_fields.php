<?php

/* 
	New User Fields Class
*/

$fields = array( 
	'staff' => array( 
							'label' 	=> 'Staff?', 
							'type' 		=> 'checkbox', 
							'options' 	=> array( 1 => 'Yes' ),
							'single' 	=> true 
						),
	'club_member' => array( 
							'label' 	=> 'Member of a club?', 
							'type' 		=> 'select', 
							'options' 	=> $option_array,
							'single'	=> true
						),
			);

$bjm_user_fields = new Bjm_user_fields( $fields );


class Bjm_user_fields
{

	var $args;

	function __construct( $fields )
	{
	
		$this->fields = $fields;
	
		add_action( 'show_user_profile', array( $this, 'fields' ) );
		add_action( 'edit_user_profile', array( $this, 'fields' ) );
		add_action( 'register_form', array( $this, 'fields' ) ); 
		
		add_action( 'personal_options_update', array( $this, 'save' ) );
		add_action( 'edit_user_profile_update', array( $this, 'save' ) );
		add_action( 'user_register', array( $this, 'save' ) );
		
	}

	function fields( $user_id=null ) 
	{  
		foreach( $this->fields as $field_name => $field_args )
			call_user_func( 
							array( $this, 'display_' . $field_args['type'] ), 
							array( 
									'user_id' => is_object( $user_id ) ? $user_id->ID : $user_id , 
									'name' => $field_name, 
									'args' => $field_args 
								) 
						);
	}
	
	function save( $user_id = false ) 
	{
		// If user ID is false, means this will be a user sign up, not an update. 
		// @todo fix below, as it fails on user sign up. 
		// if ( $user_id && ( !current_user_can( 'edit_user', $user_id ) ) ) return false;
		// @todo validation would be good. 
				
		foreach( $this->fields as $field_name => $field_args ) 
		{
			if( isset( $_REQUEST[ $field_name ] ) ) 
			{
				update_user_meta( $user_id, $field_name, $_POST[ $field_name ] ); 
			}
			else
			{
				delete_user_meta( $user_id, $field_name );
			}
		}		
	}
	
	function display_checkbox( $arg_array )
	{
		extract( $arg_array );
	?>
		<p id="field-<?php echo $name;?>">
		
			<label for="<?php echo $name;?>"> <?php echo $args['label'];?> </label>
			<?php foreach( $args['options'] as $val => $option ): ?>				
				<input 
						type="checkbox" 
						name="<?php echo $name;?>" 
						id="<?php echo $name;?>" 
						value="<?php echo $val; ?>"  
						<?php 
						if( get_user_meta( $user_id, $name, $args['single'] ) == $val ) 
							echo 'checked="checked";';
						?> 
				/> 
				
				<span class="description"><?php echo $option; ?></span>
			
			<?php endforeach; ?>
		
		</p> 
	<?php		
	}
	
	function display_select( $arg_array )
	{
	extract( $arg_array ); 
	?>
		<p id="field-<?php echo $name;?>">
		
			<label for="<?php echo $name;?>"> <?php echo $args['label'];?> </label>
			
			<select name="<?php echo $name; ?>" id="<?php echo $name;?>" >
			
			<?php foreach( $args['options'] as $val => $option ): ?>		
			
				<option value="<?php echo trim($val); ?>"
						<?php 
						if( get_user_meta( $user_id, $name, $args['single'] ) == trim( $val ) ) 
							echo 'selected="selected"';
						?> 
						>
				<?php echo trim($option); ?>
				</option>
			
			<?php endforeach; ?>
			
			</select>
		</p> 
	<?php	
	}

}