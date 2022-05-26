/* ------------------------------------------------------------------------------
 *
 *  # Custom JS code
 *
 *  Place here all your custom js. Make sure it's loaded after app.js
 *
 * ---------------------------------------------------------------------------- */

/* ------------------------------------------------------------------------------
 *
 *  # Login form with validation
 *
 *  Demo JS code for login_validation.html page
 *
 * ---------------------------------------------------------------------------- */

// Setup module
// ------------------------------

var ComponentLoad = (function () {
    // Uniform
    // var _componentUniform = function () {
    //     if (!$().uniform) {
    //         console.warn("Warning - uniform.min.js is not loaded.");
    //         return;
    //     }
    //     // Initialize
    //     $(".form-input-styled").uniform();
    // };
    // var _componentValidate = function () {
    //     if (!$().validate) {
    //         console.warn("Warning - validate.min.js is not loaded.");
    //         return;
    //     }
    // };
    var _componentFileUpload = function () {
        if (!$().fileinput) {
            console.warn("Warning - fileinput.min.js is not loaded.");
            return;
        }
    };
    // var _componentOwlCarousel = function () {
    //     if (!$().owlCarousel) {
    //         console.warn("Warning - owl.carousel.js is not loaded.");
    //         return;
    //     }
    // };
    // var _componentSweetAlert = function () {
    //     if (typeof swal == 'undefined') {
    //         console.warn('Warning - sweet_alert.min.js is not loaded.');
    //         return;
    //     }
    // };
    // var _componentSummernote = function () {
    //     if (!$().summernote) {
    //         console.warn('Warning - summernote.min.js is not loaded.');
    //         return;
    //     }
    // }
    // var _componentSortable = function () {
    //     if (!$().sortable) {
    //         console.warn('Warning - jquery_ui.js components are not loaded.');
    //         return;
    //     }
    // };

    return {
        init: function () {
            // _componentUniform();
            // _componentValidate();
            _componentFileUpload();
            // _componentOwlCarousel();
            // _componentSweetAlert();
            // _componentSummernote();
            // _componentSortable();
        },
    };
})();

var ImageAddUpload = (function () {
    var _componentImageAddUpload = function () {
        var modalTemplate =
            '<div class="modal-dialog modal-lg" role="document">\n' +
            '  <div class="modal-content">\n' +
            '    <div class="modal-header align-items-center">\n' +
            '      <h6 class="modal-title">{heading} <small><span class="kv-zoom-title"></span></small></h6>\n' +
            '      <div class="kv-zoom-actions btn-group">{toggleheader}{fullscreen}{borderless}{close}</div>\n' +
            "    </div>\n" +
            '    <div class="modal-body">\n' +
            '      <div class="floating-buttons btn-group"></div>\n' +
            '      <div class="kv-zoom-body file-zoom-content"></div>\n' +
            "{prev} {next}\n" +
            "    </div>\n" +
            "  </div>\n" +
            "</div>\n";

        var previewZoomButtonClasses = {
            toggleheader: "btn btn-light btn-icon btn-header-toggle btn-sm",
            fullscreen: "btn btn-light btn-icon btn-sm",
            borderless: "btn btn-light btn-icon btn-sm",
            close: "btn btn-light btn-icon btn-sm",
        };

        var previewZoomButtonIcons = {
            prev: '<i class="icon-arrow-left32"></i>',
            next: '<i class="icon-arrow-right32"></i>',
            toggleheader: '<i class="icon-menu-open"></i>',
            fullscreen: '<i class="icon-screen-full"></i>',
            borderless: '<i class="icon-alignment-unalign"></i>',
            close: '<i class="icon-cross2 font-size-base"></i>',
        };
        if($(".file-input-ajax").length) {
            $(".file-input-ajax").fileinput({
                browseLabel: "Browse",
                uploadUrl: upload_medial_url, // server upload action
                enableResumableUpload: true,
                initialPreviewAsData: true,
                allowedFileTypes: ["video"],
                overwriteInitial: true,
                autoOrientImage: false,
                // initialPreview: [],
                browseIcon: '<i class="icon-file-plus mr-2"></i>',
                uploadIcon: '<i class="icon-file-upload2 mr-2"></i>',
                removeIcon: '<i class="icon-cross2 font-size-base mr-2"></i>',
                fileActionSettings: {
                    removeIcon: '<i class="icon-bin"></i>',
                    removeClass: "",
                    uploadIcon: '<i class="icon-upload"></i>',
                    uploadClass: "",
                    zoomIcon: '<i class="icon-zoomin3"></i>',
                    zoomClass: "",
                    dragClass: 'p-2',
                    dragIcon: '<i class="icon-three-bars"></i>',
                    indicatorNew: '<i class="icon-file-plus text-success"></i>',
                    indicatorSuccess:
                        '<i class="icon-checkmark3 file-icon-large text-success"></i>',
                    indicatorError: '<i class="icon-cross2 text-danger"></i>',
                    indicatorLoading: '<i class="icon-spinner2 spinner text-muted"></i>',
                },
                uploadExtraData: {
                    '_token': csrf_token
                },
                layoutTemplates: {
                    icon: '<i class="icon-file-check"></i>',
                    modal: modalTemplate,
                },
                initialCaption: "No file selected",
                previewZoomButtonClasses: previewZoomButtonClasses,
                previewZoomButtonIcons: previewZoomButtonIcons,
                // deleteUrl: "file_delete.php"
            });
        }
    };

    return {
        init: function () {
            _componentImageAddUpload();
        },
    };
})();

// Initialize module
// ------------------------------

document.addEventListener("DOMContentLoaded", function () {
    ComponentLoad.init();
    ImageAddUpload.init();
});
