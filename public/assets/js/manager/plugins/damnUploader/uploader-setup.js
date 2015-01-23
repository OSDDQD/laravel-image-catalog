(function($) {

    $(function() {
        var $fileInput = $('#file-input');
        var $dropBox = $('#drop-box');
        var $uploadForm = $('#upload-form');
        var $uploadRows = $('#upload-rows');
        var $clearBtn = $('#clear-btn');
        var $sendBtn = $('#send-btn');
        //var $position = $('#muPosition');
        var $autostartChecker = $('#autostart-checker');
        var autostartOn = false;
        var $previewsChecker = $('#previews-checker');
        var previewsOn = true;

        ///// Uploader init
        $fileInput.damnUploader({
            // URL of server-side upload handler
            url: '/manager/gallery/photos/upload',
            // File POST field name (for ex., it will be used as key in $_FILES array, if you using PHP)
            fieldName:  'gallery-file',
            // Container for handling drag&drops (not required)
            dropBox: $dropBox,
            // Limiting queued files count (if not defined [or false] - queue will be unlimited)
            limit: 5,
            // Expected response type ('text' or 'json')
            dataType: 'text'
        });


        ///// Misc funcs

        var isTextFile = function(file) {
            return file.type == 'text/plain';
        };

        var isImgFile = function(file) {
            return file.type.match(/image.*/);
        };


        // Creates queue table row with file information and upload status
        var createRowFromUploadItem = function(ui) {
            var $row = $('<tr/>').prependTo($uploadRows);
            var $progressBar = $('<div/>').addClass('progress-bar').css('width', '0%');
            var $pbWrapper = $('<div/>').addClass('progress').append($progressBar);

            // Defining cancel button & its handler
            var $cancelBtn = $('<a/>').attr('href', 'javascript:').append(
                $('<i/>').addClass('fa fa-fw fa-remove')
            ).on('click', function() {
                var $statusCell = $pbWrapper.parent();
                $statusCell.empty().html('<i>cancelled</i>');
                ui.cancel();
                log((ui.file.name || "[custom-data]") + " canceled");
            });

            var $position = $('<a/>').attr('href', 'javascript:').append(
                $('<input/>').attr({'type': 'text', 'name': 'position', 'id': 'position-' + ui.id()})
            );

            // Generating preview
            var $preview;
            if (previewsOn) {
                if (isImgFile(ui.file)) {
                    // image preview (note: might work slow with large images)
                    $preview = $('<img/>').attr('width', 120);
                    ui.readAs('DataURL', function(e) {
                        $preview.attr('src', e.target.result);
                    });
                } else {
                    // plain text preview
                    $preview = $('<i/>');
                    ui.readAs('Text', function(e) {
                        $preview.text(e.target.result.substr(0, 15) + '...');
                    });
                }
            } else {
                $preview = $('<i>no preview</i>');
            }

            // Appending cells to row
            $('<td/>').append($preview).appendTo($row); // Preview
            $('<td/>').text(ui.file.name).appendTo($row); // Filename
            $('<td/>').text(Math.round(ui.file.size / 1024) + ' KB').appendTo($row); // Size in KB
            $('<td/>').append($pbWrapper).appendTo($row); // Status
            $('<td/>').append($position).appendTo($row); // Position
            $('<td/>').append($cancelBtn).appendTo($row); // Cancel button
            return $progressBar;
        };
        //assets/js/manager/plugins/damnUploader/jquery.damnUploader.js"
        // File adding handler
        var fileAddHandler = function(e) {
            // e.uploadItem represents uploader task as special object,
            // that allows us to define complete & progress callbacks as well as some another parameters
            // for every single upload
            var ui = e.uploadItem;
            var filename = ui.file.name || ""; // Filename property may be absent when adding custom data
           // var positionVal = ui.value.value || ""; // Filename property may be absent when adding custom data

            // We can call preventDefault() method of event to cancel adding
            if (!isTextFile(ui.file) && !isImgFile(ui.file)) {
                log(filename + ": is not image. Only images & plain text files accepted!");
                e.preventDefault();
                return ;
            }

            // We can replace original filename if needed
            if (!filename.length) {
                ui.replaceName = "custom-data";
            } else if (filename.length > 14) {
                ui.replaceName = filename.substr(0, 10) + "_" + filename.substr(filename.lastIndexOf('.'));
            }
            // We can add some data to POST in upload request
            ui.addPostData($uploadForm.serializeArray()); // from array
            ui.addPostData('original-filename', filename); // .. or as field/value pair
            // Show info and response when upload completed
            var $progressBar = createRowFromUploadItem(ui);
            ui.completeCallback = function(success, data, errorCode) {
                log('******');
                log((this.file.name || "[custom-data]") + " completed");
                if (success) {
                    log('recieved data:', data);
                } else {
                    log('uploading failed. Response code is:', errorCode);
                }
            };

            var allTbody = $('#upload-rows');
            for(var myI=0; myI<allTbody.length; myI++){
                var tbody = allTbody.eq(myI);
                var allTr = tbody.children('tr');
                for(var myI2=0; myI2<allTr.length; myI2++){
                    myTr = allTr.eq(myI2);
                    var myTdImg = myTr.children('td:first').children();
                    myTdImg.on('load', function(){
                        //location.reload();
                    });
                    console.log(myTdImg);
                }
            }

            // Updating progress bar value in progress callback
            ui.progressCallback = function(percent) {
                $progressBar.css('width', Math.round(percent) + '%');
            };

            // To start uploading immediately as soon as added
            autostartOn && ui.upload();
        };


        ///// Setting up events handlers

        // Uploader events
        $fileInput.on({
            'du.add' : fileAddHandler,

            'du.limit' : function() {
                log("File upload limit exceeded!");
            },

            'du.completed' : function() {
                log('******');
                log("All uploads completed!");
                location.replace(location.toString() + '/order');
            }
        });

        // Clear button
        $clearBtn.on('click', function() {
            $fileInput.duCancelAll();
            $uploadRows.empty();
            log('******');
            log("All uploads canceled :(");
        });

        // Previews generating switcher
        $previewsChecker.on('change', function() {
            previewsOn = $previewsChecker.prop('checked');
        });

        // Autostart switcher
        $autostartChecker.on('change', function() {
            autostartOn = $autostartChecker.prop('checked');
            $sendBtn.prop('disabled', autostartOn);
            $fileInput.duOption('limit', autostartOn ? false : 5);
        });

        // Adding from textarea
       

        // Form submit
        $uploadForm.on('submit', function(e) {
            // Sending files by HTML5 File API if available, else - form will be submitted on fallback handler
            if ($.support.fileSending) {
                e.preventDefault();
                $fileInput.duStart();
            }
        });

    });

})(window.jQuery);

// File API support info
if(!$.support.fileSelecting) {
    log("[-] Your browser doesn't support File API (uploads may be performed only by default form submitting)");
} else {
    log("[√] Your browser supports multiple file selecting" + ($.support.fileSending ? " and sending" : ""));
    if(!$.support.fileReading) {
        log("[-] Your browser doesn't support file reading on client side");
    }
    if(!$.support.uploadControl) {
        log("[-] Your browser can't retrieve upload progress information (progress bars will be disabled)");
    }
    if(!$.support.fileSending) {
        log("[-] Your browser doesn't support FormData object (files will be send by default form submitting)");
    }
    log("Now select some files to see what happen ...");
}
