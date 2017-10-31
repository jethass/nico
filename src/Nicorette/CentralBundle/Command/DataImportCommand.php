<?php

namespace Nicorette\CentralBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Nicorette\CentralBundle\Entity\Patient;
use Nicorette\CentralBundle\Entity\Contact;
use Nicorette\CentralBundle\Entity\Contract;
use Nicorette\CentralBundle\Entity\PointHistory;
use Nicorette\CentralBundle\Entity\Quiz;
use Nicorette\CentralBundle\Entity\Question;
use Nicorette\CentralBundle\Entity\Choice;
use Nicorette\CentralBundle\Entity\QuizAnswer;
use Nicorette\CentralBundle\Entity\Answer;

class DataImportCommand extends ContainerAwareCommand {
	
	private $em;
	
    protected function configure() {
        $this ->setName('nicorette:central:import')
              ->setDescription('Insertion des données dans la Base de données.');
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
    	$this->em = $this->getDoctrine()->getManager();
        
        $patient = new Patient();
        $patient->setExpiredAt(new \DateTime("2015-03-27 12:25:36"));
        $patient->setToken("vuwh3kfz66prxksf");
        $patient->setJanrainId("b5738b33-639e-479c-b78c-d1985d39a30b");
        $patient->setClubAlerts(0);
        $patient->setJohnsonAlerts(0);
        $patient->setStatus(0);
        
        $contact1 = new Contact();
        $contact1->setPatient($patient);
        $contact1->setPhone("0653213695");
        $contact1->setEmail("contact_1@yopmail.com");
        $contact1->setName("Contact_1");
        $patient->addContact($contact1);
        $contact2 = new Contact();
        $contact2->setPatient($patient);
        $contact2->setPhone("0653213685");
        $contact2->setEmail("contact_2@yopmail.com");
        $contact2->setName("Contact_2");
        $patient->addContact($contact2);
        $contact3 = new Contact();
        $contact3->setPatient($patient);
        $contact3->setPhone("0653213652");
        $contact3->setEmail("contact_3@yopmail.com");
        $contact3->setName("Contact_3");
        $patient->addContact($contact3);
        
        $contract1 = new Contract();
        $contract1->setPatient($patient);
        $contract1->setLastCigarette(new \DateTime("2015-01-15 12:25:36"));
        $contract1->setQuit(0);
        $contract1->setStopDate(new \DateTime("2015-02-15 12:25:36"));
        $patient->addContract($contract1);
        
        $pointHistory1 = new PointHistory();
        $pointHistory1->setPatient($patient);
        $pointHistory1->setNbPoint(11);
        $pointHistory1->setType("Type_1");
        $patient->addPointHistory($pointHistory1);
        
        $patient2 = new Patient();
        $patient2->setExpiredAt(new \DateTime("2015-02-17 12:25:36"));
        $patient2->setToken("gqqps4hnt6m57q8a");
        $patient2->setJanrainId("01e0cada-e442-43ac-a3a1-1226ea0ffe8f");
        $patient2->setClubAlerts(0);
        $patient2->setJohnsonAlerts(0);
        $patient2->setStatus(0);
        
        $contact12 = new Contact();
        $contact12->setPatient($patient2);
        $contact12->setPhone("0253213695");
        $contact12->setEmail("contact_12@yopmail.com");
        $contact12->setName("Contact_12");
        $patient2->addContact($contact12);
        $contact22 = new Contact();
        $contact22->setPatient($patient2);
        $contact22->setPhone("0253213685");
        $contact22->setEmail("contact_22@yopmail.com");
        $contact22->setName("Contact_22");
        $patient2->addContact($contact22);
        $contact32 = new Contact();
        $contact32->setPatient($patient2);
        $contact32->setPhone("0253213652");
        $contact32->setEmail("contact_32@yopmail.com");
        $contact32->setName("Contact_32");
        $patient2->addContact($contact32);
        
        $contract2 = new Contract();
        $contract2->setPatient($patient2);
        $contract2->setLastCigarette(new \DateTime("2015-01-10 12:25:36"));
        $contract2->setQuit(0);
        $contract2->setStopDate(new \DateTime("2015-03-05 12:25:36"));
        $patient2->addContract($contract2);
        
        $pointHistory2 = new PointHistory();
        $pointHistory2->setPatient($patient2);
        $pointHistory2->setNbPoint(12);
        $pointHistory2->setType("Type_2");
        $patient2->addPointHistory($pointHistory2);
        
        $patient3 = new Patient();
        $patient3->setExpiredAt(new \DateTime("2015-01-27 13:25:36"));
        $patient3->setToken("62kx54f577m28v6y");
        $patient3->setJanrainId("2bbe5b77-53c4-4d19-896c-b1fcd3c4337e");
        $patient3->setClubAlerts(0);
        $patient3->setJohnsonAlerts(0);
        $patient3->setStatus(0);
        
        $contact13 = new Contact();
        $contact13->setPatient($patient3);
        $contact13->setPhone("0353213695");
        $contact13->setEmail("contact_13@yopmail.com");
        $contact13->setName("Contact_13");
        $patient3->addContact($contact13);
        $contact23 = new Contact();
        $contact23->setPatient($patient3);
        $contact23->setPhone("0353213685");
        $contact23->setEmail("contact_23@yopmail.com");
        $contact23->setName("Contact_23");
        $patient3->addContact($contact23);
        $contact33 = new Contact();
        $contact33->setPatient($patient3);
        $contact33->setPhone("0353213652");
        $contact33->setEmail("contact_33@yopmail.com");
        $contact33->setName("Contact_33");
        $patient3->addContact($contact33);
        
        $contract3 = new Contract();
        $contract3->setPatient($patient3);
        $contract3->setLastCigarette(new \DateTime("2015-01-13 12:25:36"));
        $contract3->setQuit(0);
        $contract3->setStopDate(new \DateTime("2015-03-03 12:25:36"));
        $patient3->addContract($contract3);
        
        $pointHistory3 = new PointHistory();
        $pointHistory3->setPatient($patient3);
        $pointHistory3->setNbPoint(13);
        $pointHistory3->setType("Type_3");
        $patient3->addPointHistory($pointHistory3);
        
        $patient4 = new Patient();
        $patient4->setExpiredAt(new \DateTime("2015-01-07 12:25:36"));
        $patient4->setToken("r599dgtskzvhzrnm");
        $patient4->setJanrainId("0b482ff2-5e44-4adb-ba7b-8713f2e5f897");
        $patient4->setClubAlerts(0);
        $patient4->setJohnsonAlerts(0);
        $patient4->setStatus(0);
        
        $contact14 = new Contact();
        $contact14->setPatient($patient4);
        $contact14->setPhone("0453213695");
        $contact14->setEmail("contact_14@yopmail.com");
        $contact14->setName("Contact_14");
        $patient4->addContact($contact14);
        $contact24 = new Contact();
        $contact24->setPatient($patient4);
        $contact24->setPhone("0453213685");
        $contact24->setEmail("contact_24@yopmail.com");
        $contact24->setName("Contact_24");
        $patient4->addContact($contact24);
        $contact34 = new Contact();
        $contact34->setPatient($patient4);
        $contact34->setPhone("0453213652");
        $contact34->setEmail("contact_34@yopmail.com");
        $contact34->setName("Contact_34");
        $patient4->addContact($contact34);
        
        $contract4 = new Contract();
        $contract4->setPatient($patient4);
        $contract4->setLastCigarette(new \DateTime("2015-01-04 12:25:36"));
        $contract4->setQuit(0);
        $contract4->setStopDate(new \DateTime("2015-02-04 12:25:36"));
        $patient4->addContract($contract4);
        
        $pointHistory4 = new PointHistory();
        $pointHistory4->setPatient($patient4);
        $pointHistory4->setNbPoint(14);
        $pointHistory4->setType("Type_4");
        $patient->addPointHistory($pointHistory4);
        
        $patient5 = new Patient();
        $patient5->setExpiredAt(new \DateTime("2014-12-07 12:25:36"));
        $patient5->setToken("6gm9xp8pcut28nx9");
        $patient5->setJanrainId("c76db572-d94d-4d1c-8fdc-7ed0206f3d30");
        $patient5->setClubAlerts(0);
        $patient5->setJohnsonAlerts(0);
        $patient5->setStatus(0);
        
        $contact15 = new Contact();
        $contact15->setPatient($patient5);
        $contact15->setPhone("0553213695");
        $contact15->setEmail("contact_15@yopmail.com");
        $contact15->setName("Contact_15");
        $patient5->addContact($contact15);
        $contact25 = new Contact();
        $contact25->setPatient($patient5);
        $contact25->setPhone("0553213685");
        $contact25->setEmail("contact_25@yopmail.com");
        $contact25->setName("Contact_25");
        $patient5->addContact($contact25);
        $contact35 = new Contact();
        $contact35->setPatient($patient5);
        $contact35->setPhone("0553213652");
        $contact35->setEmail("contact_35@yopmail.com");
        $contact35->setName("Contact_35");
        $patient5->addContact($contact35);
        
        $contract5 = new Contract();
        $contract5->setPatient($patient5);
        $contract5->setLastCigarette(new \DateTime("2015-01-25 12:25:36"));
        $contract5->setQuit(0);
        $contract5->setStopDate(new \DateTime("2015-02-25 12:25:36"));
        $patient5->addContract($contract5);
        
        $pointHistory5 = new PointHistory();
        $pointHistory5->setPatient($patient5);
        $pointHistory5->setNbPoint(15);
        $pointHistory5->setType("Type_5");
        $patient5->addPointHistory($pointHistory5);
        
        $patient6 = new Patient();
        $patient6->setExpiredAt(new \DateTime("2014-06-07 12:26:36"));
        $patient6->setToken("kj3hbdd4s87u2zhw");
        $patient6->setJanrainId("648bc815-ce66-4941-af6f-489af0bcc52a");
        $patient6->setClubAlerts(0);
        $patient6->setJohnsonAlerts(0);
        $patient6->setStatus(0);
        
        $contact16 = new Contact();
        $contact16->setPatient($patient6);
        $contact16->setPhone("0663213696");
        $contact16->setEmail("contact_16@yopmail.com");
        $contact16->setName("Contact_16");
        $patient6->addContact($contact16);
        $contact26 = new Contact();
        $contact26->setPatient($patient6);
        $contact26->setPhone("0663213686");
        $contact26->setEmail("contact_26@yopmail.com");
        $contact26->setName("Contact_26");
        $patient6->addContact($contact26);
        $contact36 = new Contact();
        $contact36->setPatient($patient6);
        $contact36->setPhone("0663213662");
        $contact36->setEmail("contact_36@yopmail.com");
        $contact36->setName("Contact_36");
        $patient6->addContact($contact36);
        
        $contract6 = new Contract();
        $contract6->setPatient($patient6);
        $contract6->setLastCigarette(new \DateTime("2015-01-25 12:26:36"));
        $contract6->setQuit(0);
        $contract6->setStopDate(new \DateTime("2015-02-06 12:26:36"));
        $patient6->addContract($contract6);
        
        $pointHistory6 = new PointHistory();
        $pointHistory6->setPatient($patient6);
        $pointHistory6->setNbPoint(16);
        $pointHistory6->setType("Type_6");
        $patient6->addPointHistory($pointHistory6);
        
        $patient7 = new Patient();
        $patient7->setExpiredAt(new \DateTime("2014-07-07 12:27:37"));
        $patient7->setToken("58j6ueufg6h2pr8e");
        $patient7->setJanrainId("1700dc3c-68e1-4e7f-846b-17e732ae793a");
        $patient7->setClubAlerts(0);
        $patient7->setJohnsonAlerts(0);
        $patient7->setStatus(0);
        
        $contact17 = new Contact();
        $contact17->setPatient($patient7);
        $contact17->setPhone("0773213797");
        $contact17->setEmail("contact_17@yopmail.com");
        $contact17->setName("Contact_17");
        $patient7->addContact($contact17);
        $contact27 = new Contact();
        $contact27->setPatient($patient7);
        $contact27->setPhone("0773213787");
        $contact27->setEmail("contact_27@yopmail.com");
        $contact27->setName("Contact_27");
        $patient7->addContact($contact27);
        $contact37 = new Contact();
        $contact37->setPatient($patient7);
        $contact37->setPhone("0773213772");
        $contact37->setEmail("contact_37@yopmail.com");
        $contact37->setName("Contact_37");
        $patient7->addContact($contact37);
        
        $contract7 = new Contract();
        $contract7->setPatient($patient7);
        $contract7->setLastCigarette(new \DateTime("2015-01-25 12:27:37"));
        $contract7->setQuit(0);
        $contract7->setStopDate(new \DateTime("2015-01-31 12:27:37"));
        $patient7->addContract($contract7);
        
        $pointHistory7 = new PointHistory();
        $pointHistory7->setPatient($patient7);
        $pointHistory7->setNbPoint(17);
        $pointHistory7->setType("Type_7");
        $patient7->addPointHistory($pointHistory7);
        
        $patient8 = new Patient();
        $patient8->setExpiredAt(new \DateTime("2014-08-07 12:28:38"));
        $patient8->setToken("ujjebxy2udnh3n9x");
        $patient8->setJanrainId("15ee8d90-b04c-4363-bf48-1245c2c39bb5");
        $patient8->setClubAlerts(0);
        $patient8->setJohnsonAlerts(0);
        $patient8->setStatus(0);
        
        $contact18 = new Contact();
        $contact18->setPatient($patient8);
        $contact18->setPhone("0883213898");
        $contact18->setEmail("contact_18@yopmail.com");
        $contact18->setName("Contact_18");
        $patient8->addContact($contact18);
        $contact28 = new Contact();
        $contact28->setPatient($patient8);
        $contact28->setPhone("0883213888");
        $contact28->setEmail("contact_28@yopmail.com");
        $contact28->setName("Contact_28");
        $patient8->addContact($contact28);
        $contact38 = new Contact();
        $contact38->setPatient($patient8);
        $contact38->setPhone("0883213882");
        $contact38->setEmail("contact_38@yopmail.com");
        $contact38->setName("Contact_38");
        $patient8->addContact($contact38);
        
        $contract8 = new Contract();
        $contract8->setPatient($patient8);
        $contract8->setLastCigarette(new \DateTime("2015-01-25 12:28:38"));
        $contract8->setQuit(0);
        $contract8->setStopDate(new \DateTime("2015-01-30 12:28:38"));
        $patient8->addContract($contract8);
        
        $pointHistory8 = new PointHistory();
        $pointHistory8->setPatient($patient8);
        $pointHistory8->setNbPoint(18);
        $pointHistory8->setType("Type_8");
        $patient8->addPointHistory($pointHistory8);
        
        $patient9 = new Patient();
        $patient9->setExpiredAt(new \DateTime("2014-09-07 12:29:39"));
        $patient9->setToken("jdgjcyf86myvz6j7");
        $patient9->setJanrainId("5c867948-700f-4f07-91f1-584815f19660");
        $patient9->setClubAlerts(0);
        $patient9->setJohnsonAlerts(0);
        $patient9->setStatus(0);
        
        $contact19 = new Contact();
        $contact19->setPatient($patient9);
        $contact19->setPhone("0993213999");
        $contact19->setEmail("contact_19@yopmail.com");
        $contact19->setName("Contact_19");
        $patient9->addContact($contact19);
        $contact29 = new Contact();
        $contact29->setPatient($patient9);
        $contact29->setPhone("0993213989");
        $contact29->setEmail("contact_29@yopmail.com");
        $contact29->setName("Contact_29");
        $patient9->addContact($contact29);
        $contact39 = new Contact();
        $contact39->setPatient($patient9);
        $contact39->setPhone("0993213992");
        $contact39->setEmail("contact_39@yopmail.com");
        $contact39->setName("Contact_39");
        $patient9->addContact($contact39);
        
        $contract9 = new Contract();
        $contract9->setPatient($patient9);
        $contract9->setLastCigarette(new \DateTime("2015-01-25 12:29:39"));
        $contract9->setQuit(0);
        $contract9->setStopDate(new \DateTime("2015-02-09 12:29:39"));
        $patient9->addContract($contract9);
        
        $pointHistory9 = new PointHistory();
        $pointHistory9->setPatient($patient9);
        $pointHistory9->setNbPoint(19);
        $pointHistory9->setType("Type_9");
        $patient9->addPointHistory($pointHistory9);
        
        $patient10 = new Patient();
        $patient10->setExpiredAt(new \DateTime("2014-10-07 12:26:36"));
        $patient10->setToken("argvv8gbhurerfft");
        $patient10->setJanrainId("33a2f42c-afbe-4be8-8efe-c825714d043e");
        $patient10->setClubAlerts(0);
        $patient10->setJohnsonAlerts(0);
        $patient10->setStatus(0);
        
        $contact110 = new Contact();
        $contact110->setPatient($patient10);
        $contact110->setPhone("0103213696");
        $contact110->setEmail("contact_110@yopmail.com");
        $contact110->setName("Contact_110");
        $patient10->addContact($contact110);
        $contact210 = new Contact();
        $contact210->setPatient($patient10);
        $contact210->setPhone("0106313686");
        $contact210->setEmail("contact_210@yopmail.com");
        $contact210->setName("Contact_210");
        $patient10->addContact($contact210);
        $contact310 = new Contact();
        $contact310->setPatient($patient10);
        $contact310->setPhone("0106321362");
        $contact310->setEmail("contact_310@yopmail.com");
        $contact310->setName("Contact_310");
        $patient10->addContact($contact310);
        
        $contract10 = new Contract();
        $contract10->setPatient($patient10);
        $contract10->setLastCigarette(new \DateTime("2015-01-25 12:26:36"));
        $contract10->setQuit(0);
        $contract10->setStopDate(new \DateTime("2015-02-16 12:26:36"));
        $patient10->addContract($contract10);
        
        $pointHistory10 = new PointHistory();
        $pointHistory10->setPatient($patient10);
        $pointHistory10->setNbPoint(110);
        $pointHistory10->setType("Type_10");
        $patient10->addPointHistory($pointHistory10);
        
        /*$quiz1 = new Quiz();        
        $quiz1->setName("Feedback 1");
        $quiz1->setCode("FEEDBACK_1");
        $quiz1->setPassed(NULL);
        $quiz1->setStepNbr(3);
        
        $question1 = new Question();
        $question1->setId(1);
        $question1->setQuiz($quiz1);
        $question1->setName("Quand envisagez-vous d'arrêter de fumer ?");
        $question1->setInputType(1);
        $question1->setAnswerRequired(1);
        $question1->setAnswerMultiple(0);
        $question1->setQuestionOrder(1);
        $question1->setSecondName(NULL);
        
        $question2 = new Question();
        $question2->setId(2);
        $question2->setQuiz($quiz1);
        $question2->setName("Êtes-vous d'accord avec les propositions suivantes ?");
        $question2->setInputType(2);
        $question2->setAnswerRequired(1);
        $question2->setAnswerMultiple(1);
        $question2->setQuestionOrder(2);
        $question2->setSecondName(NULL);
        
        $question3 = new Question();
        $question3->setId(3);
        $question3->setQuiz($quiz1);
        $question3->setName("Quel sera pour vous l'obstacle le plus difficile pour arrêter ?");
        $question3->setInputType(3);
        $question3->setAnswerRequired(1);
        $question3->setAnswerMultiple(1);
        $question3->setQuestionOrder(3);
        $question3->setSecondName("Aujourd'hui quels sont les obstacles que vous rencontrez dans votre sevrage tabagique ?");
        
        $quiz2 = new Quiz();
        $quiz2->setName("Feedback 2");
        $quiz2->setCode("FEEDBACK_2");
        $quiz2->setPassed(NULL);
        $quiz2->setStepNbr(2);
        
        $question4 = new Question();
        $question4->setId(4);
        $question4->setQuiz($quiz2);
        $question4->setName("Pourquoi voulez-vous arrêter ?");
        $question4->setInputType(9);
        $question4->setAnswerRequired(1);
        $question4->setAnswerMultiple(1);
        $question4->setQuestionOrder(1);
        $question4->setSecondName("Pourquoi vouliez-vous arrêter ?");
        
        $question5 = new Question();
        $question5->setId(5);
        $question5->setQuiz($quiz2);
        $question5->setName("Avez-vous déjà essayé d'arrêter de fumer dans le passé ?");
        $question5->setInputType(1);
        $question5->setAnswerRequired(1);
        $question5->setAnswerMultiple(0);
        $question5->setQuestionOrder(2);
        $question5->setSecondName(NULL);
        
        $quiz3 = new Quiz();
        $quiz3->setName("Feedback 3");
        $quiz3->setCode("FEEDBACK_3");
        $quiz3->setPassed(NULL);
        $quiz3->setStepNbr(8);
        
        $question6 = new Question();
        $question6->setId(7);
        $question6->setQuiz($quiz3);
        $question6->setName("Combien de temps après votre réveil fumez-vous votre première cigarette ?");
        $question6->setInputType(1);
        $question6->setAnswerRequired(1);
        $question6->setAnswerMultiple(0);
        $question6->setQuestionOrder(1);
        $question6->setSecondName(NULL);
        
        $question7 = new Question();
        $question7->setId(8);
        $question7->setQuiz($quiz3);
        $question7->setName("Trouvez-vous qu’il est difficile de ne pas fumer dans les endroits où c'est interdit ?");
        $question7->setInputType(5);
        $question7->setAnswerRequired(1);
        $question7->setAnswerMultiple(0);
        $question7->setQuestionOrder(2);
        $question7->setSecondName(NULL);
        
        $question8 = new Question();
        $question8->setId(9);
        $question8->setQuiz($quiz3);
        $question8->setName("Combien de cigarettes fumez-vous par jour ?");
        $question8->setInputType(4);
        $question8->setAnswerRequired(1);
        $question8->setAnswerMultiple(1);
        $question8->setQuestionOrder(2);
        $question8->setSecondName("combien de cigarettes fumiez-vous par jour ?");
        
        $question9 = new Question();
        $question9->setId(10);
        $question9->setQuiz($quiz3);
        $question9->setName("A quelle cigarette de la journée vous serait-il le plus difficile de renoncer ?");
        $question9->setInputType(1);
        $question9->setAnswerRequired(1);
        $question9->setAnswerMultiple(0);
        $question9->setQuestionOrder(3);
        $question9->setSecondName(NULL);
        
        $question10 = new Question();
        $question10->setId(11);
        $question10->setQuiz($quiz3);
        $question10->setName("Fumez-vous à un rythme plus soutenu le matin que l'après-midi ?");
        $question10->setInputType(5);
        $question10->setAnswerRequired(1);
        $question10->setAnswerMultiple(0);
        $question10->setQuestionOrder(3);
        $question10->setSecondName("Fumiez-vous à un rythme plus soutenu le matin que l'après-midi ?");
        
        $question11 = new Question();
        $question11->setId(12);
        $question11->setQuiz($quiz3);
        $question11->setName("Fumez-vous lorsque vous êtes si malade que vous devez rester au lit  presque toute la journée?");
        $question11->setInputType(5);
        $question11->setAnswerRequired(1);
        $question11->setAnswerMultiple(0);
        $question11->setQuestionOrder(4);
        $question11->setSecondName("Fumiez-vous lorsque vous étiez si malade que vous deviez rester au lit presque toute la journée?");
        
        $question12 = new Question();
        $question12->setId(13);
        $question12->setQuiz($quiz3);
        $question12->setName("Qu’est-ce qui vous semble le plus important concernant votre sevrage tabagique ?");
        $question12->setInputType(10);
        $question12->setAnswerRequired(1);
        $question12->setAnswerMultiple(1);
        $question12->setQuestionOrder(5);
        $question12->setSecondName(NULL);
        
        $question13 = new Question();
        $question13->setId(14);
        $question13->setQuiz($quiz3);
        $question13->setName("Il y a-t-il d'autres fumeurs dans votre foyer ? \r\n\r\nRenseigner les contacts des personnes sur qui vous pouvez compter pour vous aider et que vous aimeriez contacter en cas de moments difficiles.\r\n\r\nEn renseignant ces contacts, vous reconnaissez avoir info");
        $question13->setInputType(6);
        $question13->setAnswerRequired(1);
        $question13->setAnswerMultiple(0);
        $question13->setQuestionOrder(6);
        $question13->setSecondName(NULL);
        
        $question14 = new Question();
        $question14->setId(16);
        $question14->setQuiz($quiz3);
        $question14->setName("Sexe");
        $question14->setInputType(7);
        $question14->setAnswerRequired(1);
        $question14->setAnswerMultiple(0);
        $question14->setQuestionOrder(7);
        $question14->setSecondName(NULL);
        
        $question15 = new Question();
        $question15->setId(18);
        $question15->setQuiz($quiz3);
        $question15->setName("Êtes vous actuellement enceinte ?");
        $question15->setInputType(8);
        $question15->setAnswerRequired(0);
        $question15->setAnswerMultiple(0);
        $question15->setQuestionOrder(7);
        $question15->setSecondName(NULL);
        
        $question16 = new Question();
        $question16->setId(19);
        $question16->setQuiz($quiz3);
        $question16->setName("Comment avez-vous connu cette application ?");
        $question16->setInputType(1);
        $question16->setAnswerRequired(1);
        $question16->setAnswerMultiple(0);
        $question16->setQuestionOrder(8);
        $question16->setSecondName(NULL);
        
        $quiz4 = new Quiz();
        $quiz4->setName("Mydiary_BeforeQuit");
        $quiz4->setCode("MYDIARY_BEFOREQUIT");
        $quiz4->setPassed(NULL);
        $quiz4->setStepNbr(Null);
        
        $question17 = new Question();
        $question17->setId(20);
        $question17->setQuiz($quiz4);
        $question17->setName("avez-vous atteint votre objectif de réduction?");
        $question17->setInputType(1);
        $question17->setAnswerRequired(1);
        $question17->setAnswerMultiple(0);
        $question17->setQuestionOrder(1);
        $question17->setSecondName(NULL);
        
        $question18 = new Question();
        $question18->setId(21);
        $question18->setQuiz($quiz4);
        $question18->setName("Qu'est ce qui est le plus difficile pour vous ?");
        $question18->setInputType(1);
        $question18->setAnswerRequired(1);
        $question18->setAnswerMultiple(0);
        $question18->setQuestionOrder(2);
        $question18->setSecondName(NULL);
        
        $quiz5 = new Quiz();
        $quiz5->setName("Mydiary_AfterQuit");
        $quiz5->setCode("MYDIARY_AFTERQUIT");
        $quiz5->setPassed(NULL);
        $quiz5->setStepNbr(Null);
        
        $question19 = new Question();
        $question19->setId(22);
        $question19->setQuiz($quiz5);
        $question19->setName("Sur une échelle de 1 à 10, comment évaluez-vous la difficulté à ne pas fumer aujourd'hui ?");
        $question19->setInputType(1);
        $question19->setAnswerRequired(1);
        $question19->setAnswerMultiple(0);
        $question19->setQuestionOrder(1);
        $question19->setSecondName(NULL);
        
        $question20 = new Question();
        $question20->setId(23);
        $question20->setQuiz($quiz5);
        $question20->setName("Avez-vous pris un substitut nicotinique ?");
        $question20->setInputType(1);
        $question20->setAnswerRequired(1);
        $question20->setAnswerMultiple(0);
        $question20->setQuestionOrder(2);
        $question20->setSecondName(NULL);
        
        $quiz6 = new Quiz();
        $quiz6->setName("Panic Button Tempted Not Cracked");
        $quiz6->setCode("PANIC_BUTTON_TEMPTED_NOT_CRACKED");
        $quiz6->setPassed(NULL);
        $quiz6->setStepNbr(NULL);
        
        $question21 = new Question();
        $question21->setId(24);
        $question21->setQuiz($quiz6);
        $question21->setName("A quel moment avez-vous été tenté ?");
        $question21->setInputType(1);
        $question21->setAnswerRequired(1);
        $question21->setAnswerMultiple(1);
        $question21->setQuestionOrder(1);
        $question21->setSecondName(NULL);
        
        $question22 = new Question();
        $question22->setId(25);
        $question22->setQuiz($quiz6);
        $question22->setName("Quel a été le déclenchement de votre envie ?");
        $question22->setInputType(1);
        $question22->setAnswerRequired(1);
        $question22->setAnswerMultiple(1);
        $question22->setQuestionOrder(2);
        $question22->setSecondName(NULL);
        
        $question23 = new Question();
        $question23->setId(26);
        $question23->setQuiz($quiz6);
        $question23->setName("Pensez-vous que de fumer cette cigarette, ne va pas en enclencher d'autres ?");
        $question23->setInputType(1);
        $question23->setAnswerRequired(1);
        $question23->setAnswerMultiple(0);
        $question23->setQuestionOrder(3);
        $question23->setSecondName(NULL);
        
        $question24 = new Question();
        $question24->setId(27);
        $question24->setQuiz($quiz6);
        $question24->setName("Êtes-vous réellement prêt à accepter les conséquences à abandonner et fumer à nouveau ?");
        $question24->setInputType(1);
        $question24->setAnswerRequired(1);
        $question24->setAnswerMultiple(0);
        $question24->setQuestionOrder(4);
        $question24->setSecondName(NULL);
        
        $quiz7 = new Quiz();
        $quiz7->setName("Panic Button Want");
        $quiz7->setCode("PANIC_BUTTON_WANT");
        $quiz7->setPassed(NULL);
        $quiz7->setStepNbr(Null);
        
        $question25 = new Question();
        $question25->setId(28);
        $question25->setQuiz($quiz7);
        $question25->setName("Quel est le déclenchement de votre envie ?");
        $question25->setInputType(1);
        $question25->setAnswerRequired(1);
        $question25->setAnswerMultiple(1);
        $question25->setQuestionOrder(1);
        $question25->setSecondName(NULL);
        
        $question26 = new Question();
        $question26->setId(29);
        $question26->setQuiz($quiz7);
        $question26->setName("Pensez-vous que de fumer cette cigarette, ne \r\nva pas en enclencher d'autres ?");
        $question26->setInputType(1);
        $question26->setAnswerRequired(1);
        $question26->setAnswerMultiple(0);
        $question26->setQuestionOrder(2);
        $question26->setSecondName(NULL);
        
        $question27 = new Question();
        $question27->setId(30);
        $question27->setQuiz($quiz7);
        $question27->setName("Êtes-vous réellement prêt à accepter les conséquences à abandonner et fumer à nouveau ?");
        $question27->setInputType(1);
        $question27->setAnswerRequired(1);
        $question27->setAnswerMultiple(0);
        $question27->setQuestionOrder(3);
        $question27->setSecondName(NULL);
        
        $quiz8 = new Quiz();
        $quiz8->setName("Panic Button Cracked");
        $quiz8->setCode("PANIC_BUTTON_CRACKED");
        $quiz8->setPassed(NULL);
        $quiz8->setStepNbr(Null);
        
        $question28 = new Question();
        $question28->setId(31);
        $question28->setQuiz($quiz8);
        $question28->setName("A quel moment avez-vous craqué?");
        $question28->setInputType(1);
        $question28->setAnswerRequired(1);
        $question28->setAnswerMultiple(1);
        $question28->setQuestionOrder(1);
        $question28->setSecondName(NULL);
        
        $question29 = new Question();
        $question29->setId(32);
        $question29->setQuiz($quiz8);
        $question29->setName("Quel a été le déclenchement de votre envie?");
        $question29->setInputType(1);
        $question29->setAnswerRequired(1);
        $question29->setAnswerMultiple(1);
        $question29->setQuestionOrder(2);
        $question29->setSecondName(NULL);
        
        $quiz9 = new Quiz();
        $quiz9->setName("Exit");
        $quiz9->setCode("EXIT");
        $quiz9->setPassed(NULL);
        $quiz9->setStepNbr(NULL);
        
        $question30 = new Question();
        $question30->setId(33);
        $question30->setQuiz($quiz9);
        $question30->setName("Pourquoi souhaitez-vous mettre fin à votre programme d'arrêt?");
        $question30->setInputType(1);
        $question30->setAnswerRequired(1);
        $question30->setAnswerMultiple(1);
        $question30->setQuestionOrder(1);
        $question30->setSecondName(NULL);
        
        $question31 = new Question();
        $question31->setId(34);
        $question31->setQuiz($quiz9);
        $question31->setName("Après une tentative d'arrêt, beaucoup de personnes fument moins qu'avant l'arrêt. Pensez-vous que vous pourrez maintenir un faible niveau de consommation de cigarettes?");
        $question31->setInputType(1);
        $question31->setAnswerRequired(1);
        $question31->setAnswerMultiple(0);
        $question31->setQuestionOrder(2);
        $question31->setSecondName(NULL);
        
        $question32 = new Question();
        $question32->setId(35);
        $question32->setQuiz($quiz9);
        $question32->setName("Prévoyez-vous une nouvelle tentative d'arrêt dans le futur?");
        $question32->setInputType(1);
        $question32->setAnswerRequired(1);
        $question32->setAnswerMultiple(0);
        $question32->setQuestionOrder(3);
        $question32->setSecondName(NULL);
        
        $question33 = new Question();
        $question33->setId(36);
        $question33->setQuiz($quiz9);
        $question33->setName("Si vous avez utilisé un substitut Nicorette durant votre programme d'arrêt, vous a-t-il aidé?");
        $question33->setInputType(1);
        $question33->setAnswerRequired(1);
        $question33->setAnswerMultiple(0);
        $question33->setQuestionOrder(4);
        $question33->setSecondName(NULL);
        
        $question34 = new Question();
        $question34->setId(37);
        $question34->setQuiz($quiz9);
        $question34->setName("Comment évaluez-vous l'utilité du programme Nicorette \"Accomplissons l'incroyable\"?");
        $question34->setInputType(1);
        $question34->setAnswerRequired(1);
        $question34->setAnswerMultiple(1);
        $question34->setQuestionOrder(5);
        $question34->setSecondName(NULL);*/
        
        
        $this->em->persist($patient);
        $this->em->persist($contact1);
        $this->em->persist($contact2);
        $this->em->persist($contact3);
        $this->em->persist($contract1);
        $this->em->persist($pointHistory1);
        $this->em->persist($patient2);
        $this->em->persist($contact12);
        $this->em->persist($contact22);
        $this->em->persist($contact32);
        $this->em->persist($contract2);
        $this->em->persist($pointHistory2);
        $this->em->persist($patient3);
        $this->em->persist($contact13);
        $this->em->persist($contact23);
        $this->em->persist($contact33);
        $this->em->persist($contract3);
        $this->em->persist($pointHistory3);
        $this->em->persist($patient4);
        $this->em->persist($contact14);
        $this->em->persist($contact24);
        $this->em->persist($contact34);
        $this->em->persist($contract4);
        $this->em->persist($pointHistory4);
        $this->em->persist($patient5);
        $this->em->persist($contact15);
        $this->em->persist($contact25);
        $this->em->persist($contact35);
        $this->em->persist($contract5);
        $this->em->persist($pointHistory5);
        
        $this->em->persist($patient6);
        $this->em->persist($contact16);
        $this->em->persist($contact26);
        $this->em->persist($contact36);
        $this->em->persist($contract6);
        $this->em->persist($pointHistory6);
        $this->em->persist($patient7);
        $this->em->persist($contact17);
        $this->em->persist($contact27);
        $this->em->persist($contact37);
        $this->em->persist($contract7);
        $this->em->persist($pointHistory7);
        $this->em->persist($patient8);
        $this->em->persist($contact13);
        $this->em->persist($contact28);
        $this->em->persist($contact38);
        $this->em->persist($contract8);
        $this->em->persist($pointHistory8);
        $this->em->persist($patient9);
        $this->em->persist($contact19);
        $this->em->persist($contact29);
        $this->em->persist($contact39);
        $this->em->persist($contract9);
        $this->em->persist($pointHistory9);
        $this->em->persist($patient10);
        $this->em->persist($contact110);
        $this->em->persist($contact210);
        $this->em->persist($contact310);
        $this->em->persist($contract10);
        $this->em->persist($pointHistory10);
        
        /*$this->em->persist($quiz1);
        $this->em->persist($quiz2);
        $this->em->persist($quiz3);
        $this->em->persist($quiz4);
        $this->em->persist($quiz5);
        $this->em->persist($quiz6);
        $this->em->persist($quiz7);
        $this->em->persist($quiz8);
        $this->em->persist($quiz9);
        
        $this->em->persist($question1);
        $this->em->persist($question2);
        $this->em->persist($question3);
        $this->em->persist($question4);
        $this->em->persist($question5);
        $this->em->persist($question6);
        $this->em->persist($question7);
        $this->em->persist($question8);
        $this->em->persist($question9);
        $this->em->persist($question10);
        $this->em->persist($question11);
        $this->em->persist($question12);
        $this->em->persist($question13);
        $this->em->persist($question14);
        $this->em->persist($question15);
        $this->em->persist($question16);
        $this->em->persist($question17);
        $this->em->persist($question18);
        $this->em->persist($question19);
        $this->em->persist($question20);
        $this->em->persist($question21);
        $this->em->persist($question22);
        $this->em->persist($question23);
        $this->em->persist($question24);
        $this->em->persist($question25);
        $this->em->persist($question26);
        $this->em->persist($question27);
        $this->em->persist($question28);
        $this->em->persist($question29);
        $this->em->persist($question30);
        $this->em->persist($question31);
        $this->em->persist($question32);
        $this->em->persist($question33);
        $this->em->persist($question34);
        
        $choice1 = new Choice();$choice1->setId(1);$choice1->setQuestion($question1);$choice1->setName("Je n'ai pas prévu d'arrêter pour le moment, je recherche juste des informations");$choice1->setScoring('a:17:{s:1:"C";s:1:"1";s:1:"P";s:1:"0";s:1:"A";s:1:"0";s:1:"M";s:1:"0";s:3:"Beh";s:1:"0";s:5:"Ppath";s:1:"0";s:4:"Psoc";s:1:"0";s:4:"Phys";s:1:"0";s:3:"Rew";s:1:"0";s:3:"C/R";s:1:"0";s:10:"Fagerstrom";s:1:"0";s:8:"MotHPres";s:1:"0";s:7:"MotHFut";s:1:"0";s:6:"MotSoc";s:1:"0";s:6:"MotMon";s:1:"0";s:7:"MotSelf";s:1:"0";s:7:"OthSmok";s:1:"0";}');$choice1->setNextQuestion(2);$choice1->setRenamedQuestion(NULL);$choice1->setHideQuestion('a:1:{i:0;i:4;}');$this->em->persist($choice1);
        $choice2 = new Choice();$choice2->setId(2);$choice2->setQuestion($question1);$choice2->setName("Je veux arrêter d'ici un an");$choice2->setScoring('a:17:{s:1:"C";s:1:"1";s:1:"P";s:1:"0";s:1:"A";s:1:"0";s:1:"M";s:1:"0";s:3:"Beh";s:1:"0";s:5:"Ppath";s:1:"0";s:4:"Psoc";s:1:"0";s:4:"Phys";s:1:"0";s:3:"Rew";s:1:"0";s:3:"C/R";s:1:"0";s:10:"Fagerstrom";s:1:"0";s:8:"MotHPres";s:1:"0";s:7:"MotHFut";s:1:"0";s:6:"MotSoc";s:1:"0";s:6:"MotMon";s:1:"0";s:7:"MotSelf";s:1:"0";s:7:"OthSmok";s:1:"0";}');$choice2->setNextQuestion(2);$choice2->setRenamedQuestion(NULL);$choice2->setHideQuestion(NULL);$this->em->persist($choice2);
        $choice3 = new Choice();$choice3->setId(3);$choice3->setQuestion($question1);$choice3->setName("Je veux arrêter d'ici six mois");$choice3->setScoring('a:17:{s:1:"C";s:1:"0";s:1:"P";s:1:"1";s:1:"A";s:1:"0";s:1:"M";s:1:"0";s:3:"Beh";s:1:"0";s:5:"Ppath";s:1:"0";s:4:"Psoc";s:1:"0";s:4:"Phys";s:1:"0";s:3:"Rew";s:1:"0";s:3:"C/R";s:1:"0";s:10:"Fagerstrom";s:1:"0";s:8:"MotHPres";s:1:"0";s:7:"MotHFut";s:1:"0";s:6:"MotSoc";s:1:"0";s:6:"MotMon";s:1:"0";s:7:"MotSelf";s:1:"0";s:7:"OthSmok";s:1:"0";}');$choice3->setNextQuestion(2);$choice3->setRenamedQuestion(NULL);$choice3->setHideQuestion(NULL);$this->em->persist($choice3);
        $choice4 = new Choice();$choice4->setId(4);$choice4->setQuestion($question1);$choice4->setName("Je veux arrêter d'ici un mois");$choice4->setScoring('a:17:{s:1:"C";s:1:"0";s:1:"P";s:1:"1";s:1:"A";s:1:"0";s:1:"M";s:1:"0";s:3:"Beh";s:1:"0";s:5:"Ppath";s:1:"0";s:4:"Psoc";s:1:"0";s:4:"Phys";s:1:"0";s:3:"Rew";s:1:"0";s:3:"C/R";s:1:"0";s:10:"Fagerstrom";s:1:"0";s:8:"MotHPres";s:1:"0";s:7:"MotHFut";s:1:"0";s:6:"MotSoc";s:1:"0";s:6:"MotMon";s:1:"0";s:7:"MotSelf";s:1:"0";s:7:"OthSmok";s:1:"0";}');$choice4->setNextQuestion(2);$choice4->setRenamedQuestion(NULL);$choice4->setHideQuestion(NULL);$this->em->persist($choice4);
        $choice5 = new Choice();$choice5->setId(5);$choice5->setQuestion($question1);$choice5->setName("Je veux arrêter maintenant");$choice5->setScoring('a:17:{s:1:"C";s:1:"0";s:1:"P";s:1:"1";s:1:"A";s:1:"0";s:1:"M";s:1:"0";s:3:"Beh";s:1:"0";s:5:"Ppath";s:1:"0";s:4:"Psoc";s:1:"0";s:4:"Phys";s:1:"0";s:3:"Rew";s:1:"0";s:3:"C/R";s:1:"0";s:10:"Fagerstrom";s:1:"0";s:8:"MotHPres";s:1:"0";s:7:"MotHFut";s:1:"0";s:6:"MotSoc";s:1:"0";s:6:"MotMon";s:1:"0";s:7:"MotSelf";s:1:"0";s:7:"OthSmok";s:1:"0";}');$choice5->setNextQuestion(2);$choice5->setRenamedQuestion(NULL);$choice5->setHideQuestion(NULL);$this->em->persist($choice5);
        $choice6 = new Choice();$choice6->setId(6);$choice6->setQuestion($question1);$choice6->setName("J'ai arrêté le mois dernier");$choice6->setScoring('a:17:{s:1:"C";s:1:"0";s:1:"P";s:1:"0";s:1:"A";s:1:"1";s:1:"M";s:1:"0";s:3:"Beh";s:1:"0";s:5:"Ppath";s:1:"0";s:4:"Psoc";s:1:"0";s:4:"Phys";s:1:"0";s:3:"Rew";s:1:"0";s:3:"C/R";s:1:"0";s:10:"Fagerstrom";s:1:"0";s:8:"MotHPres";s:1:"0";s:7:"MotHFut";s:1:"0";s:6:"MotSoc";s:1:"0";s:6:"MotMon";s:1:"0";s:7:"MotSelf";s:1:"0";s:7:"OthSmok";s:1:"0";}');$choice6->setNextQuestion(2);$choice6->setRenamedQuestion('a:5:{i:0;s:1:"3";i:1;s:1:"4";i:2;s:1:"9";i:3;s:2:"11";i:4;s:2:"12";}');$choice6->setHideQuestion(NULL);$this->em->persist($choice6);
        $choice7 = new Choice();$choice7->setId(7);$choice7->setQuestion($question1);$choice7->setName("J'ai arrêté il y a plus d'un mois");$choice7->setScoring('a:17:{s:1:"C";s:1:"0";s:1:"P";s:1:"0";s:1:"A";s:1:"0";s:1:"M";s:1:"1";s:3:"Beh";s:1:"0";s:5:"Ppath";s:1:"0";s:4:"Psoc";s:1:"0";s:4:"Phys";s:1:"0";s:3:"Rew";s:1:"0";s:3:"C/R";s:1:"0";s:10:"Fagerstrom";s:1:"0";s:8:"MotHPres";s:1:"0";s:7:"MotHFut";s:1:"0";s:6:"MotSoc";s:1:"0";s:6:"MotMon";s:1:"0";s:7:"MotSelf";s:1:"0";s:7:"OthSmok";s:1:"0";}');$choice7->setNextQuestion(2);$choice7->setRenamedQuestion('a:5:{i:0;s:1:"3";i:1;s:1:"4";i:2;s:1:"9";i:3;s:2:"11";i:4;s:2:"12";}');$choice7->setHideQuestion(NULL);$this->em->persist($choice7);
        $choice8 = new Choice();$choice8->setId(8);$choice8->setQuestion($question2);$choice8->setName("Je fume machinalement, sans y penser");$choice8->setScoring('a:17:{s:1:"C";s:1:"0";s:1:"P";s:1:"0";s:1:"A";s:1:"0";s:1:"M";s:1:"0";s:3:"Beh";s:1:"0";s:5:"Ppath";s:1:"4";s:4:"Psoc";s:1:"0";s:4:"Phys";s:1:"0";s:3:"Rew";s:1:"0";s:3:"C/R";s:1:"0";s:10:"Fagerstrom";s:1:"0";s:8:"MotHPres";s:1:"0";s:7:"MotHFut";s:1:"0";s:6:"MotSoc";s:1:"0";s:6:"MotMon";s:1:"0";s:7:"MotSelf";s:1:"0";s:7:"OthSmok";s:1:"0";}');$choice8->setNextQuestion(3);$choice8->setRenamedQuestion(NULL);$choice8->setHideQuestion(NULL);$this->em->persist($choice8);
        $choice9 = new Choice();$choice9->setId(9);$choice9->setQuestion($question2);$choice9->setName("Je fume pour être comme les autres");$choice9->setScoring('a:17:{s:1:"C";s:1:"0";s:1:"P";s:1:"0";s:1:"A";s:1:"0";s:1:"M";s:1:"0";s:3:"Beh";s:1:"0";s:5:"Ppath";s:1:"0";s:4:"Psoc";s:1:"4";s:4:"Phys";s:1:"0";s:3:"Rew";s:1:"0";s:3:"C/R";s:1:"0";s:10:"Fagerstrom";s:1:"0";s:8:"MotHPres";s:1:"0";s:7:"MotHFut";s:1:"0";s:6:"MotSoc";s:1:"0";s:6:"MotMon";s:1:"0";s:7:"MotSelf";s:1:"0";s:7:"OthSmok";s:1:"0";}');$choice9->setNextQuestion(3);$choice9->setRenamedQuestion(NULL);$choice9->setHideQuestion(NULL);$this->em->persist($choice9);
        $choice10 = new Choice();$choice10->setId(10);$choice10->setQuestion($question2);$choice10->setName("Je me sens plus confiant(e) quand je fume");$choice10->setScoring('a:17:{s:1:"C";s:1:"0";s:1:"P";s:1:"0";s:1:"A";s:1:"0";s:1:"M";s:1:"0";s:3:"Beh";s:1:"0";s:5:"Ppath";s:1:"3";s:4:"Psoc";s:1:"0";s:4:"Phys";s:1:"0";s:3:"Rew";s:1:"0";s:3:"C/R";s:1:"2";s:10:"Fagerstrom";s:1:"0";s:8:"MotHPres";s:1:"0";s:7:"MotHFut";s:1:"0";s:6:"MotSoc";s:1:"0";s:6:"MotMon";s:1:"0";s:7:"MotSelf";s:1:"0";s:7:"OthSmok";s:1:"0";}');$choice10->setNextQuestion(3);$choice10->setRenamedQuestion(NULL);$choice10->setHideQuestion(NULL);$this->em->persist($choice10);
        $choice10_ = new Choice();$choice10_->setId(11);$choice10_->setQuestion($question2);$choice10_->setName("Je fume quand je me sens anxieux(se) ou préoccupé(e)");$choice10_->setScoring('a:17:{s:1:"C";s:1:"0";s:1:"P";s:1:"0";s:1:"A";s:1:"0";s:1:"M";s:1:"0";s:3:"Beh";s:1:"0";s:5:"Ppath";s:1:"0";s:4:"Psoc";s:1:"0";s:4:"Phys";s:1:"0";s:3:"Rew";s:1:"1";s:3:"C/R";s:1:"2";s:10:"Fagerstrom";s:1:"0";s:8:"MotHPres";s:1:"0";s:7:"MotHFut";s:1:"0";s:6:"MotSoc";s:1:"0";s:6:"MotMon";s:1:"0";s:7:"MotSelf";s:1:"0";s:7:"OthSmok";s:1:"0";}');$choice10_->setNextQuestion(3);$choice10_->setRenamedQuestion(NULL);$choice10_->setHideQuestion(NULL);$this->em->persist($choice10_);
        $choice11 = new Choice();$choice11->setId(12);$choice11->setQuestion($question2);$choice11->setName("Je fume quand je me sens triste ou déprimé(e)");$choice11->setScoring('a:17:{s:1:"C";s:1:"0";s:1:"P";s:1:"0";s:1:"A";s:1:"0";s:1:"M";s:1:"0";s:3:"Beh";s:1:"0";s:5:"Ppath";s:1:"0";s:4:"Psoc";s:1:"0";s:4:"Phys";s:1:"0";s:3:"Rew";s:1:"2";s:3:"C/R";s:1:"2";s:10:"Fagerstrom";s:1:"0";s:8:"MotHPres";s:1:"0";s:7:"MotHFut";s:1:"0";s:6:"MotSoc";s:1:"0";s:6:"MotMon";s:1:"0";s:7:"MotSelf";s:1:"0";s:7:"OthSmok";s:1:"0";}');$choice11->setNextQuestion(3);$choice11->setRenamedQuestion(NULL);$choice11->setHideQuestion(NULL);$this->em->persist($choice11);
        $choice12 = new Choice();$choice12->setId(13);$choice12->setQuestion($question2);$choice12->setName("Je fume quand je me sens seul(e)");$choice12->setScoring('a:17:{s:1:"C";s:1:"0";s:1:"P";s:1:"0";s:1:"A";s:1:"0";s:1:"M";s:1:"0";s:3:"Beh";s:1:"0";s:5:"Ppath";s:1:"0";s:4:"Psoc";s:1:"0";s:4:"Phys";s:1:"0";s:3:"Rew";s:1:"2";s:3:"C/R";s:1:"2";s:10:"Fagerstrom";s:1:"0";s:8:"MotHPres";s:1:"0";s:7:"MotHFut";s:1:"0";s:6:"MotSoc";s:1:"0";s:6:"MotMon";s:1:"0";s:7:"MotSelf";s:1:"0";s:7:"OthSmok";s:1:"0";}');$choice12->setNextQuestion(3);$choice12->setRenamedQuestion(NULL);$choice12->setHideQuestion(NULL);$this->em->persist($choice12);
        $choice13 = new Choice();$choice13->setId(14);$choice13->setQuestion($question2);$choice13->setName("Fumer me détend");$choice13->setScoring('a:17:{s:1:"C";s:1:"0";s:1:"P";s:1:"0";s:1:"A";s:1:"0";s:1:"M";s:1:"0";s:3:"Beh";s:1:"2";s:5:"Ppath";s:1:"0";s:4:"Psoc";s:1:"0";s:4:"Phys";s:1:"0";s:3:"Rew";s:1:"1";s:3:"C/R";s:1:"0";s:10:"Fagerstrom";s:1:"0";s:8:"MotHPres";s:1:"0";s:7:"MotHFut";s:1:"0";s:6:"MotSoc";s:1:"0";s:6:"MotMon";s:1:"0";s:7:"MotSelf";s:1:"0";s:7:"OthSmok";s:1:"0";}');$choice13->setNextQuestion(3);$choice13->setRenamedQuestion(NULL);$choice13->setHideQuestion(NULL);$this->em->persist($choice13);
        $choice14 = new Choice();$choice14->setId(15);$choice14->setQuestion($question2);$choice14->setName("Le plaisir de fumer commence avec les gestes que je fais pour allumer ma cigarette");$choice14->setScoring('a:17:{s:1:"C";s:1:"0";s:1:"P";s:1:"0";s:1:"A";s:1:"0";s:1:"M";s:1:"0";s:3:"Beh";s:1:"3";s:5:"Ppath";s:1:"0";s:4:"Psoc";s:1:"0";s:4:"Phys";s:1:"0";s:3:"Rew";s:1:"0";s:3:"C/R";s:1:"0";s:10:"Fagerstrom";s:1:"0";s:8:"MotHPres";s:1:"0";s:7:"MotHFut";s:1:"0";s:6:"MotSoc";s:1:"0";s:6:"MotMon";s:1:"0";s:7:"MotSelf";s:1:"0";s:7:"OthSmok";s:1:"0";}');$choice14->setNextQuestion(3);$choice14->setRenamedQuestion(NULL);$choice14->setHideQuestion(NULL);$this->em->persist($choice14);
        $choice15 = new Choice();$choice15->setId(16);$choice15->setQuestion($question2);$choice15->setName("Je fume pour m’offrir un petit plaisir");$choice15->setScoring('a:17:{s:1:"C";s:1:"0";s:1:"P";s:1:"0";s:1:"A";s:1:"0";s:1:"M";s:1:"0";s:3:"Beh";s:1:"0";s:5:"Ppath";s:1:"0";s:4:"Psoc";s:1:"0";s:4:"Phys";s:1:"0";s:3:"Rew";s:1:"2";s:3:"C/R";s:1:"0";s:10:"Fagerstrom";s:1:"0";s:8:"MotHPres";s:1:"0";s:7:"MotHFut";s:1:"0";s:6:"MotSoc";s:1:"0";s:6:"MotMon";s:1:"0";s:7:"MotSelf";s:1:"0";s:7:"OthSmok";s:1:"0";}');$choice15->setNextQuestion(3);$choice15->setRenamedQuestion(NULL);$choice15->setHideQuestion(NULL);$this->em->persist($choice15);
        $choice16 = new Choice();$choice16->setId(17);$choice16->setQuestion($question2);$choice16->setName("J'aime manipuler les cigarettes");$choice16->setScoring('a:17:{s:1:"C";s:1:"0";s:1:"P";s:1:"0";s:1:"A";s:1:"0";s:1:"M";s:1:"0";s:3:"Beh";s:1:"0";s:5:"Ppath";s:1:"0";s:4:"Psoc";s:1:"3";s:4:"Phys";s:1:"0";s:3:"Rew";s:1:"0";s:3:"C/R";s:1:"0";s:10:"Fagerstrom";s:1:"0";s:8:"MotHPres";s:1:"0";s:7:"MotHFut";s:1:"0";s:6:"MotSoc";s:1:"0";s:6:"MotMon";s:1:"0";s:7:"MotSelf";s:1:"0";s:7:"OthSmok";s:1:"0";}');$choice16->setNextQuestion(3);$choice16->setRenamedQuestion(NULL);$choice16->setHideQuestion(NULL);$this->em->persist($choice16);
        $choice17 = new Choice();$choice17->setId(18);$choice17->setQuestion($question2);$choice17->setName("J’aime regarder la fumée de la cigarette");$choice17->setScoring('a:17:{s:1:"C";s:1:"0";s:1:"P";s:1:"0";s:1:"A";s:1:"0";s:1:"M";s:1:"0";s:3:"Beh";s:1:"3";s:5:"Ppath";s:1:"0";s:4:"Psoc";s:1:"1";s:4:"Phys";s:1:"0";s:3:"Rew";s:1:"0";s:3:"C/R";s:1:"0";s:10:"Fagerstrom";s:1:"0";s:8:"MotHPres";s:1:"0";s:7:"MotHFut";s:1:"0";s:6:"MotSoc";s:1:"0";s:6:"MotMon";s:1:"0";s:7:"MotSelf";s:1:"0";s:7:"OthSmok";s:1:"0";}');$choice17->setNextQuestion(3);$choice17->setRenamedQuestion(NULL);$choice17->setHideQuestion(NULL);$this->em->persist($choice17);
        $choice18 = new Choice();$choice18->setId(19);$choice18->setQuestion($question3);$choice18->setName("La peur de pas y arriver");$choice18->setScoring('a:17:{s:1:"C";s:1:"0";s:1:"P";s:1:"0";s:1:"A";s:1:"0";s:1:"M";s:1:"0";s:3:"Beh";s:1:"0";s:5:"Ppath";s:1:"0";s:4:"Psoc";s:1:"0";s:4:"Phys";s:1:"0";s:3:"Rew";s:1:"0";s:3:"C/R";s:1:"0";s:10:"Fagerstrom";s:1:"0";s:8:"MotHPres";s:1:"0";s:7:"MotHFut";s:1:"0";s:6:"MotSoc";s:1:"0";s:6:"MotMon";s:1:"0";s:7:"MotSelf";s:1:"0";s:7:"OthSmok";s:1:"0";}');$choice18->setNextQuestion(NULL);$choice18->setRenamedQuestion(NULL);$choice18->setHideQuestion(NULL);$this->em->persist($choice18);
        $choice19 = new Choice();$choice19->setId(20);$choice19->setQuestion($question3);$choice19->setName("La nervosité ou la déprime liée à l'arrêt");$choice19->setScoring('a:17:{s:1:"C";s:1:"0";s:1:"P";s:1:"0";s:1:"A";s:1:"0";s:1:"M";s:1:"0";s:3:"Beh";s:1:"0";s:5:"Ppath";s:1:"1";s:4:"Psoc";s:1:"0";s:4:"Phys";s:1:"0";s:3:"Rew";s:1:"0";s:3:"C/R";s:1:"2";s:10:"Fagerstrom";s:1:"0";s:8:"MotHPres";s:1:"0";s:7:"MotHFut";s:1:"0";s:6:"MotSoc";s:1:"0";s:6:"MotMon";s:1:"0";s:7:"MotSelf";s:1:"0";s:7:"OthSmok";s:1:"0";}');$choice19->setNextQuestion(NULL);$choice19->setRenamedQuestion(NULL);$choice19->setHideQuestion(NULL);$this->em->persist($choice19);
        $choice20 = new Choice();$choice20->setId(21);$choice20->setQuestion($question3);$choice20->setName("Le risque de prendre du poids");$choice20->setScoring('a:17:{s:1:"C";s:1:"0";s:1:"P";s:1:"0";s:1:"A";s:1:"0";s:1:"M";s:1:"0";s:3:"Beh";s:1:"0";s:5:"Ppath";s:1:"0";s:4:"Psoc";s:1:"0";s:4:"Phys";s:1:"0";s:3:"Rew";s:1:"0";s:3:"C/R";s:1:"0";s:10:"Fagerstrom";s:1:"0";s:8:"MotHPres";s:1:"0";s:7:"MotHFut";s:1:"0";s:6:"MotSoc";s:1:"0";s:6:"MotMon";s:1:"0";s:7:"MotSelf";s:1:"0";s:7:"OthSmok";s:1:"0";}');$choice20->setNextQuestion(NULL);$choice20->setRenamedQuestion(NULL);$choice20->setHideQuestion(NULL);$this->em->persist($choice20);
        $choice21 = new Choice();$choice21->setId(22);$choice21->setQuestion($question3);$choice21->setName("L'impact négatif sur ma vie sociale");$choice21->setScoring('a:17:{s:1:"C";s:1:"0";s:1:"P";s:1:"0";s:1:"A";s:1:"0";s:1:"M";s:1:"0";s:3:"Beh";s:1:"0";s:5:"Ppath";s:1:"0";s:4:"Psoc";s:1:"2";s:4:"Phys";s:1:"0";s:3:"Rew";s:1:"0";s:3:"C/R";s:1:"0";s:10:"Fagerstrom";s:1:"0";s:8:"MotHPres";s:1:"0";s:7:"MotHFut";s:1:"0";s:6:"MotSoc";s:1:"0";s:6:"MotMon";s:1:"0";s:7:"MotSelf";s:1:"0";s:7:"OthSmok";s:1:"0";}');$choice21->setNextQuestion(NULL);$choice21->setRenamedQuestion(NULL);$choice21->setHideQuestion(NULL);$this->em->persist($choice21);
        $choice22 = new Choice();$choice22->setId(23);$choice22->setQuestion($question3);$choice22->setName("La perte de mon statut de fumeur");$choice22->setScoring('a:17:{s:1:"C";s:1:"0";s:1:"P";s:1:"0";s:1:"A";s:1:"0";s:1:"M";s:1:"0";s:3:"Beh";s:1:"0";s:5:"Ppath";s:1:"2";s:4:"Psoc";s:1:"0";s:4:"Phys";s:1:"0";s:3:"Rew";s:1:"0";s:3:"C/R";s:1:"0";s:10:"Fagerstrom";s:1:"0";s:8:"MotHPres";s:1:"0";s:7:"MotHFut";s:1:"0";s:6:"MotSoc";s:1:"0";s:6:"MotMon";s:1:"0";s:7:"MotSelf";s:1:"0";s:7:"OthSmok";s:1:"0";}');$choice22->setNextQuestion(NULL);$choice22->setRenamedQuestion(NULL);$choice22->setHideQuestion(NULL);$this->em->persist($choice22);
        $choice23 = new Choice();$choice23->setId(24);$choice23->setQuestion($question3);$choice23->setName("Le manque du plaisir de fumer");$choice23->setScoring('a:17:{s:1:"C";s:1:"0";s:1:"P";s:1:"0";s:1:"A";s:1:"0";s:1:"M";s:1:"0";s:3:"Beh";s:1:"1";s:5:"Ppath";s:1:"0";s:4:"Psoc";s:1:"0";s:4:"Phys";s:1:"0";s:3:"Rew";s:1:"2";s:3:"C/R";s:1:"0";s:10:"Fagerstrom";s:1:"0";s:8:"MotHPres";s:1:"0";s:7:"MotHFut";s:1:"0";s:6:"MotSoc";s:1:"0";s:6:"MotMon";s:1:"0";s:7:"MotSelf";s:1:"0";s:7:"OthSmok";s:1:"0";}');$choice23->setNextQuestion(NULL);$choice23->setRenamedQuestion(NULL);$choice23->setHideQuestion(NULL);$this->em->persist($choice23);
        $choice24 = new Choice();$choice24->setId(25);$choice24->setQuestion($question3);$choice24->setName("L'absence de cigarette dans les bons moments de ma journée");$choice24->setScoring('a:17:{s:1:"C";s:1:"0";s:1:"P";s:1:"0";s:1:"A";s:1:"0";s:1:"M";s:1:"0";s:3:"Beh";s:1:"1";s:5:"Ppath";s:1:"0";s:4:"Psoc";s:1:"0";s:4:"Phys";s:1:"0";s:3:"Rew";s:1:"0";s:3:"C/R";s:1:"0";s:10:"Fagerstrom";s:1:"0";s:8:"MotHPres";s:1:"0";s:7:"MotHFut";s:1:"0";s:6:"MotSoc";s:1:"0";s:6:"MotMon";s:1:"0";s:7:"MotSelf";s:1:"0";s:7:"OthSmok";s:1:"0";}');$choice24->setNextQuestion(NULL);$choice24->setRenamedQuestion(NULL);$choice24->setHideQuestion(NULL);$this->em->persist($choice24);
        $choice25 = new Choice();$choice25->setId(26);$choice25->setQuestion($question4);$choice25->setName("Ma famille / Mes amis m'y encourage");$choice25->setScoring('a:17:{s:1:"C";s:1:"0";s:1:"P";s:1:"0";s:1:"A";s:1:"0";s:1:"M";s:1:"0";s:3:"Beh";s:1:"0";s:5:"Ppath";s:1:"0";s:4:"Psoc";s:1:"0";s:4:"Phys";s:1:"0";s:3:"Rew";s:1:"0";s:3:"C/R";s:1:"0";s:10:"Fagerstrom";s:1:"0";s:8:"MotHPres";s:1:"0";s:7:"MotHFut";s:1:"0";s:6:"MotSoc";s:1:"2";s:6:"MotMon";s:1:"0";s:7:"MotSelf";s:1:"0";s:7:"OthSmok";s:1:"0";}');$choice25->setNextQuestion(5);$choice25->setRenamedQuestion(NULL);$choice25->setHideQuestion(NULL);$this->em->persist($choice25);
        $choice26 = new Choice();$choice26->setId(27);$choice26->setQuestion($question4);$choice26->setName("Je veux éviter de futur problèmes de santé");$choice26->setScoring('a:17:{s:1:"C";s:1:"0";s:1:"P";s:1:"0";s:1:"A";s:1:"0";s:1:"M";s:1:"0";s:3:"Beh";s:1:"0";s:5:"Ppath";s:1:"0";s:4:"Psoc";s:1:"0";s:4:"Phys";s:1:"0";s:3:"Rew";s:1:"0";s:3:"C/R";s:1:"0";s:10:"Fagerstrom";s:1:"0";s:8:"MotHPres";s:1:"0";s:7:"MotHFut";s:1:"6";s:6:"MotSoc";s:1:"0";s:6:"MotMon";s:1:"0";s:7:"MotSelf";s:1:"0";s:7:"OthSmok";s:1:"0";}');$choice26->setNextQuestion(5);$choice26->setRenamedQuestion(NULL);$choice26->setHideQuestion(NULL);$this->em->persist($choice26);
        $choice27 = new Choice();$choice27->setId(28);$choice27->setQuestion($question4);$choice27->setName("Je veux améliorer mon état de santé actuel");$choice27->setScoring('a:17:{s:1:"C";s:1:"0";s:1:"P";s:1:"0";s:1:"A";s:1:"0";s:1:"M";s:1:"0";s:3:"Beh";s:1:"0";s:5:"Ppath";s:1:"0";s:4:"Psoc";s:1:"0";s:4:"Phys";s:1:"0";s:3:"Rew";s:1:"0";s:3:"C/R";s:1:"0";s:10:"Fagerstrom";s:1:"0";s:8:"MotHPres";s:1:"6";s:7:"MotHFut";s:1:"0";s:6:"MotSoc";s:1:"0";s:6:"MotMon";s:1:"0";s:7:"MotSelf";s:1:"0";s:7:"OthSmok";s:1:"0";}');$choice27->setNextQuestion(5);$choice27->setRenamedQuestion(NULL);$choice27->setHideQuestion(NULL);$this->em->persist($choice27);
        $choice28 = new Choice();$choice28->setId(29);$choice28->setQuestion($question4);$choice28->setName("J'ai honte de fumer");$choice28->setScoring('a:17:{s:1:"C";s:1:"0";s:1:"P";s:1:"0";s:1:"A";s:1:"0";s:1:"M";s:1:"0";s:3:"Beh";s:1:"0";s:5:"Ppath";s:1:"0";s:4:"Psoc";s:1:"0";s:4:"Phys";s:1:"0";s:3:"Rew";s:1:"0";s:3:"C/R";s:1:"0";s:10:"Fagerstrom";s:1:"0";s:8:"MotHPres";s:1:"0";s:7:"MotHFut";s:1:"0";s:6:"MotSoc";s:1:"6";s:6:"MotMon";s:1:"0";s:7:"MotSelf";s:1:"0";s:7:"OthSmok";s:1:"0";}');$choice28->setNextQuestion(5);$choice28->setRenamedQuestion(NULL);$choice28->setHideQuestion(NULL);$this->em->persist($choice28);
        $choice29 = new Choice();$choice29->setId(30);$choice29->setQuestion($question4);$choice29->setName("Je veux économiser de l'argent");$choice29->setScoring('a:17:{s:1:"C";s:1:"0";s:1:"P";s:1:"0";s:1:"A";s:1:"0";s:1:"M";s:1:"0";s:3:"Beh";s:1:"0";s:5:"Ppath";s:1:"0";s:4:"Psoc";s:1:"0";s:4:"Phys";s:1:"0";s:3:"Rew";s:1:"0";s:3:"C/R";s:1:"0";s:10:"Fagerstrom";s:1:"0";s:8:"MotHPres";s:1:"0";s:7:"MotHFut";s:1:"0";s:6:"MotSoc";s:1:"0";s:6:"MotMon";s:2:"10";s:7:"MotSelf";s:1:"0";s:7:"OthSmok";s:1:"0";}');$choice29->setNextQuestion(5);$choice29->setRenamedQuestion(NULL);$choice29->setHideQuestion(NULL);$this->em->persist($choice29);
        $choice30 = new Choice();$choice30->setId(31);$choice30->setQuestion($question4);$choice30->setName("Mon médecin m'a conseillé d'arrêter");$choice30->setScoring('a:17:{s:1:"C";s:1:"0";s:1:"P";s:1:"0";s:1:"A";s:1:"0";s:1:"M";s:1:"0";s:3:"Beh";s:1:"0";s:5:"Ppath";s:1:"0";s:4:"Psoc";s:1:"0";s:4:"Phys";s:1:"0";s:3:"Rew";s:1:"0";s:3:"C/R";s:1:"0";s:10:"Fagerstrom";s:1:"0";s:8:"MotHPres";s:1:"4";s:7:"MotHFut";s:1:"4";s:6:"MotSoc";s:1:"0";s:6:"MotMon";s:1:"0";s:7:"MotSelf";s:1:"0";s:7:"OthSmok";s:1:"0";}');$choice30->setNextQuestion(5);$choice30->setRenamedQuestion(NULL);$choice30->setHideQuestion(NULL);$this->em->persist($choice30);
        $choice31 = new Choice();$choice31->setId(32);$choice31->setQuestion($question4);$choice31->setName("Je pense que fumer n'est plus socialement acceptable");$choice31->setScoring('a:17:{s:1:"C";s:1:"0";s:1:"P";s:1:"0";s:1:"A";s:1:"0";s:1:"M";s:1:"0";s:3:"Beh";s:1:"0";s:5:"Ppath";s:1:"0";s:4:"Psoc";s:1:"0";s:4:"Phys";s:1:"0";s:3:"Rew";s:1:"0";s:3:"C/R";s:1:"0";s:10:"Fagerstrom";s:1:"0";s:8:"MotHPres";s:1:"0";s:7:"MotHFut";s:1:"0";s:6:"MotSoc";s:1:"2";s:6:"MotMon";s:1:"0";s:7:"MotSelf";s:1:"0";s:7:"OthSmok";s:1:"0";}');$choice31->setNextQuestion(5);$choice31->setRenamedQuestion(NULL);$choice31->setHideQuestion(NULL);$this->em->persist($choice31);
        $choice32 = new Choice();$choice32->setId(33);$choice32->setQuestion($question4);$choice32->setName("Je n'aime pas l'idée d'être un fumeur");$choice32->setScoring('a:17:{s:1:"C";s:1:"0";s:1:"P";s:1:"0";s:1:"A";s:1:"0";s:1:"M";s:1:"0";s:3:"Beh";s:1:"0";s:5:"Ppath";s:1:"0";s:4:"Psoc";s:1:"0";s:4:"Phys";s:1:"0";s:3:"Rew";s:1:"0";s:3:"C/R";s:1:"0";s:10:"Fagerstrom";s:1:"0";s:8:"MotHPres";s:1:"0";s:7:"MotHFut";s:1:"0";s:6:"MotSoc";s:1:"0";s:6:"MotMon";s:1:"0";s:7:"MotSelf";s:2:"10";s:7:"OthSmok";s:1:"0";}');$choice32->setNextQuestion(5);$choice32->setRenamedQuestion(NULL);$choice32->setHideQuestion(NULL);$this->em->persist($choice32);
        $choice33 = new Choice();$choice33->setId(34);$choice33->setQuestion($question5);$choice33->setName("Non");$choice33->setScoring('a:17:{s:1:"C";s:1:"0";s:1:"P";s:1:"0";s:1:"A";s:1:"0";s:1:"M";s:1:"0";s:3:"Beh";s:1:"0";s:5:"Ppath";s:1:"0";s:4:"Psoc";s:1:"0";s:4:"Phys";s:1:"0";s:3:"Rew";s:1:"0";s:3:"C/R";s:1:"0";s:10:"Fagerstrom";s:1:"0";s:8:"MotHPres";s:1:"0";s:7:"MotHFut";s:1:"0";s:6:"MotSoc";s:1:"0";s:6:"MotMon";s:1:"0";s:7:"MotSelf";s:1:"0";s:7:"OthSmok";s:1:"0";}');$choice33->setNextQuestion(7);$choice33->setRenamedQuestion(NULL);$choice33->setHideQuestion(NULL);$this->em->persist($choice33);
        $choice34 = new Choice();$choice34->setId(35);$choice34->setQuestion($question5);$choice34->setName("Oui, une fois");$choice34->setScoring('a:17:{s:1:"C";s:1:"0";s:1:"P";s:1:"0";s:1:"A";s:1:"0";s:1:"M";s:1:"0";s:3:"Beh";s:1:"0";s:5:"Ppath";s:1:"0";s:4:"Psoc";s:1:"0";s:4:"Phys";s:1:"0";s:3:"Rew";s:1:"0";s:3:"C/R";s:1:"0";s:10:"Fagerstrom";s:1:"0";s:8:"MotHPres";s:1:"0";s:7:"MotHFut";s:1:"0";s:6:"MotSoc";s:1:"0";s:6:"MotMon";s:1:"0";s:7:"MotSelf";s:1:"0";s:7:"OthSmok";s:1:"0";}');$choice34->setNextQuestion(7);$choice34->setRenamedQuestion(NULL);$choice34->setHideQuestion(NULL);$this->em->persist($choice34);
        $choice35 = new Choice();$choice35->setId(36);$choice35->setQuestion($question5);$choice35->setName("Oui, de deux à quatre fois");$choice35->setScoring('a:17:{s:1:"C";s:1:"0";s:1:"P";s:1:"0";s:1:"A";s:1:"0";s:1:"M";s:1:"0";s:3:"Beh";s:1:"0";s:5:"Ppath";s:1:"0";s:4:"Psoc";s:1:"0";s:4:"Phys";s:1:"0";s:3:"Rew";s:1:"0";s:3:"C/R";s:1:"0";s:10:"Fagerstrom";s:1:"0";s:8:"MotHPres";s:1:"0";s:7:"MotHFut";s:1:"0";s:6:"MotSoc";s:1:"0";s:6:"MotMon";s:1:"0";s:7:"MotSelf";s:1:"0";s:7:"OthSmok";s:1:"0";}');$choice35->setNextQuestion(7);$choice35->setRenamedQuestion(NULL);$choice35->setHideQuestion(NULL);$this->em->persist($choice35);
        $choice36 = new Choice();$choice36->setId(37);$choice36->setQuestion($question5);$choice36->setName("Oui, plus de quatre fois");$choice36->setScoring('a:17:{s:1:"C";s:1:"0";s:1:"P";s:1:"0";s:1:"A";s:1:"0";s:1:"M";s:1:"0";s:3:"Beh";s:1:"0";s:5:"Ppath";s:1:"0";s:4:"Psoc";s:1:"0";s:4:"Phys";s:1:"0";s:3:"Rew";s:1:"0";s:3:"C/R";s:1:"0";s:10:"Fagerstrom";s:1:"0";s:8:"MotHPres";s:1:"0";s:7:"MotHFut";s:1:"0";s:6:"MotSoc";s:1:"0";s:6:"MotMon";s:1:"0";s:7:"MotSelf";s:1:"0";s:7:"OthSmok";s:1:"0";}');$choice36->setNextQuestion(7);$choice36->setRenamedQuestion(NULL);$choice36->setHideQuestion(NULL);$this->em->persist($choice36);
        $choice37 = new Choice();$choice37->setId(38);$choice37->setQuestion($question6);$choice37->setName("Entre 6 et 30 minutes");$choice37->setScoring('a:17:{s:1:"C";s:1:"0";s:1:"P";s:1:"0";s:1:"A";s:1:"0";s:1:"M";s:1:"0";s:3:"Beh";s:1:"0";s:5:"Ppath";s:1:"0";s:4:"Psoc";s:1:"0";s:4:"Phys";s:1:"0";s:3:"Rew";s:1:"0";s:3:"C/R";s:1:"0";s:10:"Fagerstrom";s:1:"3";s:8:"MotHPres";s:1:"0";s:7:"MotHFut";s:1:"0";s:6:"MotSoc";s:1:"0";s:6:"MotMon";s:1:"0";s:7:"MotSelf";s:1:"0";s:7:"OthSmok";s:1:"0";}');$choice37->setNextQuestion(8);$choice37->setRenamedQuestion(NULL);$choice37->setHideQuestion(NULL);$this->em->persist($choice37);
        $choice38 = new Choice();$choice38->setId(39);$choice38->setQuestion($question6);$choice38->setName("Entre 31 et 60 minutes");$choice38->setScoring('a:17:{s:1:"C";s:1:"0";s:1:"P";s:1:"0";s:1:"A";s:1:"0";s:1:"M";s:1:"0";s:3:"Beh";s:1:"0";s:5:"Ppath";s:1:"0";s:4:"Psoc";s:1:"0";s:4:"Phys";s:1:"0";s:3:"Rew";s:1:"0";s:3:"C/R";s:1:"0";s:10:"Fagerstrom";s:1:"2";s:8:"MotHPres";s:1:"0";s:7:"MotHFut";s:1:"0";s:6:"MotSoc";s:1:"0";s:6:"MotMon";s:1:"0";s:7:"MotSelf";s:1:"0";s:7:"OthSmok";s:1:"0";}');$choice38->setNextQuestion(8);$choice38->setRenamedQuestion(NULL);$choice38->setHideQuestion(NULL);$this->em->persist($choice38);
        $choice39 = new Choice();$choice39->setId(40);$choice39->setQuestion($question6);$choice39->setName("31- 60 minutes");$choice39->setScoring('a:17:{s:1:"C";s:1:"0";s:1:"P";s:1:"0";s:1:"A";s:1:"0";s:1:"M";s:1:"0";s:3:"Beh";s:1:"0";s:5:"Ppath";s:1:"0";s:4:"Psoc";s:1:"0";s:4:"Phys";s:1:"0";s:3:"Rew";s:1:"0";s:3:"C/R";s:1:"0";s:10:"Fagerstrom";s:1:"1";s:8:"MotHPres";s:1:"0";s:7:"MotHFut";s:1:"0";s:6:"MotSoc";s:1:"0";s:6:"MotMon";s:1:"0";s:7:"MotSelf";s:1:"0";s:7:"OthSmok";s:1:"0";}');$choice39->setNextQuestion(8);$choice39->setRenamedQuestion(NULL);$choice39->setHideQuestion(NULL);$this->em->persist($choice39);
        $choice40 = new Choice();$choice40->setId(41);$choice40->setQuestion($question6);$choice40->setName("Aprés 60 minutes");$choice40->setScoring('a:17:{s:1:"C";s:1:"0";s:1:"P";s:1:"0";s:1:"A";s:1:"0";s:1:"M";s:1:"0";s:3:"Beh";s:1:"0";s:5:"Ppath";s:1:"0";s:4:"Psoc";s:1:"0";s:4:"Phys";s:1:"0";s:3:"Rew";s:1:"0";s:3:"C/R";s:1:"0";s:10:"Fagerstrom";s:1:"0";s:8:"MotHPres";s:1:"0";s:7:"MotHFut";s:1:"0";s:6:"MotSoc";s:1:"0";s:6:"MotMon";s:1:"0";s:7:"MotSelf";s:1:"0";s:7:"OthSmok";s:1:"0";}');$choice40->setNextQuestion(8);$choice40->setRenamedQuestion(NULL);$choice40->setHideQuestion(NULL);$this->em->persist($choice40);
        $choice41 = new Choice();$choice41->setId(42);$choice41->setQuestion($question7);$choice41->setName("oui ");$choice41->setScoring('a:17:{s:1:"C";s:1:"0";s:1:"P";s:1:"0";s:1:"A";s:1:"0";s:1:"M";s:1:"0";s:3:"Beh";s:1:"0";s:5:"Ppath";s:1:"0";s:4:"Psoc";s:1:"0";s:4:"Phys";s:1:"0";s:3:"Rew";s:1:"0";s:3:"C/R";s:1:"0";s:10:"Fagerstrom";s:1:"0";s:8:"MotHPres";s:1:"0";s:7:"MotHFut";s:1:"0";s:6:"MotSoc";s:1:"0";s:6:"MotMon";s:1:"0";s:7:"MotSelf";s:1:"0";s:7:"OthSmok";s:1:"1";}');$choice41->setNextQuestion(10);$choice41->setRenamedQuestion(NULL);$choice41->setHideQuestion(NULL);$this->em->persist($choice41);
        $choice42 = new Choice();$choice42->setId(43);$choice42->setQuestion($question7);$choice42->setName("non");$choice42->setScoring('a:17:{s:1:"C";s:1:"0";s:1:"P";s:1:"0";s:1:"A";s:1:"0";s:1:"M";s:1:"0";s:3:"Beh";s:1:"0";s:5:"Ppath";s:1:"0";s:4:"Psoc";s:1:"0";s:4:"Phys";s:1:"0";s:3:"Rew";s:1:"0";s:3:"C/R";s:1:"0";s:10:"Fagerstrom";s:1:"0";s:8:"MotHPres";s:1:"0";s:7:"MotHFut";s:1:"0";s:6:"MotSoc";s:1:"0";s:6:"MotMon";s:1:"0";s:7:"MotSelf";s:1:"0";s:7:"OthSmok";s:1:"1";}');$choice42->setNextQuestion(10);$choice42->setRenamedQuestion(NULL);$choice42->setHideQuestion(NULL);$this->em->persist($choice42);
        $choice43 = new Choice();$choice43->setId(44);$choice43->setQuestion($question8);$choice43->setName("champ libre de saisie");$choice43->setScoring('a:17:{s:1:"C";s:1:"0";s:1:"P";s:1:"0";s:1:"A";s:1:"0";s:1:"M";s:1:"0";s:3:"Beh";s:1:"0";s:5:"Ppath";s:1:"0";s:4:"Psoc";s:1:"0";s:4:"Phys";s:1:"0";s:3:"Rew";s:1:"0";s:3:"C/R";s:1:"0";s:10:"Fagerstrom";s:1:"0";s:8:"MotHPres";s:1:"0";s:7:"MotHFut";s:1:"0";s:6:"MotSoc";s:1:"0";s:6:"MotMon";s:1:"0";s:7:"MotSelf";s:1:"0";s:7:"OthSmok";s:1:"0";}');$choice43->setNextQuestion(10);$choice43->setRenamedQuestion(NULL);$choice43->setHideQuestion(NULL);$this->em->persist($choice43);
        $choice44 = new Choice();$choice44->setId(48);$choice44->setQuestion($question9);$choice44->setName("La première cigarette de la journée");$choice44->setScoring('a:17:{s:1:"C";s:1:"0";s:1:"P";s:1:"0";s:1:"A";s:1:"0";s:1:"M";s:1:"0";s:3:"Beh";s:1:"0";s:5:"Ppath";s:1:"0";s:4:"Psoc";s:1:"0";s:4:"Phys";s:1:"0";s:3:"Rew";s:1:"0";s:3:"C/R";s:1:"0";s:10:"Fagerstrom";s:1:"1";s:8:"MotHPres";s:1:"0";s:7:"MotHFut";s:1:"0";s:6:"MotSoc";s:1:"0";s:6:"MotMon";s:1:"0";s:7:"MotSelf";s:1:"0";s:7:"OthSmok";s:1:"0";}');$choice44->setNextQuestion(12);$choice44->setRenamedQuestion(NULL);$choice44->setHideQuestion(NULL);$this->em->persist($choice44);
        $choice45 = new Choice();$choice45->setId(49);$choice45->setQuestion($question9);$choice45->setName("Une autre");$choice45->setScoring('a:17:{s:1:"C";s:1:"0";s:1:"P";s:1:"0";s:1:"A";s:1:"0";s:1:"M";s:1:"0";s:3:"Beh";s:1:"0";s:5:"Ppath";s:1:"0";s:4:"Psoc";s:1:"0";s:4:"Phys";s:1:"0";s:3:"Rew";s:1:"0";s:3:"C/R";s:1:"0";s:10:"Fagerstrom";s:1:"0";s:8:"MotHPres";s:1:"0";s:7:"MotHFut";s:1:"0";s:6:"MotSoc";s:1:"0";s:6:"MotMon";s:1:"0";s:7:"MotSelf";s:1:"0";s:7:"OthSmok";s:1:"0";}');$choice45->setNextQuestion(12);$choice45->setRenamedQuestion(NULL);$choice45->setHideQuestion(NULL);$this->em->persist($choice45);
        $choice46 = new Choice();$choice46->setId(50);$choice46->setQuestion($question10);$choice46->setName("oui ");$choice46->setScoring('a:17:{s:1:"C";s:1:"0";s:1:"P";s:1:"0";s:1:"A";s:1:"0";s:1:"M";s:1:"0";s:3:"Beh";s:1:"0";s:5:"Ppath";s:1:"0";s:4:"Psoc";s:1:"0";s:4:"Phys";s:1:"0";s:3:"Rew";s:1:"0";s:3:"C/R";s:1:"0";s:10:"Fagerstrom";s:1:"1";s:8:"MotHPres";s:1:"0";s:7:"MotHFut";s:1:"0";s:6:"MotSoc";s:1:"0";s:6:"MotMon";s:1:"0";s:7:"MotSelf";s:1:"0";s:7:"OthSmok";s:1:"0";}');$choice46->setNextQuestion(12);$choice46->setRenamedQuestion(NULL);$choice46->setHideQuestion(NULL);$this->em->persist($choice46);
        $choice47 = new Choice();$choice47->setId(51);$choice47->setQuestion($question10);$choice47->setName("non");$choice47->setScoring('a:17:{s:1:"C";s:1:"0";s:1:"P";s:1:"0";s:1:"A";s:1:"0";s:1:"M";s:1:"0";s:3:"Beh";s:1:"0";s:5:"Ppath";s:1:"0";s:4:"Psoc";s:1:"0";s:4:"Phys";s:1:"0";s:3:"Rew";s:1:"0";s:3:"C/R";s:1:"0";s:10:"Fagerstrom";s:1:"0";s:8:"MotHPres";s:1:"0";s:7:"MotHFut";s:1:"0";s:6:"MotSoc";s:1:"0";s:6:"MotMon";s:1:"0";s:7:"MotSelf";s:1:"0";s:7:"OthSmok";s:1:"0";}');$choice47->setNextQuestion(12);$choice47->setRenamedQuestion(NULL);$choice47->setHideQuestion(NULL);$this->em->persist($choice47);
        $choice48 = new Choice();$choice48->setId(52);$choice48->setQuestion($question11);$choice48->setName("oui");$choice48->setScoring('a:17:{s:1:"C";s:1:"0";s:1:"P";s:1:"0";s:1:"A";s:1:"0";s:1:"M";s:1:"0";s:3:"Beh";s:1:"0";s:5:"Ppath";s:1:"0";s:4:"Psoc";s:1:"0";s:4:"Phys";s:1:"0";s:3:"Rew";s:1:"0";s:3:"C/R";s:1:"0";s:10:"Fagerstrom";s:1:"1";s:8:"MotHPres";s:1:"0";s:7:"MotHFut";s:1:"0";s:6:"MotSoc";s:1:"0";s:6:"MotMon";s:1:"0";s:7:"MotSelf";s:1:"0";s:7:"OthSmok";s:1:"0";}');$choice48->setNextQuestion(13);$choice48->setRenamedQuestion(NULL);$choice48->setHideQuestion(NULL);$this->em->persist($choice48);
        $choice49 = new Choice();$choice49->setId(53);$choice49->setQuestion($question11);$choice49->setName("non");$choice49->setScoring('a:17:{s:1:"C";s:1:"0";s:1:"P";s:1:"0";s:1:"A";s:1:"0";s:1:"M";s:1:"0";s:3:"Beh";s:1:"0";s:5:"Ppath";s:1:"0";s:4:"Psoc";s:1:"0";s:4:"Phys";s:1:"0";s:3:"Rew";s:1:"0";s:3:"C/R";s:1:"0";s:10:"Fagerstrom";s:1:"0";s:8:"MotHPres";s:1:"0";s:7:"MotHFut";s:1:"0";s:6:"MotSoc";s:1:"0";s:6:"MotMon";s:1:"0";s:7:"MotSelf";s:1:"0";s:7:"OthSmok";s:1:"0";}');$choice49->setNextQuestion(13);$choice49->setRenamedQuestion(NULL);$choice49->setHideQuestion(NULL);$this->em->persist($choice49);
        $choice50 = new Choice();$choice50->setId(54);$choice50->setQuestion($question12);$choice50->setName("Y penser le moins possible");$choice50->setScoring('a:17:{s:1:"C";s:1:"0";s:1:"P";s:1:"0";s:1:"A";s:1:"0";s:1:"M";s:1:"0";s:3:"Beh";s:1:"0";s:5:"Ppath";s:1:"0";s:4:"Psoc";s:1:"0";s:4:"Phys";s:1:"0";s:3:"Rew";s:1:"0";s:3:"C/R";s:1:"0";s:10:"Fagerstrom";s:1:"0";s:8:"MotHPres";s:1:"0";s:7:"MotHFut";s:1:"0";s:6:"MotSoc";s:1:"0";s:6:"MotMon";s:1:"0";s:7:"MotSelf";s:1:"0";s:7:"OthSmok";s:1:"0";}');$choice50->setNextQuestion(14);$choice50->setRenamedQuestion(NULL);$choice50->setHideQuestion(NULL);$this->em->persist($choice50);
        $choice51 = new Choice();$choice51->setId(55);$choice51->setQuestion($question12);$choice51->setName("Pouvoir conserver le geste");$choice51->setScoring('a:17:{s:1:"C";s:1:"0";s:1:"P";s:1:"0";s:1:"A";s:1:"0";s:1:"M";s:1:"0";s:3:"Beh";s:1:"0";s:5:"Ppath";s:1:"0";s:4:"Psoc";s:1:"0";s:4:"Phys";s:1:"0";s:3:"Rew";s:1:"0";s:3:"C/R";s:1:"0";s:10:"Fagerstrom";s:1:"0";s:8:"MotHPres";s:1:"0";s:7:"MotHFut";s:1:"0";s:6:"MotSoc";s:1:"0";s:6:"MotMon";s:1:"0";s:7:"MotSelf";s:1:"0";s:7:"OthSmok";s:1:"0";}');$choice51->setNextQuestion(14);$choice51->setRenamedQuestion(NULL);$choice51->setHideQuestion(NULL);$this->em->persist($choice51);
        $choice52 = new Choice();$choice52->setId(56);$choice52->setQuestion($question12);$choice52->setName("Pouvoir m'occuper la bouche");$choice52->setScoring('a:17:{s:1:"C";s:1:"0";s:1:"P";s:1:"0";s:1:"A";s:1:"0";s:1:"M";s:1:"0";s:3:"Beh";s:1:"0";s:5:"Ppath";s:1:"0";s:4:"Psoc";s:1:"0";s:4:"Phys";s:1:"0";s:3:"Rew";s:1:"0";s:3:"C/R";s:1:"0";s:10:"Fagerstrom";s:1:"0";s:8:"MotHPres";s:1:"0";s:7:"MotHFut";s:1:"0";s:6:"MotSoc";s:1:"0";s:6:"MotMon";s:1:"0";s:7:"MotSelf";s:1:"0";s:7:"OthSmok";s:1:"0";}');$choice52->setNextQuestion(14);$choice52->setRenamedQuestion(NULL);$choice52->setHideQuestion(NULL);$this->em->persist($choice52);
        $choice53 = new Choice();$choice53->setId(57);$choice53->setQuestion($question12);$choice53->setName("Rester discret ");$choice53->setScoring('a:17:{s:1:"C";s:1:"0";s:1:"P";s:1:"0";s:1:"A";s:1:"0";s:1:"M";s:1:"0";s:3:"Beh";s:1:"0";s:5:"Ppath";s:1:"0";s:4:"Psoc";s:1:"0";s:4:"Phys";s:1:"0";s:3:"Rew";s:1:"0";s:3:"C/R";s:1:"0";s:10:"Fagerstrom";s:1:"0";s:8:"MotHPres";s:1:"0";s:7:"MotHFut";s:1:"0";s:6:"MotSoc";s:1:"0";s:6:"MotMon";s:1:"0";s:7:"MotSelf";s:1:"0";s:7:"OthSmok";s:1:"0";}');$choice53->setNextQuestion(14);$choice53->setRenamedQuestion(NULL);$choice53->setHideQuestion(NULL);$this->em->persist($choice53);
        $choice54 = new Choice();$choice54->setId(58);$choice54->setQuestion($question12);$choice54->setName("Agir sur mes envies irrésistibles de fumer");$choice54->setScoring('a:17:{s:1:"C";s:1:"0";s:1:"P";s:1:"0";s:1:"A";s:1:"0";s:1:"M";s:1:"0";s:3:"Beh";s:1:"0";s:5:"Ppath";s:1:"0";s:4:"Psoc";s:1:"0";s:4:"Phys";s:1:"0";s:3:"Rew";s:1:"0";s:3:"C/R";s:1:"0";s:10:"Fagerstrom";s:1:"0";s:8:"MotHPres";s:1:"0";s:7:"MotHFut";s:1:"0";s:6:"MotSoc";s:1:"0";s:6:"MotMon";s:1:"0";s:7:"MotSelf";s:1:"0";s:7:"OthSmok";s:1:"0";}');$choice54->setNextQuestion(14);$choice54->setRenamedQuestion(NULL);$choice54->setHideQuestion(NULL);$this->em->persist($choice54);
        $choice55 = new Choice();$choice55->setId(59);$choice55->setQuestion($question12);$choice55->setName("Arrêter avec un goût de menthe intense ");$choice55->setScoring('a:17:{s:1:"C";s:1:"0";s:1:"P";s:1:"0";s:1:"A";s:1:"0";s:1:"M";s:1:"0";s:3:"Beh";s:1:"0";s:5:"Ppath";s:1:"0";s:4:"Psoc";s:1:"0";s:4:"Phys";s:1:"0";s:3:"Rew";s:1:"0";s:3:"C/R";s:1:"0";s:10:"Fagerstrom";s:1:"0";s:8:"MotHPres";s:1:"0";s:7:"MotHFut";s:1:"0";s:6:"MotSoc";s:1:"0";s:6:"MotMon";s:1:"0";s:7:"MotSelf";s:1:"0";s:7:"OthSmok";s:1:"0";}');$choice55->setNextQuestion(14);$choice55->setRenamedQuestion(NULL);$choice55->setHideQuestion(NULL);$this->em->persist($choice55);
        $choice56 = new Choice();$choice56->setId(60);$choice56->setQuestion($question13);$choice56->setName("oui");$choice56->setScoring('a:17:{s:1:"C";s:1:"0";s:1:"P";s:1:"0";s:1:"A";s:1:"0";s:1:"M";s:1:"0";s:3:"Beh";s:1:"0";s:5:"Ppath";s:1:"0";s:4:"Psoc";s:1:"0";s:4:"Phys";s:1:"0";s:3:"Rew";s:1:"0";s:3:"C/R";s:1:"0";s:10:"Fagerstrom";s:1:"0";s:8:"MotHPres";s:1:"0";s:7:"MotHFut";s:1:"0";s:6:"MotSoc";s:1:"0";s:6:"MotMon";s:1:"0";s:7:"MotSelf";s:1:"0";s:7:"OthSmok";s:1:"1";}');$choice56->setNextQuestion(16);$choice56->setRenamedQuestion(NULL);$choice56->setHideQuestion(NULL);$this->em->persist($choice56);
        $choice57 = new Choice();$choice57->setId(61);$choice57->setQuestion($question13);$choice57->setName("non");$choice57->setScoring('a:17:{s:1:"C";s:1:"0";s:1:"P";s:1:"0";s:1:"A";s:1:"0";s:1:"M";s:1:"0";s:3:"Beh";s:1:"0";s:5:"Ppath";s:1:"0";s:4:"Psoc";s:1:"0";s:4:"Phys";s:1:"0";s:3:"Rew";s:1:"0";s:3:"C/R";s:1:"0";s:10:"Fagerstrom";s:1:"0";s:8:"MotHPres";s:1:"0";s:7:"MotHFut";s:1:"0";s:6:"MotSoc";s:1:"0";s:6:"MotMon";s:1:"0";s:7:"MotSelf";s:1:"0";s:7:"OthSmok";s:1:"0";}');$choice57->setNextQuestion(16);$choice57->setRenamedQuestion(NULL);$choice57->setHideQuestion(NULL);$this->em->persist($choice57);
        
        $choice58 = new Choice();$choice58->setId(62);$choice58->setQuestion($question14);$choice58->setName("Homme");$choice58->setScoring('a:17:{s:1:"C";s:1:"0";s:1:"P";s:1:"0";s:1:"A";s:1:"0";s:1:"M";s:1:"0";s:3:"Beh";s:1:"0";s:5:"Ppath";s:1:"0";s:4:"Psoc";s:1:"0";s:4:"Phys";s:1:"0";s:3:"Rew";s:1:"0";s:3:"C/R";s:1:"0";s:10:"Fagerstrom";s:1:"0";s:8:"MotHPres";s:1:"0";s:7:"MotHFut";s:1:"0";s:6:"MotSoc";s:1:"0";s:6:"MotMon";s:1:"0";s:7:"MotSelf";s:1:"0";s:7:"OthSmok";s:1:"0";}');$choice58->setNextQuestion(19);$choice58->setRenamedQuestion(NULL);$choice58->setHideQuestion(NULL);$this->em->persist($choice58);
        $choice59 = new Choice();$choice59->setId(63);$choice59->setQuestion($question14);$choice59->setName("Femme");$choice59->setScoring('a:17:{s:1:"C";s:1:"0";s:1:"P";s:1:"0";s:1:"A";s:1:"0";s:1:"M";s:1:"0";s:3:"Beh";s:1:"0";s:5:"Ppath";s:1:"0";s:4:"Psoc";s:1:"0";s:4:"Phys";s:1:"0";s:3:"Rew";s:1:"0";s:3:"C/R";s:1:"0";s:10:"Fagerstrom";s:1:"0";s:8:"MotHPres";s:1:"0";s:7:"MotHFut";s:1:"0";s:6:"MotSoc";s:1:"0";s:6:"MotMon";s:1:"0";s:7:"MotSelf";s:1:"0";s:7:"OthSmok";s:1:"0";}');$choice59->setNextQuestion(19, 'a:1:{i:0;s:2:"18";}');$choice59->setNextQuestion(NULL);$this->em->persist($choice59);
        $choice60 = new Choice();$choice60->setId(64);$choice60->setQuestion($question15);$choice60->setName("oui");$choice60->setScoring('a:17:{s:1:"C";s:1:"0";s:1:"P";s:1:"0";s:1:"A";s:1:"0";s:1:"M";s:1:"0";s:3:"Beh";s:1:"0";s:5:"Ppath";s:1:"0";s:4:"Psoc";s:1:"0";s:4:"Phys";s:1:"0";s:3:"Rew";s:1:"0";s:3:"C/R";s:1:"0";s:10:"Fagerstrom";s:1:"0";s:8:"MotHPres";s:1:"0";s:7:"MotHFut";s:1:"0";s:6:"MotSoc";s:1:"0";s:6:"MotMon";s:1:"0";s:7:"MotSelf";s:1:"0";s:7:"OthSmok";s:1:"0";}');$choice60->setNextQuestion(19);$choice60->setRenamedQuestion(NULL);$choice60->setHideQuestion(NULL);$this->em->persist($choice60);
        $choice61 = new Choice();$choice61->setId(65);$choice61->setQuestion($question15);$choice61->setName("non");$choice61->setScoring('a:17:{s:1:"C";s:1:"0";s:1:"P";s:1:"0";s:1:"A";s:1:"0";s:1:"M";s:1:"0";s:3:"Beh";s:1:"0";s:5:"Ppath";s:1:"0";s:4:"Psoc";s:1:"0";s:4:"Phys";s:1:"0";s:3:"Rew";s:1:"0";s:3:"C/R";s:1:"0";s:10:"Fagerstrom";s:1:"0";s:8:"MotHPres";s:1:"0";s:7:"MotHFut";s:1:"0";s:6:"MotSoc";s:1:"0";s:6:"MotMon";s:1:"0";s:7:"MotSelf";s:1:"0";s:7:"OthSmok";s:1:"0";}');$choice61->setNextQuestion(19);$choice61->setRenamedQuestion(NULL);$choice61->setHideQuestion(NULL);$this->em->persist($choice61);
        $choice62 = new Choice();$choice62->setId(66);$choice62->setQuestion($question16);$choice62->setName("Mon médecin");$choice62->setScoring('a:17:{s:1:"C";s:1:"0";s:1:"P";s:1:"0";s:1:"A";s:1:"0";s:1:"M";s:1:"0";s:3:"Beh";s:1:"0";s:5:"Ppath";s:1:"0";s:4:"Psoc";s:1:"0";s:4:"Phys";s:1:"0";s:3:"Rew";s:1:"0";s:3:"C/R";s:1:"0";s:10:"Fagerstrom";s:1:"0";s:8:"MotHPres";s:1:"0";s:7:"MotHFut";s:1:"0";s:6:"MotSoc";s:1:"0";s:6:"MotMon";s:1:"0";s:7:"MotSelf";s:1:"0";s:7:"OthSmok";s:1:"0";}');$choice62->setNextQuestion(NULL);$choice62->setRenamedQuestion(NULL);$choice62->setHideQuestion(NULL);$this->em->persist($choice62);
        $choice63 = new Choice();$choice63->setId(67);$choice63->setQuestion($question16);$choice63->setName("Mon pharmacien");$choice63->setScoring('a:17:{s:1:"C";s:1:"0";s:1:"P";s:1:"0";s:1:"A";s:1:"0";s:1:"M";s:1:"0";s:3:"Beh";s:1:"0";s:5:"Ppath";s:1:"0";s:4:"Psoc";s:1:"0";s:4:"Phys";s:1:"0";s:3:"Rew";s:1:"0";s:3:"C/R";s:1:"0";s:10:"Fagerstrom";s:1:"0";s:8:"MotHPres";s:1:"0";s:7:"MotHFut";s:1:"0";s:6:"MotSoc";s:1:"0";s:6:"MotMon";s:1:"0";s:7:"MotSelf";s:1:"0";s:7:"OthSmok";s:1:"0";}');$choice63->setNextQuestion(NULL);$choice63->setRenamedQuestion(NULL);$choice63->setHideQuestion(NULL);$this->em->persist($choice63);
        $choice64 = new Choice();$choice64->setId(68);$choice64->setQuestion($question16);$choice64->setName("Un ami / membre de ma famille");$choice64->setScoring('a:17:{s:1:"C";s:1:"0";s:1:"P";s:1:"0";s:1:"A";s:1:"0";s:1:"M";s:1:"0";s:3:"Beh";s:1:"0";s:5:"Ppath";s:1:"0";s:4:"Psoc";s:1:"0";s:4:"Phys";s:1:"0";s:3:"Rew";s:1:"0";s:3:"C/R";s:1:"0";s:10:"Fagerstrom";s:1:"0";s:8:"MotHPres";s:1:"0";s:7:"MotHFut";s:1:"0";s:6:"MotSoc";s:1:"0";s:6:"MotMon";s:1:"0";s:7:"MotSelf";s:1:"0";s:7:"OthSmok";s:1:"0";}');$choice64->setNextQuestion(NULL);$choice64->setRenamedQuestion(NULL);$choice64->setHideQuestion(NULL);$this->em->persist($choice64);
        $choice65 = new Choice();$choice65->setId(69);$choice65->setQuestion($question16);$choice65->setName("Internet");$choice65->setScoring('a:17:{s:1:"C";s:1:"0";s:1:"P";s:1:"0";s:1:"A";s:1:"0";s:1:"M";s:1:"0";s:3:"Beh";s:1:"0";s:5:"Ppath";s:1:"0";s:4:"Psoc";s:1:"0";s:4:"Phys";s:1:"0";s:3:"Rew";s:1:"0";s:3:"C/R";s:1:"0";s:10:"Fagerstrom";s:1:"0";s:8:"MotHPres";s:1:"0";s:7:"MotHFut";s:1:"0";s:6:"MotSoc";s:1:"0";s:6:"MotMon";s:1:"0";s:7:"MotSelf";s:1:"0";s:7:"OthSmok";s:1:"0";}');$choice65->setNextQuestion(NULL);$choice65->setRenamedQuestion(NULL);$choice65->setHideQuestion(NULL);$this->em->persist($choice65);
        $choice66 = new Choice();$choice66->setId(70);$choice66->setQuestion($question16);$choice66->setName("TV, magazines");$choice66->setScoring('a:17:{s:1:"C";s:1:"0";s:1:"P";s:1:"0";s:1:"A";s:1:"0";s:1:"M";s:1:"0";s:3:"Beh";s:1:"0";s:5:"Ppath";s:1:"0";s:4:"Psoc";s:1:"0";s:4:"Phys";s:1:"0";s:3:"Rew";s:1:"0";s:3:"C/R";s:1:"0";s:10:"Fagerstrom";s:1:"0";s:8:"MotHPres";s:1:"0";s:7:"MotHFut";s:1:"0";s:6:"MotSoc";s:1:"0";s:6:"MotMon";s:1:"0";s:7:"MotSelf";s:1:"0";s:7:"OthSmok";s:1:"0";}');$choice66->setNextQuestion(NULL);$choice66->setRenamedQuestion(NULL);$choice66->setHideQuestion(NULL);$this->em->persist($choice66);
        $choice67 = new Choice();$choice67->setId(71);$choice67->setQuestion($question16);$choice67->setName("Autre");$choice67->setScoring('a:17:{s:1:"C";s:1:"0";s:1:"P";s:1:"0";s:1:"A";s:1:"0";s:1:"M";s:1:"0";s:3:"Beh";s:1:"0";s:5:"Ppath";s:1:"0";s:4:"Psoc";s:1:"0";s:4:"Phys";s:1:"0";s:3:"Rew";s:1:"0";s:3:"C/R";s:1:"0";s:10:"Fagerstrom";s:1:"0";s:8:"MotHPres";s:1:"0";s:7:"MotHFut";s:1:"0";s:6:"MotSoc";s:1:"0";s:6:"MotMon";s:1:"0";s:7:"MotSelf";s:1:"0";s:7:"OthSmok";s:1:"0";}');$choice67->setNextQuestion(NULL);$choice67->setRenamedQuestion(NULL);$choice67->setHideQuestion(NULL);$this->em->persist($choice67);
        $choice68 = new Choice();$choice68->setId(72);$choice68->setQuestion($question17);$choice68->setName("OUI");$choice68->setScoring('a:17:{s:1:"C";s:1:"0";s:1:"P";s:1:"0";s:1:"A";s:1:"0";s:1:"M";s:1:"0";s:3:"Beh";s:1:"0";s:5:"Ppath";s:1:"0";s:4:"Psoc";s:1:"0";s:4:"Phys";s:1:"0";s:3:"Rew";s:1:"0";s:3:"C/R";s:1:"0";s:10:"Fagerstrom";s:1:"0";s:8:"MotHPres";s:1:"0";s:7:"MotHFut";s:1:"0";s:6:"MotSoc";s:1:"0";s:6:"MotMon";s:1:"0";s:7:"MotSelf";s:1:"0";s:7:"OthSmok";s:1:"0";}');$choice68->setNextQuestion(21);$choice68->setRenamedQuestion(NULL);$choice68->setHideQuestion(NULL);$this->em->persist($choice68);
        $choice69 = new Choice();$choice69->setId(73);$choice69->setQuestion($question17);$choice69->setName("NON");$choice69->setScoring('a:17:{s:1:"C";s:1:"0";s:1:"P";s:1:"0";s:1:"A";s:1:"0";s:1:"M";s:1:"0";s:3:"Beh";s:1:"0";s:5:"Ppath";s:1:"0";s:4:"Psoc";s:1:"0";s:4:"Phys";s:1:"0";s:3:"Rew";s:1:"0";s:3:"C/R";s:1:"0";s:10:"Fagerstrom";s:1:"0";s:8:"MotHPres";s:1:"0";s:7:"MotHFut";s:1:"0";s:6:"MotSoc";s:1:"0";s:6:"MotMon";s:1:"0";s:7:"MotSelf";s:1:"0";s:7:"OthSmok";s:1:"0";}');$choice69->setNextQuestion(21);$choice69->setRenamedQuestion(NULL);$choice69->setHideQuestion(NULL);$this->em->persist($choice69);
        $choice70 = new Choice();$choice70->setId(74);$choice70->setQuestion($question18);$choice70->setName("L'idée d'arrêter");$choice70->setScoring('a:17:{s:1:"C";s:1:"0";s:1:"P";s:1:"0";s:1:"A";s:1:"0";s:1:"M";s:1:"0";s:3:"Beh";s:1:"0";s:5:"Ppath";s:1:"0";s:4:"Psoc";s:1:"0";s:4:"Phys";s:1:"0";s:3:"Rew";s:1:"0";s:3:"C/R";s:1:"0";s:10:"Fagerstrom";s:1:"0";s:8:"MotHPres";s:1:"0";s:7:"MotHFut";s:1:"0";s:6:"MotSoc";s:1:"0";s:6:"MotMon";s:1:"0";s:7:"MotSelf";s:1:"0";s:7:"OthSmok";s:1:"0";}');$choice70->setNextQuestion(NULL);$choice70->setRenamedQuestion(NULL);$choice70->setHideQuestion(NULL);$this->em->persist($choice70);
        $choice71 = new Choice();$choice71->setId(75);$choice71->setQuestion($question18);$choice71->setName("Réduire ma consommation");$choice71->setScoring('a:17:{s:1:"C";s:1:"0";s:1:"P";s:1:"0";s:1:"A";s:1:"0";s:1:"M";s:1:"0";s:3:"Beh";s:1:"0";s:5:"Ppath";s:1:"0";s:4:"Psoc";s:1:"0";s:4:"Phys";s:1:"0";s:3:"Rew";s:1:"0";s:3:"C/R";s:1:"0";s:10:"Fagerstrom";s:1:"0";s:8:"MotHPres";s:1:"0";s:7:"MotHFut";s:1:"0";s:6:"MotSoc";s:1:"0";s:6:"MotMon";s:1:"0";s:7:"MotSelf";s:1:"0";s:7:"OthSmok";s:1:"0";}');$choice71->setNextQuestion(NULL);$choice71->setRenamedQuestion(NULL);$choice71->setHideQuestion(NULL);$this->em->persist($choice71);
        
        $choice72 = new Choice();$choice72->setId(76);$choice72->setQuestion($question19);$choice72->setName("1");$choice72->setScoring('a:17:{s:1:"C";s:1:"0";s:1:"P";s:1:"0";s:1:"A";s:1:"0";s:1:"M";s:1:"0";s:3:"Beh";s:1:"0";s:5:"Ppath";s:1:"0";s:4:"Psoc";s:1:"0";s:4:"Phys";s:1:"0";s:3:"Rew";s:1:"0";s:3:"C/R";s:1:"0";s:10:"Fagerstrom";s:1:"0";s:8:"MotHPres";s:1:"0";s:7:"MotHFut";s:1:"0";s:6:"MotSoc";s:1:"0";s:6:"MotMon";s:1:"0";s:7:"MotSelf";s:1:"0";s:7:"OthSmok";s:1:"0";}');$choice72->setNextQuestion(23);$choice72->setRenamedQuestion(NULL);$choice72->setHideQuestion(NULL);$this->em->persist($choice72);
        $choice73 = new Choice();$choice73->setId(77);$choice73->setQuestion($question19);$choice73->setName("2");$choice73->setScoring('a:17:{s:1:"C";s:1:"0";s:1:"P";s:1:"0";s:1:"A";s:1:"0";s:1:"M";s:1:"0";s:3:"Beh";s:1:"0";s:5:"Ppath";s:1:"0";s:4:"Psoc";s:1:"0";s:4:"Phys";s:1:"0";s:3:"Rew";s:1:"0";s:3:"C/R";s:1:"0";s:10:"Fagerstrom";s:1:"0";s:8:"MotHPres";s:1:"0";s:7:"MotHFut";s:1:"0";s:6:"MotSoc";s:1:"0";s:6:"MotMon";s:1:"0";s:7:"MotSelf";s:1:"0";s:7:"OthSmok";s:1:"0";}');$choice73->setNextQuestion(23);$choice73->setRenamedQuestion(NULL);$choice73->setHideQuestion(NULL);$this->em->persist($choice73);
        $choice74 = new Choice();$choice74->setId(78);$choice74->setQuestion($question19);$choice74->setName("3");$choice74->setScoring('a:17:{s:1:"C";s:1:"0";s:1:"P";s:1:"0";s:1:"A";s:1:"0";s:1:"M";s:1:"0";s:3:"Beh";s:1:"0";s:5:"Ppath";s:1:"0";s:4:"Psoc";s:1:"0";s:4:"Phys";s:1:"0";s:3:"Rew";s:1:"0";s:3:"C/R";s:1:"0";s:10:"Fagerstrom";s:1:"0";s:8:"MotHPres";s:1:"0";s:7:"MotHFut";s:1:"0";s:6:"MotSoc";s:1:"0";s:6:"MotMon";s:1:"0";s:7:"MotSelf";s:1:"0";s:7:"OthSmok";s:1:"0";}');$choice74->setNextQuestion(23);$choice74->setRenamedQuestion(NULL);$choice74->setHideQuestion(NULL);$this->em->persist($choice74);
        $choice75 = new Choice();$choice75->setId(79);$choice75->setQuestion($question19);$choice75->setName("4");$choice75->setScoring('a:17:{s:1:"C";s:1:"0";s:1:"P";s:1:"0";s:1:"A";s:1:"0";s:1:"M";s:1:"0";s:3:"Beh";s:1:"0";s:5:"Ppath";s:1:"0";s:4:"Psoc";s:1:"0";s:4:"Phys";s:1:"0";s:3:"Rew";s:1:"0";s:3:"C/R";s:1:"0";s:10:"Fagerstrom";s:1:"0";s:8:"MotHPres";s:1:"0";s:7:"MotHFut";s:1:"0";s:6:"MotSoc";s:1:"0";s:6:"MotMon";s:1:"0";s:7:"MotSelf";s:1:"0";s:7:"OthSmok";s:1:"0";}');$choice75->setNextQuestion(23);$choice75->setRenamedQuestion(NULL);$choice75->setHideQuestion(NULL);$this->em->persist($choice75);
        $choice76 = new Choice();$choice76->setId(80);$choice76->setQuestion($question19);$choice76->setName("5");$choice76->setScoring('a:17:{s:1:"C";s:1:"0";s:1:"P";s:1:"0";s:1:"A";s:1:"0";s:1:"M";s:1:"0";s:3:"Beh";s:1:"0";s:5:"Ppath";s:1:"0";s:4:"Psoc";s:1:"0";s:4:"Phys";s:1:"0";s:3:"Rew";s:1:"0";s:3:"C/R";s:1:"0";s:10:"Fagerstrom";s:1:"0";s:8:"MotHPres";s:1:"0";s:7:"MotHFut";s:1:"0";s:6:"MotSoc";s:1:"0";s:6:"MotMon";s:1:"0";s:7:"MotSelf";s:1:"0";s:7:"OthSmok";s:1:"0";}');$choice76->setNextQuestion(23);$choice76->setRenamedQuestion(NULL);$choice76->setHideQuestion(NULL);$this->em->persist($choice76);
        $choice77 = new Choice();$choice77->setId(81);$choice77->setQuestion($question19);$choice77->setName("6");$choice77->setScoring('a:17:{s:1:"C";s:1:"0";s:1:"P";s:1:"0";s:1:"A";s:1:"0";s:1:"M";s:1:"0";s:3:"Beh";s:1:"0";s:5:"Ppath";s:1:"0";s:4:"Psoc";s:1:"0";s:4:"Phys";s:1:"0";s:3:"Rew";s:1:"0";s:3:"C/R";s:1:"0";s:10:"Fagerstrom";s:1:"0";s:8:"MotHPres";s:1:"0";s:7:"MotHFut";s:1:"0";s:6:"MotSoc";s:1:"0";s:6:"MotMon";s:1:"0";s:7:"MotSelf";s:1:"0";s:7:"OthSmok";s:1:"0";}');$choice77->setNextQuestion(23);$choice77->setRenamedQuestion(NULL);$choice77->setHideQuestion(NULL);$this->em->persist($choice77);
        $choice78 = new Choice();$choice78->setId(82);$choice78->setQuestion($question19);$choice78->setName("7");$choice78->setScoring('a:17:{s:1:"C";s:1:"0";s:1:"P";s:1:"0";s:1:"A";s:1:"0";s:1:"M";s:1:"0";s:3:"Beh";s:1:"0";s:5:"Ppath";s:1:"0";s:4:"Psoc";s:1:"0";s:4:"Phys";s:1:"0";s:3:"Rew";s:1:"0";s:3:"C/R";s:1:"0";s:10:"Fagerstrom";s:1:"0";s:8:"MotHPres";s:1:"0";s:7:"MotHFut";s:1:"0";s:6:"MotSoc";s:1:"0";s:6:"MotMon";s:1:"0";s:7:"MotSelf";s:1:"0";s:7:"OthSmok";s:1:"0";}');$choice78->setNextQuestion(23);$choice78->setRenamedQuestion(NULL);$choice78->setHideQuestion(NULL);$this->em->persist($choice78);
        $choice79 = new Choice();$choice79->setId(83);$choice79->setQuestion($question19);$choice79->setName("8");$choice79->setScoring('a:17:{s:1:"C";s:1:"0";s:1:"P";s:1:"0";s:1:"A";s:1:"0";s:1:"M";s:1:"0";s:3:"Beh";s:1:"0";s:5:"Ppath";s:1:"0";s:4:"Psoc";s:1:"0";s:4:"Phys";s:1:"0";s:3:"Rew";s:1:"0";s:3:"C/R";s:1:"0";s:10:"Fagerstrom";s:1:"0";s:8:"MotHPres";s:1:"0";s:7:"MotHFut";s:1:"0";s:6:"MotSoc";s:1:"0";s:6:"MotMon";s:1:"0";s:7:"MotSelf";s:1:"0";s:7:"OthSmok";s:1:"0";}');$choice79->setNextQuestion(23);$choice79->setRenamedQuestion(NULL);$choice79->setHideQuestion(NULL);$this->em->persist($choice79);
        $choice80 = new Choice();$choice80->setId(84);$choice80->setQuestion($question19);$choice80->setName("9");$choice80->setScoring('a:17:{s:1:"C";s:1:"0";s:1:"P";s:1:"0";s:1:"A";s:1:"0";s:1:"M";s:1:"0";s:3:"Beh";s:1:"0";s:5:"Ppath";s:1:"0";s:4:"Psoc";s:1:"0";s:4:"Phys";s:1:"0";s:3:"Rew";s:1:"0";s:3:"C/R";s:1:"0";s:10:"Fagerstrom";s:1:"0";s:8:"MotHPres";s:1:"0";s:7:"MotHFut";s:1:"0";s:6:"MotSoc";s:1:"0";s:6:"MotMon";s:1:"0";s:7:"MotSelf";s:1:"0";s:7:"OthSmok";s:1:"0";}');$choice80->setNextQuestion(23);$choice80->setRenamedQuestion(NULL);$choice80->setHideQuestion(NULL);$this->em->persist($choice80);
        $choice81 = new Choice();$choice81->setId(85);$choice81->setQuestion($question19);$choice81->setName("10");$choice81->setScoring('a:17:{s:1:"C";s:1:"0";s:1:"P";s:1:"0";s:1:"A";s:1:"0";s:1:"M";s:1:"0";s:3:"Beh";s:1:"0";s:5:"Ppath";s:1:"0";s:4:"Psoc";s:1:"0";s:4:"Phys";s:1:"0";s:3:"Rew";s:1:"0";s:3:"C/R";s:1:"0";s:10:"Fagerstrom";s:1:"0";s:8:"MotHPres";s:1:"0";s:7:"MotHFut";s:1:"0";s:6:"MotSoc";s:1:"0";s:6:"MotMon";s:1:"0";s:7:"MotSelf";s:1:"0";s:7:"OthSmok";s:1:"0";}');$choice81->setNextQuestion(23);$choice81->setRenamedQuestion(NULL);$choice81->setHideQuestion(NULL);$this->em->persist($choice81);
        $choice82 = new Choice();$choice82->setId(86);$choice82->setQuestion($question19);$choice82->setName("J'ai fumé");$choice82->setScoring('a:17:{s:1:"C";s:1:"0";s:1:"P";s:1:"0";s:1:"A";s:1:"0";s:1:"M";s:1:"0";s:3:"Beh";s:1:"0";s:5:"Ppath";s:1:"0";s:4:"Psoc";s:1:"0";s:4:"Phys";s:1:"0";s:3:"Rew";s:1:"0";s:3:"C/R";s:1:"0";s:10:"Fagerstrom";s:1:"0";s:8:"MotHPres";s:1:"0";s:7:"MotHFut";s:1:"0";s:6:"MotSoc";s:1:"0";s:6:"MotMon";s:1:"0";s:7:"MotSelf";s:1:"0";s:7:"OthSmok";s:1:"0";}');$choice82->setNextQuestion(32);$choice82->setRenamedQuestion(NULL);$choice82->setHideQuestion(NULL);$this->em->persist($choice82);
        $choice83 = new Choice();$choice83->setId(87);$choice83->setQuestion($question20);$choice83->setName("Tout le temps");$choice83->setScoring('a:17:{s:1:"C";s:1:"0";s:1:"P";s:1:"0";s:1:"A";s:1:"0";s:1:"M";s:1:"0";s:3:"Beh";s:1:"0";s:5:"Ppath";s:1:"0";s:4:"Psoc";s:1:"0";s:4:"Phys";s:1:"0";s:3:"Rew";s:1:"0";s:3:"C/R";s:1:"0";s:10:"Fagerstrom";s:1:"0";s:8:"MotHPres";s:1:"0";s:7:"MotHFut";s:1:"0";s:6:"MotSoc";s:1:"0";s:6:"MotMon";s:1:"0";s:7:"MotSelf";s:1:"0";s:7:"OthSmok";s:1:"0";}');$choice83->setNextQuestion(NULL);$choice83->setRenamedQuestion(NULL);$choice83->setHideQuestion(NULL);$this->em->persist($choice83);
        $choice84 = new Choice();$choice84->setId(88);$choice84->setQuestion($question20);$choice84->setName("Parfois");$choice84->setScoring('a:17:{s:1:"C";s:1:"0";s:1:"P";s:1:"0";s:1:"A";s:1:"0";s:1:"M";s:1:"0";s:3:"Beh";s:1:"0";s:5:"Ppath";s:1:"0";s:4:"Psoc";s:1:"0";s:4:"Phys";s:1:"0";s:3:"Rew";s:1:"0";s:3:"C/R";s:1:"0";s:10:"Fagerstrom";s:1:"0";s:8:"MotHPres";s:1:"0";s:7:"MotHFut";s:1:"0";s:6:"MotSoc";s:1:"0";s:6:"MotMon";s:1:"0";s:7:"MotSelf";s:1:"0";s:7:"OthSmok";s:1:"0";}');$choice84->setNextQuestion(NULL);$choice84->setRenamedQuestion(NULL);$choice84->setHideQuestion(NULL);$this->em->persist($choice84);
        $choice85 = new Choice();$choice85->setId(89);$choice85->setQuestion($question20);$choice85->setName("Non");$choice85->setScoring('a:17:{s:1:"C";s:1:"0";s:1:"P";s:1:"0";s:1:"A";s:1:"0";s:1:"M";s:1:"0";s:3:"Beh";s:1:"0";s:5:"Ppath";s:1:"0";s:4:"Psoc";s:1:"0";s:4:"Phys";s:1:"0";s:3:"Rew";s:1:"0";s:3:"C/R";s:1:"0";s:10:"Fagerstrom";s:1:"0";s:8:"MotHPres";s:1:"0";s:7:"MotHFut";s:1:"0";s:6:"MotSoc";s:1:"0";s:6:"MotMon";s:1:"0";s:7:"MotSelf";s:1:"0";s:7:"OthSmok";s:1:"0";}');$choice85->setNextQuestion(NULL);$choice85->setRenamedQuestion(NULL);$choice85->setHideQuestion(NULL);$this->em->persist($choice85);
        $choice86 = new Choice();$choice86->setId(90);$choice86->setQuestion($question21);$choice86->setName("Au réveil");$choice86->setScoring('a:17:{s:1:"C";s:1:"0";s:1:"P";s:1:"0";s:1:"A";s:1:"0";s:1:"M";s:1:"0";s:3:"Beh";s:1:"0";s:5:"Ppath";s:1:"0";s:4:"Psoc";s:1:"0";s:4:"Phys";s:1:"0";s:3:"Rew";s:1:"0";s:3:"C/R";s:1:"0";s:10:"Fagerstrom";s:1:"0";s:8:"MotHPres";s:1:"0";s:7:"MotHFut";s:1:"0";s:6:"MotSoc";s:1:"0";s:6:"MotMon";s:1:"0";s:7:"MotSelf";s:1:"0";s:7:"OthSmok";s:1:"0";}');$choice86->setNextQuestion(25);$choice86->setRenamedQuestion(NULL);$choice86->setHideQuestion(NULL);$this->em->persist($choice86);
        $choice87 = new Choice();$choice87->setId(91);$choice87->setQuestion($question21);$choice87->setName("Le matin");$choice87->setScoring('a:17:{s:1:"C";s:1:"0";s:1:"P";s:1:"0";s:1:"A";s:1:"0";s:1:"M";s:1:"0";s:3:"Beh";s:1:"0";s:5:"Ppath";s:1:"0";s:4:"Psoc";s:1:"0";s:4:"Phys";s:1:"0";s:3:"Rew";s:1:"0";s:3:"C/R";s:1:"0";s:10:"Fagerstrom";s:1:"0";s:8:"MotHPres";s:1:"0";s:7:"MotHFut";s:1:"0";s:6:"MotSoc";s:1:"0";s:6:"MotMon";s:1:"0";s:7:"MotSelf";s:1:"0";s:7:"OthSmok";s:1:"0";}');$choice87->setNextQuestion(25);$choice87->setRenamedQuestion(NULL);$choice87->setHideQuestion(NULL);$this->em->persist($choice87);
        $choice88 = new Choice();$choice88->setId(92);$choice88->setQuestion($question21);$choice88->setName("A midi");$choice88->setScoring('a:17:{s:1:"C";s:1:"0";s:1:"P";s:1:"0";s:1:"A";s:1:"0";s:1:"M";s:1:"0";s:3:"Beh";s:1:"0";s:5:"Ppath";s:1:"0";s:4:"Psoc";s:1:"0";s:4:"Phys";s:1:"0";s:3:"Rew";s:1:"0";s:3:"C/R";s:1:"0";s:10:"Fagerstrom";s:1:"0";s:8:"MotHPres";s:1:"0";s:7:"MotHFut";s:1:"0";s:6:"MotSoc";s:1:"0";s:6:"MotMon";s:1:"0";s:7:"MotSelf";s:1:"0";s:7:"OthSmok";s:1:"0";}');$choice88->setNextQuestion(25);$choice88->setRenamedQuestion(NULL);$choice88->setHideQuestion(NULL);$this->em->persist($choice88);
        $choice89 = new Choice();$choice89->setId(93);$choice89->setQuestion($question21);$choice89->setName("Dans l'après-midi");$choice89->setScoring('a:17:{s:1:"C";s:1:"0";s:1:"P";s:1:"0";s:1:"A";s:1:"0";s:1:"M";s:1:"0";s:3:"Beh";s:1:"0";s:5:"Ppath";s:1:"0";s:4:"Psoc";s:1:"0";s:4:"Phys";s:1:"0";s:3:"Rew";s:1:"0";s:3:"C/R";s:1:"0";s:10:"Fagerstrom";s:1:"0";s:8:"MotHPres";s:1:"0";s:7:"MotHFut";s:1:"0";s:6:"MotSoc";s:1:"0";s:6:"MotMon";s:1:"0";s:7:"MotSelf";s:1:"0";s:7:"OthSmok";s:1:"0";}');$choice89->setNextQuestion(25);$choice89->setRenamedQuestion(NULL);$choice89->setHideQuestion(NULL);$this->em->persist($choice89);
        $choice90 = new Choice();$choice90->setId(94);$choice90->setQuestion($question21);$choice90->setName("En soirée");$choice90->setScoring('a:17:{s:1:"C";s:1:"0";s:1:"P";s:1:"0";s:1:"A";s:1:"0";s:1:"M";s:1:"0";s:3:"Beh";s:1:"0";s:5:"Ppath";s:1:"0";s:4:"Psoc";s:1:"0";s:4:"Phys";s:1:"0";s:3:"Rew";s:1:"0";s:3:"C/R";s:1:"0";s:10:"Fagerstrom";s:1:"0";s:8:"MotHPres";s:1:"0";s:7:"MotHFut";s:1:"0";s:6:"MotSoc";s:1:"0";s:6:"MotMon";s:1:"0";s:7:"MotSelf";s:1:"0";s:7:"OthSmok";s:1:"0";}');$choice90->setNextQuestion(25);$choice90->setRenamedQuestion(NULL);$choice90->setHideQuestion(NULL);$this->em->persist($choice90);
        $choice91 = new Choice();$choice91->setId(95);$choice91->setQuestion($question22);$choice91->setName("Avoir terminé un repas");$choice91->setScoring('a:17:{s:1:"C";s:1:"0";s:1:"P";s:1:"0";s:1:"A";s:1:"0";s:1:"M";s:1:"0";s:3:"Beh";s:1:"0";s:5:"Ppath";s:1:"0";s:4:"Psoc";s:1:"0";s:4:"Phys";s:1:"0";s:3:"Rew";s:1:"0";s:3:"C/R";s:1:"0";s:10:"Fagerstrom";s:1:"0";s:8:"MotHPres";s:1:"0";s:7:"MotHFut";s:1:"0";s:6:"MotSoc";s:1:"0";s:6:"MotMon";s:1:"0";s:7:"MotSelf";s:1:"0";s:7:"OthSmok";s:1:"0";}');$choice91->setNextQuestion(26);$choice91->setRenamedQuestion(NULL);$choice91->setHideQuestion(NULL);$this->em->persist($choice91);
        $choice92 = new Choice();$choice92->setId(96);$choice92->setQuestion($question22);$choice92->setName("Boire un verre d'alcool");$choice92->setScoring('a:17:{s:1:"C";s:1:"0";s:1:"P";s:1:"0";s:1:"A";s:1:"0";s:1:"M";s:1:"0";s:3:"Beh";s:1:"0";s:5:"Ppath";s:1:"0";s:4:"Psoc";s:1:"0";s:4:"Phys";s:1:"0";s:3:"Rew";s:1:"0";s:3:"C/R";s:1:"0";s:10:"Fagerstrom";s:1:"0";s:8:"MotHPres";s:1:"0";s:7:"MotHFut";s:1:"0";s:6:"MotSoc";s:1:"0";s:6:"MotMon";s:1:"0";s:7:"MotSelf";s:1:"0";s:7:"OthSmok";s:1:"0";}');$choice92->setNextQuestion(26);$choice92->setRenamedQuestion(NULL);$choice92->setHideQuestion(NULL);$this->em->persist($choice92);
        $choice93 = new Choice();$choice93->setId(97);$choice93->setQuestion($question22);$choice93->setName("Boire un boisson chaude");$choice93->setScoring('a:17:{s:1:"C";s:1:"0";s:1:"P";s:1:"0";s:1:"A";s:1:"0";s:1:"M";s:1:"0";s:3:"Beh";s:1:"0";s:5:"Ppath";s:1:"0";s:4:"Psoc";s:1:"0";s:4:"Phys";s:1:"0";s:3:"Rew";s:1:"0";s:3:"C/R";s:1:"0";s:10:"Fagerstrom";s:1:"0";s:8:"MotHPres";s:1:"0";s:7:"MotHFut";s:1:"0";s:6:"MotSoc";s:1:"0";s:6:"MotMon";s:1:"0";s:7:"MotSelf";s:1:"0";s:7:"OthSmok";s:1:"0";}');$choice93->setNextQuestion(26);$choice93->setRenamedQuestion(NULL);$choice93->setHideQuestion(NULL);$this->em->persist($choice93);
        $choice94 = new Choice();$choice94->setId(98);$choice94->setQuestion($question22);$choice94->setName("Une pause au travail ");$choice94->setScoring('a:17:{s:1:"C";s:1:"0";s:1:"P";s:1:"0";s:1:"A";s:1:"0";s:1:"M";s:1:"0";s:3:"Beh";s:1:"0";s:5:"Ppath";s:1:"0";s:4:"Psoc";s:1:"0";s:4:"Phys";s:1:"0";s:3:"Rew";s:1:"0";s:3:"C/R";s:1:"0";s:10:"Fagerstrom";s:1:"0";s:8:"MotHPres";s:1:"0";s:7:"MotHFut";s:1:"0";s:6:"MotSoc";s:1:"0";s:6:"MotMon";s:1:"0";s:7:"MotSelf";s:1:"0";s:7:"OthSmok";s:1:"0";}');$choice94->setNextQuestion(26);$choice94->setRenamedQuestion(NULL);$choice94->setHideQuestion(NULL);$this->em->persist($choice94);
        $choice95 = new Choice();$choice95->setId(99);$choice95->setQuestion($question22);$choice95->setName("Etre dans une situation où j'ai l'habitude de fumer");$choice95->setScoring('a:17:{s:1:"C";s:1:"0";s:1:"P";s:1:"0";s:1:"A";s:1:"0";s:1:"M";s:1:"0";s:3:"Beh";s:1:"0";s:5:"Ppath";s:1:"0";s:4:"Psoc";s:1:"0";s:4:"Phys";s:1:"0";s:3:"Rew";s:1:"0";s:3:"C/R";s:1:"0";s:10:"Fagerstrom";s:1:"0";s:8:"MotHPres";s:1:"0";s:7:"MotHFut";s:1:"0";s:6:"MotSoc";s:1:"0";s:6:"MotMon";s:1:"0";s:7:"MotSelf";s:1:"0";s:7:"OthSmok";s:1:"0";}');$choice95->setNextQuestion(26);$choice95->setRenamedQuestion(NULL);$choice95->setHideQuestion(NULL);$this->em->persist($choice95);
        $choice96 = new Choice();$choice96->setId(100);$choice96->setQuestion($question22);$choice96->setName("Voir quelqu'un d'autre fumer");$choice96->setScoring('a:17:{s:1:"C";s:1:"0";s:1:"P";s:1:"0";s:1:"A";s:1:"0";s:1:"M";s:1:"0";s:3:"Beh";s:1:"0";s:5:"Ppath";s:1:"0";s:4:"Psoc";s:1:"0";s:4:"Phys";s:1:"0";s:3:"Rew";s:1:"0";s:3:"C/R";s:1:"0";s:10:"Fagerstrom";s:1:"0";s:8:"MotHPres";s:1:"0";s:7:"MotHFut";s:1:"0";s:6:"MotSoc";s:1:"0";s:6:"MotMon";s:1:"0";s:7:"MotSelf";s:1:"0";s:7:"OthSmok";s:1:"0";}');$choice96->setNextQuestion(26);$choice96->setRenamedQuestion(NULL);$choice96->setHideQuestion(NULL);$this->em->persist($choice96);
        $choice97 = new Choice();$choice97->setId(101);$choice97->setQuestion($question22);$choice97->setName("Stress / anxieté");$choice97->setScoring('a:17:{s:1:"C";s:1:"0";s:1:"P";s:1:"0";s:1:"A";s:1:"0";s:1:"M";s:1:"0";s:3:"Beh";s:1:"0";s:5:"Ppath";s:1:"0";s:4:"Psoc";s:1:"0";s:4:"Phys";s:1:"0";s:3:"Rew";s:1:"0";s:3:"C/R";s:1:"0";s:10:"Fagerstrom";s:1:"0";s:8:"MotHPres";s:1:"0";s:7:"MotHFut";s:1:"0";s:6:"MotSoc";s:1:"0";s:6:"MotMon";s:1:"0";s:7:"MotSelf";s:1:"0";s:7:"OthSmok";s:1:"0";}');$choice97->setNextQuestion(26);$choice97->setRenamedQuestion(NULL);$choice97->setHideQuestion(NULL);$this->em->persist($choice97);
        $choice98 = new Choice();$choice98->setId(102);$choice98->setQuestion($question22);$choice98->setName("Le plaisir de fumer me manque");$choice98->setScoring('a:17:{s:1:"C";s:1:"0";s:1:"P";s:1:"0";s:1:"A";s:1:"0";s:1:"M";s:1:"0";s:3:"Beh";s:1:"0";s:5:"Ppath";s:1:"0";s:4:"Psoc";s:1:"0";s:4:"Phys";s:1:"0";s:3:"Rew";s:1:"0";s:3:"C/R";s:1:"0";s:10:"Fagerstrom";s:1:"0";s:8:"MotHPres";s:1:"0";s:7:"MotHFut";s:1:"0";s:6:"MotSoc";s:1:"0";s:6:"MotMon";s:1:"0";s:7:"MotSelf";s:1:"0";s:7:"OthSmok";s:1:"0";}');$choice98->setNextQuestion(26);$choice98->setRenamedQuestion(NULL);$choice98->setHideQuestion(NULL);$this->em->persist($choice98);
        $choice99 = new Choice();$choice99->setId(103);$choice99->setQuestion($question22);$choice99->setName("Autre / Je ne sais pas");$choice99->setScoring('a:17:{s:1:"C";s:1:"0";s:1:"P";s:1:"0";s:1:"A";s:1:"0";s:1:"M";s:1:"0";s:3:"Beh";s:1:"0";s:5:"Ppath";s:1:"0";s:4:"Psoc";s:1:"0";s:4:"Phys";s:1:"0";s:3:"Rew";s:1:"0";s:3:"C/R";s:1:"0";s:10:"Fagerstrom";s:1:"0";s:8:"MotHPres";s:1:"0";s:7:"MotHFut";s:1:"0";s:6:"MotSoc";s:1:"0";s:6:"MotMon";s:1:"0";s:7:"MotSelf";s:1:"0";s:7:"OthSmok";s:1:"0";}');$choice99->setNextQuestion(26);$choice99->setRenamedQuestion(NULL);$choice99->setHideQuestion(NULL);$this->em->persist($choice99);
        $choice100 = new Choice();$choice100->setId(104);$choice100->setQuestion($question23);$choice100->setName("OUI");$choice100->setScoring('a:17:{s:1:"C";s:1:"0";s:1:"P";s:1:"0";s:1:"A";s:1:"0";s:1:"M";s:1:"0";s:3:"Beh";s:1:"0";s:5:"Ppath";s:1:"0";s:4:"Psoc";s:1:"0";s:4:"Phys";s:1:"0";s:3:"Rew";s:1:"0";s:3:"C/R";s:1:"0";s:10:"Fagerstrom";s:1:"0";s:8:"MotHPres";s:1:"0";s:7:"MotHFut";s:1:"0";s:6:"MotSoc";s:1:"0";s:6:"MotMon";s:1:"0";s:7:"MotSelf";s:1:"0";s:7:"OthSmok";s:1:"0";}');$choice100->setNextQuestion(27);$choice100->setRenamedQuestion(NULL);$choice100->setHideQuestion(NULL);$this->em->persist($choice100);
        $choice101 = new Choice();$choice101->setId(105);$choice101->setQuestion($question23);$choice101->setName("NON");$choice101->setScoring('a:17:{s:1:"C";s:1:"0";s:1:"P";s:1:"0";s:1:"A";s:1:"0";s:1:"M";s:1:"0";s:3:"Beh";s:1:"0";s:5:"Ppath";s:1:"0";s:4:"Psoc";s:1:"0";s:4:"Phys";s:1:"0";s:3:"Rew";s:1:"0";s:3:"C/R";s:1:"0";s:10:"Fagerstrom";s:1:"0";s:8:"MotHPres";s:1:"0";s:7:"MotHFut";s:1:"0";s:6:"MotSoc";s:1:"0";s:6:"MotMon";s:1:"0";s:7:"MotSelf";s:1:"0";s:7:"OthSmok";s:1:"0";}');$choice101->setNextQuestion(27);$choice101->setRenamedQuestion(NULL);$choice101->setHideQuestion(NULL);$this->em->persist($choice101);
        $choice102 = new Choice();$choice102->setId(106);$choice102->setQuestion($question24);$choice102->setName("OUI");$choice102->setScoring('a:17:{s:1:"C";s:1:"0";s:1:"P";s:1:"0";s:1:"A";s:1:"0";s:1:"M";s:1:"0";s:3:"Beh";s:1:"0";s:5:"Ppath";s:1:"0";s:4:"Psoc";s:1:"0";s:4:"Phys";s:1:"0";s:3:"Rew";s:1:"0";s:3:"C/R";s:1:"0";s:10:"Fagerstrom";s:1:"0";s:8:"MotHPres";s:1:"0";s:7:"MotHFut";s:1:"0";s:6:"MotSoc";s:1:"0";s:6:"MotMon";s:1:"0";s:7:"MotSelf";s:1:"0";s:7:"OthSmok";s:1:"0";}');$choice102->setNextQuestion(NULL);$choice102->setRenamedQuestion(NULL);$choice102->setHideQuestion(NULL);$this->em->persist($choice102);
        $choice103 = new Choice();$choice103->setId(107);$choice103->setQuestion($question24);$choice103->setName("NON");$choice103->setScoring('a:17:{s:1:"C";s:1:"0";s:1:"P";s:1:"0";s:1:"A";s:1:"0";s:1:"M";s:1:"0";s:3:"Beh";s:1:"0";s:5:"Ppath";s:1:"0";s:4:"Psoc";s:1:"0";s:4:"Phys";s:1:"0";s:3:"Rew";s:1:"0";s:3:"C/R";s:1:"0";s:10:"Fagerstrom";s:1:"0";s:8:"MotHPres";s:1:"0";s:7:"MotHFut";s:1:"0";s:6:"MotSoc";s:1:"0";s:6:"MotMon";s:1:"0";s:7:"MotSelf";s:1:"0";s:7:"OthSmok";s:1:"0";}');$choice103->setNextQuestion(NULL);$choice103->setRenamedQuestion(NULL);$choice103->setHideQuestion(NULL);$this->em->persist($choice103);
        $choice104 = new Choice();$choice104->setId(108);$choice104->setQuestion($question25);$choice104->setName("Avoir terminé un repas");$choice104->setScoring('a:17:{s:1:"C";s:1:"0";s:1:"P";s:1:"0";s:1:"A";s:1:"0";s:1:"M";s:1:"0";s:3:"Beh";s:1:"0";s:5:"Ppath";s:1:"0";s:4:"Psoc";s:1:"0";s:4:"Phys";s:1:"0";s:3:"Rew";s:1:"0";s:3:"C/R";s:1:"0";s:10:"Fagerstrom";s:1:"0";s:8:"MotHPres";s:1:"0";s:7:"MotHFut";s:1:"0";s:6:"MotSoc";s:1:"0";s:6:"MotMon";s:1:"0";s:7:"MotSelf";s:1:"0";s:7:"OthSmok";s:1:"0";}');$choice104->setNextQuestion(29);$choice104->setRenamedQuestion(NULL);$choice104->setHideQuestion(NULL);$this->em->persist($choice104);
        $choice105 = new Choice();$choice105->setId(109);$choice105->setQuestion($question25);$choice105->setName("Boire un verre d'alcool");$choice105->setScoring('a:17:{s:1:"C";s:1:"0";s:1:"P";s:1:"0";s:1:"A";s:1:"0";s:1:"M";s:1:"0";s:3:"Beh";s:1:"0";s:5:"Ppath";s:1:"0";s:4:"Psoc";s:1:"0";s:4:"Phys";s:1:"0";s:3:"Rew";s:1:"0";s:3:"C/R";s:1:"0";s:10:"Fagerstrom";s:1:"0";s:8:"MotHPres";s:1:"0";s:7:"MotHFut";s:1:"0";s:6:"MotSoc";s:1:"0";s:6:"MotMon";s:1:"0";s:7:"MotSelf";s:1:"0";s:7:"OthSmok";s:1:"0";}');$choice105->setNextQuestion(29);$choice105->setRenamedQuestion(NULL);$choice105->setHideQuestion(NULL);$this->em->persist($choice105);
        $choice106 = new Choice();$choice106->setId(110);$choice106->setQuestion($question25);$choice106->setName("Boire un boisson chaude");$choice106->setScoring('a:17:{s:1:"C";s:1:"0";s:1:"P";s:1:"0";s:1:"A";s:1:"0";s:1:"M";s:1:"0";s:3:"Beh";s:1:"0";s:5:"Ppath";s:1:"0";s:4:"Psoc";s:1:"0";s:4:"Phys";s:1:"0";s:3:"Rew";s:1:"0";s:3:"C/R";s:1:"0";s:10:"Fagerstrom";s:1:"0";s:8:"MotHPres";s:1:"0";s:7:"MotHFut";s:1:"0";s:6:"MotSoc";s:1:"0";s:6:"MotMon";s:1:"0";s:7:"MotSelf";s:1:"0";s:7:"OthSmok";s:1:"0";}');$choice106->setNextQuestion(29);$choice106->setRenamedQuestion(NULL);$choice106->setHideQuestion(NULL);$this->em->persist($choice106);
        $choice107 = new Choice();$choice107->setId(111);$choice107->setQuestion($question25);$choice107->setName("Une pause au travail ");$choice107->setScoring('a:17:{s:1:"C";s:1:"0";s:1:"P";s:1:"0";s:1:"A";s:1:"0";s:1:"M";s:1:"0";s:3:"Beh";s:1:"0";s:5:"Ppath";s:1:"0";s:4:"Psoc";s:1:"0";s:4:"Phys";s:1:"0";s:3:"Rew";s:1:"0";s:3:"C/R";s:1:"0";s:10:"Fagerstrom";s:1:"0";s:8:"MotHPres";s:1:"0";s:7:"MotHFut";s:1:"0";s:6:"MotSoc";s:1:"0";s:6:"MotMon";s:1:"0";s:7:"MotSelf";s:1:"0";s:7:"OthSmok";s:1:"0";}');$choice107->setNextQuestion(29);$choice107->setRenamedQuestion(NULL);$choice107->setHideQuestion(NULL);$this->em->persist($choice107);
        $choice108 = new Choice();$choice108->setId(112);$choice108->setQuestion($question25);$choice108->setName("Etre dans une situation où j'ai l'habitude de fumer");$choice108->setScoring('a:17:{s:1:"C";s:1:"0";s:1:"P";s:1:"0";s:1:"A";s:1:"0";s:1:"M";s:1:"0";s:3:"Beh";s:1:"0";s:5:"Ppath";s:1:"0";s:4:"Psoc";s:1:"0";s:4:"Phys";s:1:"0";s:3:"Rew";s:1:"0";s:3:"C/R";s:1:"0";s:10:"Fagerstrom";s:1:"0";s:8:"MotHPres";s:1:"0";s:7:"MotHFut";s:1:"0";s:6:"MotSoc";s:1:"0";s:6:"MotMon";s:1:"0";s:7:"MotSelf";s:1:"0";s:7:"OthSmok";s:1:"0";}');$choice108->setNextQuestion(29);$choice108->setRenamedQuestion(NULL);$choice108->setHideQuestion(NULL);$this->em->persist($choice108);
        $choice109 = new Choice();$choice109->setId(113);$choice109->setQuestion($question25);$choice109->setName(" Voir quelqu'un d'autre fumer");$choice109->setScoring('a:17:{s:1:"C";s:1:"0";s:1:"P";s:1:"0";s:1:"A";s:1:"0";s:1:"M";s:1:"0";s:3:"Beh";s:1:"0";s:5:"Ppath";s:1:"0";s:4:"Psoc";s:1:"0";s:4:"Phys";s:1:"0";s:3:"Rew";s:1:"0";s:3:"C/R";s:1:"0";s:10:"Fagerstrom";s:1:"0";s:8:"MotHPres";s:1:"0";s:7:"MotHFut";s:1:"0";s:6:"MotSoc";s:1:"0";s:6:"MotMon";s:1:"0";s:7:"MotSelf";s:1:"0";s:7:"OthSmok";s:1:"0";}');$choice109->setNextQuestion(29);$choice109->setRenamedQuestion(NULL);$choice109->setHideQuestion(NULL);$this->em->persist($choice109);
        $choice110 = new Choice();$choice110->setId(114);$choice110->setQuestion($question25);$choice110->setName("Stress / anxieté");$choice110->setScoring('a:17:{s:1:"C";s:1:"0";s:1:"P";s:1:"0";s:1:"A";s:1:"0";s:1:"M";s:1:"0";s:3:"Beh";s:1:"0";s:5:"Ppath";s:1:"0";s:4:"Psoc";s:1:"0";s:4:"Phys";s:1:"0";s:3:"Rew";s:1:"0";s:3:"C/R";s:1:"0";s:10:"Fagerstrom";s:1:"0";s:8:"MotHPres";s:1:"0";s:7:"MotHFut";s:1:"0";s:6:"MotSoc";s:1:"0";s:6:"MotMon";s:1:"0";s:7:"MotSelf";s:1:"0";s:7:"OthSmok";s:1:"0";}');$choice110->setNextQuestion(29);$choice110->setRenamedQuestion(NULL);$choice110->setHideQuestion(NULL);$this->em->persist($choice110);
        $choice111 = new Choice();$choice111->setId(115);$choice111->setQuestion($question25);$choice111->setName("Le plaisir de fumer me manque");$choice111->setScoring('a:17:{s:1:"C";s:1:"0";s:1:"P";s:1:"0";s:1:"A";s:1:"0";s:1:"M";s:1:"0";s:3:"Beh";s:1:"0";s:5:"Ppath";s:1:"0";s:4:"Psoc";s:1:"0";s:4:"Phys";s:1:"0";s:3:"Rew";s:1:"0";s:3:"C/R";s:1:"0";s:10:"Fagerstrom";s:1:"0";s:8:"MotHPres";s:1:"0";s:7:"MotHFut";s:1:"0";s:6:"MotSoc";s:1:"0";s:6:"MotMon";s:1:"0";s:7:"MotSelf";s:1:"0";s:7:"OthSmok";s:1:"0";}');$choice111->setNextQuestion(29);$choice111->setRenamedQuestion(NULL);$choice111->setHideQuestion(NULL);$this->em->persist($choice111);
        $choice112 = new Choice();$choice112->setId(116);$choice112->setQuestion($question25);$choice112->setName("Autre / Je ne sais pas");$choice112->setScoring('a:17:{s:1:"C";s:1:"0";s:1:"P";s:1:"0";s:1:"A";s:1:"0";s:1:"M";s:1:"0";s:3:"Beh";s:1:"0";s:5:"Ppath";s:1:"0";s:4:"Psoc";s:1:"0";s:4:"Phys";s:1:"0";s:3:"Rew";s:1:"0";s:3:"C/R";s:1:"0";s:10:"Fagerstrom";s:1:"0";s:8:"MotHPres";s:1:"0";s:7:"MotHFut";s:1:"0";s:6:"MotSoc";s:1:"0";s:6:"MotMon";s:1:"0";s:7:"MotSelf";s:1:"0";s:7:"OthSmok";s:1:"0";}');$choice112->setNextQuestion(29);$choice112->setRenamedQuestion(NULL);$choice112->setHideQuestion(NULL);$this->em->persist($choice112);
        $choice113 = new Choice();$choice113->setId(117);$choice113->setQuestion($question26);$choice113->setName("OUI");$choice113->setScoring('a:17:{s:1:"C";s:1:"0";s:1:"P";s:1:"0";s:1:"A";s:1:"0";s:1:"M";s:1:"0";s:3:"Beh";s:1:"0";s:5:"Ppath";s:1:"0";s:4:"Psoc";s:1:"0";s:4:"Phys";s:1:"0";s:3:"Rew";s:1:"0";s:3:"C/R";s:1:"0";s:10:"Fagerstrom";s:1:"0";s:8:"MotHPres";s:1:"0";s:7:"MotHFut";s:1:"0";s:6:"MotSoc";s:1:"0";s:6:"MotMon";s:1:"0";s:7:"MotSelf";s:1:"0";s:7:"OthSmok";s:1:"0";}');$choice113->setNextQuestion(30);$choice113->setRenamedQuestion(NULL);$choice113->setHideQuestion(NULL);$this->em->persist($choice113);
        $choice114 = new Choice();$choice114->setId(118);$choice114->setQuestion($question26);$choice114->setName("NON");$choice114->setScoring('a:17:{s:1:"C";s:1:"0";s:1:"P";s:1:"0";s:1:"A";s:1:"0";s:1:"M";s:1:"0";s:3:"Beh";s:1:"0";s:5:"Ppath";s:1:"0";s:4:"Psoc";s:1:"0";s:4:"Phys";s:1:"0";s:3:"Rew";s:1:"0";s:3:"C/R";s:1:"0";s:10:"Fagerstrom";s:1:"0";s:8:"MotHPres";s:1:"0";s:7:"MotHFut";s:1:"0";s:6:"MotSoc";s:1:"0";s:6:"MotMon";s:1:"0";s:7:"MotSelf";s:1:"0";s:7:"OthSmok";s:1:"0";}');$choice114->setNextQuestion(30);$choice114->setRenamedQuestion(NULL);$choice114->setHideQuestion(NULL);$this->em->persist($choice114);
        $choice115 = new Choice();$choice115->setId(119);$choice115->setQuestion($question27);$choice115->setName("OUI");$choice115->setScoring('a:17:{s:1:"C";s:1:"0";s:1:"P";s:1:"0";s:1:"A";s:1:"0";s:1:"M";s:1:"0";s:3:"Beh";s:1:"0";s:5:"Ppath";s:1:"0";s:4:"Psoc";s:1:"0";s:4:"Phys";s:1:"0";s:3:"Rew";s:1:"0";s:3:"C/R";s:1:"0";s:10:"Fagerstrom";s:1:"0";s:8:"MotHPres";s:1:"0";s:7:"MotHFut";s:1:"0";s:6:"MotSoc";s:1:"0";s:6:"MotMon";s:1:"0";s:7:"MotSelf";s:1:"0";s:7:"OthSmok";s:1:"0";}');$choice115->setNextQuestion(NULL);$choice115->setRenamedQuestion(NULL);$choice115->setHideQuestion(NULL);$this->em->persist($choice115);
        $choice116 = new Choice();$choice116->setId(120);$choice116->setQuestion($question27);$choice116->setName("NON");$choice116->setScoring('a:17:{s:1:"C";s:1:"0";s:1:"P";s:1:"0";s:1:"A";s:1:"0";s:1:"M";s:1:"0";s:3:"Beh";s:1:"0";s:5:"Ppath";s:1:"0";s:4:"Psoc";s:1:"0";s:4:"Phys";s:1:"0";s:3:"Rew";s:1:"0";s:3:"C/R";s:1:"0";s:10:"Fagerstrom";s:1:"0";s:8:"MotHPres";s:1:"0";s:7:"MotHFut";s:1:"0";s:6:"MotSoc";s:1:"0";s:6:"MotMon";s:1:"0";s:7:"MotSelf";s:1:"0";s:7:"OthSmok";s:1:"0";}');$choice116->setNextQuestion(NULL);$choice116->setRenamedQuestion(NULL);$choice116->setHideQuestion(NULL);$this->em->persist($choice116);
        $choice117 = new Choice();$choice117->setId(121);$choice117->setQuestion($question28);$choice117->setName("Au réveil");$choice117->setScoring('a:17:{s:1:"C";s:1:"0";s:1:"P";s:1:"0";s:1:"A";s:1:"0";s:1:"M";s:1:"0";s:3:"Beh";s:1:"0";s:5:"Ppath";s:1:"0";s:4:"Psoc";s:1:"0";s:4:"Phys";s:1:"0";s:3:"Rew";s:1:"0";s:3:"C/R";s:1:"0";s:10:"Fagerstrom";s:1:"0";s:8:"MotHPres";s:1:"0";s:7:"MotHFut";s:1:"0";s:6:"MotSoc";s:1:"0";s:6:"MotMon";s:1:"0";s:7:"MotSelf";s:1:"0";s:7:"OthSmok";s:1:"0";}');$choice117->setNextQuestion(32);$choice117->setRenamedQuestion(NULL);$choice117->setHideQuestion(NULL);$this->em->persist($choice117);
        $choice118 = new Choice();$choice118->setId(122);$choice118->setQuestion($question28);$choice118->setName("Le matin");$choice118->setScoring('a:17:{s:1:"C";s:1:"0";s:1:"P";s:1:"0";s:1:"A";s:1:"0";s:1:"M";s:1:"0";s:3:"Beh";s:1:"0";s:5:"Ppath";s:1:"0";s:4:"Psoc";s:1:"0";s:4:"Phys";s:1:"0";s:3:"Rew";s:1:"0";s:3:"C/R";s:1:"0";s:10:"Fagerstrom";s:1:"0";s:8:"MotHPres";s:1:"0";s:7:"MotHFut";s:1:"0";s:6:"MotSoc";s:1:"0";s:6:"MotMon";s:1:"0";s:7:"MotSelf";s:1:"0";s:7:"OthSmok";s:1:"0";}');$choice118->setNextQuestion(32);$choice118->setRenamedQuestion(NULL);$choice118->setHideQuestion(NULL);$this->em->persist($choice118);
        $choice119 = new Choice();$choice119->setId(123);$choice119->setQuestion($question28);$choice119->setName("A midi");$choice119->setScoring('a:17:{s:1:"C";s:1:"0";s:1:"P";s:1:"0";s:1:"A";s:1:"0";s:1:"M";s:1:"0";s:3:"Beh";s:1:"0";s:5:"Ppath";s:1:"0";s:4:"Psoc";s:1:"0";s:4:"Phys";s:1:"0";s:3:"Rew";s:1:"0";s:3:"C/R";s:1:"0";s:10:"Fagerstrom";s:1:"0";s:8:"MotHPres";s:1:"0";s:7:"MotHFut";s:1:"0";s:6:"MotSoc";s:1:"0";s:6:"MotMon";s:1:"0";s:7:"MotSelf";s:1:"0";s:7:"OthSmok";s:1:"0";}');$choice119->setNextQuestion(32);$choice119->setRenamedQuestion(NULL);$choice119->setHideQuestion(NULL);$this->em->persist($choice119);
        $choice120 = new Choice();$choice120->setId(124);$choice120->setQuestion($question28);$choice120->setName("Dans l'après-midi");$choice120->setScoring('a:17:{s:1:"C";s:1:"0";s:1:"P";s:1:"0";s:1:"A";s:1:"0";s:1:"M";s:1:"0";s:3:"Beh";s:1:"0";s:5:"Ppath";s:1:"0";s:4:"Psoc";s:1:"0";s:4:"Phys";s:1:"0";s:3:"Rew";s:1:"0";s:3:"C/R";s:1:"0";s:10:"Fagerstrom";s:1:"0";s:8:"MotHPres";s:1:"0";s:7:"MotHFut";s:1:"0";s:6:"MotSoc";s:1:"0";s:6:"MotMon";s:1:"0";s:7:"MotSelf";s:1:"0";s:7:"OthSmok";s:1:"0";}');$choice120->setNextQuestion(32);$choice120->setRenamedQuestion(NULL);$choice120->setHideQuestion(NULL);$this->em->persist($choice120);
        $choice121 = new Choice();$choice121->setId(125);$choice121->setQuestion($question28);$choice121->setName("En soirée");$choice121->setScoring('a:17:{s:1:"C";s:1:"0";s:1:"P";s:1:"0";s:1:"A";s:1:"0";s:1:"M";s:1:"0";s:3:"Beh";s:1:"0";s:5:"Ppath";s:1:"0";s:4:"Psoc";s:1:"0";s:4:"Phys";s:1:"0";s:3:"Rew";s:1:"0";s:3:"C/R";s:1:"0";s:10:"Fagerstrom";s:1:"0";s:8:"MotHPres";s:1:"0";s:7:"MotHFut";s:1:"0";s:6:"MotSoc";s:1:"0";s:6:"MotMon";s:1:"0";s:7:"MotSelf";s:1:"0";s:7:"OthSmok";s:1:"0";}');$choice121->setNextQuestion(32);$choice121->setRenamedQuestion(NULL);$choice121->setHideQuestion(NULL);$this->em->persist($choice121);
        $choice122 = new Choice();$choice122->setId(126);$choice122->setQuestion($question29);$choice122->setName("Avoir terminé un repas");$choice122->setScoring('a:17:{s:1:"C";s:1:"0";s:1:"P";s:1:"0";s:1:"A";s:1:"0";s:1:"M";s:1:"0";s:3:"Beh";s:1:"0";s:5:"Ppath";s:1:"0";s:4:"Psoc";s:1:"0";s:4:"Phys";s:1:"0";s:3:"Rew";s:1:"0";s:3:"C/R";s:1:"0";s:10:"Fagerstrom";s:1:"0";s:8:"MotHPres";s:1:"0";s:7:"MotHFut";s:1:"0";s:6:"MotSoc";s:1:"0";s:6:"MotMon";s:1:"0";s:7:"MotSelf";s:1:"0";s:7:"OthSmok";s:1:"0";}');$choice122->setNextQuestion(NULL);$choice122->setRenamedQuestion(NULL);$choice122->setHideQuestion(NULL);$this->em->persist($choice122);
        $choice123 = new Choice();$choice123->setId(127);$choice123->setQuestion($question29);$choice123->setName("Boire un verre d'alcool");$choice123->setScoring('a:17:{s:1:"C";s:1:"0";s:1:"P";s:1:"0";s:1:"A";s:1:"0";s:1:"M";s:1:"0";s:3:"Beh";s:1:"0";s:5:"Ppath";s:1:"0";s:4:"Psoc";s:1:"0";s:4:"Phys";s:1:"0";s:3:"Rew";s:1:"0";s:3:"C/R";s:1:"0";s:10:"Fagerstrom";s:1:"0";s:8:"MotHPres";s:1:"0";s:7:"MotHFut";s:1:"0";s:6:"MotSoc";s:1:"0";s:6:"MotMon";s:1:"0";s:7:"MotSelf";s:1:"0";s:7:"OthSmok";s:1:"0";}');$choice123->setNextQuestion(NULL);$choice123->setRenamedQuestion(NULL);$choice123->setHideQuestion(NULL);$this->em->persist($choice123);
        $choice124 = new Choice();$choice124->setId(128);$choice124->setQuestion($question29);$choice124->setName("Boire un boisson chaude");$choice124->setScoring('a:17:{s:1:"C";s:1:"0";s:1:"P";s:1:"0";s:1:"A";s:1:"0";s:1:"M";s:1:"0";s:3:"Beh";s:1:"0";s:5:"Ppath";s:1:"0";s:4:"Psoc";s:1:"0";s:4:"Phys";s:1:"0";s:3:"Rew";s:1:"0";s:3:"C/R";s:1:"0";s:10:"Fagerstrom";s:1:"0";s:8:"MotHPres";s:1:"0";s:7:"MotHFut";s:1:"0";s:6:"MotSoc";s:1:"0";s:6:"MotMon";s:1:"0";s:7:"MotSelf";s:1:"0";s:7:"OthSmok";s:1:"0";}');$choice124->setNextQuestion(NULL);$choice124->setRenamedQuestion(NULL);$choice124->setHideQuestion(NULL);$this->em->persist($choice124);
        $choice125 = new Choice();$choice125->setId(129);$choice125->setQuestion($question29);$choice125->setName("Une pause au travail ");$choice125->setScoring('a:17:{s:1:"C";s:1:"0";s:1:"P";s:1:"0";s:1:"A";s:1:"0";s:1:"M";s:1:"0";s:3:"Beh";s:1:"0";s:5:"Ppath";s:1:"0";s:4:"Psoc";s:1:"0";s:4:"Phys";s:1:"0";s:3:"Rew";s:1:"0";s:3:"C/R";s:1:"0";s:10:"Fagerstrom";s:1:"0";s:8:"MotHPres";s:1:"0";s:7:"MotHFut";s:1:"0";s:6:"MotSoc";s:1:"0";s:6:"MotMon";s:1:"0";s:7:"MotSelf";s:1:"0";s:7:"OthSmok";s:1:"0";}');$choice125->setNextQuestion(NULL, NULL, NULL);$this->em->persist($choice125);
        $choice126 = new Choice();$choice126->setId(130);$choice126->setQuestion($question29);$choice126->setName("Etre dans une situation où j'ai l'habitude de fumer");$choice126->setScoring('a:17:{s:1:"C";s:1:"0";s:1:"P";s:1:"0";s:1:"A";s:1:"0";s:1:"M";s:1:"0";s:3:"Beh";s:1:"0";s:5:"Ppath";s:1:"0";s:4:"Psoc";s:1:"0";s:4:"Phys";s:1:"0";s:3:"Rew";s:1:"0";s:3:"C/R";s:1:"0";s:10:"Fagerstrom";s:1:"0";s:8:"MotHPres";s:1:"0";s:7:"MotHFut";s:1:"0";s:6:"MotSoc";s:1:"0";s:6:"MotMon";s:1:"0";s:7:"MotSelf";s:1:"0";s:7:"OthSmok";s:1:"0";}');$choice126->setNextQuestion(NULL);$choice126->setRenamedQuestion(NULL);$choice126->setHideQuestion(NULL);$this->em->persist($choice126);
        $choice127 = new Choice();$choice127->setId(131);$choice127->setQuestion($question29);$choice127->setName(" Voir quelqu'un d'autre fumer");$choice127->setScoring('a:17:{s:1:"C";s:1:"0";s:1:"P";s:1:"0";s:1:"A";s:1:"0";s:1:"M";s:1:"0";s:3:"Beh";s:1:"0";s:5:"Ppath";s:1:"0";s:4:"Psoc";s:1:"0";s:4:"Phys";s:1:"0";s:3:"Rew";s:1:"0";s:3:"C/R";s:1:"0";s:10:"Fagerstrom";s:1:"0";s:8:"MotHPres";s:1:"0";s:7:"MotHFut";s:1:"0";s:6:"MotSoc";s:1:"0";s:6:"MotMon";s:1:"0";s:7:"MotSelf";s:1:"0";s:7:"OthSmok";s:1:"0";}');$choice127->setNextQuestion(NULL);$choice127->setRenamedQuestion(NULL);$choice127->setHideQuestion(NULL);$this->em->persist($choice127);
        $choice128 = new Choice();$choice128->setId(132);$choice128->setQuestion($question29);$choice128->setName("Stress / anxieté");$choice128->setScoring('a:17:{s:1:"C";s:1:"0";s:1:"P";s:1:"0";s:1:"A";s:1:"0";s:1:"M";s:1:"0";s:3:"Beh";s:1:"0";s:5:"Ppath";s:1:"0";s:4:"Psoc";s:1:"0";s:4:"Phys";s:1:"0";s:3:"Rew";s:1:"0";s:3:"C/R";s:1:"0";s:10:"Fagerstrom";s:1:"0";s:8:"MotHPres";s:1:"0";s:7:"MotHFut";s:1:"0";s:6:"MotSoc";s:1:"0";s:6:"MotMon";s:1:"0";s:7:"MotSelf";s:1:"0";s:7:"OthSmok";s:1:"0";}');$choice128->setNextQuestion(NULL);$choice128->setRenamedQuestion(NULL);$choice128->setHideQuestion(NULL);$this->em->persist($choice128);
        $choice129 = new Choice();$choice129->setId(133);$choice129->setQuestion($question29);$choice129->setName("Le plaisir de fumer me manque");$choice129->setScoring('a:17:{s:1:"C";s:1:"0";s:1:"P";s:1:"0";s:1:"A";s:1:"0";s:1:"M";s:1:"0";s:3:"Beh";s:1:"0";s:5:"Ppath";s:1:"0";s:4:"Psoc";s:1:"0";s:4:"Phys";s:1:"0";s:3:"Rew";s:1:"0";s:3:"C/R";s:1:"0";s:10:"Fagerstrom";s:1:"0";s:8:"MotHPres";s:1:"0";s:7:"MotHFut";s:1:"0";s:6:"MotSoc";s:1:"0";s:6:"MotMon";s:1:"0";s:7:"MotSelf";s:1:"0";s:7:"OthSmok";s:1:"0";}');$choice129->setNextQuestion(NULL);$choice129->setRenamedQuestion(NULL);$choice129->setHideQuestion(NULL);$this->em->persist($choice129);
        $choice130 = new Choice();$choice130->setId(134);$choice130->setQuestion($question29);$choice130->setName("Autre / Je ne sais pas");$choice130->setScoring('a:17:{s:1:"C";s:1:"0";s:1:"P";s:1:"0";s:1:"A";s:1:"0";s:1:"M";s:1:"0";s:3:"Beh";s:1:"0";s:5:"Ppath";s:1:"0";s:4:"Psoc";s:1:"0";s:4:"Phys";s:1:"0";s:3:"Rew";s:1:"0";s:3:"C/R";s:1:"0";s:10:"Fagerstrom";s:1:"0";s:8:"MotHPres";s:1:"0";s:7:"MotHFut";s:1:"0";s:6:"MotSoc";s:1:"0";s:6:"MotMon";s:1:"0";s:7:"MotSelf";s:1:"0";s:7:"OthSmok";s:1:"0";}');$choice130->setNextQuestion(NULL);$choice130->setRenamedQuestion(NULL);$choice130->setHideQuestion(NULL);$this->em->persist($choice130);
        $choice131 = new Choice();$choice131->setId(135);$choice131->setQuestion($question30);$choice131->setName("J'essayais juste le programme, je ne suis pas encore prêt(e) ");$choice131->setScoring('a:17:{s:1:"C";s:1:"0";s:1:"P";s:1:"0";s:1:"A";s:1:"0";s:1:"M";s:1:"0";s:3:"Beh";s:1:"0";s:5:"Ppath";s:1:"0";s:4:"Psoc";s:1:"0";s:4:"Phys";s:1:"0";s:3:"Rew";s:1:"0";s:3:"C/R";s:1:"0";s:10:"Fagerstrom";s:1:"0";s:8:"MotHPres";s:1:"0";s:7:"MotHFut";s:1:"0";s:6:"MotSoc";s:1:"0";s:6:"MotMon";s:1:"0";s:7:"MotSelf";s:1:"0";s:7:"OthSmok";s:1:"0";}');$choice131->setNextQuestion(34);$choice131->setRenamedQuestion(NULL);$choice131->setHideQuestion(NULL);$this->em->persist($choice131);
        $choice132 = new Choice();$choice132->setId(136);$choice132->setQuestion($question30);$choice132->setName("Je ne pense pas avoir assez de volonté pour arrêter de fumer");$choice132->setScoring('a:17:{s:1:"C";s:1:"0";s:1:"P";s:1:"0";s:1:"A";s:1:"0";s:1:"M";s:1:"0";s:3:"Beh";s:1:"0";s:5:"Ppath";s:1:"0";s:4:"Psoc";s:1:"0";s:4:"Phys";s:1:"0";s:3:"Rew";s:1:"0";s:3:"C/R";s:1:"0";s:10:"Fagerstrom";s:1:"0";s:8:"MotHPres";s:1:"0";s:7:"MotHFut";s:1:"0";s:6:"MotSoc";s:1:"0";s:6:"MotMon";s:1:"0";s:7:"MotSelf";s:1:"0";s:7:"OthSmok";s:1:"0";}');$choice132->setNextQuestion(34);$choice132->setRenamedQuestion(NULL);$choice132->setHideQuestion(NULL);$this->em->persist($choice132);
        $choice133 = new Choice();$choice133->setId(137);$choice133->setQuestion($question30);$choice133->setName(" Je me trouve trop irritable");$choice133->setScoring('a:17:{s:1:"C";s:1:"0";s:1:"P";s:1:"0";s:1:"A";s:1:"0";s:1:"M";s:1:"0";s:3:"Beh";s:1:"0";s:5:"Ppath";s:1:"0";s:4:"Psoc";s:1:"0";s:4:"Phys";s:1:"0";s:3:"Rew";s:1:"0";s:3:"C/R";s:1:"0";s:10:"Fagerstrom";s:1:"0";s:8:"MotHPres";s:1:"0";s:7:"MotHFut";s:1:"0";s:6:"MotSoc";s:1:"0";s:6:"MotMon";s:1:"0";s:7:"MotSelf";s:1:"0";s:7:"OthSmok";s:1:"0";}');$choice133->setNextQuestion(34);$choice133->setRenamedQuestion(NULL);$choice133->setHideQuestion(NULL);$this->em->persist($choice133);
        $choice134 = new Choice();$choice134->setId(138);$choice134->setQuestion($question30);$choice134->setName("Le programme ne me convient pas");$choice134->setScoring('a:17:{s:1:"C";s:1:"0";s:1:"P";s:1:"0";s:1:"A";s:1:"0";s:1:"M";s:1:"0";s:3:"Beh";s:1:"0";s:5:"Ppath";s:1:"0";s:4:"Psoc";s:1:"0";s:4:"Phys";s:1:"0";s:3:"Rew";s:1:"0";s:3:"C/R";s:1:"0";s:10:"Fagerstrom";s:1:"0";s:8:"MotHPres";s:1:"0";s:7:"MotHFut";s:1:"0";s:6:"MotSoc";s:1:"0";s:6:"MotMon";s:1:"0";s:7:"MotSelf";s:1:"0";s:7:"OthSmok";s:1:"0";}');$choice134->setNextQuestion(36);$choice134->setRenamedQuestion(NULL);$choice134->setHideQuestion(NULL);$this->em->persist($choice134);
        $choice135 = new Choice();$choice135->setId(139);$choice135->setQuestion($question30);$choice135->setName("J'aime bien fumer avec des amis");$choice135->setScoring('a:17:{s:1:"C";s:1:"0";s:1:"P";s:1:"0";s:1:"A";s:1:"0";s:1:"M";s:1:"0";s:3:"Beh";s:1:"0";s:5:"Ppath";s:1:"0";s:4:"Psoc";s:1:"0";s:4:"Phys";s:1:"0";s:3:"Rew";s:1:"0";s:3:"C/R";s:1:"0";s:10:"Fagerstrom";s:1:"0";s:8:"MotHPres";s:1:"0";s:7:"MotHFut";s:1:"0";s:6:"MotSoc";s:1:"0";s:6:"MotMon";s:1:"0";s:7:"MotSelf";s:1:"0";s:7:"OthSmok";s:1:"0";}');$choice135->setNextQuestion(34);$choice135->setRenamedQuestion(NULL);$choice135->setHideQuestion(NULL);$this->em->persist($choice135);
        $choice136 = new Choice();$choice136->setId(140);$choice136->setQuestion($question30);$choice136->setName("Je veux contrôler mon poids.");$choice136->setScoring('a:17:{s:1:"C";s:1:"0";s:1:"P";s:1:"0";s:1:"A";s:1:"0";s:1:"M";s:1:"0";s:3:"Beh";s:1:"0";s:5:"Ppath";s:1:"0";s:4:"Psoc";s:1:"0";s:4:"Phys";s:1:"0";s:3:"Rew";s:1:"0";s:3:"C/R";s:1:"0";s:10:"Fagerstrom";s:1:"0";s:8:"MotHPres";s:1:"0";s:7:"MotHFut";s:1:"0";s:6:"MotSoc";s:1:"0";s:6:"MotMon";s:1:"0";s:7:"MotSelf";s:1:"0";s:7:"OthSmok";s:1:"0";}');$choice136->setNextQuestion(34);$choice136->setRenamedQuestion(NULL);$choice136->setHideQuestion(NULL);$this->em->persist($choice136);
        $choice137 = new Choice();$choice137->setId(141);$choice137->setQuestion($question30);$choice137->setName("Autre ");$choice137->setScoring('a:17:{s:1:"C";s:1:"0";s:1:"P";s:1:"0";s:1:"A";s:1:"0";s:1:"M";s:1:"0";s:3:"Beh";s:1:"0";s:5:"Ppath";s:1:"0";s:4:"Psoc";s:1:"0";s:4:"Phys";s:1:"0";s:3:"Rew";s:1:"0";s:3:"C/R";s:1:"0";s:10:"Fagerstrom";s:1:"0";s:8:"MotHPres";s:1:"0";s:7:"MotHFut";s:1:"0";s:6:"MotSoc";s:1:"0";s:6:"MotMon";s:1:"0";s:7:"MotSelf";s:1:"0";s:7:"OthSmok";s:1:"0";}');$choice137->setNextQuestion(34);$choice137->setRenamedQuestion(NULL);$choice137->setHideQuestion(NULL);$this->em->persist($choice137);
        $choice138 = new Choice();$choice138->setId(142);$choice138->setQuestion($question31);$choice138->setName("OUI");$choice138->setScoring('a:17:{s:1:"C";s:1:"0";s:1:"P";s:1:"0";s:1:"A";s:1:"0";s:1:"M";s:1:"0";s:3:"Beh";s:1:"0";s:5:"Ppath";s:1:"0";s:4:"Psoc";s:1:"0";s:4:"Phys";s:1:"0";s:3:"Rew";s:1:"0";s:3:"C/R";s:1:"0";s:10:"Fagerstrom";s:1:"0";s:8:"MotHPres";s:1:"0";s:7:"MotHFut";s:1:"0";s:6:"MotSoc";s:1:"0";s:6:"MotMon";s:1:"0";s:7:"MotSelf";s:1:"0";s:7:"OthSmok";s:1:"0";}');$choice138->setNextQuestion(35);$choice138->setRenamedQuestion(NULL);$choice138->setHideQuestion(NULL);$this->em->persist($choice138);
        $choice139 = new Choice();$choice139->setId(143);$choice139->setQuestion($question31);$choice139->setName("NON");$choice139->setScoring('a:17:{s:1:"C";s:1:"0";s:1:"P";s:1:"0";s:1:"A";s:1:"0";s:1:"M";s:1:"0";s:3:"Beh";s:1:"0";s:5:"Ppath";s:1:"0";s:4:"Psoc";s:1:"0";s:4:"Phys";s:1:"0";s:3:"Rew";s:1:"0";s:3:"C/R";s:1:"0";s:10:"Fagerstrom";s:1:"0";s:8:"MotHPres";s:1:"0";s:7:"MotHFut";s:1:"0";s:6:"MotSoc";s:1:"0";s:6:"MotMon";s:1:"0";s:7:"MotSelf";s:1:"0";s:7:"OthSmok";s:1:"0";}');$choice139->setNextQuestion(35);$choice139->setRenamedQuestion(NULL);$choice139->setHideQuestion(NULL);$this->em->persist($choice139);
        $choice140 = new Choice();$choice140->setId(144);$choice140->setQuestion($question32);$choice140->setName("OUI");$choice140->setScoring('a:17:{s:1:"C";s:1:"0";s:1:"P";s:1:"0";s:1:"A";s:1:"0";s:1:"M";s:1:"0";s:3:"Beh";s:1:"0";s:5:"Ppath";s:1:"0";s:4:"Psoc";s:1:"0";s:4:"Phys";s:1:"0";s:3:"Rew";s:1:"0";s:3:"C/R";s:1:"0";s:10:"Fagerstrom";s:1:"0";s:8:"MotHPres";s:1:"0";s:7:"MotHFut";s:1:"0";s:6:"MotSoc";s:1:"0";s:6:"MotMon";s:1:"0";s:7:"MotSelf";s:1:"0";s:7:"OthSmok";s:1:"0";}');$choice140->setNextQuestion(36);$choice140->setRenamedQuestion(NULL);$choice140->setHideQuestion(NULL);$this->em->persist($choice140);
        $choice141 = new Choice();$choice141->setId(145);$choice141->setQuestion($question32);$choice141->setName("NON");$choice141->setScoring('a:17:{s:1:"C";s:1:"0";s:1:"P";s:1:"0";s:1:"A";s:1:"0";s:1:"M";s:1:"0";s:3:"Beh";s:1:"0";s:5:"Ppath";s:1:"0";s:4:"Psoc";s:1:"0";s:4:"Phys";s:1:"0";s:3:"Rew";s:1:"0";s:3:"C/R";s:1:"0";s:10:"Fagerstrom";s:1:"0";s:8:"MotHPres";s:1:"0";s:7:"MotHFut";s:1:"0";s:6:"MotSoc";s:1:"0";s:6:"MotMon";s:1:"0";s:7:"MotSelf";s:1:"0";s:7:"OthSmok";s:1:"0";}');$choice141->setNextQuestion(36);$choice141->setRenamedQuestion(NULL);$choice141->setHideQuestion(NULL);$this->em->persist($choice141);
        $choice142 = new Choice();$choice142->setId(146);$choice142->setQuestion($question33);$choice142->setName("OUI");$choice142->setScoring('a:17:{s:1:"C";s:1:"0";s:1:"P";s:1:"0";s:1:"A";s:1:"0";s:1:"M";s:1:"0";s:3:"Beh";s:1:"0";s:5:"Ppath";s:1:"0";s:4:"Psoc";s:1:"0";s:4:"Phys";s:1:"0";s:3:"Rew";s:1:"0";s:3:"C/R";s:1:"0";s:10:"Fagerstrom";s:1:"0";s:8:"MotHPres";s:1:"0";s:7:"MotHFut";s:1:"0";s:6:"MotSoc";s:1:"0";s:6:"MotMon";s:1:"0";s:7:"MotSelf";s:1:"0";s:7:"OthSmok";s:1:"0";}');$choice142->setNextQuestion(37);$choice142->setRenamedQuestion(NULL);$choice142->setHideQuestion(NULL);$this->em->persist($choice142);
        $choice143 = new Choice();$choice143->setId(147);$choice143->setQuestion($question33);$choice143->setName("NON");$choice143->setScoring('a:17:{s:1:"C";s:1:"0";s:1:"P";s:1:"0";s:1:"A";s:1:"0";s:1:"M";s:1:"0";s:3:"Beh";s:1:"0";s:5:"Ppath";s:1:"0";s:4:"Psoc";s:1:"0";s:4:"Phys";s:1:"0";s:3:"Rew";s:1:"0";s:3:"C/R";s:1:"0";s:10:"Fagerstrom";s:1:"0";s:8:"MotHPres";s:1:"0";s:7:"MotHFut";s:1:"0";s:6:"MotSoc";s:1:"0";s:6:"MotMon";s:1:"0";s:7:"MotSelf";s:1:"0";s:7:"OthSmok";s:1:"0";}');$choice143->setNextQuestion(37);$choice143->setRenamedQuestion(NULL);$choice143->setHideQuestion(NULL);$this->em->persist($choice143);
        $choice144 = new Choice();$choice144->setId(148);$choice144->setQuestion($question33);$choice144->setName("J'utilise un autre produit de remplacement ");$choice144->setScoring('a:17:{s:1:"C";s:1:"0";s:1:"P";s:1:"0";s:1:"A";s:1:"0";s:1:"M";s:1:"0";s:3:"Beh";s:1:"0";s:5:"Ppath";s:1:"0";s:4:"Psoc";s:1:"0";s:4:"Phys";s:1:"0";s:3:"Rew";s:1:"0";s:3:"C/R";s:1:"0";s:10:"Fagerstrom";s:1:"0";s:8:"MotHPres";s:1:"0";s:7:"MotHFut";s:1:"0";s:6:"MotSoc";s:1:"0";s:6:"MotMon";s:1:"0";s:7:"MotSelf";s:1:"0";s:7:"OthSmok";s:1:"0";}');$choice144->setNextQuestion(37);$choice144->setRenamedQuestion(NULL);$choice144->setHideQuestion(NULL);$this->em->persist($choice144);
        $choice145 = new Choice();$choice145->setId(149);$choice145->setQuestion($question33);$choice145->setName("Je n'utilise aucun produit de remplacement");$choice145->setScoring('a:17:{s:1:"C";s:1:"0";s:1:"P";s:1:"0";s:1:"A";s:1:"0";s:1:"M";s:1:"0";s:3:"Beh";s:1:"0";s:5:"Ppath";s:1:"0";s:4:"Psoc";s:1:"0";s:4:"Phys";s:1:"0";s:3:"Rew";s:1:"0";s:3:"C/R";s:1:"0";s:10:"Fagerstrom";s:1:"0";s:8:"MotHPres";s:1:"0";s:7:"MotHFut";s:1:"0";s:6:"MotSoc";s:1:"0";s:6:"MotMon";s:1:"0";s:7:"MotSelf";s:1:"0";s:7:"OthSmok";s:1:"0";}');$choice145->setNextQuestion(37);$choice145->setRenamedQuestion(NULL);$choice145->setHideQuestion(NULL);$this->em->persist($choice145);
        $choice146 = new Choice();$choice146->setId(150);$choice146->setQuestion($question34);$choice146->setName("le contenu");$choice146->setScoring('a:17:{s:1:"C";s:1:"0";s:1:"P";s:1:"0";s:1:"A";s:1:"0";s:1:"M";s:1:"0";s:3:"Beh";s:1:"0";s:5:"Ppath";s:1:"0";s:4:"Psoc";s:1:"0";s:4:"Phys";s:1:"0";s:3:"Rew";s:1:"0";s:3:"C/R";s:1:"0";s:10:"Fagerstrom";s:1:"0";s:8:"MotHPres";s:1:"0";s:7:"MotHFut";s:1:"0";s:6:"MotSoc";s:1:"0";s:6:"MotMon";s:1:"0";s:7:"MotSelf";s:1:"0";s:7:"OthSmok";s:1:"0";}');$choice146->setNextQuestion(NULL);$choice146->setRenamedQuestion(NULL);$choice146->setHideQuestion(NULL);$this->em->persist($choice146);
        $choice147 = new Choice();$choice147->setId(151);$choice147->setQuestion($question34);$choice147->setName("la durée du programme");$choice147->setScoring('a:17:{s:1:"C";s:1:"0";s:1:"P";s:1:"0";s:1:"A";s:1:"0";s:1:"M";s:1:"0";s:3:"Beh";s:1:"0";s:5:"Ppath";s:1:"0";s:4:"Psoc";s:1:"0";s:4:"Phys";s:1:"0";s:3:"Rew";s:1:"0";s:3:"C/R";s:1:"0";s:10:"Fagerstrom";s:1:"0";s:8:"MotHPres";s:1:"0";s:7:"MotHFut";s:1:"0";s:6:"MotSoc";s:1:"0";s:6:"MotMon";s:1:"0";s:7:"MotSelf";s:1:"0";s:7:"OthSmok";s:1:"0";}');$choice147->setNextQuestion(NULL);$choice147->setRenamedQuestion(NULL);$choice147->setHideQuestion(NULL);$this->em->persist($choice147);
        $choice148 = new Choice();$choice148->setId(152);$choice148->setQuestion($question34);$choice148->setName("la fréquence");$choice148->setScoring('a:17:{s:1:"C";s:1:"0";s:1:"P";s:1:"0";s:1:"A";s:1:"0";s:1:"M";s:1:"0";s:3:"Beh";s:1:"0";s:5:"Ppath";s:1:"0";s:4:"Psoc";s:1:"0";s:4:"Phys";s:1:"0";s:3:"Rew";s:1:"0";s:3:"C/R";s:1:"0";s:10:"Fagerstrom";s:1:"0";s:8:"MotHPres";s:1:"0";s:7:"MotHFut";s:1:"0";s:6:"MotSoc";s:1:"0";s:6:"MotMon";s:1:"0";s:7:"MotSelf";s:1:"0";s:7:"OthSmok";s:1:"0";}');$choice148->setNextQuestion(NULL);$choice148->setRenamedQuestion(NULL);$choice148->setHideQuestion(NULL);$this->em->persist($choice148);
        $choice149 = new Choice();$choice149->setId(153);$choice149->setQuestion($question34);$choice149->setName("la personnalisation");$choice149->setScoring('a:17:{s:1:"C";s:1:"0";s:1:"P";s:1:"0";s:1:"A";s:1:"0";s:1:"M";s:1:"0";s:3:"Beh";s:1:"0";s:5:"Ppath";s:1:"0";s:4:"Psoc";s:1:"0";s:4:"Phys";s:1:"0";s:3:"Rew";s:1:"0";s:3:"C/R";s:1:"0";s:10:"Fagerstrom";s:1:"0";s:8:"MotHPres";s:1:"0";s:7:"MotHFut";s:1:"0";s:6:"MotSoc";s:1:"0";s:6:"MotMon";s:1:"0";s:7:"MotSelf";s:1:"0";s:7:"OthSmok";s:1:"0";}');$choice149->setNextQuestion(NULL);$choice149->setRenamedQuestion(NULL);$choice149->setHideQuestion(NULL);$this->em->persist($choice149);
        */
        
        $this->em->flush();
        
        $msg = "<html><head><meta charset='utf-8'></head><body>";
        $quizs = $this->em->getRepository('NicoretteCentralBundle:Quiz')->findAll();
        $nbrPatient = 1;
        $msg .= $this->initQuizPatient($quizs, $patient, $nbrPatient);
        $nbrPatient++;
        $msg .= $this->initQuizPatient($quizs, $patient2, $nbrPatient);
        $nbrPatient++;
        $msg .= $this->initQuizPatient($quizs, $patient3, $nbrPatient);
        $nbrPatient++;
        $msg .= $this->initQuizPatient($quizs, $patient4, $nbrPatient);
        $nbrPatient++;
        $msg .= $this->initQuizPatient($quizs, $patient5, $nbrPatient);
        $nbrPatient++;
        $msg .= $this->initQuizPatient($quizs, $patient6, $nbrPatient);
        $nbrPatient++;
        $msg .= $this->initQuizPatient($quizs, $patient7, $nbrPatient);
        $nbrPatient++;
        $msg .= $this->initQuizPatient($quizs, $patient8, $nbrPatient);
        $nbrPatient++;
        $msg .= $this->initQuizPatient($quizs, $patient9, $nbrPatient);
        $nbrPatient++;
        $msg .= $this->initQuizPatient($quizs, $patient10, $nbrPatient);
        
        $msg .= "</body></html>";
        $fp = fopen("C:/Amir/test_sql.html", "w+");
    	fseek($fp, 0); // On remet le curseur au début du fichier
    	fputs($fp, $msg); // On écrit le nouveau nombre de pages vues
    	fclose($fp);
        
        
    	$output->writeln(sprintf('Ok'));
    }

    private function initQuizPatient($quizs, $patient, $nbrPatient){
    	$msg = "<table border=1><tbody>";
    	$msg .= "<tr style='background-color: yellowgreen;'><td><b>Patient : ".$patient->getId()."</b></td></tr>";
    	foreach($patient->getContracts() as $contract){
    		$msg .= "<tr><td>Date d'arrêt : ".( $contract->getStopDate() != NULL ? $contract->getStopDate()->format( 'd-m-Y' ) : "-")."\rDate dernier cigarette".( $contract->getStopDate() != NULL ? $contract->getLastCigarette()->format( 'd-m-Y' ) : "-")."</tr></td>";
    	}
    	foreach ($quizs as $quiz){
    		$quizAnswer = new QuizAnswer();
    		$quizAnswer->setPatient($patient);
    		$quizAnswer->setQuiz($quiz);
    		$this->em->persist($quizAnswer);
    		$this->em->flush();
    		$msg .= "<tr style='background-color:#9AC3ED;'><td>Quiz : ".$quiz->getId()."=>".$quiz->getName()."</tr></td>";
    		foreach ($quiz->getQuestions() as $question){
    			$msg .= "<tr style='background-color:tomato;'><td>Question : ".$question->getId()."=>".$question->getName()."</tr></td>";
    			$multiple = $question->getAnswerMultiple() == 0 ? false : true;
    			foreach ($question->getChoices() as $choice){
    				$answer = new Answer();
    				$answer->setQuizAnswer($quizAnswer);
    				$answer->setChoice($choice);
    				$this->em->persist($answer);
    				$this->em->flush();
    				$msg .= "<tr><td>Réponse : ".$choice->getId()."=>".$choice->getName()."</tr></td>";
    				if( $multiple == 0 ){
    					break;
    				}
    			}
    		}
    		if($nbrPatient == 1){
    			break;
    		}
    	}
    	$msg .= "</tbody></table><br/>";
    	return $msg;
    }
    
    private function getDoctrine() {
        return $this->getContainer()->get('doctrine');
    }
    
    private function get($service) {
    	return $this->getContainer()->get($service);
    }
}