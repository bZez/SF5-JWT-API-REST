<?php


namespace App\Controller\Front;

use App\Helper\DataParser;
use App\Repository\PartnerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Routing\Annotation\Route;
use \ReflectionException;

/**
 * Class ApiFrontController
 * @package App\Controller\Front
 * @Route("/~private")
 */
class ApiFrontController extends AbstractController
{
    /**
     * @Route("/",name="api_front_dash")
     * @return Response
     */
    public function dashboard()
    {
        return $this->render('front/dash.html.twig');
    }

    /**
     * @param KernelInterface $kernel
     * @return Response
     * @throws ReflectionException
     * @Route("/datas",name="api_front_data")
     */
    public function data(KernelInterface $kernel)
    {
        $parser = new DataParser($kernel);
        $controllers = $parser->getControllers();
        return $this->render('front/data.html.twig', [
            'controllers' => $controllers,
        ]);
    }

   /* public function contract($id)
    {
        return $this->render('contracts/contract'.$id.'.html.twig',[
            'rootdir' => '',
            'adherent' => [
                'lastName' => 'TEST',
                'firstName' => 'Tester',
                'address'=> '44 cours Léopold',
                'addressComplementary'=> '',
                'postalCode'=> '54000',
                'email'=> 'test@mgel.fr',
                'city'=> 'NANCY',
                'mobile'=> '06.07.08.09.10',
                'adherentNumber' => 'XX',
            ],
            'formule'=>[
                'nom'=>'NomFormule'
            ],
            'destination' =>'SomeWhere',
            'price' =>'XXX',
            'monthly' =>false,
            'startDate' => new \DateTime(),
            'endDate' => new \DateTime(),
        ]);
    }*/
}