function managePositions(jsonData, originalParentId, entityHasId, newElementLabel, entityPosition) {
    var entitiesCount = $.parseJSON(jsonData);
    $('.position-parent').on('change', function() {
        $('#position').find('option').remove();
        if (entitiesCount[$('.position-parent').val()] != undefined) {
            for (var i = 1; i <= entitiesCount[$('.position-parent').val()].length; i++) {
                $('#position').append($('<option>').val(i).text(i + ' - ' + entitiesCount[$('.position-parent').val()][i - 1]));
            }
        } else {
            var i = 1;
        }
        if (!entityHasId || $('.position-parent').val() != originalParentId) {
            $('#position').append($('<option>').val(i).text(i + ' - ' + newElementLabel));
        }
        if (entityHasId) {
            $('#position option[value="' + entityPosition + '"]').attr('selected', 'selected');
        } else {
            $('#position option:last-child').attr('selected', 'selected');
        }
    });
    $('.position-parent').change();
}

$(function() {
    // Editor
    function elFinderBrowser (field_name, url, type, win) {
        tinymce.activeEditor.windowManager.open({
            file: '/manager/elfinder/tinymce', // use an absolute path!
            title: 'elFinder 2.0',
            width: 900,
            height: 450,
            resizable: 'yes'
        }, {
            setUrl: function (url) {
                win.document.getElementById(field_name).value = url;
            }
        });
        return false;
    }
    tinymce.init({
        selector: 'textarea.tinymce',
        content_css: '/assets/css/manager/tinymce_content.css',
        plugins: [
            'image pagebreak wordcount code nonbreaking save table link',
            'insertdatetime media textcolor colorpicker textpattern visualblocks',
            'searchreplace visualchars',
            'component module'
        ],
        toolbar1: "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | forecolor backcolor | bullist numlist outdent indent | link image media table | component module",
        height: 300,
        file_browser_callback : elFinderBrowser
    });

    // Gallery uploader
    $('#gallery-upload').on('click', function(){
        $('.gallery-uploader-container').fadeToggle();
    });


});