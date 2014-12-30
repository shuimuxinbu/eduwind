$(function() {


    var uploader = new plupload.Uploader({
        runtimes : 'html5,flash,silverlight,html4',
        browse_button : 'pickfiles', // you can pass in id...
        container: document.getElementById('container'), // ... or DOM Element itself
        url : $('#url').val(),
        flash_swf_url : 'plupload/Moxie.swf',
        silverlight_xap_url : 'plupload/Moxie.xap',
        chunk_size:0,

        filters : {
            max_file_size : '2000mb',
            mime_types: [
                { title : "mp4 文件", extensions : "mp4" }
            ]
        },

        init: {
            PostInit: function() {
                document.getElementById('uploadfiles').onclick = function() {
                    uploader.start();
                    return false;
                };
            },

            FilesAdded: function(up, files) {
                $('#pickfiles').hide();
                $('table').show();
                $('#success').hide();
                plupload.each(files, function(file) {
                    var progress = new FileProgress(file, 'fsUploadProgress');
                    progress.setStatus("等待...");
                });

                uploader.start();
            },
            BeforeUpload: function(up, file) {
                var progress = new FileProgress(file, 'fsUploadProgress');
                var chunk_size = plupload.parseSize(this.getOption('chunk_size'));
                if (up.runtime === 'html5' && chunk_size) {
                    progress.setChunkProgress(chunk_size);
                }
            },

            UploadProgress: function(up, file) {
                var progress = new FileProgress(file, 'fsUploadProgress');
                var chunk_size = plupload.parseSize(this.getOption('chunk_size'));
                progress.setProgress(file.percent + "%", up.total.bytesPerSec, chunk_size);
            },

            FileUploaded: function(up, file, info) {
                var progress = new FileProgress(file, 'fsUploadProgress');
                progress.setComplete(up, info);

                if(info){
                    $('#uploaded-file-'+$('#modelId').val()).html('<span style="text-success">' + file.name + '</span>'+'已经上传成功。');

                }else{
                    $('#uploaded-file-'+$('#modelId').val()).html('<span style="text-error">'+file.name+'</span>'+'上传失败。');
                }

            },

            Error: function(up, err) {
                document.getElementById('console').innerHTML += "\nError #" + err.code + ": " + err.message;
            }
        }
    });

    uploader.init();

});
