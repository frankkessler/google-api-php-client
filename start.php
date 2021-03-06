<?php
/**
 * @author Andrew Zappella < http://www.suisseo.ch/ >
 * @copyright 2012 Suisseo SARL
 * @license http://creativecommons.org/licenses/by-sa/3.0/
 * @package Google API PHP Client (Laravel Bundle)
 * @version 0.2.1 - 2013-03-17
 */

const BUNDLE_NAME = 'google-api-php-client';
 
Autoloader::map(array(
  'Google_Client' => Bundle::path(BUNDLE_NAME).'google-api-php-client'.DS.'src'.DS.'Google_Client.php',
));

// Autoloader::directories(array(Bundle::path(BUNDLE_NAME).'google-api-php-client'.DS.'src'.DS.'contrib'));

Laravel\IoC::singleton('google-api-php-client', function()
{
    
    $bundle_prefix = Bundle::prefix(BUNDLE_NAME);
    
    $config = array();
    $config['application_name'] = Config::get($bundle_prefix.'google.application_name');
    $config['oauth2_client_id'] = Config::get($bundle_prefix.'google.client_id');
    $config['oauth2_client_secret'] = Config::get($bundle_prefix.'google.client_secret');
    $config['oauth2_redirect_uri'] = Config::get($bundle_prefix.'google.redirect_uri');
    $config['developer_key'] = Config::get($bundle_prefix.'google.developer_key');
    $config['use_objects'] = Config::get($bundle_prefix.'google.use_objects');
    
    $google = new Google_Client($config);
    $google->setScopes(Config::get($bundle_prefix.'google.set_scopes'));
    $google->setAccessType(Config::get($bundle_prefix.'google.access_type'));
    $google->setApprovalPrompt(Config::get($bundle_prefix.'google.approval_prompt'));
    
    // autoload Google API services
    $classes = Google::services();
    $mappings = Google::format_mappings($classes);
    Autoloader::map($mappings);
    
    return $google;
    
});


