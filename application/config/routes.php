<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/*
  | -------------------------------------------------------------------------
  | URI ROUTING
  | -------------------------------------------------------------------------
  | This file lets you re-map URI requests to specific controller functions.
  |
  | Typically there is a one-to-one relationship between a URL string
  | and its corresponding controller class/method. The segments in a
  | URL normally follow this pattern:
  |
  |	example.com/class/method/id/
  |
  | In some instances, however, you may want to remap this relationship
  | so that a different class/function is called than the one
  | corresponding to the URL.
  |
  | Please see the user guide for complete details:
  |
  |	https://codeigniter.com/user_guide/general/routing.html
  |
  | -------------------------------------------------------------------------
  | RESERVED ROUTES
  | -------------------------------------------------------------------------
  |
  | There are three reserved routes:
  |
  |	$route['default_controller'] = 'welcome';
  |
  | This route indicates which controller class should be loaded if the
  | URI contains no data. In the above example, the "welcome" class
  | would be loaded.
  |
  |	$route['404_override'] = 'errors/page_missing';
  |
  | This route will tell the Router which controller/method to use if those
  | provided in the URL cannot be matched to a valid route.
  |
  |	$route['translate_uri_dashes'] = FALSE;
  |
  | This is not exactly a route, but allows you to automatically route
  | controller and method names that contain dashes. '-' isn't a valid
  | class or method name character, so it requires translation.
  | When you set this option to TRUE, it will replace ALL dashes in the
  | controller and method URI segments.
  |
  | Examples:	my-controller/index	-> my_controller/index
  |		my-controller/my-method	-> my_controller/my_method
 */
$route['default_controller'] = 'Home_Controller';
$route['404_override'] = '';
$route['translate_uri_dashes'] = TRUE;
/* ==============================================================================
 * Admin Section
 * Routes defined
  =============================================================================== */
$route["21232f297a57a5a743894a0e4a801fc3/login"] = 'admin/User_Controller/login';

$route["21232f297a57a5a743894a0e4a801fc3/sign-out"] = 'admin/User_Controller/logout';

$route["21232f297a57a5a743894a0e4a801fc3"] = 'admin/Dashboard_Controller';

$route["21232f297a57a5a743894a0e4a801fc3/projects"] = 'admin/Project_Controller/pagination_project';

$route["21232f297a57a5a743894a0e4a801fc3/projects/(:any)"] = 'admin/Project_Controller/pagination_project/$1';

$route["21232f297a57a5a743894a0e4a801fc3/search-comapnies"] = 'admin/Project_Controller/get_search_company_project';

$route["21232f297a57a5a743894a0e4a801fc3/search-users"] = 'admin/Project_Controller/search_user';

$route["21232f297a57a5a743894a0e4a801fc3/move-project"] = 'admin/Project_Controller/move_project';

$route["21232f297a57a5a743894a0e4a801fc3/search-domain"] = 'admin/Project_Controller/search_project';

$route["21232f297a57a5a743894a0e4a801fc3/search-project"] = 'admin/Project_Controller/get_search_project';

$route["21232f297a57a5a743894a0e4a801fc3/filter-project"] = 'admin/Project_Controller/get_project';


$route["21232f297a57a5a743894a0e4a801fc3/register"] = 'register';

$route["21232f297a57a5a743894a0e4a801fc3/companies"] = 'companies';

$route["21232f297a57a5a743894a0e4a801fc3/edit-company-profile/(:any)"] = 'companies/get_register_data/$1';

$route["21232f297a57a5a743894a0e4a801fc3/update-profile"] = 'companies/update_user_profile';

$route["21232f297a57a5a743894a0e4a801fc3/update_user"] = 'companies/update_user_sataus';

$route["21232f297a57a5a743894a0e4a801fc3/alerts"] = 'alerts';

$route["21232f297a57a5a743894a0e4a801fc3/add-alert"] = 'alerts/manage_alert';

$route["21232f297a57a5a743894a0e4a801fc3/edit-alert"] = 'alerts/edit_alert';

$route["21232f297a57a5a743894a0e4a801fc3/edit-delete/(:any)"] = 'alerts/delete/$1';

$route["21232f297a57a5a743894a0e4a801fc3/email/"] = 'admin/Email_template';

$route["21232f297a57a5a743894a0e4a801fc3/hostmanager"] = 'hostmanager';

$route["21232f297a57a5a743894a0e4a801fc3/add-host-company"] = 'hostmanager/add';

$route["21232f297a57a5a743894a0e4a801fc3/edit-host-company/(:any)"] = 'hostmanager/edit/$1';

$route["21232f297a57a5a743894a0e4a801fc3/delete-host-company/(:any)"] = 'hostmanager/delete/$1';

$route["21232f297a57a5a743894a0e4a801fc3/mail-server"] = 'admin/Mail_Hosting_Controller';

$route["21232f297a57a5a743894a0e4a801fc3/add-mail-server"] = 'admin/Mail_Hosting_Controller/add';

$route["21232f297a57a5a743894a0e4a801fc3/edit-mail-server/(:any)"] = 'admin/Mail_Hosting_Controller/edit/$1';

$route["21232f297a57a5a743894a0e4a801fc3/delete-mail-server/(:any)"] = 'admin/Mail_Hosting_Controller/delete/$1';

$route["21232f297a57a5a743894a0e4a801fc3/errro-massage"] = 'admin/Error_Message_Controller';

$route["21232f297a57a5a743894a0e4a801fc3/edit-message"] = 'admin/Error_Message_Controller/get_message';

$route["21232f297a57a5a743894a0e4a801fc3/delete/(:any)"] = 'admin/Error_Message_Controller/delete/$1';

$route["21232f297a57a5a743894a0e4a801fc3/login_user/(:any)"] = 'admin/Dashboard_Controller/user_login/$1';

$route["21232f297a57a5a743894a0e4a801fc3/email-templates"] = 'admin/Email_template';

$route["21232f297a57a5a743894a0e4a801fc3/add-email-template"] = 'admin/Email_template/add';

$route["21232f297a57a5a743894a0e4a801fc3/edit-email-template"] = 'admin/Email_template/edit';

$route["21232f297a57a5a743894a0e4a801fc3/delete-email-template/(:any)"] = 'admin/Email_template/delete/$1';

$route["21232f297a57a5a743894a0e4a801fc3/alert-setting"] = 'admin/Alert_Setting_Controller';

$route["21232f297a57a5a743894a0e4a801fc3/update-alert-setting"] = 'admin/Alert_Setting_Controller/update';

$route["21232f297a57a5a743894a0e4a801fc3/cron-frequency"] = 'admin/Alert_Setting_Controller/cron_frequency';

$route["21232f297a57a5a743894a0e4a801fc3/save-frequency"] = 'admin/Alert_Setting_Controller/save_frequency';


/* ==============================================================================
 * Public Section
 * Routes defined
  =============================================================================== */
$route["project-list/(:any)"] = "Home_Controller/project_list/$1";

$route["queue-status/(:any)"] = "Home_Controller/check_queue_status/$1";

$route["connection"] = "Handshake_Controller";

$route["search/(:any)"] = "Home_Controller/search/$1";

$route["autocomplete/(:any)"] = "Home_Controller/autocomplete/$1";

$route["public"] = "public/User_Controller";

$route["login"] = "auth";

$route["login/(:any)"] = "auth";

$route["reset-password"] = "reset";

$route["new-password"] = "reset/set_password";

$route["new-password/(:any)"] = "reset/set_password";

$route["save-password"] = "reset/save_new_password";

$route["logout"] = "public/User_Controller/logout";

$route["profile/update"] = "profile/update_profile";

$route["profile/photo"] = "profile/upload_profile_photo";

$route["profile/reset-brand"] = "profile/reset_branding";



$route["close-account"] = "profile/close_account";

$route["save-brand"] = "profile/save_brand/";

$route["confirm-close-account/(:any)"] = "profile/confirm_close_account/$1";

$route["add-project"] = "project/step_first";

$route["project/edit/(:any)"] = "project/update_project/$1";

$route["project/update-cpanel"] = "project/update_cPanel_details";

$route["project/detail/(:any)"] = "project/project_detail/$1";

$route["project/delete/(:any)"] = "project/delete_project/$1";

$route["projects"] = "project";

$route["update-alerts"] = "project/update_alerts";

$route["project/down-time"] = "project/get_down_time";

$route["project/malware"] = "project/malware";

$route["project/save-admin-credential"] = "project/step_three";

$route["thanku"] = "project/thanku";

$route["wp-admin-auth/(:any)"] = "project/wp_login/$1";

$route["check-cms"] = "public/Local_Controller/check_cms";

$route["wp-auth-verify"] = "public/Local_Controller/wp_verify_auth";

$route["update-counter"] = "public/Local_Controller/update_alert_counter"; 

$route["wp-update-info"] = "project/wp_update_info";

$route["wp-info/(:any)"] = "public/WP_Controller/index/$1";

$route["check-health-intervel/(:any)"] = "project/check_helth/$1";

$route["congifure/(:any)"] = "project/configure_alert/$1";

$route["skip"] = "project/skip";

$route["up-time-info/(:any)"] = "project/display_up_time_info/$1";

$route["malware-blacklist-info/(:any)"] = "project/display_malware_blacklist_info/$1";

$route["projects/(:any)"] = "project";

$route["project/cpanel/(:any)"] = "project/auto_login_cpanel/$1";

$route["alerts"] = "public/Alert_Controller";

$route["login-google"] = "public/GoogleAnalytics_Controller/google_aouth";

$route["oauth"] = "public/GoogleAnalytics_Controller";

$route["logout-analytics/(:any)"] = "public/GoogleAnalytics_Controller/unlink_google_analytic/$1";

$route["acquisation"] = "public/GoogleAnalytics_Controller/get_acquisation";

$route["keywords"] = "public/GoogleAnalytics_Controller/get_keywords";

$route["new-vs-return"] = "public/GoogleAnalytics_Controller/return_visitor";

$route["landing-page"] = "public/GoogleAnalytics_Controller/landing_report";

$route["fetch-site-speed/(:any)"] = "public/Fetch_Controller/fetch_site_speed/$1";

$route["fetch-responsive-status/(:any)"] = "public/Fetch_Controller/fetch_responsive_pages/$1";

$route["fetch-blacklist-status/(:any)"] = "public/Fetch_Controller/fetch_blacklist/$1";

$route["fetch-uptime-status/(:any)"] = "public/Fetch_Controller/fetch_uptime_status/$1";

$route["fetch-website-info/(:any)"] = "public/Fetch_Controller/fetch_website_info/$1";

$route["fetch-wp-status/(:any)"] = "public/Fetch_Controller/fetch_wp_status/$1";

$route["fetch-domain-status/(:any)"] = "public/Fetch_Controller/fetch_domain_status/$1";

$route["managements"] = "public/GoogleAnalytics_Controller/managementAccounts";

$route["returning-graph"] = "public/GoogleAnalytics_Controller/return_visitor_graph";

$route["device-perform"] = "public/GoogleAnalytics_Controller/device_performance";

$route["bounce-vs-exit"] = "public/GoogleAnalytics_Controller/bounce_vs_exit_rate";

$route["sitemap"] = "public/GoogleAnalytics_Controller/sitemap";

$route["get-report/(:any)"] = "public/Report_Controller/report/$1";

$route["acquisation-pdf"] = "public/Report_Controller/acquisation_pdf_report";

$route["keyword-pdf"] = "public/Report_Controller/keywords_pdf_report";

$route["newvsreturning-pdf"] = "public/Report_Controller/newVsReturning_pdf_report";

$route["landing-pdf"] = "public/Report_Controller/landing_pdf_report";

$route["top-search-pdf/(:any)"] = "public/Report_Controller/top_query_pdf_report/$1";

$route["report-setting"] = "public/Report_Controller/report_setting";

$route["blacklist-report/(:any)"] = "public/Blacklist_Controller/get/$1";

$route["responsiveness/(:any)"] = "public/Responsive_Controller/index/$1";

$route["speed-status/(:any)"] = "public/Speed_Controller/index/$1";










