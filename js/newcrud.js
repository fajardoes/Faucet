
$(document).ready(function(e){
  $('#submit').click(function(){
    var first_name = $("#first_name").val();
    var last_name = $("#last_name").val();
    var email = $("#email").val();
    var phone = $("#phone").val();
    var pass = $("#pass").val();
    var cpass = $("#cpass").val();
    var wallet = $("#walletad").val();
    var result = validate()
    var msg = $("#msg")

    if (first_name == '') {

        msg.text("First name field is requiered!");
        $("#first_name").focus();

      }else if(last_name == ''){

        msg.text("Last name field is requiered!");
        $("#last_name").focus();

      }else if (email == ''){

        msg.text("Email field is requiered!");
        $("#email").focus();

      }else if(pass == ''){

        msg.text("Password field is requiered!");
        $("#pass").focus();

      }else if (cpass == ''){

        msg.text("Confirm password field is requiered!");
        $("#cpass").focus();
        
      }else if (wallet == ''){

        msg.text("Wallet address field is required!");
        $("#walletad").focus();

      }else if (pass != cpass){

        msg.text("Passwords does not match!");
        $("#pass").focus();

      }else if(result == false) {

        msg.text("Enter a valid email!")
        $("#email").focus();

      }else if( wallet.length != 95){

        msg.text("Enter a valid wallet address!")
        $("#walletad").focus();

      }else{   
             
             $.post("insert-user.php",{
              first_name:first_name,
              last_name:last_name,
              email:email,
              phone:phone,
              pass:pass,
              wallet:wallet},
                    function(data, status) 
                    { 
                         var user = JSON.parse(data);
                         if (user.email == email)
                         {
                          $("#msg").text("There is an account registered whith this email");
                          $("#email").focus();
                         }
                         else if(user.wallet == wallet)
                         {
                          $("#msg").text("There is an account registered with this wallet address");
                          $("#walletad").focus();

                         }
                         else
                         {
                         $("#msg").text(""); 
                         $("#add_new_record_modal").modal("hide");
                         //clear fields
                         $("#wallet").val(wallet);
                         $("#first_name").val("");
                         $("#last_name").val("");
                         $("#email").val("");
                         $("#phone").val("");
                         $("#pass").val("");
                         $("#cpass").val("");
                         $("#walletad").val("");
                         $("#email_logged").text(email);
                         //open modal alert
                         $("#succes_signup_modal").modal("show");

                         }

                       
    }
   );
 }
});
});

function validateEmail(email) {

    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
    }

  function validate(){
    var email = $("#email").val();
    if (validateEmail(email)){
        return true;
    }else
    {
      return false;
    } 
  }  

      $(document).ready(function(e){
       $("#btn_enter").click(function(){
       var wallet = $("#wallet").val();   
       localStorage.setItem("walle",wallet);
       if (wallet == ''){
        $("#alert_msg").text("Enter your wallet address!");
        $("#alert_modal").modal("show");
       }
       else if(wallet.length != 95){
        $("#alert_msg").text("Enter a valid wallet address!");
        $("#alert_modal").modal("show");
       }
       else{
            $.post('get_user.php',{
                wallet : wallet},
                function(data,status)
                {
                     var values = JSON.parse(data); 
                     if (values.total_users == 0){
                     $("#alert_msg").text("You have to sign-up first.");
                     $("#alert_modal").modal("show");
                 }else{
                    var date = new Date();
                    var minutes = 30;
                    date.setTime(date.getTime() + (minutes * 60 * 1000));
                    Cookies.set("session", "foo", { expires: date });
                    $("#wallet").val("");
                    window.location.href = "faucet.html";                                      
                   }
                 }
               );     
             }   
    });
  });
function Enter_Page() {

}

           function OnLoadPage() {
               if (!!Cookies.get('session')){
                var wallet = localStorage.getItem("walle");
                $("#walletid").text(wallet);             
                $.post('get_user.php',{
                wallet : wallet},
                function(data,status)
                {
                var values = JSON.parse(data);
                var userss = values.user.email;

                if (values.status == 200){
                 alert("Invalid Request!");
                 window.location.href = "index.html";
                }else{
                  var total_users = values.total_users;
                  var total_rewards = values.total_rewards;
                  var total_paids = values.total_paids;
                  var total_paid = parseFloat(total_paids).toFixed(2);
                  var total_paid_final = (total_paid+" SUP");
                 $("#user_email").text(userss);
                 $("#total_users").text(total_users);
                 $("#total_rewards").text(total_rewards);
                 $("#total_paid").text(total_paid_final);
                }
                }
                );                
                }
                else {
                window.location.href = "index.html";
              }
            }

function randomNumberFromRange(min,max)
{
    return Math.floor(Math.random()*(max-min+1)+min);
}
function ReadPayments(){
  var wallet = localStorage.getItem("walle");
  $.post("read_payments.php",
    {wallet:wallet},
    function(data,status){     
        $(".records_content").html(data);
    }
    );
}
function readBalance(){
  var wallet = localStorage.getItem("walle");
  $.post("get_balance.php",
    {wallet:wallet},
    function(data,status){
       var values = JSON.parse(data);      
       if (values.status == 0) {
        $("#id_balance").text("You need start to claim a reward!!.");
        $("#balancemodal").modal("show");
       }else{
        var balance = values.balance;
        var balance1 = Math.round(balance * 1e2) / 1e2;
        var balance2 = parseFloat(balance1).toFixed(2);
        var final_balance = (balance2+" SUP");
        $("#id_balance").text(final_balance);
        $("#balancemodal").modal("show");
       }
    }
    );
}

function OpenWithdraw(){
  var wallet = localStorage.getItem("walle");
  $("#id_wallet").text(wallet);
  $.post("get_balance.php",
    {wallet:wallet},
    function(data,status){
      var values = JSON.parse(data);
      if(values.status == 0){
         $("#id_balancew").text("Not Founds!");
         $("#btn_transfer").attr("disabled",true);
         $("#amount_w").attr("disabled",true);
         $("#withdraw_modal").modal("show");
      }else if (values.balance == 0){
        $("#id_balancew").text("Not Founds!");
        $("#btn_transfer").attr("disabled",true);
        $("#amount_w").attr("disabled",true);
        $("#withdraw_modal").modal("show");
      }else{
        var balance = values.balance;
        var balance1 = Math.round(balance * 1e2) / 1e2;
        var balance2 = parseFloat(balance1).toFixed(2);
        var final_balance = (balance2+" SUP");
        $("#btn_transfer").removeAttr("disabled");
        $("#amount_w").removeAttr("disabled");
        $("#id_balancew").text(final_balance);
        $("#withdraw_modal").modal("show");
      }
    }
    ); 
}
function transfer(){
  var walletF = localStorage.getItem("walle");
  var amountF = $("#amount_w").val();
  if (amountF == '') {
    alert("Please enter an amount!");
    $("#amount_w").focus();
  }else{
    $.post("daemon_fx.php",
      {walletF:walletF,
       amountF:amountF},
       function(data,status){
        var values = JSON.parse(data);
        if (values.status == 0) {
          alert("Not founds!")
        }else if (values.status == 1) {
         alert("Claim some rewards first to have a balance!");
        }else if (values.status == 2) {
          alert("Invalid request.. try to login again!");
        }else{
          alert("Succesfull transfer");
          $("#amount_w").val("");
        }
       }
       );
  }

}
    


