$(document).ready(function() {
            
    appMaster.preLoader();
    new WOW().init();
    $('#secondform').hide();

            //$('#banner-pictures').show();
 //====================================================================================

 		function completeAndRedirect()
 		{
 			//alert('hii');
 		}

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
            	 /*person_designation = $('#person_designation').val();*/

            	//alert(company_country);

               	if($.trim(company_name)=="" || $.trim(company_email)=="" ||$.trim(company_employee_strength)=="" ||$.trim(company_country)=="" ||$.trim(company_state)=="" ||$.trim(company_city)=="" /*||$.trim(person_designation)==""*/)
            	{
            		//alert(company_name);
            		$('#errorAlert').show();
            		$('#supportlink').click();
            		$('#errorMsg').text('All Fields Are Mandatory');
            	}
            	else
            	{
            		$.post('ConfessionWeb/registerCompany',{company_name: company_name,company_email: company_email,company_employee_strength: company_employee_strength, company_country: company_country, company_state: company_state, company_city: company_city} ,function(data){

            			if($.trim(data))
            			{
            				$('#errorAlert').hide();
            				$('#firstform').hide();
            				$('#successbox').show();
	                		$('#supportlink').click();
	                		//$('#successMsg').text('!RSSOFTTIER593');
	                		data = JSON.parse(data);

	                		$('#successMsg').text(data);
            			}

            		});

            		
            		//$('#firstform').hide();
                    //$('#secondform').fadeIn("slow");
            	}

            });
//======================================================================================
            $('#secondsubmitback').click(function(){



                    $('#secondform').hide();
                    $('#firstform').fadeIn("slow");




            });
//=======================================================================================
            $('#secondsubmit').click(function(){

                $('#secondform').hide();

                $('#successbox').show();
                $('#supportlink').click();

                $('#successMsg').text('!RSSOFTTIER593');

            });


        });

//=======================================================================================

function ValidateEmail(email) {
        var expr = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
        return expr.test(email);
    };
//==============================================================================