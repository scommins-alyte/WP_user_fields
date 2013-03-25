This plugin is a drop in. Either add to mu-plugins directory, or include in functions.php.

### Example

```
if( class_exists( 'Bjm_user_fields' ) )
{
    $fields = array( 
                   'publication' => array( 
                        'label'     => 'Publication', 
                        'type'      => 'textbox', 
                        'single'    => true
                    ),
        );

    $bjm_user_fields = new Bjm_user_fields( $fields );
}
```

### Types

####  Textbox

```
  'type'   	=> 'textbox', 
```

####  Checkbox 

Uses key => val

```
  'type' 		=> 'checkbox', 
  'options' 	=> array( 1 => 'Yes' ),
```

####  Select 

Uses key => val

```
  'type' 		=> 'select', 
  'options' 	=> $option_array,            
```
