$(document).ready(function(){
    $('#class').live("change",function(){
        var grade = $(this).val();
        $.ajax({
            dataType:'json',
            url:site.baseUrl+'/admin/result/studentautocomplete/id/'+grade+'/format/json',
            success: function(res){
                $("#studentsearch").replaceWith(res.html);
                
            }
        });
    });
});
