$(document).ready(function(){
    // untuk show password
    $(".show-password").click(function(){
        if($(".show-password:checked").val() == "on"){
            $(".password-hash").attr('type', 'text');
        }else{
            $(".password-hash").attr('type', 'password');
        }
    });
});