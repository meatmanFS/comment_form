$(document).ready(function(){
    $.ajax({
        url: 'lib/index.php',
        type: 'POST',
        success: function( data )
        {
            $(".response").html(data);
        }
    });
   var jVal_comm = {
        "check" : function() {
                var email = $("#inputEmail").val();
                var fio = $("#inputFIO").val();
                var phone = $("#inputphone").val();
                var comment = $("#inputcomment").val();
                
                var patt_fio = /^[A-zА-я .]{3,}$/i;
                var patt_email = /^.+@.+[.].{2,}$/i;
                var patt_phone = /^[0-9]{10}$/i;

                if(!patt_email.test(email))  
                {
                    jVal_comm.errors = true;
                    $("#inputEmail").parent().parent().addClass("has-error");
                }
                if(!patt_fio.test(fio))  
                {
                    jVal_comm.errors = true;
                    $("#inputFIO").parent().parent().addClass("has-error");
                }
                if(!patt_phone.test(phone))  
                {
                    jVal_comm.errors = true;
                    $("#inputphone").parent().parent().addClass("has-error");
                }
                if(comment === "")  
                {
                    jVal_comm.errors = true;
                    $("#inputcomment").parent().parent().addClass("has-error");
                }
        },				
        "sendIt" : function (){
                if(!jVal_comm.errors) {
                    var email = $("#inputEmail");
                    var fio = $("#inputFIO");
                    var phone = $("#inputphone");
                    var comment = $("#inputcomment");
                    var submit_button = $(".submit_button").val();
                    
                    var formData = new FormData();
                    var inputget_file = $("#inputget_file");
                    if (inputget_file.val() !=="")
                    {
                        $.each($("#inputget_file")[0].files, function(i, file)
                        {
                            formData.append('file-'+i, file);
                        });
                    }   
                    formData.append('email',email.val());
                    formData.append('fio',fio.val());
                    formData.append('phone',phone.val());
                    formData.append('comment',comment.val());
                    formData.append('submit_button',submit_button);
                    $.ajax({
                        url: 'lib/index.php',
                        type: 'POST',
                        contentType: false,
                        processData: false,
                        cache: false,
                        headers: { 'cache-control': 'no-cache' },
                        dataType: 'json',
                        data: formData,                        
                        success: function(data)
                        {
                            $.ajax({
                                url: 'lib/index.php',
                                type: 'POST',
                                success: function( data )
                                {
                                    $(".response").empty();
                                    $(".response").html(data);
                                }
                            });
                            var responce ="";
                            for (var i=0;i<data.length;i++)
                            {
                                responce += data[i]["respond"]+"\n";
                            }
                            alert(responce);
                            email.val("");
                            fio.val("");
                            phone.val("");
                            comment.val("");
                            inputget_file.val("");
                        },
                        error: function ()
                        {
                            alert("Произошла ошибка при отправке!");
                        }
                    });
                }
        }
    };
    
    $(".submit_button").click(function(event){
        event.preventDefault();
        jVal_comm.errors = false;
        jVal_comm.check();
        jVal_comm.sendIt();
        if(jVal_comm.errors) {
        return false;
        }
    });
    $("#inputEmail").keyup(function (){ 
        $(this).parent().parent().removeClass("has-error");
        jVal_comm.errors = false;
        jVal_comm.check();   
    });
    $("#inputFIO").keyup(function (){ 
        $(this).parent().parent().removeClass("has-error");
        jVal_comm.errors = false;
        jVal_comm.check();   
    });
    $("#inputphone").keyup(function (){ 
        $(this).parent().parent().removeClass("has-error");
        jVal_comm.errors = false;
        jVal_comm.check();   
    });
    $("#inputcomment").keyup(function (){ 
        $(this).parent().parent().removeClass("has-error");
        jVal_comm.errors = false;
        jVal_comm.check();   
    });
});


