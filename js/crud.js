//AddNewUSer
    function Insert_user(){
        //getValues
       
            var first_name = $("#first_name").val();
            var last_name = $("#last_name").val();
            var email = $("#email").val();
            var phone = $("#phone").val();
            var pass = $("#pass").val();
            var cpass = $("#cpass").val();
            var wallet = $("#walletad").val();

                if ($("#first_name").val() == '') {

                    $("#msg").text("First name field is requiered!");
                    $("#first_name").focus();

                  }else if($("#last_name").val() == ''){

                    $("#msg").text("Last name field is requiered!");
                    $("#last_name").focus();

                  } else if ($("#email").val() == ''){

                      $("#msg").text("Email field is requiered!");
                      $("#email").focus();

                  }else if($("#pass").val() == ''){

                    $("#msg").text("Password field is requiered!");
                    $("#pass").focus();

                  }else if ($("#cpass").val() == ''){

                    $("#msg").text("Confirm password field is requiered!");
                    $("#cpass").focus();
                    
                  }else if ($("#walletad").val() == ''){

                    $("#msg").text("Wallet address field is required!");
                    $("#walletad").focus();
                  } 
                  else if ($("#pass").val() != ($("#cpass").val())){

                    $("#msg").text("Passwords does not match!");
                    $("#pass").focus();

                  }
                  else{
                    $("#msg").text("");

                      $.post("ajax/insert-user.php",{
                           first_name:first_name,
                           last_name:last_name,
                           email:email,
                           phone:phone,
                           pass:pass,
                           wallet:wallet
                          }, function (result) {
                            $("#succes_signup_modal").modal("hide");
          
                            //clear fields
                            $("#first_name").val("");
                            $("#last_name").val("");
                            $("#email").val("");
                            $("#phone").val("");
                            $("#pass").val("");
                            $("#cpass").val("");
                            $("#walletad").val("");                     
                       });   
                    }
                }    