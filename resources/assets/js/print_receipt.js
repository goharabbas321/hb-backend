/**
 * Invoice Print
 */

'use strict';

document.addEventListener('DOMContentLoaded', function (e) {
    (function () {
        if (window.Landscape) {
            var style = $("<style>@media print { @page { size: landscape; } }</style>");
            $("head").append(style); // Add the style to force landscape
            window.print(); // Trigger the print dialog
            setTimeout(function () {
                style.remove(); // Remove the style after printing
            }, 1000);
        } else {
            window.print();
        }
    })();
});
