/*=========================================================================================
    File Name: form-file-uploader.js
    Description: dropzone
    --------------------------------------------------------------------------------------
    Item Name: Vuexy  - Vuejs, HTML & Laravel Admin Dashboard Template
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

Dropzone.autoDiscover = false;

$(function () {
    "use strict";
    var linkCount=0;
    var singleFile = $("#dpz-single-file");
    var multipleFiles = $("#dpz-multiple-files");
    var homeMultipleFiles = $("#dpz-home-multiple-files");
    var buttonSelect = $("#dpz-btn-select-files");
    var limitFiles = $("#dpz-file-limits");
    var acceptFiles = $("#dpz-accept-files");
    var removeThumb = $("#dpz-remove-thumb");
    var removeAllThumbs = $("#dpz-remove-all-thumb");

    // Basic example
    singleFile.dropzone({
        paramName: "file", // The name that will be used to transfer the file
        maxFiles: 1,
    });

    // Multiple Files
    multipleFiles.dropzone({
        paramName: "file", // The name that will be used to transfer the file
        maxFilesize: 500, // MB
        clickable: true,
        // acceptedFiles: ".jpeg,.jpg,.png,.gif",
        // addRemoveLinks: true,
        success: function (file, response) {
            $("#uploadFileModal").modal("hide");
            let url = window.location.href;
            window.location.href = url;
        },
        error: function (file, reject) {
            $("#rejectResponse").append('<hr><p class="text-danger">Error For '+file.upload.filename+'</p>');
            $("#rejectResponse").append('<small class="text-danger">'+reject+'</small><br>');
        },
    });

    // Home Multiple Files
    homeMultipleFiles.dropzone({
        paramName: "file", // The name that will be used to transfer the file
        maxFilesize: 500, // MB
        clickable: true,
        // acceptedFiles: ".jpeg,.jpg,.png,.gif",
        // addRemoveLinks: true,
        success: function (file, response) {
            $(".dz-processing").remove();
            $(".linkContent").append(
                '<div class="col-5 m-3 py-3 contentBorder"> <div class="input-group"> <input type="text" class="form-control" id="link_'+linkCount+'" value="'+response.success.data.shareFile+'" aria-describedby="button-addon2"/> <div class="input-group-append" id="button-addon2"> <button class="btn btn-primary copyLink_'+linkCount+'"  data-clipboard-target="#link_'+linkCount+'" onclick="copy_to_clipboard(\'copyLink_'+linkCount+'\')" type="button">Copy</button> </div></div><a href="'+response.success.data.shareFile+'" class="btn btn-primary btn-block mt-2">Go to download page</a></div>'
            );
            linkCount++;
        },
        error: function (file, reject) {
            $("#rejectResponse").append('<hr><p class="text-danger">Error For '+file.upload.filename+'</p>');
            $("#rejectResponse").append('<small class="text-danger">'+reject+'</small><br>');
           
        },
    });

    // Use Button To Select Files
    buttonSelect.dropzone({
        clickable: "#select-files", // Define the element that should be used as click trigger to select files.
    });

    // Limit File Size and No. Of Files
    limitFiles.dropzone({
        paramName: "file", // The name that will be used to transfer the file
        maxFilesize: 0.5, // MB
        maxFiles: 5,
        maxThumbnailFilesize: 1, // MB
    });

    // Accepted Only Files
    acceptFiles.dropzone({
        paramName: "file", // The name that will be used to transfer the file
        maxFilesize: 1, // MB
        acceptedFiles: "image/*",
    });

    //Remove Thumbnail
    removeThumb.dropzone({
        paramName: "file", // The name that will be used to transfer the file
        maxFilesize: 1, // MB
        addRemoveLinks: true,
        dictRemoveFile: " Trash",
    });

    // Remove All Thumbnails
    removeAllThumbs.dropzone({
        paramName: "file", // The name that will be used to transfer the file
        maxFilesize: 1, // MB
        init: function () {
            // Using a closure.
            var _this = this;

            // Setup the observer for the button.
            $("#clear-dropzone").on("click", function () {
                // Using "_this" here, because "this" doesn't point to the dropzone anymore
                _this.removeAllFiles();
                // If you want to cancel uploads as well, you
                // could also call _this.removeAllFiles(true);
            });
        },
    });
});
