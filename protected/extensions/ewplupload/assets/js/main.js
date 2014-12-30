
/*global plupload */
/*global FileProgress */
/*global hljs */


$(function() {


    var uploader = plupload.Uploader({
        filters: {
                  mime_types : [
                    { title : "mp4 文件", extensions : "mp4" }
                  ],
                },
        multi_selection: false,
        runtimes: 'html5,flash,html4',
        browse_button: 'pickfiles',
        container: 'container',


        flash_swf_url: 'js/plupload/Moxie.swf',
        dragdrop: false,
        chunk_size: 0,
        url:$('#url').val(),


        auto_start: true,
        init: {
            'FilesAdded': function(up, files) {
                $('#pickfiles').hide();
                $('table').show();
                $('#success').hide();
                plupload.each(files, function(file) {
                    var progress = new FileProgress(file, 'fsUploadProgress');
                    progress.setStatus("等待...");
                });
            },
            'BeforeUpload': function(up, file) {
                var progress = new FileProgress(file, 'fsUploadProgress');
                var chunk_size = plupload.parseSize(this.getOption('chunk_size'));
                if (up.runtime === 'html5' && chunk_size) {
                    progress.setChunkProgress(chunk_size);
                }
            },
            'UploadProgress': function(up, file) {
                var progress = new FileProgress(file, 'fsUploadProgress');
                var chunk_size = plupload.parseSize(this.getOption('chunk_size'));
                progress.setProgress(file.percent + "%", up.total.bytesPerSec, chunk_size);

            },
            'UploadComplete': function() {
                //$('#success').show();
            },
            'FileUploaded': function(up, file, info) {
                var progress = new FileProgress(file, 'fsUploadProgress');
                progress.setComplete(up, info);
                //回调结果
                
                dataObj = JSON.parse(info);
                
                if(info){
                    //$('#uploaded-file-$model->id').html('<span style="text-success">' + file.name + '</span>'.Yii::t('app','已经上传成功。'));
                    //$.post($this->createUrl('setMedia',array('lessonId'=>$model->id)),{name:file.name,mediaId:dataObj.id});
                    $('#uploaded-file-'+$('#modelId').val()).html('<span style="text-success">' + file.name + '</span>'+'已经上传成功。');

                    }else{
                    //$('#uploaded-file-$model->id').html('<span style="text-error">“' + file.name + '</span>”".Yii::t('app','上传失败。').");
                    $('#uploaded-file-'+$('#modelId').val()).html('<span style="text-error">'+file.name+'</span>'+'上传失败。');
                }
             
            },
            'Error': function(up, err, errTip) {
                $('table').show();
                var progress = new FileProgress(err.file, 'fsUploadProgress');
                progress.setError();
                progress.setStatus(errTip);
            }

        }
    });

    uploader.bind('FileUploaded', function() {
        console.log('hello man,a file is uploaded');
    });
    $('#container').on(
        'dragenter',
        function(e) {
            e.preventDefault();
            $('#container').addClass('draging');
            e.stopPropagation();
        }
    ).on('drop', function(e) {
        e.preventDefault();
        $('#container').removeClass('draging');
        e.stopPropagation();
    }).on('dragleave', function(e) {
        e.preventDefault();
        $('#container').removeClass('draging');
        e.stopPropagation();
    }).on('dragover', function(e) {
        e.preventDefault();
        $('#container').addClass('draging');
        e.stopPropagation();
    });



    $('#show_code').on('click', function() {
        $('#myModal-code').modal();
        $('pre code').each(function(i, e) {
            hljs.highlightBlock(e);
        });
    });


    $('body').on('click', 'table button.btn', function() {
        $(this).parents('tr').next().toggle();
    });


    var getRotate = function(url) {
        if (!url) {
            return 0;
        }
        var arr = url.split('/');
        for (var i = 0, len = arr.length; i < len; i++) {
            if (arr[i] === 'rotate') {
                return parseInt(arr[i + 1], 10);
            }
        }
        return 0;
    };


});
