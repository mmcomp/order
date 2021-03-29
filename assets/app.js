/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

import jquery from 'jquery';
import 'jquery-ui';

import '@pugx/autocompleter-bundle/js/autocompleter-jqueryui';

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css';

// start the Stimulus application
import './bootstrap';

console.log("Start");

$('#order_item_product').autocompleter({
    url_list: '{{ path("searchproduct") }}',
    url_get: '{{ path("getproduct") }}'
});
