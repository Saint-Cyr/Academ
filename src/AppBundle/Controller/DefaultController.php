<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

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
    
    /**
     * @Route("/mark_upload")
     */
    public function markUploadAction(Request $request)
    {
        
        $em = $this->getDoctrine()->getManager();
        //Make sure the request content data
        if($request->request->get('data')){
            //Get all the necessary variable
            $inputData = $request->request->get('data');
            
            return new JsonResponse('Mark: '.$inputData['mark'].' Student #ID: '.$inputData['student_id'].'Section #ID: '.$inputData['section_id']);
            
        }
        
        $arrData = ['d1' => 'val1'];
                
        return new JsonResponse($arrData);
        
    }
    
    /**
     * 
     * @Route("/mark_table")
     */
    public function markTableAction()
    {
        return $this->render("@App/Default/mark_table.html.twig");
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
