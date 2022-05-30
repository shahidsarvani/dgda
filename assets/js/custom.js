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
        if ($(".file-input-ajax").length) {
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

var DropzoneUpload = (function () {
    var _componentDropzone = function () {
        if (typeof Dropzone == 'undefined') {
            console.warn('Warning - dropzone.min.js is not loaded.');
            return;
        }

        // Multiple files
        Dropzone.options.dropzoneMultipleFiles = {
            paramName: "media", // The name that will be used to transfer the file
            dictDefaultMessage: 'Drop files to upload <span>or CLICK</span>',
            maxFilesize: 400000000, // MB
            addRemoveLinks: true,
            chunking: true,
            chunkSize: 4000000,
            // If true, the individual chunks of a file are being uploaded simultaneously.
            parallelChunkUploads: true,
            acceptedFiles: 'video/*',
            init: function() {
                this.on('addedfile', function() {
                    // list.append('<li>Uploading</li>')
                }),
                this.on('sending', function (file, xhr, formData) {
                    formData.append("_token", csrf_token);
            
                    // This will track all request so we can get the correct request that returns final response:
                    // We will change the load callback but we need to ensure that we will call original
                    // load callback from dropzone
                    var dropzoneOnLoad = xhr.onload;
                    xhr.onload = function (e) {
                        dropzoneOnLoad(e)
            
                        // Check for final chunk and get the response
                        var uploadResponse = JSON.parse(xhr.responseText)
                        if (typeof uploadResponse.name === 'string') {
                            // list.append('<li>Uploaded: ' + uploadResponse.path + uploadResponse.name + '</li>')
                        }
                    }
                })
            }
        };
        // myDropzone.on('addedfile', function () {
        //     $list.append('<li>Uploading</li>')
        // })

        // Single files
        Dropzone.options.dropzoneSingle = {
            paramName: "file", // The name that will be used to transfer the file
            maxFilesize: 1, // MB
            maxFiles: 1,
            dictDefaultMessage: 'Drop file to upload <span>or CLICK</span>',
            autoProcessQueue: false,
            init: function () {
                this.on('addedfile', function (file) {
                    if (this.fileTracker) {
                        this.removeFile(this.fileTracker);
                    }
                    this.fileTracker = file;
                });
            }
        };

        // Accepted files
        Dropzone.options.dropzoneAcceptedFiles = {
            paramName: "file", // The name that will be used to transfer the file
            dictDefaultMessage: 'Drop files to upload <span>or CLICK</span>',
            maxFilesize: 1, // MB
            acceptedFiles: 'image/*'
        };

        // Removable thumbnails
        Dropzone.options.dropzoneRemove = {
            paramName: "file", // The name that will be used to transfer the file
            dictDefaultMessage: 'Drop files to upload <span>or CLICK</span>',
            maxFilesize: 1, // MB
            addRemoveLinks: true
        };

        // File limitations
        Dropzone.options.dropzoneFileLimits = {
            paramName: "file", // The name that will be used to transfer the file
            dictDefaultMessage: 'Drop files to upload <span>or CLICK</span>',
            maxFilesize: 0.4, // MB
            maxFiles: 4,
            maxThumbnailFilesize: 1,
            addRemoveLinks: true
        };
    };

    return {
        init: function() {
            _componentDropzone();
        }
    }
})();


// Initialize module
// ------------------------------

document.addEventListener("DOMContentLoaded", function () {
    // ComponentLoad.init();
    // ImageAddUpload.init();
});
DropzoneUpload.init();
