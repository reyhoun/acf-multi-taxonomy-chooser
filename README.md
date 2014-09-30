# ACF Multi Taxonomy Chooser Field

Display all taxonomies and display all terms of each taxonomy selected.

-----------------------

### Structure

* `/css`:  folder for .css files.
* `/js`: folder for .js files
* `/lang`: folder for .pot, .po and .mo files
* `acf-multi-taxonomy-chooser.php`: Main plugin file that includes the correct field file based on the ACF version
* `multi-taxonomy-chooser-v5.php`: Field class compatible with ACF version 5 
* `multi-taxonomy-chooser-v4.php`: Field class compatible with ACF version 4
* `readme.txt`: WordPress readme file to be used by the wordpress repository

### Compatibility

This ACF field type is compatible with:
* ACF 5

### Installation

1. Copy the `acf-multi-taxonomy-chooser` folder into your `wp-content/plugins` folder
2. Activate the Multi Taxonomy Chooser plugin via the plugins admin page
3. Create a new field via ACF and select the Multi Taxonomy Chooser type
4. Please refer to the Choose multi taxonomies. for more info regarding the field type settings

### Changelog
Please see `readme.txt` for changelog

## 1.2.1
* bug fix: slug return

## 1.2.0
* add two step term selector

## 1.1.0
* add option to change return value

## 1.0.0 
* Initial Release.