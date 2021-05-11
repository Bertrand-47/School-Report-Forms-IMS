$(document).ready(function () {
    var getUrlParameter = function getUrlParameter(sParam) {
        var sPageURL = decodeURIComponent(window.location.search.substring(1)),
            sURLVariables = sPageURL.split('&'),
            sParameterName,
            i;

        for (i = 0; i < sURLVariables.length; i++) {
            sParameterName = sURLVariables[i].split('=');

            if (sParameterName[0] === sParam) {
                return sParameterName[1] === undefined ? true : sParameterName[1];
            }
        }
    };

    $(".exportexcel").click(function () {
        exportEXCEL();
    });
    $(".exportpdf").click(function () {
        exportPDF();
    });

    //export
    function exportEXCEL() {

        $('#myTable').tableExport({
            fileName: "student_report",
            type: 'csv',
            bootstrap: true,
            postCallback: function () {}
        });
    }

    function exportPDF() {
        // $('#myTable').tableExport({type:'pdf',
        //     jspdf: {
        //         // orientation: 'l',
        //         format: 'a4',
        //         autotable: {styles: {border: '1px solid black'}}
        //     }
        // });
        // $('#myTable').tableExport({
        //     fileName: "student_report",
        //     type:'pdf',
        //     escape: false,
        // });
        var pdf = new jsPDF('p', 'pt', 'a4');
        // source can be HTML-formatted string, or a reference
        // to an actual DOM element from which the text will be scraped.
        source = $('#myTable')[0];

        // we support special element handlers. Register them with jQuery-style
        // ID selector for either ID or node name. ("#iAmID", "div", "span" etc.)
        // There is no support for any other type of selectors
        // (class, of compound) at this time.
        specialElementHandlers = {
            // element with id of "bypass" - jQuery style selector
            '#bypassme': function (element, renderer) {
                // true = "handled elsewhere, bypass text extraction"
                return true
            }
        };
        margins = {
            top: 80,
            bottom: 60,
            left: 40,
            width: 522
        };
        // all coords and widths are in jsPDF instance's declared units
        // 'inches' in this case
        pdf.fromHTML(
            source, // HTML string or DOM elem ref.
            margins.left, // x coord
            margins.top, { // y coord
                'width': margins.width, // max width of content on PDF
                'elementHandlers': specialElementHandlers
            },

            function (dispose) {
                // dispose: object with X, Y of the last line add to the PDF
                //          this allow the insertion of new lines after html
                pdf.save('Test.pdf');
            }, margins);
    }
})