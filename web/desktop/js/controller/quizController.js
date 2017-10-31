app.controller('quizCtrl', ['$routeParams', 'quizService', '$scope','$rootScope', '$window','$location', function($routeParams, quizService, $scope,$rootScope, $window, $location){
    
	//for show loading
	$rootScope.loading=true;
	$scope.page="quiz";
	
	// User Question IDs
	$scope.questions_list = [];
	
	$scope.answer = [];
	
	$scope.inputs = [];
	
	// user Answers
	$scope.answers = {};
	
	// second Name
	$scope.secondName = [];
	
	$scope.oldAnswers = [];
	
	$scope.textarea = false;
	
	$scope.step = $routeParams.step;
	switch($routeParams.step){
    	case "FEEDBACK_1": $scope.previousStep = "/dashboard"; break;
    	case "FEEDBACK_2": $scope.previousStep = "/quiz/FEEDBACK_1"; break;
    	case "FEEDBACK_3": $scope.previousStep = "/quiz/FEEDBACK_2"; break;
	}
	
	$scope.token = $window.localStorage.getItem('janrainCaptureToken');
	
	$scope.parrains = [{'name':'','mail':'','tel':'','validator':''}];
	
	$scope.pregnant = false;
	
	$scope.popup = false;
	
	$scope.defaultpercent = 90;
	
	$scope.order = [];
	
	$scope.hideParrainBtn = false;
	
	var feedbackHistory = JSON.parse(window.localStorage.getItem($scope.step));
	if($scope.step && feedbackHistory){
		quizService.submitQuiz($scope.step, {answers: feedbackHistory})
		  .then(function(res){
			  // Success
			  $scope.answers = [];			  
			  $scope.score = res.data.score;
			  $scope.feedBack = true;
			  switch($scope.step){
			    case "FEEDBACK_1": $scope.feedBack1 = true; break;
			    case "FEEDBACK_2": $scope.feedBack2 = true; break;
			    case "FEEDBACK_3": $scope.feedBack3 = true; break;
			  }
			  $scope.feedBack = true;
			  $rootScope.loading=false;
		  }, function(){
		  })
	}else{
		// Get Quiz Questions
		quizService.getQuiz($routeParams.step)
		 .then(function(data){
			 if(data){
				 window.localStorage.removeItem($routeParams.step);
				 if(data.answers && data.answers.length){
					// window.location.hash = '#!/dashboard';
					 $location.path('/dashboard');
				 }
				 $scope.quizs = data.quiz;	
				 $scope.stepNbr = $scope.quizs.step_nbr;
				 $scope.questionNbr = 1;
				 reintializeQuiz();
				 $scope.myQuestions = fetchQuestionByOrder($scope.questionNbr);
				 $scope.currentQuestionId = $scope.myQuestions[0].id;
				 $scope.questions_list.push($scope.currentQuestionId);
				//for hide loading
				 $rootScope.loading=false;
				 $scope.myQuestions.forEach(function(questionn){
			    	 $scope.secondName[questionn.id] = fetchSecondName(questionn.id);
			     })
				 //$scope.secondName = fetchSecondName($scope.myQuestions[0].id);
				 $scope.popup = false;
				 $scope.percent = ($scope.defaultpercent/$scope.stepNbr)*$scope.questionNbr;
			 }else{
				 //window.location.hash = '#!/dashboard';
				 $location.path('/dashboard');
			 }
		 })
	}

	// check if choice answered
	$scope.isChecked = function(id, questionId){	
		var listIds = [];
		for(key in $scope.answers){
			var answers = $scope.answers[key];
			answers.forEach(function(choice){
						listIds.push(choice.answerId);
				});
			}
		if(listIds.indexOf(id) != -1){
			//console.log($scope.oldAnswers);
			if($scope.oldAnswers.indexOf(fetchChoiceById(id))){
				if(!angular.isArray($scope.oldAnswers[questionId])){
					$scope.oldAnswers[questionId] = [];
				}
				if ($scope.oldAnswers[questionId].indexOf(fetchChoiceById(id)) == -1) {
					 $scope.oldAnswers[questionId].push(fetchChoiceById(id));
				}
			}
			return true;
		}else{
			return false;
		}
	}
	
	var fetchinputValue = function(){
		for(key in $scope.answers){
			var answers = $scope.answers[key];
			answers.forEach(function(choice){
						if(choice.inputValue){
							$scope.inputs[choice.answerId] = choice.inputValue;
							$scope.myQuestions.forEach(function(myQuestion){
								if(myQuestion.input_type == 4 && myQuestion.choices[0].id == choice.answerId){
									$scope.oldAnswers[myQuestion.id] = {0:parseInt(choice.inputValue)};
								}
							});
						}
				});
		}
	}
	
	// check if choice answered
	$scope.isRadioChecked = function(id, questionId,value){	
		var listIds = [], inputType;
		inputType = fetchQuestionInputType(questionId);
		//for(key in $scope.answers){
		var answers = $scope.answers['question-'+questionId];
		if(answers){
			if(inputType == 2){
				answers.forEach(function(choice){
					if(choice.YesNo == 1){
						listIds.push(choice.answerId);
					}
				});
				if($scope.oldAnswers.indexOf(fetchChoiceById(id))){
					if(!angular.isArray($scope.oldAnswers[questionId])){
						$scope.oldAnswers[questionId] = [];
					}
					if ($scope.oldAnswers[questionId].indexOf(fetchChoiceById(id)) == -1) {
						var choiceObject = fetchChoiceById(id);
						
						if(listIds.indexOf(id) != -1){
							choiceObject.YesNo = 1;
						}else{
							choiceObject.YesNo = 0;
						}
						$scope.oldAnswers[questionId].push(fetchChoiceById(id));
					}
				}
				if(listIds.indexOf(id) != -1){
					return value==1?true:false;
				}else{
					return value == 0?true:false;
				}
			}else{
				answers.forEach(function(choice){
					listIds.push(choice.answerId);
				});
				if(listIds.indexOf(id) != -1){
					//console.log($scope.oldAnswers);
					if($scope.oldAnswers.indexOf(fetchChoiceById(id))){
						if(!angular.isArray($scope.oldAnswers[questionId])){
							$scope.oldAnswers[questionId] = [];
						}
						if ($scope.oldAnswers[questionId].indexOf(fetchChoiceById(id)) == -1) {
							 $scope.oldAnswers[questionId].push(fetchChoiceById(id));
						}
					}
					return true;
				}else{
					return false;
				}
			}
		}
	}
	
	// Go To Previous Question
	$scope.goBack = function(){	
		//$scope.secondName = [];
		$scope.questions_list.pop();
		$scope.currentQuestionId = $scope.questions_list[$scope.questions_list.length - 1];
		$scope.questionNbr = $scope.questionNbr - 1;
		$scope.myQuestions = fetchQuestionByOrder($scope.questionNbr);
		$scope.questionError = false;	
		$scope.oldAnswers = [];
		$scope.answer = [];
		fetchinputValue();
		$scope.popup = false;
		$scope.textarea = false;
		$scope.inputs.forEach(function(inputValue){
			var inputChoice = fetchChoiceById($scope.inputs.indexOf(inputValue));
			$scope.answer[inputChoice.questionId] = {};
			$scope.answer[inputChoice.questionId][0] = parseInt(inputValue);
		});
		$scope.order.forEach(function(order){
				var orderChoice = fetchChoiceById($scope.order.indexOf(order));
				if(getObjectLength($scope.oldAnswers[orderChoice.questionId]) == 0 ){
					$scope.oldAnswers[orderChoice.questionId] = {};
				}
				orderChoice.order = order;
				$scope.oldAnswers[orderChoice.questionId][orderChoice.id] = orderChoice;
		});
		 $scope.percent = ($scope.defaultpercent/$scope.stepNbr)*$scope.questionNbr;
		 scrolToTop();
	}
	
	// Go To Next Question
	$scope.goNextQuestion = function(isLastQuestion){
	 var questionAnswers, questionInc = 0, next_quest;
	 
	 $scope.questionError = [];	
	 //$scope.secondName = [];
	 if(isLastQuestion == 'popup'){$scope.popup = true;}
	 $scope.myQuestions.forEach(function(myQuestion){
		 questionInc = questionInc + 1;
		 //console.log($scope.answer);
		 questionAnswers = $scope.answer[myQuestion.id];
		 if(!questionAnswers && $scope.oldAnswers[myQuestion.id] && getObjectLength($scope.oldAnswers) >= $scope.myQuestions.length  ){
			 //$scope.answer = $scope.oldAnswers;
			 questionAnswers = $scope.oldAnswers[myQuestion.id];
		 }
		 if(myQuestion.input_type == 8 && !$scope.pregnant){
			 console.log('homme');
		 }else if((questionAnswers && questionAnswers.length > 0) || (questionAnswers && questionAnswers[0]) || (questionAnswers && getObjectLength(questionAnswers) > 0) ){
			 if( myQuestion.input_type == 1 && getObjectLength(questionAnswers) > 1){
				 $scope.questionError[myQuestion.id] = "Merci de sélectionner une seule réponse"; 
			 }else if( myQuestion.input_type == 9 && getObjectLength(questionAnswers) < 2){
					 $scope.questionError[myQuestion.id] = "Merci de sélectionner au moins deux réponses"; 
			 }else if(myQuestion.input_type == 2 && getObjectLength(questionAnswers) != myQuestion.choices.length){
				 $scope.questionError[myQuestion.id] = "Merci de répondre à toutes les questions";
			 }else if(myQuestion.input_type == 10 && getObjectLength(questionAnswers) != myQuestion.choices.length){
				 $scope.questionError[myQuestion.id] = "Veuillez classer toutes les réponses par ordre de préférence";
			 }else if(myQuestion.input_type == 6 && !$scope.addParrain("next")){
				 $scope.questionError[myQuestion.id] = " ";
			 }else if(myQuestion.input_type == 4 && !checkCigaretNumber(myQuestion, questionAnswers)){
				 $scope.questionError[myQuestion.id] = "Veuillez indiquer le nombre de cigarettes fumées"; 
			 }else if(questionAnswers.length > 0 || angular.isObject(questionAnswers)){
			     
				 if(angular.isArray(questionAnswers)){  // Handle Multi choices Array
					 var arr = [];
			    	 questionAnswers.forEach(function(item){
			    		 if(item.id == 1 && !$scope.popup){
			    			 $("#modal1").trigger("click");
			    			 $scope.questionError[myQuestion.id] = " ";
			    		 }else{
				    		 arr.push({answerId: item.id,  questionId: myQuestion.id, renamedQuestion: item.renamed_question || [], hideQuestion: item.hide_question || [], YesNo: item.YesNo || null });
				    		 next_quest = item.next_question;
				    		 $scope.answers['question-'+myQuestion.id] = arr;
			    		 }
			    	 })
			     }else if(angular.isObject(questionAnswers) && !(questionAnswers.id)){ // Handle Multi choices Object
			         var key, arr = [];
			         
			         if(myQuestion.input_type == 4){
			        	 myQuestion.choices.forEach(function(choiceItem){
			        	 arr.push({answerId: choiceItem.id,  questionId: myQuestion.id, renamedQuestion: choiceItem.renamed_question || [], hideQuestion: choiceItem.hide_question || [],inputValue: questionAnswers[0]   });
		    			 next_quest = choiceItem.next_question;
			        	 });
			         }else if(myQuestion.input_type == 5){
			        	 for(key in questionAnswers){
				    		arr.push({answerId: questionAnswers[key].id,  questionId: myQuestion.id, renamedQuestion: questionAnswers[key].renamed_question || [], hideQuestion: questionAnswers[key].hide_question || []  });
				    	    next_quest = questionAnswers[key].next_question;
				    	 }
			         }else if(myQuestion.input_type == 10){
			        	 for(key in questionAnswers){
					    		arr.push({answerId: questionAnswers[key].id,  questionId: myQuestion.id, renamedQuestion: questionAnswers[key].renamed_question || [], hideQuestion: questionAnswers[key].hide_question || [],order: questionAnswers[key].order  });
					    	    next_quest = questionAnswers[key].next_question;
					    	 }
			         }else{
				    	 for(key in questionAnswers){
				    		 if(questionAnswers[key].id){
				    			 arr.push({answerId: questionAnswers[key].id,  questionId: myQuestion.id, renamedQuestion: questionAnswers[key].renamed_question || [], hideQuestion: questionAnswers[key].hide_question || [], YesNo: questionAnswers[key].YesNo   });
				    			 next_quest = questionAnswers[key].next_question;
				    		 }
				    		 if(questionAnswers[key].answer && questionAnswers[key].answer.id){
				    			 arr.push({answerId: questionAnswers[key].answer.id,  questionId: myQuestion.id, renamedQuestion: questionAnswers[key].answer.renamed_question || [], hideQuestion: questionAnswers[key].answer.hide_question || [], YesNo: questionAnswers[key].YesNo   });
				    			 next_quest = questionAnswers[key].answer.next_question;
				    		 }
				    	 }
			         }
			    	 $scope.answers['question-'+myQuestion.id] = arr;
			      }
			     
				 // If Is Last Question Submit		 
				 if(isLastQuestion == 'submit'){
					 $scope.submitQuiz();
				 }
			 }else{
				 $scope.questionError[myQuestion.id] = "Merci de sélectionner au moins une réponse";
			 }
		 }else{
			 if(myQuestion.input_type == 2){
				 $scope.questionError[myQuestion.id] = "Merci de répondre à toutes les questions";
			 }else if(myQuestion.input_type == 4){
				 $scope.questionError[myQuestion.id] = "Veuillez indiquer le nombre de cigarettes fumées"; 
			 }else if(myQuestion.input_type == 10){
				 $scope.questionError[myQuestion.id] = "Veuillez classer toutes les réponses par ordre de préférence"; 
			 }else{
				 $scope.questionError[myQuestion.id] = "Veuillez sélectionner une réponse"; 
			 }
		 }
		 
	  });
	 if($scope.questionError.length == 0){
		 $scope.questionNbr = $scope.questionNbr + 1;
		 $scope.currentQuestionId = next_quest;
	     $scope.myQuestions = fetchQuestionByOrder($scope.questionNbr);
	     $scope.questions_list.push($scope.currentQuestionId);
	     $scope.myQuestions.forEach(function(questionn){
	    	 $scope.secondName[questionn.id] = fetchSecondName(questionn.id);
	     })
	     
	     $scope.percent = ($scope.defaultpercent/$scope.stepNbr)*$scope.questionNbr;
	     $scope.oldAnswers = [];
	     $scope.answer = [];
	     $scope.inputs.forEach(function(inputValue){
				var inputChoice = fetchChoiceById($scope.inputs.indexOf(inputValue));
				$scope.oldAnswers[inputChoice.questionId] = {};
				$scope.oldAnswers[inputChoice.questionId][0] = inputValue;
				$scope.answer[inputChoice.questionId] = {};
				$scope.answer[inputChoice.questionId][0] = inputValue;
		 });
	     $scope.order.forEach(function(order){
				var orderChoice = fetchChoiceById($scope.order.indexOf(order));
				if(getObjectLength($scope.oldAnswers[orderChoice.questionId]) == 0 ){
					$scope.oldAnswers[orderChoice.questionId] = {};
				}
				orderChoice.order = order;
				$scope.oldAnswers[orderChoice.questionId][orderChoice.id] = orderChoice;
		 });
	    
	     
	 }
	 scrolToTop();
    }
	
	
	// Fetch Question By Order	
	var fetchQuestionByOrder = function(order){
		var question,
			doubleQuestion = [],
			secondQuestion
		;
		$scope.quizs.questions.forEach(function(item){
			if(item.question_order == order) {
				doubleQuestion.push(item);
			}
		})
		return doubleQuestion;
	}
	
	/* Fetch Second Name*/
	var fetchSecondName = function(id){
		var  changeName,
		     key,
		     listIds = [];
		for(key in $scope.answers){
			var answers = $scope.answers[key];
			answers.forEach(function(choice){
				if(choice.renamedQuestion.length > 0){
					choice.renamedQuestion.forEach(function(toRename){
						listIds.push(toRename);
					});
				}
			})
		 }
		var feedbackOneHistory = JSON.parse(window.localStorage.getItem("FEEDBACK_1"));
		if(feedbackOneHistory){
			for(question in feedbackOneHistory){
				for(choice in feedbackOneHistory[question]){
					if(feedbackOneHistory[question][choice].renamedQuestion){
						feedbackOneHistory[question][choice].renamedQuestion.forEach(function(toRename){
							 if (listIds.indexOf(toRename) == -1) {
								 listIds.push(toRename);
						     }
						});
					}
				}
			}
		}
		
		var feedbackTwoHistory = JSON.parse(window.localStorage.getItem("FEEDBACK_2"));
		if(feedbackTwoHistory){
			for(question in feedbackTwoHistory){
				for(choice in feedbackTwoHistory[question]){
					if(feedbackTwoHistory[question][choice].renamedQuestion){
						feedbackTwoHistory[question][choice].renamedQuestion.forEach(function(toRename){
							 if (listIds.indexOf(toRename) == -1) {
								 listIds.push(toRename);
						     }
						});
					}
				}
			}
		}
		return listIds.indexOf(''+id) != -1;
	}
	
	/* Fetch hide question Name*/
	var fetchHideQuestion = function(id){
		var  hideQuestion,
		     key,
		     listIds = [];
		for(key in $scope.answers){
			var answers = $scope.answers[key];
			answers.forEach(function(choice){
				if(choice.hideQuestion.length > 0){
					choice.hideQuestion.forEach(function(toHide){
						listIds.push(toHide);
					});
				}
			})
		 }
		var feedbackOneHistory = JSON.parse(window.localStorage.getItem("FEEDBACK_1"));
		if(feedbackOneHistory){
			for(question in feedbackOneHistory){
				for(choice in feedbackOneHistory[question]){
					if(feedbackOneHistory[question][choice].hideQuestion){
						feedbackOneHistory[question][choice].hideQuestion.forEach(function(toHide){
							 if (listIds.indexOf(toHide) == -1) {
								 listIds.push(toHide);
						     }
						});
					}
				}
			}
		}
		
		var feedbackTwoHistory = JSON.parse(window.localStorage.getItem("FEEDBACK_2"));
		if(feedbackTwoHistory){
			for(question in feedbackTwoHistory){
				for(choice in feedbackTwoHistory[question]){
					if(feedbackTwoHistory[question][choice].hideQuestion){
						feedbackTwoHistory[question][choice].hideQuestion.forEach(function(toHide){
							 if (listIds.indexOf(toHide) == -1) {
								 listIds.push(toHide);
						     }
						});
					}
				}
			}
		}
		return listIds.indexOf(id) != -1;
	}
	
	// Submit Quiz
	$scope.submitQuiz = function(){
		
		if($scope.myQuestions && $scope.myQuestions.input_type == 1 && getObjectLength($scope.answer) > 1){
			 $scope.questionError = "une seule reponse"; 
		 }else{
			 $scope.answers['parrains'] = $scope.parrains;
			quizService.submitQuiz($routeParams.step, {answers: $scope.answers})
			  .then(function(res){
				  // Success
				  window.localStorage.setItem($routeParams.step, JSON.stringify($scope.answers));
				  $scope.answers = [];			  
				  $scope.score = res.data.score;
				  $scope.feedBack = true;
				  switch($routeParams.step){
				    case "FEEDBACK_1": $scope.feedBack1 = true; break;
				    case "FEEDBACK_2": $scope.feedBack2 = true; break;
				    case "FEEDBACK_3": $scope.feedBack3 = true; break;
				  }
				  
			  }, function(){
				  // Fail
				  
			  })
		 }
	};
	
	/* fetch Choice by Id*/
	var fetchChoiceById = function(id){
		var choice;
		$scope.quizs.questions.forEach(function(item){
			item.choices.forEach(function(option){
				if(option.id == id){
					choice =  option;
					choice.questionId = item.id;
				}
			})
		})
		return choice;
	}
	
	/* fetch question input type */
	var fetchQuestionInputType = function(id){
		var inputType;
		$scope.quizs.questions.forEach(function(item){
			if(item.id == id){
				inputType =  item.input_type;
			}
		});
		return inputType;
	}
	
	var getQuestionLength = function(my_object, questionId){
		
		var len = 0;
		for(key in my_object){
			if( key == 'question-'+questionId){
				len++;
			}
		}
		return len;
	}
	
	var getObjectLength = function(my_object){
		var len = 0;
		for(key in my_object){
				len++;
		}
		return len;
	}
	
	$scope.validateAnswer = function(texttype){
		$scope.myQuestions.forEach(function(myQuestion){
			var	 key = 'question-'+myQuestion.id;
			if(myQuestion.input_type == 1 && getObjectLength($scope.answers)){
				//console.log($scope.answers);
				delete $scope.answers[key];
			}
			if(texttype && !$scope.textarea){
				$scope.textarea = true;
			}else{
				$scope.textarea = false;
			}
		});
	}
	
	var reintializeQuiz = function(){
		$scope.quizs.questions.forEach(function(item){
			if(fetchHideQuestion(item.id)){
				$scope.quizs.questions.splice($scope.quizs.questions.indexOf(item),1);
				 $scope.stepNbr--;
				 $scope.questionNbr++;
			};
		})
	}
	
	$scope.getNumber = function(num) {
	    return new Array(num);   
	}
	
	
	// Submit Quiz
	$scope.saveQuiz = function(){
		quizService.saveQuiz()
		  .then(function(res){
			  if(res.data.url=='pre-inscription' && $rootScope.device != 'desktop'){
				  $location.path('/inscription');
			  }else{
				  $location.path('/'+res.data.url);
			  }
		  }, function(){
			  // Fail
		  })
	};
	
	
	$scope.updateChecked = function(choiceId, inputType, questionId){
		
		if(inputType == 1){
			$scope.answer[questionId].forEach(function(item){
				if(item.id != choiceId ){
					$scope.answer[questionId].splice(0,1);
				}
			});
		}
		
	};
	
	$scope.addParrain = function(next){
		var parrain = {'name':'','mail':'','tel':'','validator':''};
		var TEL_REGEXP = /^0[6-7]([-. ]?[0-9]{2}){4}$/;
		var pass = true;
		
		for(key in $scope.parrains){
			if( !$scope.parrains[key].tel || !TEL_REGEXP.test($scope.parrains[key].tel)){
				pass = false;
			}
		}
		
		for(key in $scope.parrains){
			if(!$scope.parrains[key].tel){
				$scope.parrains[key].validator = "Veuillez renseigner un numéro de téléphone";
				return false;
			}else if(!TEL_REGEXP.test($scope.parrains[key].tel)){
				$scope.parrains[key].validator = "Veuillez renseigner un numéro de téléphone valide";
				return false;
			}else if(pass){
				$scope.parrains[key].validator = "";
				if(!next){
					if(getObjectLength($scope.parrains) < 3 ){
						$scope.parrains.push(parrain) ;
					}
	
					if(getObjectLength($scope.parrains) == 3){
						$scope.hideParrainBtn = true;
					}
				}
			}
		}
		return true;
			
	};
	
	$scope.setYesNoValue = function(id, questionId, YesNo, index){
		var choiceObject = {}, lengthObject, oldChoice = {}, listIds = [];
		choiceObject.YesNo = YesNo;
		choiceObject.answer = fetchChoiceById(id);
		if(!$scope.answer[questionId]){
			$scope.answer[questionId] = {};
		}
		$scope.answer[questionId][index] = choiceObject;
		
		if($scope.oldAnswers.length){
			for(option in $scope.answer[questionId]){
				listIds.push(option);
			};
			for(key in $scope.oldAnswers[questionId]){
				var oldChoice = {};
				oldChoice.YesNo = $scope.oldAnswers[questionId][key].YesNo;
				oldChoice.answer = $scope.oldAnswers[questionId][key];
				if(key != index && listIds.indexOf(key) == -1){
					$scope.answer[questionId][key] = oldChoice;
				}
			}
		}
		
	};
	
	$scope.goNicorette = function(){
		$window.open('http://www.nicorette.fr');
		$scope.popup = false;
	};
	
	$scope.setRadioValue = function(choiceId, questionId, inputType){
		var lengthObject, oldChoice = {};
		if(!$scope.answer[questionId]){
			$scope.answer[questionId] = {};
		}
		$scope.answer[questionId][0] = fetchChoiceById(choiceId);
		
		if(inputType == 5 || inputType == 6 || inputType == 7 || inputType == 8){
			for(index in $scope.answer[questionId]){
				if($scope.answer[questionId][index].id != choiceId){
					delete $scope.answer[questionId][index];
				}
			}
		}
		if(inputType == 7){
			for(index in $scope.answer[questionId]){
				if($scope.answer[questionId][index].name == 'Femme'){
					$scope.pregnant = true;
				}else{
					$scope.pregnant = false;
				}
			}
		}
	};
	
	$scope.setOrderInput = function(choiceId, questionId){
		
		var lengthObject, oldChoice = {}, order;
		
		if($scope.order[choiceId]){
			$scope.order = [];
		}
		order = getObjectLength($scope.order);
		order++;
		if(order <= 6){
			$scope.order[choiceId] = order;
			if(!$scope.answer[questionId]){
				$scope.answer[questionId] = {};
			}
			oldChoice = fetchChoiceById(choiceId);
			oldChoice.order = order;
			$scope.answer[questionId][choiceId] = oldChoice;
		}
		
		
	};
	
	var checkCigaretNumber = function(myQuestion, questionAnswers){
		var INT_REGEXP = /^\d+$/;
		var bool = false;
		myQuestion.choices.forEach(function(choiceItem){
			if(INT_REGEXP.test(questionAnswers[0])){
				bool = true;
			}
         });
		return bool;
	}
	
	$scope.deleteError = function(index){
		$scope.parrains[index].validator = "";
	}
	
	var scrolToTop=function(){
		 $("html, body").animate({ scrollTop: 0 }, "slow");
    }

	
}])
