<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Entity\Mark;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }
    
    /**
     * @Route("/input_mark/{section_id}/{evaluation_id}")
     */
    public function markInputAction($section_id, $evaluation_id)
    {
        //Get all student for the the right section
        $em = $this->getDoctrine()->getManager();
        //We need the evaluation
        $evaluation = $em->getRepository('AppBundle:Evaluation')->find($evaluation_id);
        $section = $em->getRepository('AppBundle:Section')->find($section_id);
        $students = $section->getStudents();
        return $this->render("@App/Teacher/input_mark.html.twig",
                             array('students' => $students, 'section' => $section, 'evaluation' => $evaluation));
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
    
    /**
     * 
     * @Route("/mark_table")
     */
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
    
    /**
     * @Route("/barcode")
     */
    public function barcodeAction()
    {
        $options = array(
        'code'   => '0000000001002',
        'type'   => 'codabar',
        'format' => 'png',
        'width'  => 2,
        'height' => 40,
        'color'  => array(0, 0, 0),
        );

        $barcode =
            $this->get('cibincasso_barcode.generator')->generate($options);

        return new Response('<img src="data:image/png;base64,'.$barcode.'" />');
        return $this->render("@App/Default/mark_table.html.twig", array('barcode' => $barcode));
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
}
