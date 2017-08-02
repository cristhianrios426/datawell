(function(window,$){
	var init = function($el){
    $el.find('[data-uploader]').each(function() {
        var $this = $(this);
        var config = {
            url: window.URL + '/upload-file',
            dataType: 'json'
        };
        $this.find('[type="file"]').each(function() {
            var $file = $(this);
            $file.fileupload(config);
            $file.on('fileuploadadd', function(e, data) {
                var file = data.files[0];
                var str = file.name;
                var patt = new RegExp(/(\.|\/)(jpg|jpeg|png|gif|pdf|zip|doc|docx|xls|xlsx|ppt|pptx)$/i);
                var res = patt.test(str);
                if (!res) {
                    alert('tipo de archivo no permitido');
                    data.jqXHR.abort();
                    return false;
                }
                $this.find('.text-uploader').html('Subiendo archivo...');
                $file.prop('disabled', true);
            });
            $file.on('fileuploaddone', function(e, data) {
                var name = data.result.files.originalName;
                var file = data.result.files.name;
                $this.find('.text-uploader').html(name);
                $file.prop('disabled', false);
                $this.find('.hidden-file').val(file);
                $this.find('.hidden-client-file').val(name);
            });
        });
    });
};
window.afterCreateView = function($el) {
    init($el);
};
window.afterEditView = function($el) {
    init($el);
};
})(window, jQuery);