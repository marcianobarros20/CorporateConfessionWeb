$(document).ready(function() {
    var imageBASE="";
    var package_name = "";
            
    appMaster.preLoader();
    new WOW().init();
    $('#secondform').hide();

            //$('#banner-pictures').show();
 //====================================================================================

         function EL(id) { return document.getElementById(id); } // Get el by ID helper function

        function readFile() {
          if (this.files && this.files[0]) {
            var FR= new FileReader();
            FR.onload = function(e) {
                imageBASE = e.target.result;
              //EL("img").src       = e.target.result;
              //EL("b64").innerHTML = e.target.result;
              //console.log(e.target.result);
            };       
            FR.readAsDataURL( this.files[0] );
          }
        }
            /*$('#btn').click(function(){
                console.log(image);
            });*/

        EL("inp").addEventListener("change", readFile, false);

//=======================================================================================
    $.post('ConfessionWeb/getCountry', function(data){

        var appendtext="<option value=''>Select</option>";

        data = JSON.parse(data);
        //console.log(data.length);

        for(i=0;i<data.length;i++)
        {
        	//console.log(data[i]);
        	appendtext += "<option value="+data[i].id+">"+data[i].name+"</option>";
        	
        }
        $('#company_country').html(appendtext);
        //$('#company_country').append(data);
    });

 //=====================================================================================

 	$('#company_country').change(function(){

 			
 			var country_id = $(this).val();

 			var appendtext="<option value=''>Select</option>";


 			 $.post('ConfessionWeb/getState',{country_id: country_id} ,function(data){

 			 		data = JSON.parse(data);
 			 		//console.log(data);

 			 		for(i=0;i<data.length;i++)
 			 		{
 			 			appendtext += "<option value="+data[i].id+">"+data[i].name+"</option>";


 			 		}
 			 		//console.log(appendtext);
 			 		$('#company_state').html(appendtext);

 			 });
 	});

//======================================================================================

	$('#company_state').change(function(){

		var state_id = $(this).val();
		//alert(state_id);

		var appendtext="";


 			 $.post('ConfessionWeb/getCities',{state_id: state_id} ,function(data){

 			 		data = JSON.parse(data);
 			 		//console.log(data);
 			 		//alert(data);
 			 		appendtext="<option value=''>Select</option>";

 			 		for(i=0;i<data.length;i++)
 			 		{
 			 			appendtext += "<option value="+data[i].id+">"+data[i].name+"</option>";


 			 		}
 			 		//console.log(appendtext);
 			 		$('#company_city').html(appendtext);

 			 });

	});

 //==================================================================================           

            
            //$('#successmsg').hide();

             //$('#banner-pictures').hide();

             //$('#banner-pictures').fadeIn("slow");

            $('#firstsubmit').click(function(){

                

            	 company_name = $('#company_name').val();
            	 company_email = $('#company_email').val();
            	 company_employee_strength = $('#company_employee_strength').val();
            	 company_country = $('#company_country').val();
            	 company_state = $('#company_state').val();
            	 company_city = $('#company_city').val();

            	 validemail = ValidateEmail(company_email);

                 
                            
            	 
            	 //return false;
            	 /*person_designation = $('#person_designation').val();*/

            	//alert(company_country);

               	if($.trim(company_name)=="" || $.trim(company_email)=="" ||$.trim(company_employee_strength)=="" ||$.trim(company_country)=="" ||$.trim(company_state)=="" ||$.trim(company_city)=="" ||$.trim(imageBASE)==""/*||$.trim(person_designation)==""*/)
            	{
            		//alert(company_name);
            		$('#errorAlert').show();
            		$('#supportlink').click();
            		$('#errorMsg').text('All Fields Are Mandatory');
            		return false;
            	}
            	else if(company_email!="" && validemail==false)
            	{
            		$('#errorAlert').show();
            		$('#supportlink').click();
            		$('#errorMsg').text('Insert A Valid Email');
            		return false;
            	}
            	else if(isNaN(company_employee_strength))
            	{
            		$('#errorAlert').show();
            		$('#supportlink').click();
            		$('#errorMsg').text('Employee Strength Must Be A Number');
            	}
            	else
            	{
                    //starting the roter
                    $("#load_screen").show();
            		$.post('ConfessionWeb/registerCompany',{company_name: company_name,company_email: company_email,company_employee_strength: company_employee_strength, company_country: company_country, company_state: company_state, company_city: company_city,imageBASE:imageBASE} ,function(data){

            			if($.trim(data))
            			{
                            //console.log(data);
            				$('#errorAlert').hide();
            				
	                		
	                		data = JSON.parse(data);

	                		$('#successMsg').text(data);
                            $('#load_screen').hide();

                            $('#first_form_with_company_info').hide();
                            $('#package_info').show();
                            $('#supportlink').click();
                            
            			}

            		});



            		
            		
            	}

            });
//======================================================================================
            $('#secondsubmitback').click(function(){



                    $('#secondform').hide();
                    $('#errorAlert').hide();
                    $('#firstform').fadeIn("slow");




            });
//=======================================================================================
            


        });

//=======================================================================================

function ValidateEmail(email) {
        var expr = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
        return expr.test(email);
    };
//==============================================================================

    function search()
    {
        var title=$("#company_name").val();
 
        if(title!="")
        {
        //$("#result").html("<img alt='' src='ajax-loader.gif'/>");
            $.post("ConfessionWeb/searchCompany",{search:title}, function(data)
            {
                data = JSON.parse(data);
                //console.log(data);
                //$("#result").html(data);
                if(data.length>0)
                {
                    $('.drop-option').hide();
                    var length = data.length;
                    
                    loopLength  =4;

                    if(loopLength>length)
                    {
                        loopLength = length;
                    }

                    var totaldiv = "";
                    for(i=0;i<loopLength;i++)
                    {
                        totaldiv +="<p id='"+data[i].tbl_id+"' onclick='searchClick("+data[i].tbl_id+")' class='drop-search'>"+data[i].company_name+"<img src='"+data[i].company_logo+"' alt='Responsive image' class='pull-right'></p><hr>";
                    }
                    $('#searchResult').html(totaldiv);
                    $('.drop-option').show();
                }
                else
                {
                    $('.drop-option').hide();
                }
            });
        }
    }

                 $('#company_name').keyup(function(e) {
                    
                    if(e.keyCode == 8)
                    {
                        $('.drop-option').hide();
                        
                    }
                    
                    
                      search();
                  });
//==================================SEARCH RESULT CLICK EVENT=====================
    function searchClick(tbl_id)
    {
        
        $('#firstform').hide();
        $('#errorAlert').hide();

        $.post('ConfessionWeb/getCompanyDetails',{tbl_id: tbl_id} ,function(data){

                        if($.trim(data))
                        {
                            data = JSON.parse(data);
                            var company_name = data[0].company_name;
                            var company_name_upper = company_name.toUpperCase();
                            //console.log(data[0].company_name);
                            $('#requestCompany').html("Request "+company_name_upper+"(via email) for their Unique ID");
                            $('#company_hidden_email').val(data[0].company_name);
                            $('#secondform').show();
                            $('#mylink').click();
                        }

                    });

        
    }
//===================================================================================

    $('#secondsubmit').click(function(){

        var person_name = $('#person_name').val();
        var person_email = $('#person_email').val();
        var person_valid_email = ValidateEmail(person_email);
        var company_email = $('#company_hidden_email').val();

        if($.trim(person_name)=="" || $.trim(person_email)=="")
        {
            $('#errorAlert').show();
            $('#supportlink').click();
            $('#errorMsg').text('All Fields Are Mandatory');
            return false;
        }
        else if(person_valid_email==false)
        {
            $('#errorAlert').show();
            $('#supportlink').click();
            $('#errorMsg').text('Insert A Valid Email');
            return false;
        }
        else if($.trim(company_email)=="")
        {
            $('#errorAlert').show();
            $('#supportlink').click();
            $('#errorMsg').text('Sorry This company have not provided an email id');
            return false;
        }
        else
        {
            //alert('hii')
            $('#errorAlert').hide();
            $('#secondform').hide();
            $('#supportlink').click();
            $('#emailsuccessbox').show();
            

            $.post('MailController/sendEmail',{company_email: company_email,person_name: person_name,person_email:person_email} ,function(data){

                        console.log(data);
            });

        }

    });
//============================================================================================

function getPackage(package_name1)
{
    package_name = package_name1;
    if(package_name=="gold")
    {
        $('#payment').text("Pay $20");
    }
    else if(package_name=="professional")
    {
        $('#payment').text("Pay $10");
    }
    $('#myModal').modal('show');
}
//============================================================================================

    $('body').click(function(){

         $('#searchResult').hide();
         $('#customerEmail').val($('#company_email').val());

    });
//============================================================================================

$('#payment').click(function(){

      $(this).button('load');
      var $form = $('#payment-form');
      $form.find('.submit').prop('disabled', true);
      Stripe.card.createToken($form, stripeResponseHandler);

  });
//============================================================================================
function stripeResponseHandler(status, response) {

      var $form = $('#payment-form');

      if (response.error) 
      { 
        $form.find('.payment-errors').text(response.error.message);
        $form.find('.submit').prop('disabled', false); // Re-enable submission
        $('#payment').button('reset');
      } 
      else 
      { 

        var token = response.id;
        console.log(response);
        $form.find('.submit').prop('disabled', false); 
        /*console.log(package_name);
        return;*/
        $.post('ConfessionWeb/stripeToken',{stripeToken: token,customerEmail: $('#customerEmail').val(),package_name: package_name} ,function(data){

            if(data)
            {
                console.log('true');
                $('#package_info').hide();
                $('#first_form_with_company_info').show();
                $('#firstform').hide();
                $('#myModal').modal('toggle');
                $('#successbox').show();                            
                $('#supportlink').click();
            }
            else
            {
                console.log('false');
            }

        });
      }
  };
//=============================================================================================
function getFreePackage()
{
    $('#package_info').hide();
    $('#first_form_with_company_info').show();
    $('#firstform').hide();
    $('#successbox').show();                            
    $('#supportlink').click();
}
//=============================================================================================
$('#load').on('click', function() {
    var $this = $(this);
  $this.button('loading');
    setTimeout(function() {
       $this.button('reset');
   }, 8000);
});
