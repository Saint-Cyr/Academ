<?php
namespace AppBundle\EventListener;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
class RequestListener
{
    public function __construct($em, $translator)
    {
        $this->em = $em;
        $this->translator = $translator;
    }

    /**
     * This method ensure the locale is set for all the user. As Academ is not an online website for public,
     * this method is then used to set a common App language values for every user
     */
    public function onKernelRequest(GetResponseEvent $event)
    {
        //Geting the locale from the DB in order to set the language.
        $setting = $this->em->getRepository('AppBundle:Setting')->findOneBy(array('name' => 'setting'));
        //Set the locale
        $request = $event->getRequest();
        $this->translator->setlocale($setting->getLanguage());
        //$request->setDefaultLocale($setting->getLanguage());
        //$request->setlocale('fr');
        //echo $setting->getLanguage();exit;
    }
    
}