<?php

class acf_field_multi_taxonomy_chooser extends acf_field {
	
	
	/*
	*  __construct
	*
	*  This function will setup the field type data
	*
	*  @type	function
	*  @date	5/03/2014
	*  @since	5.0.0
	*
	*  @param	n/a
	*  @return	n/a
	*/
	
	function __construct() {
		
		/*
		*  name (string) Single word, no spaces. Underscores allowed
		*/
		
		$this->name = 'multi-taxonomy-chooser';
		
		
		/*
		*  label (string) Multiple words, can include spaces, visible when selecting a field type
		*/
		
		$this->label = __('Multi Taxonomy Chooser', 'acf-multi-taxonomy-chooser');
		
		
		/*
		*  category (string) basic | content | choice | relational | jquery | layout | CUSTOM GROUP NAME
		*/
		
		$this->category = 'choice';
		
		
		/*
		*  defaults (array) Array of default settings which are merged into the field object. These are used later in settings
		*/
		
		$this->defaults = array(
            'choices'		=> array(),
            'allow_null' 	=> 0,
            'multiple'		=> 0,
            'ui'            => 0,
            'ajax'          => 0,
            'type_value'	=> 1,
            'data_type'		=> 1,
		);
		
		
		/*
		*  l10n (array) Array of strings that are used in JavaScript. This allows JS strings to be translated in PHP and loaded via:
		*  var message = acf._e('multi-taxonomy-chooser', 'error');
		*/
		
		$this->l10n = array(
			'error'	=> __('Error! Please enter a higher value', 'acf-multi-taxonomy-chooser'),
		);
		
				
		// do not delete!
    	parent::__construct();
    	
	}
	
	
	/*
	*  render_field_settings()
	*
	*  Create extra settings for your field. These are visible when editing a field
	*
	*  @type	action
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	$field (array) the $field being edited
	*  @return	n/a
	*/
	
	function render_field_settings( $field ) {
		
		/*
		*  acf_render_field_setting
		*
		*  This function will create a setting for your field. Simply pass the $field parameter and an array of field settings.
		*  The array of settings does not require a `value` or `prefix`; These settings are found from the $field array.
		*
		*  More than one setting can be added by copy/paste the above code.
		*  Please note that you must also have a matching $defaults value for the field name (font_size)
		*/
		
        // choices : Taxonomies
        acf_render_field_setting( $field, array(
            'label'			=> __('Choose Allowed Taxonomies','acf-multi-taxonomy-chooser'),
            'instructions'	=> '',
            'type'			=> 'select',
            'name'			=> 'choices',
            'choices'		=> acf_get_pretty_taxonomies(),
            'multiple'		=> 1,
            'ui'			=> 1,
            'allow_null'	=> 1,
            'placeholder'	=> __("All Taxonomies",'acf-multi-taxonomy-chooser'),
        ));


        // multiple
        acf_render_field_setting( $field, array(
            'label'			=> __('Select multiple values?','acf-multi-taxonomy-chooser'),
            'instructions'	=> '',
            'type'			=> 'radio',
            'name'			=> 'multiple',
            'choices'		=> array(
                1				=> __("Yes",'acf-multi-taxonomy-chooser'),
                0				=> __("No",'acf-multi-taxonomy-chooser'),
            ),
            'layout'	=>	'horizontal',
        ));

         // id or slug
        acf_render_field_setting( $field, array(
            'label'			=> __('Return Value','acf-multi-taxonomy-chooser'),
            'instructions'	=> __('Specify the returned value on front end','acf-multi-taxonomy-chooser'),
            'type'			=> 'radio',
            'name'			=> 'type_value',
            'choices'		=> array(
                1				=> __("ID",'acf-multi-taxonomy-chooser'),
                0				=> __("Slug",'acf-multi-taxonomy-chooser'),
            ),
            'layout'	=>	'horizontal',
        ));
	
	    // multi or single
        acf_render_field_setting( $field, array(
            'label'			=> __('Return Value','acf-multi-taxonomy-chooser'),
            'instructions'	=> __('Specify the returned value on front end','acf-multi-taxonomy-chooser'),
            'type'			=> 'radio',
            'name'			=> 'data_type',
            'choices'		=> array(
                1				=> __("Multi",'acf-multi-taxonomy-chooser'),
                0				=> __("Single",'acf-multi-taxonomy-chooser'),
            ),
            'layout'	=>	'horizontal',
        ));
	}
	
	
	
	/*
	*  render_field()
	*
	*  Create the HTML interface for your field
	*
	*  @param	$field (array) the $field being rendered
	*
	*  @type	action
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	$field (array) the $field being edited
	*  @return	n/a
	*/

    function render_field( $field ) {

	    	// echo "<pre>";
	    	// 	print_r($field);
	    	// echo "</pre>";

        
        $taxonomies             = array();
        $taxonomies             = acf_get_array( $taxonomies );
        $taxonomies             = acf_get_pretty_taxonomies( $taxonomies );
        $all_taxonomies         = acf_get_taxonomy_terms();
        $selected_taxonomies    = array();
        $terms = array();
       	$slug_name = ! empty( $field['choices'] ) ? $field['choices'] : array_keys( acf_get_pretty_taxonomies() );

        foreach( $slug_name as $k1 => $v1 ) {
        	$terms = array_merge($terms, get_terms( $v1, array( 'hide_empty' => false ) ));
            foreach( $taxonomies as $k2 => $v2 ) {
                if( $v1 == $k2 ) {
                    $field['choices'][$k1] = $v2;
                }
            }
        }

        
        foreach( $field['choices'] as $k1 => $v1 ) {
            foreach( $all_taxonomies as $k2 => $v2 ) {
                if( $v1 == $k2 ) {
                    $selected_taxonomies[$v1] = $all_taxonomies[$k2];
                }
            }
        }

        $field['choices'] = $selected_taxonomies;


        	
        // convert value to array
        // $field['value'] = acf_force_type_array($field['value']);


        // add empty value (allows '' to be selected)
        if( empty($field['value']) ){

            $field['value'][''] = '';
            $field['value']['cat']	 = 	'';
        }


        // placeholder
        if( empty($field['placeholder']) ) {

            $field['placeholder'] = __("Select",'acf');

        }


        // vars
        $atts = array(
            'id'				=> $field['id'],
            'class'				=> $field['class'] . ' js-multi-taxonomy-select2',
            'name'				=> $field['name'],
            'data-ui'			=> $field['ui'],
            'data-ajax'			=> $field['ajax'],
            'data-multiple'		=> $field['multiple'],
            'data-placeholder'	=> $field['placeholder'],
            'data-allow_null'	=> $field['allow_null']
        );



        // hidden input
        if( $field['ui'] ) {

            acf_hidden_input(array(
                'type'	=> 'hidden',
                'id'	=> $field['id'],
                'name'	=> $field['name'],
                'value'	=> implode(',', $field['value'])
            ));

        } elseif( $field['multiple'] ) {

            acf_hidden_input(array(
                'type'	=> 'hidden',
                'name'	=> $field['name'],
            ));

        } 


        // ui
        if( $field['ui'] ) {

            $atts['disabled'] = 'disabled';
            $atts['class'] .= ' acf-hidden';

        }


        // multiple
        if( $field['multiple'] ) {

            $atts['multiple'] = 'multiple';
            $atts['size'] = 5;
            $atts['name'] .= '[]';

        } 


        // special atts
        foreach( array( 'readonly', 'disabled' ) as $k ) {

            if( !empty($field[ $k ]) ) {

                $atts[ $k ] = $k;
            }

        }


        // vars
        $els = array();
        $choices = array();


        if ($field['data_type']) {
        	// loop through values and add them as options
        	if( !empty($field['choices']) ) {

        	    foreach( $field['choices'] as $k => $v ) {

       		         if( is_array($v) ){

        	            // optgroup
        	            $els[] = array( 'type' => 'optgroup', 'label' => $k );

        	            if( !empty($v) ) {

        	                foreach( $v as $k2 => $v2 ) {
        	                	if ($field['type_value']) {
        	                		foreach ($terms as $key => $val) {

        	                			if ($val->name == $v2 ) {

        	                			    $els[] = array( 'type' => 'option', 'value' => $val->term_id, 'label' => $v2 , 'selected' => $slct = ($val->term_id == $field['value'] ? "selected": "") );
	
        	                			}
    	
        	                		}
        	                	} else {
        	                		$els[] = array( 'type' => 'option', 'value' => $k2, 'label' => $v2, 'selected' => $slct = ($k2 == $field['value'] ? "selected": "") );
        	                	}
	
	
        	                	$choices[] = $k2;
        	                }
	
        	            }
	
        	            $els[] = array( 'type' => '/optgroup' );
	
        	        } else {
	
        	            $els[] = array( 'type' => 'option', 'value' => $k, 'label' => $v, 'selected' => $slct = ($k == $field['value'] ? "selected": "") );
	
        	            $choices[] = $k;

        	        }

        	    }
        	}

        	// null
        	if( $field['allow_null'] ) {

        	    array_unshift( $els, array( 'type' => 'option', 'value' => '', 'label' => '- ' . $field['placeholder'] . ' -' ) );

        	}		
        
        	        
        	// html
        	echo '<select ' . acf_esc_attr( $atts ) . '>';	

	        	// construct html
	        	if( !empty($els) ) {

	        	    foreach( $els as $el ) {

	        	        // extract type
	        	        $type = acf_extract_var($el, 'type');


	        	        if( $type == 'option' ) {

	        	            // get label
	        	            $label = acf_extract_var($el, 'label');


	        	            // validate selected
	        	            if( acf_extract_var($el, 'selected') ) {

	        	                $el['selected'] = 'selected';

	         	           }
	        	            echo acf_esc_attr( $el );
	        	            echo '<option ' . acf_esc_attr( $el ) . '>' . $label . '</option>';

	        	        } else {

	        	            echo '<' . $type . ' ' . acf_esc_attr( $el ) . '>';
	        	        }
	        	    }

	        	}

        	echo '</select>';
        }
        else {

        	$els = '[';
        	$i = 0;
        	foreach( $field['choices'] as $k => $v ) {
       		    if( is_array($v) ){
       		    	$els .= '[';
       		    	foreach ($v  as $k2 => $v2) {
       		    		foreach ($terms as $key => $val) {
        	               	if ($val->name == $v2 ) {

        	               		$els .= '["' . $v2 .'","' . $val->term_id . '",'. '"' . $slug_name[$i] . '"],';
        	               	}
        	            }
       		    	}
       		    	$els .= '],';
       		    }
       		    $i++;
       		}
       		$els .= ']';

       	echo '<div class="h">';
        	echo '<div class="Taxonomies">';
				echo '<label class="" for="'. $field['key'] .'">Taxonomies</label> ';
				echo '<select class="js-multi-taxonomy-select2 taxonomiesF"  name="' . $field['name'] . '" id="' . $field['key'] . '-taxonomies">';
					$i = 0;
					foreach ($field['choices'] as $k => $v) {
						echo '<option value="' . $i++ . '">' . $k . '</option>';
					}
				echo '</select>';
			echo '</div>';


			echo '<div class="Terms">';
				echo '<label class="" >Terms</label> ';
				echo '<input name="' . $field['name'] . '[cat]" id="' . $field['key'] . '-terms" class="js-multi-taxonomy-select2 termsF" value="" />';
			echo '</div>';
		echo '</div>';
        	

        // }



            echo '
			<script>
				(function($){

					var arr = ' . $els . ';

		//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++

				$(".TaxonomiesF").each(function(){
   					$(this).ready(function(){	

   						$(this).closest(":has(.h .Terms .termsF)").find(".termsF").attr("name","' . $field['name'] . '[" + arr[$(this).closest(":has(.h .Taxonomies .TaxonomiesF)").find(".TaxonomiesF").val()][0][2]+ "]")

   						$(this).closest(":has(.h .Terms .termsF)").find(".termsF").select2({


							multiple: true,
					     	query: function (query) {

					     		   var data = {results: []}, i;
					
					     		   for (i in arr[$(this).closest(":has(.h .Taxonomies .TaxonomiesF)").find(".TaxonomiesF").val()] ) { 
					     		   		data.results.push({id: arr[$(this).closest(":has(.h .Taxonomies .TaxonomiesF)").find(".TaxonomiesF").val()][i][1] , text: arr[$(this).closest(":has(.h .Taxonomies .TaxonomiesF)").find(".TaxonomiesF").val()][i][0]});
					     		   }
					     		   query.callback(data);
 					    	},
 					    	initSelection : function (element, callback) {

    			   		var elementText = $(element).val();

    			        var data = {id: elementText, text: elementText};
    			        callback(data);
    			    	}
					    });
				    });				
   				});

		//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++

				})(jQuery);
			</script> ';
		}
	
    }

		
	/*
	*  input_admin_enqueue_scripts()
	*
	*  This action is called in the admin_enqueue_scripts action on the edit screen where your field is created.
	*  Use this action to add CSS + JavaScript to assist your render_field() action.
	*
	*  @type	action (admin_enqueue_scripts)
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	n/a
	*  @return	n/a
	*/

    function input_admin_enqueue_scripts() {

        $dir = plugin_dir_url( __FILE__ );


        // register & include JS
        wp_register_script( 'acf-input-multi-taxonomy-chooser', "{$dir}js/input.js" );
        wp_enqueue_script('acf-input-multi-taxonomy-chooser');


        // register & include CSS
        wp_register_style( 'acf-input-multi-taxonomy-chooser', "{$dir}css/input.css" ); 
        wp_enqueue_style('acf-input-multi-taxonomy-chooser');	

    }
	
	
	/*
	*  input_admin_head()
	*
	*  This action is called in the admin_head action on the edit screen where your field is created.
	*  Use this action to add CSS and JavaScript to assist your render_field() action.
	*
	*  @type	action (admin_head)
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	n/a
	*  @return	n/a
	*/

	/*
		
	function input_admin_head() {
	
		
		
	}
	
	*/
	
	
	/*
   	*  input_form_data()
   	*
   	*  This function is called once on the 'input' page between the head and footer
   	*  There are 2 situations where ACF did not load during the 'acf/input_admin_enqueue_scripts' and 
   	*  'acf/input_admin_head' actions because ACF did not know it was going to be used. These situations are
   	*  seen on comments / user edit forms on the front end. This function will always be called, and includes
   	*  $args that related to the current screen such as $args['post_id']
   	*
   	*  @type	function
   	*  @date	6/03/2014
   	*  @since	5.0.0
   	*
   	*  @param	$args (array)
   	*  @return	n/a
   	*/
   	
   	/*
   	
   	function input_form_data( $args ) {
	   	
		
	
   	}
   	
   	*/
	
	
	/*
	*  input_admin_footer()
	*
	*  This action is called in the admin_footer action on the edit screen where your field is created.
	*  Use this action to add CSS and JavaScript to assist your render_field() action.
	*
	*  @type	action (admin_footer)
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	n/a
	*  @return	n/a
	*/

	/*
		
	function input_admin_footer() {
	
		
		
	}
	
	*/
	
	
	/*
	*  field_group_admin_enqueue_scripts()
	*
	*  This action is called in the admin_enqueue_scripts action on the edit screen where your field is edited.
	*  Use this action to add CSS + JavaScript to assist your render_field_options() action.
	*
	*  @type	action (admin_enqueue_scripts)
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	n/a
	*  @return	n/a
	*/

	/*
	
	function field_group_admin_enqueue_scripts() {
		
	}
	
	*/

	
	/*
	*  field_group_admin_head()
	*
	*  This action is called in the admin_head action on the edit screen where your field is edited.
	*  Use this action to add CSS and JavaScript to assist your render_field_options() action.
	*
	*  @type	action (admin_head)
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	n/a
	*  @return	n/a
	*/

	/*
	
	function field_group_admin_head() {
	
	}
	
	*/


	/*
	*  load_value()
	*
	*  This filter is applied to the $value after it is loaded from the db
	*
	*  @type	filter
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	$value (mixed) the value found in the database
	*  @param	$post_id (mixed) the $post_id from which the value was loaded
	*  @param	$field (array) the field array holding all the field options
	*  @return	$value
	*/
	
	/*
	
	function load_value( $value, $post_id, $field ) {
		
		return $value;
		
	}
	
	*/
	
	
	/*
	*  update_value()
	*
	*  This filter is applied to the $value before it is saved in the db
	*
	*  @type	filter
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	$value (mixed) the value found in the database
	*  @param	$post_id (mixed) the $post_id from which the value was loaded
	*  @param	$field (array) the field array holding all the field options
	*  @return	$value
	*/
	
	/*
	
	function update_value( $value, $post_id, $field ) {
		
		return $value;
		
	}
	
	*/
	
	
	/*
	*  format_value()
	*
	*  This filter is appied to the $value after it is loaded from the db and before it is returned to the template
	*
	*  @type	filter
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	$value (mixed) the value which was loaded from the database
	*  @param	$post_id (mixed) the $post_id from which the value was loaded
	*  @param	$field (array) the field array holding all the field options
	*
	*  @return	$value (mixed) the modified value
	*/
		
	/*
	
	function format_value( $value, $post_id, $field ) {
		
		// bail early if no value
		if( empty($value) ) {
		
			return $value;
			
		}
		
		
		// apply setting
		if( $field['font_size'] > 12 ) { 
			
			// format the value
			// $value = 'something';
		
		}
		
		
		// return
		return $value;
	}
	
	*/
	
	
	/*
	*  validate_value()
	*
	*  This filter is used to perform validation on the value prior to saving.
	*  All values are validated regardless of the field's required setting. This allows you to validate and return
	*  messages to the user if the value is not correct
	*
	*  @type	filter
	*  @date	11/02/2014
	*  @since	5.0.0
	*
	*  @param	$valid (boolean) validation status based on the value and the field's required setting
	*  @param	$value (mixed) the $_POST value
	*  @param	$field (array) the field array holding all the field options
	*  @param	$input (string) the corresponding input name for $_POST value
	*  @return	$valid
	*/
	
	/*
	
	function validate_value( $valid, $value, $field, $input ){
		
		// Basic usage
		if( $value < $field['custom_minimum_setting'] )
		{
			$valid = false;
		}
		
		
		// Advanced usage
		if( $value < $field['custom_minimum_setting'] )
		{
			$valid = __('The value is too little!','acf-multi-taxonomy-chooser'),
		}
		
		
		// return
		return $valid;
		
	}
	
	*/
	
	
	/*
	*  delete_value()
	*
	*  This action is fired after a value has been deleted from the db.
	*  Please note that saving a blank value is treated as an update, not a delete
	*
	*  @type	action
	*  @date	6/03/2014
	*  @since	5.0.0
	*
	*  @param	$post_id (mixed) the $post_id from which the value was deleted
	*  @param	$key (string) the $meta_key which the value was deleted
	*  @return	n/a
	*/
	
	/*
	
	function delete_value( $post_id, $key ) {
		
		
		
	}
	
	*/
	
	
	/*
	*  load_field()
	*
	*  This filter is applied to the $field after it is loaded from the database
	*
	*  @type	filter
	*  @date	23/01/2013
	*  @since	3.6.0	
	*
	*  @param	$field (array) the field array holding all the field options
	*  @return	$field
	*/
	
	/*
	
	function load_field( $field ) {
		
		return $field;
		
	}	
	
	*/
	
	
	/*
	*  update_field()
	*
	*  This filter is applied to the $field before it is saved to the database
	*
	*  @type	filter
	*  @date	23/01/2013
	*  @since	3.6.0
	*
	*  @param	$field (array) the field array holding all the field options
	*  @return	$field
	*/
	
	/*
	
	function update_field( $field ) {
		
		return $field;
		
	}	
	
	*/
	
	
	/*
	*  delete_field()
	*
	*  This action is fired after a field is deleted from the database
	*
	*  @type	action
	*  @date	11/02/2014
	*  @since	5.0.0
	*
	*  @param	$field (array) the field array holding all the field options
	*  @return	n/a
	*/
	
	/*
	
	function delete_field( $field ) {
		
		
		
	}	
	
	*/
	
}


// create field
new acf_field_multi_taxonomy_chooser();

?>
