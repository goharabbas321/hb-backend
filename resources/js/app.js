import './bootstrap';
import $ from 'jquery';
import dt from 'datatables.net';
import __ from './i18n';

/*
  Add custom scripts here
*/
import.meta.glob([
    //'../assets/img/**',
    // '../assets/json/**',
    '../assets/vendor/fonts/**'
]);

// Language Translation Setup
window.__ = __;

// Jquery Setup
window.$ = window.jQuery = $;

$('.dt-table').DataTable({
    language: {
        url: window.APP_URL + '/assets/json/i18n/' + window.APP_LOCALE + '.json'
    },
});


$('.dt-export').DataTable({
    language: {
        url: window.APP_URL + '/assets/json/i18n/' + window.APP_LOCALE + '.json'
    },
    paging: false,  // Disable pagination
    searching: false, // Remove the search bar
    info: false, // Remove "Showing X of Y entries"
    ordering: false, // Disable sorting
    dom: 'Bfrtip', // Show only buttons (export options)
    buttons: [
        {
            extend: 'csv',
            text: 'تصدير إلى CSV' // Arabic translation for CSV export
        },
        {
            extend: 'excel',
            text: 'تصدير إلى Excel' // Arabic translation for Excel export
        },
    ]
});


import.meta.glob(['../assets/img/**', '../assets/vendor/fonts/**']);
