<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Entity\Mark;
use AppBundle\Helper\CSVTypes;

use Ddeboer\DataImport\ValueConverter\StringToObjectConverter;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Ddeboer\DataImport\Reader\CsvReader;
use Ddeboer\DataImport\Workflow;
use Ddeboer\DataImport\Writer\DoctrineWriter;
use Ddeboer\DataImport\Workflow\StepAggregator;


class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {
        /*$pw = '';
        $user = $this->getDoctrine()->getManager()->getRepository('UserBundle:User')->find(1);
        $token = new \Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken($user, $pw, "main", array("ROLE_USER"));
        $utils = $this->get('app.utils');
        $utils->getSecurityHandler()->setToken($token);

        $event = new \Symfony\Component\Security\Http\Event\InteractiveLoginEvent($request, $token);
        $this->get('event_dispatcher')->dispatch('security.interactive_login', $event);

        $user = $utils->getSecurityHandler()->getToken()->getUser();
        //var_dump($user->getUserName());exit;*/
        
     //var_dump($this->getUser()->getRoles());exit;
        
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }
    
    
    public function markInputAction($section_id, $evaluation_id)
    {
        //Get all student for the the right section
        $em = $this->getDoctrine()->getManager();
        //We need the evaluation
        $evaluation = $em->getRepository('AppBundle:Evaluation')->find($evaluation_id);
        //Make sure the evaluation is related to the current section
        //Exemple we want to avoid a situation where 1ere G3B evaluation
        //is loaded when student of 1ere G3A suppose to receive mark...
        if($evaluation->getSection()->getId() == $section_id){
            $section = $em->getRepository('AppBundle:Section')->find($section_id);
            $students = $section->getStudents();
            return $this->render("@App/Teacher/input_mark.html.twig",
                                 array('students' => $students, 'section' => $section, 'evaluation' => $evaluation));
        }else{
            throw $this->createNotFoundException('Evaluation #ID: '.$evaluation_id.' & Section #ID: '.$section_id.' are not related.');
        }
        
    }
    
    
    public function markUploadAction(Request $request)
    {
        
        $em = $this->getDoctrine()->getManager();
        //Make sure the request content data
        if($request->request->get('data')){
            //Get all the necessary variable
            $inputData = $request->request->get('data');
            $markValue = $inputData['mark'];
            $student = $em->getRepository('AppBundle:Student')->find($inputData['student_id']);
            //$section = $em->getRepository('AppBundle:Section')->find($inputData['section_id']);
            $evaluation = $em->getRepository('AppBundle:Evaluation')->find($inputData['evaluation_id']);
            if(!$student || !$evaluation){
                throw $this->createNotFoundException('User of #ID '.$inputData['student_id'].' or Evaluation not found in DB');
            }
            //check whether this student all ready have a mark for the current evaluation
            foreach ($evaluation->getMarks() as $mark){
                if($mark->getStudent()->getId() == $student->getId()){
                    return new JsonResponse('[Error] This student all ready have a mark:'.$mark->getValue());
                }
            }
            //create new Mark object
            $markObject = new Mark();
            $markObject->setValue($markValue);
            $markObject->setEvaluation($evaluation);
            $markObject->setStudent($student);
            $em->persist($markObject);
            $em->flush();
            
            return new JsonResponse('[ok] Sucessfull submission!');
            
        }
                
        return new JsonResponse('Error: Wrong parameters.');
        
    }
    
    
    public function markTableAction($section_id)
    {
        //We will need DB connection
        $em = $this->getDoctrine()->getManager();
        $setting = $em->getRepository('AppBundle:Setting')->findOneBy(array('name' => 'setting'));
        
        $sequence = $setting->getSequence();
        
        if(!$setting){
            throw $this->createNotFoundException('Setting not found');
        }
        
        //Get the section from DB
        $section = $em->getRepository('AppBundle:Section')->find($section_id);
        
        //Get the service
        $markTable = $this->get('AppBundle\Service\BuildMarkTableLTBHandler')->generateMarkTableLTB($section, $sequence);
        return $this->render("@App/Default/mark_table.html.twig", array('markTables' => $markTable));
    }
    
    public function markTableStdAction($section_id)
    {
        //We will need DB connection
        $em = $this->getDoctrine()->getManager();
        $setting = $em->getRepository('AppBundle:Setting')->findOneBy(array('name' => 'setting'));
        
        $sequence = $setting->getSequence();
        
        if(!$setting){
            throw $this->createNotFoundException('Setting not found');
        }
        
        //Get the section from DB
        $section = $em->getRepository('AppBundle:Section')->find($section_id);
        
        //Get the service
        $markTable = $this->get('app.build_marktable_handler')->generateMarkTable($section, $sequence);
       
        return $this->render("@App/Default/mark_table_std.html.twig", array('markTables' => $markTable, 'parameters' => $setting));
    }
    
   
    public function studentBarcodeAction($selectedStudents = null)
    {
        //Get all the teacher
        $em = $this->getDoctrine()->getManager();
        if(!$selectedStudents){
            $students = $em->getRepository('AppBundle:Student')->findAll();
        }else{
            $students = $selectedStudents;
        }
        
        //Build the barcode for each teacher
        foreach ($students as $student){
            
            $formatedId = str_pad($student->getId(),5,"0",STR_PAD_LEFT); 
            $options = array(
                'code'   => $formatedId,
                'type'   => 'codabar',
                'format' => 'png',
                'width'  => 1,
                'height' => 18,
                'color'  => array(0, 0, 0),
                );
             
            $barcode = $this->get('cibincasso_barcode.generator')->generate($options);
            $student->setBarcode($barcode);
        }
        
        return $this->render("@App/Default/student_barcode.html.twig", array('students' => $students));
    }
    
     /**
    * simple cache path returning method (sample cache path: "upload/barcode/cache" )
    *
    * @param bool $public
    *
    * @return string
    *
    */
   protected function getBarcodeCachePath($public = false)
   {
      return (!$public) ? $this->get('kernel')->getRootDir(). '/../web/upload/barcode/cache' : '/upload/barcode/cache';
   }
   
    public function importFileAction(Request $request) 
    {
         // Get FileId to "import"
        $param = $request->request;
        $fileId = (int)trim($param->get("fileId"));
        $curType=trim($param->get("fileType"));
        $uploadedFile = $request->files->get("csvFile");
        $sectionId = $param->get('section');
        //var_dump($uploadedFile->guessExtension());exit;
        
        // if upload was not ok, just redirect to "shortyStatWrongPArameters"
        if (!CSVTypes::existsType($curType) || $uploadedFile==null){
            $this->get('session')->getFlashBag()
                 ->add('sonata_flash_info', 'Sorry... cannot upload the file(s). Check documentation or see super-administrator');
            
            return $this->redirect($this->generateUrl('sonata_admin_dashboard'));
        }
        
        // generate dummy dir
        $dummyImport = getcwd()."/dummyImport";
        $fname= $uploadedFile->getClientOriginalName();
        $filename=$dummyImport."/".$fname;
        @mkdir($dummyImport);
        @unlink($filename);
        
        // move file to dummy filename
        $uploadedFile->move($dummyImport, $fname);            
        echo "Starting to Import file. Type: ".CSVTypes::getNameOfType($curType)."<br />n";
        
        /** By @Saint-Cyr **/
        $file = new \SplFileObject($dummyImport.'/'.$fname);
        $reader = new CsvReader($file);
        //set the hander in order to build an associative array
        $reader->setHeaderRowNumber(0);
        // Create the workflow from the reader
        $workflow = new StepAggregator($reader);
        //doctrine writer
        $em = $this->getDoctrine()->getManager();
        
        $doctrineWriter = new DoctrineWriter($em, CSVTypes::getEntityClass($curType));
        
        //disable truncate
        $doctrineWriter->disableTruncate();
        
        try{
            
            $workflow->addWriter($doctrineWriter);
            $repository = $em->getRepository('AppBundle:Student');
            
            //$converter = new StringToObjectConverter($repository, 'code');
            //$workflow->addValueConverter($property, $converter);
            $result = $workflow->process();
            
        }catch (UniqueConstraintViolationException $e){
            $this->get('session')->getFlashBag()
                 ->add('sonata_flash_error', 'Error: cannot import the CSV file because it contains one or many entry that allready '
                         . 'exists in the Data Base');
            return $this->redirect($this->generateUrl('sonata_admin_dashboard'));
        }
    
        
        /** End if code by S@int-Cyr **/
        $this->get('session')->getFlashBag()
             ->add('sonata_flash_success', CSVTypes::getNameOfType($curType)." CSV file uploaded successfully ! processing time: ".$result->getElapsed()->s);
            
        return $this->redirect($this->generateUrl('admin_app_student_list'));

    }
    
    /* If a preselected list of teachers is
     * sent (from sonata list for exple) then
     * it need to be consider instead of using
     * all the list of teachers from DB
     */
    public function teacherCardAction($selectedTeachers = null)
    {
        
        //Get all the teacher
        $em = $this->getDoctrine()->getManager();
        if(!$selectedTeachers){
            $teachers = $em->getRepository('AppBundle:Teacher')->findAll();
        }else{
            $teachers = $selectedTeachers;
        }
        
        //Build the barcode for each teacher
        foreach ($teachers as $teach){
            
            $formatedId = str_pad($teach->getId(),18,"0",STR_PAD_LEFT); 
            $options = array(
                'code'   => $formatedId,
                'type'   => 'codabar',
                'format' => 'png',
                'width'  => 1,
                'height' => 18,
                'color'  => array(0, 0, 0),
                );
             
            $barcode = $this->get('cibincasso_barcode.generator')->generate($options);
            $teach->setBarcode($barcode);
        }
        
        return $this->render("@App/Teacher/teacher_card2.html.twig", array('teachers' => $teachers));
    }
}
