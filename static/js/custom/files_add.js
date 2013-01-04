var count = 0;
var max_files = 50;
var error_add = false;
    
var uploader = new plupload.Uploader({
    runtimes : 'html5,html4',
    browse_button : 'pickfiles',
    container : 'container',
    url : '/modules/files_add/?category='+$('#filelist').attr('data-category'),
    filters : [
    {
        title : "Custom files", 
        extensions : $('#filetypes').attr('data-types')
    }
    ],
    resize : {
        width : 1024, 
        height : 1024, 
        quality : 90
    }
});

$('#page_files_add').bind('pageshow', function () {

    uploader.bind('Init', function(up, params) {});

    $('#uploadfiles').click(function(e) {
        uploader.start();
        e.preventDefault();
    });

    uploader.init();

    uploader.bind('FilesAdded', function(up, files) {
            
        if(count == 0)
            $('#filelist').html('').trigger("create").trigger("refresh");
            
        var text = '';
        var count_all = 0;
        $.each(files, function(){
            count_all++;
        })            
                                
        $.each(files, function(i, file) {
            
            if (count+1 > max_files) {
                        
                up.removeFile(file);
                        
                error_add = true;
                        
            }else{
            
                if(count == 0)
                    text += '<ul data-role="listview" data-inset="true" id="files"><li data-role="list-divider">Файлы</li>';

                text += '<li id="' + file.id + '"><h3>'+file.name + '</h3><p>'+ plupload.formatSize(file.size) +'</p> <span class="ui-li-count">0%</span>' +'</li>';

                if(count_all-1 == i)
                    text += '</ul>';

                count++;
                    
            }
                    
        });

        if(error_add)
            alert_message('Нельзя добавлять более '+max_files+' '+word(max_files, 'файла','файлов','файлов')+'.', 'information', 3)

        div_text = $('#filelist').html().replace('</ul>', '')+text;
                
        $('#filelist').html(div_text).trigger("create").trigger("refresh");
        up.refresh();
    });

    uploader.bind('UploadProgress', function(up, file) {
        $('#' + file.id + " span").html(file.percent + "%");
    });

    uploader.bind('FileUploaded', function(up, file, response) {

        response = jQuery.parseJSON( response.response );

        if(response.error.code > 0)
            $('#'+file.id+' p').html(response.error.message);

        $('#' + file.id + " span").html("100%");
            
    });

});
    
uploader.bind('UploadComplete', function(up, files) {
    
    alert_message('Загрузка завершена.', 'information', 3)
    //clean_files();
    
});
        
$('#page_files_add').bind('pagehide', function () {
    $('#page_files_add').remove();
});

$('#page_files_add').on('click', '#clean', function(){
   
    clean_files();
   
});

function clean_files(){
    
   uploader.splice();
   count = 0;
   error_add = false;
   
   $('#filelist').html('').trigger("create").trigger("refresh");
    
}