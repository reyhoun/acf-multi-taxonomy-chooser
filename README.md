# ACF Field Type Template

Welcome to the Advanced Custom Fields field type template repository.
Here you will find a starter-kit for creating a new ACF field type. This start-kit will work as a normal WP plugin.

For more information about creating a new field type, please read the following article:
http://www.advancedcustomfields.com/resources/tutorials/creating-a-new-field-type/

### Structure

* `/css`:  folder for .css files.
* `/images`: folder for image files
* `/js`: folder for .js files
* `/lang`: folder for .pot, .po and .mo files
* `acf-multi-taxonomy-chooser.php`: Main plugin file that includes the correct field file based on the ACF version
* `multi-taxonomy-chooser-v5.php`: Field class compatible with ACF version 5 
* `multi-taxonomy-chooser-v4.php`: Field class compatible with ACF version 4
* `readme.txt`: WordPress readme file to be used by the wordpress repository

### step 1.

This template uses `PLACEHOLDERS` such as `multi-taxonomy-chooser` throughout the file names and code. Use the following list of placeholders to do a 'find and replace':

* `multi-taxonomy-chooser`: Single word, no spaces. Underscores allowed. eg. donate_button
* `Multi Taxonomy Chooser`: Multiple words, can include spaces, visible when selecting a field type. eg. Donate Button
* `http://reyhoun.com`: Url to the github or WordPress repository
* `ACF, Taxonomy, Field, Multi`: Comma seperated list of relevant tags
* `Choose multi taxonomies.`: Brief Choose multi taxonomies. of the field type, no longer than 2 lines
* `EXTENDED_Choose multi taxonomies.`: Extended Choose multi taxonomies. of the field type
* `Parhum Khoshbakht`: Name of field type author
* `http://parhum.net/`: URL to author's website

### step 2.

Edit the `multi-taxonomy-chooser-v5.php` and `multi-taxonomy-chooser-v4.php` files (now renamed using your field name) and include your custom code in the appropriate functions. 
Please note that v4 and v5 field classes have slightly different functions. For more information, please read:
* http://www.advancedcustomfields.com/resources/tutorials/creating-a-new-field-type/

### step 3.

Edit this `README.md` file with the appropriate information and delete all content above and including the following line.

-----------------------

# ACF Multi Taxonomy Chooser Field

Choose multi taxonomies.

-----------------------

### Choose multi taxonomies.

EXTENDED_Choose multi taxonomies.

### Compatibility

This ACF field type is compatible with:
* ACF 5
* ACF 4

### Installation

1. Copy the `acf-multi-taxonomy-chooser` folder into your `wp-content/plugins` folder
2. Activate the Multi Taxonomy Chooser plugin via the plugins admin page
3. Create a new field via ACF and select the Multi Taxonomy Chooser type
4. Please refer to the Choose multi taxonomies. for more info regarding the field type settings

### Changelog
Please see `readme.txt` for changelog
