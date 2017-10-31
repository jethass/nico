app.controller('inscriptionCtrl', ['$scope', '$rootScope', '$location', '$interval', 'inscriptionService', '$window', 'appSettings', '$timeout', function ($scope, $rootScope, $location, $interval, inscriptionService, $window, appSettings, $timeout) {

        //for show loading
        //$rootScope.loading=true;
        $scope.page = "inscription";
        $scope.user = null;
        $scope.verificationCode = null;
        $scope.afficheForm = function () {
            fn = $interval(function () {
                $("#capture_signIn_traditionalSignIn_createButton").trigger("click");
                $("#traditionalRegistration").css({'display': 'block !important;'});
                $interval.cancel(fn);
            }, 500);
        }
        
        $scope.status = 0;


        function janrainCaptureWidgetOnLoad() {
        	
        	

            janrain.events.onCaptureSessionFound.addHandler(function (result) {
                janrain.capture.ui.modal.close();
                if (window.console && window.console.log)
                    console.log(result);
                document.getElementById("captureSignInLink").style.display = 'none';
                document.getElementById("captureSignOutLink").style.display = '';
                document.getElementById("captureProfileLink").style.display = '';
            });

            janrain.events.onCaptureRegistrationSuccess.addHandler(function (result) {
                janrain.capture.ui.modal.close();
                if (window.console && window.console.log)
                    console.log(result);
            });

            janrain.events.onCaptureSessionEnded.addHandler(function (result) {
                document.getElementById("captureSignInLink").style.display = '';
                document.getElementById("captureSignOutLink").style.display = 'none';
                document.getElementById("captureProfileLink").style.display = 'none';
            });

            janrain.events.onCaptureScreenShow.addHandler(function (result) {

                $('#capture_traditionalRegistration_phone').attr('type', 'tel');  
                $('#capture_traditionalRegistration_zipcode').attr('type', 'number');
                 
                $('#capture_traditionalRegistration_city').attr('autocomplete','off');  
                $('#capture_traditionalRegistration_zipcode').attr('autocomplete','off');  
                
                $('#capture_traditionalRegistration_registrationForm').submit(function (event) {

                    var PASSWD_REGEXP = /(?=^.{8,21}$)(?=(?:.*?\d){1})(?=.*[A-Z]{1})(?!.*\s)[0-9a-zA-Z!@#$%^&*()<>_-]*$/;

                    if ($("#capture_traditionalRegistration_password").val().length < 8) {
                        $("#capture_traditionalRegistration_form_item_password .capture_tip_error").html("Votre mot de passe doit contenir au minimum 8 caractères avec au moins, une majuscule, une minuscule et un chiffre");
                        $("#capture_traditionalRegistration_form_item_password .capture_tip_error").css("display", "block");
                        event.preventDefault();
                    }
                    else if (!PASSWD_REGEXP.test($('#capture_traditionalRegistration_password').val())) {
                        $('#capture_traditionalRegistration_form_item_password .capture_tip_error').html("S'il vous plaît entrer un mot de passe valide.");
                        $('#capture_traditionalRegistration_form_item_password .capture_tip_error').css("display", "block");
                        event.preventDefault();
                    }else{
                        $('#capture_traditionalRegistration_form_item_password .capture_tip_error').css("display", "none");
                    }


                    if ($("#capture_traditionalRegistration_firstName").val().length >= 40) {
                        $("#capture_traditionalRegistration_form_item_firstName .capture_tip_error").html("Vous avez dépassé le nombre des caractères autorisé.");
                        $("#capture_traditionalRegistration_form_item_firstName .capture_tip_error").css("display", "block");
                        event.preventDefault();
                    }

                    if ($("#capture_traditionalRegistration_lastName").val().length >= 40) {
                        $("#capture_traditionalRegistration_lastName .capture_tip_error").html("Vous avez dépassé le nombre des caractères autorisé.");
                        $("#capture_traditionalRegistration_lastName .capture_tip_error").css("display", "block");
                        event.preventDefault();
                    }

                    var TEL_REGEXP = /^0[6-7]([-. ]?[0-9]{2}){4}$/;
                    if ($("#capture_traditionalRegistration_phone").val() == '') {
                        $("#capture_traditionalRegistration_form_item_phone .capture_tip_error").html("Veuillez indiquer votre numéro de portable");
                        $("#capture_traditionalRegistration_form_item_phone .capture_tip_error").css("display", "block");
                        event.preventDefault();
                        $("#capture_traditionalRegistration_createAccountButton").show();
                    }else if(!TEL_REGEXP.test($('#capture_traditionalRegistration_phone').val())){
                        $("#capture_traditionalRegistration_form_item_phone .capture_tip_error").html("Le format est incorrect.");
                        $("#capture_traditionalRegistration_form_item_phone .capture_tip_error").css("display", "block");
                        event.preventDefault();
                    }else{
                        $("#capture_traditionalRegistration_form_item_phone .capture_tip_error").css("display", "none");
                    }



                    // End validate password
                    
                    // Validate birthdate
                    var day = $('#capture_traditionalRegistration_birthdate_dateselectday').val();
                    var month = $('#capture_traditionalRegistration_birthdate_dateselectmonth').val() - 1;
                    var year = $('#capture_traditionalRegistration_birthdate_dateselectyear').val();
                    objBirthdate = new Date();
                    objBirthdate.setDate(day);
                    objBirthdate.setMonth(month);
                    objBirthdate.setFullYear(year);
                    var objCurrentdate = new Date();

                    objCurrentdate.setFullYear(parseInt(objCurrentdate.getFullYear()) - 18);
                    diff = objCurrentdate.getTime() - objBirthdate.getTime();
                    if (diff < 0 || day == null || month == null || year == null) {
                        $("#capture_traditionalRegistration_form_item_birthdate .capture_tip_error").html("Vous devez être âgé au minimum de 18 ans pour vous inscrire");
                        $("#capture_traditionalRegistration_form_item_birthdate .capture_tip_error").css("display", "block");
                        event.preventDefault();
                    } else {
                        $("#capture_traditionalRegistration_form_item_birthdate .capture_tip_error").css("display", "none");
                    }
                    // End validate birthdate

                    $( "#capture_traditionalRegistration_createAccountButton" ).addClass( "displayBlock" );
                    $( ".capture_processing" ).addClass( "displayNone" );
                    setTimeout(function() {
                        $( ".capture_processing" ).addClass( "displayNone" );
                    }, 100);
                });





                $('#capture_traditionalRegistration_city').keyup(function () {
                    var city = $('#capture_traditionalRegistration_city').val();
                    inscriptionService.getZipCodes(city)
                            .then(function (res) {
                                var helpers_list_result = '<div id="helpers_list_result" class="helpers_list_result" style="background-color: #fff;border: 1px solid #f3f3f3;left: 5px;max-height: 285px;min-height: 100px;overflow: auto;padding: 10px;position: absolute;top: 40px;width: 95%;z-index: 15000;">';
                                helpers_list_result += '<ul id="helpers_list_result_content">';

                                if (res.data.length > 0) {
                                    for (i = 0; i < res.data.length; i++) {
                                        var city = res.data[i];
                                        helpers_list_result += '<li><a href="javascript:helpers_city_zip_select(\'' + city.zip + '\', \'' + city.name + '\')">(' + city.name + ') ' + city.zip + '</a></li>';
                                    }
                                } else {
                                    helpers_list_result += '<li>Aucun résultat.</li>';
                                }
                                helpers_list_result += '</ul></div>';

                                $(".helpers_list_result").remove();
                                $('#capture_traditionalRegistration_city').after(helpers_list_result);

                            });
                });

                $('#capture_traditionalRegistration_zipcode').keyup(function () {
                    var zipCode = $('#capture_traditionalRegistration_zipcode').val();
                    inscriptionService.getCitiesNames(zipCode)
                            .then(function (res) {
                                var helpers_list_result = '<div id="helpers_list_result" class="helpers_list_result" style="background-color: #fff;border: 1px solid #f3f3f3;left: 5px;max-height: 285px;min-height: 100px;overflow: auto;padding: 10px;position: absolute;top: 40px;width: 95%;z-index: 15000;">';
                                helpers_list_result += '<ul id="helpers_list_result_content">';

                                if (res.data.length > 0) {
                                    for (i = 0; i < res.data.length; i++) {
                                        var city = res.data[i];
                                        helpers_list_result += '<li><a href="javascript:helpers_city_zip_select(\'' + city.zip + '\', \'' + city.name + '\')">(' + city.zip + ') ' + city.name + '</a></li>';
                                    }
                                } else {
                                    helpers_list_result += '<li>Aucun résultat.</li>';
                                }
                                helpers_list_result += '</ul></div>';

                                $(".helpers_list_result").remove();
                                $('#capture_traditionalRegistration_zipcode').after(helpers_list_result);

                            });
                });

                if (result.screen == 'returnTraditional') {
                    janrainReturnExperience();
                }
                if (result.screen == "registrationUnderage") {
                    if (!localStorage.janrainTooYoung) {
                        var date = new Date();
                        var expireDate = date.setDate(date.getDate() + 1);
                        localStorage.setItem('janrainTooYoung', true);
                        localStorage.setItem('janrainTooYoung_Expires', expireDate);
                    }
                }
                if (result.screen == 'traditionalRegistration' || result.screen == 'socialRegistration') {
                    //Sample of how privacy text can be displayed next to checkbox

                    var parent = document.getElementById('capture_traditionalRegistration_form_item_inner_privacyOpt');
                    var child = document.getElementById('privacy_statement');
                    parent.appendChild(document.getElementById('privacy_statement'));
                    document.getElementById('privacy_statement').style.display = '';


                }
                if (result.screen == 'emailUnverified') {
                    $scope.user = JSON.parse($window.localStorage.getItem('janrainCaptureProfileData')) || null;
                    
                    if ($scope.user.uuid) {
                        inscriptionService.getVerifCodeAndSendMail($scope.user.uuid, $scope.user.email, $("#selectStatus").val())
                                .then(function (res) {
                                    console.log(res);
                                });
                    }
                }


            });


            janrain.events.onCaptureRenderComplete.addHandler(function (result) {
            	$('input[name$="createAccountButton"]').val('Valider et fixer ma date d\'arrêt');
                document.getElementById('capture_traditionalRegistration_form_item_civility_MR_0').innerHTML = '<input id="capture_traditionalRegistration_civility_MR_0" class="radio capture_civility_MR_0 capture_input_radio" type="radio" name="civility" value="MR" data-capturecollection="true" data-capturefield="civility"><label class="custom-radio" for="capture_traditionalRegistration_civility_MR_0"></label><label class="txt-radio">M</label>';
                document.getElementById('capture_traditionalRegistration_form_item_civility_MME_1').innerHTML = '<input id="capture_traditionalRegistration_civility_MME_1" class="radio capture_civility_MME_1 capture_input_radio" type="radio" name="civility" value="MME" data-capturecollection="true" data-capturefield="civility"><label class="custom-radio" for="capture_traditionalRegistration_civility_MME_1"></label><label class="txt-radio">Mme</label>';

                $timeout(function () {
                    $("#capture_traditionalRegistration_displayName").attr("placeholder", "Choisir votre pseudo*");
                    $("#capture_traditionalRegistration_emailAddress").attr("placeholder", "Votre email*");
                    $("#capture_traditionalRegistration_password").attr("placeholder", "Saisissez votre mot de passe*");
                    $("#capture_traditionalRegistration_passwordConfirm").attr("placeholder", "Ressaisissez votre mot de passe*");
                    $("#capture_traditionalRegistration_phone").attr("placeholder", "Téléphone");
                    $("#capture_traditionalRegistration_firstName").attr("placeholder", "Votre prénom*");
                    $("#capture_traditionalRegistration_lastName").attr("placeholder", "Votre nom*");
                    $("#capture_traditionalRegistration_zipcode").attr("placeholder", "Code postal*");
                    $("#capture_traditionalRegistration_city").attr("placeholder", "Ville*");
                    $("#capture_traditionalRegistration_address").attr("placeholder", "Adresse*");



                }, 300);


                if (result.screen == "requirementsPostLogin") {

                    if (document.getElementById("capture_requirementsPostLogin_birthdate_dateselectmonth").selectedIndex != 0) {
                        document.getElementById("capture_requirementsPostLogin_form_item_birthdate").style.display = "none";
                    }
                }


            });


            // should be the last line in janrainCaptureWidgetOnLoad()
            janrain.capture.ui.start();

        }

        janrainInterval = $interval(function () {
            $rootScope.loading = true;
            if ((janrain) && (janrain.events)) {
                janrainCaptureWidgetOnLoad();
                $rootScope.loading = false;
                $scope.afficheForm();
                $interval.cancel(janrainInterval);
            }
        }, 300)


    }])

function helpers_city_zip_select(zip, city) {
    $("#capture_traditionalRegistration_zipcode").val(zip);
    $("#capture_traditionalRegistration_city").val(city);
    $(".helpers_list_result").remove();
}







