<?php
/**
 * Plugin Name: PMPRO append current year and a counter of invoice number.
 * Plugin URI:  https://www.expresstechsoftwares.com
 * Description: This small plugin will append current YEAR as well invoice counter at the end of the invoice number.<a href="https://www.expresstechsoftwares.com">Get more plugins for your e-commerce shop on <strong>ExpressTech</strong></a>.
 * Version: 1.0.0
 * Author: ExpressTech Software Solutions Pvt. Ltd.
 * Text Domain: pmpro_invoice_ets
 */

if ( ! defined( 'WPINC' ) ) {
	die;
}

// Check class exist
if( !class_exists("ETS_PMPRO_INVOICE_CONFIG") ) :

    /* create class ETS_PMPRO_INVOICE_CONFIG*/
    class ETS_PMPRO_INVOICE_CONFIG
    {
        public function __construct() {
            // add filter pmpro_random_code
            add_filter('pmpro_random_code', array($this,'append_invoice_number'));
        }

        /**
         * Description : This method is to append Year and s.no in the invoice number.
         *
         * @param:- {$invoice} 
         *
         * @return:- {$invoice}
         */ 
        public function append_invoice_number($code){
            global $wpdb;
            $date = "-".date("Y");
            $year = date("Y-m-d");
            $i = 1;
             
            // get all invoice from current user
            $check = $wpdb->get_results( "SELECT code FROM $wpdb->pmpro_membership_orders WHERE year(`timestamp`) = year('$year')" );
            if($check){
                foreach ($check  as $index => $value) {
                    if(isset($value->code) && $value->code){
                        if(strpos($value->code, $date)){
                            $i++;
                        }
                    }
                }
            }
            if(!strpos($code, $date)){
                $code = $code.$date;
            }
            return $code.'-'.str_pad($i, 2, '0', STR_PAD_LEFT);
        }
    }

endif;

// Create class object
new ETS_PMPRO_INVOICE_CONFIG();