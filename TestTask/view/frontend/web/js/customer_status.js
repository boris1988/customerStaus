define([
    "jquery",
    "Magento_Customer/js/customer-data"
], function($,customerData){
    'use strict';

    return function (config, element) {
        var data = customerData.get('customer_status')();
        if (data) {
            $(element).text(data.customer_status);
        }
    }
});
