<?php

namespace App\Controller;


use App\Entity\UserReward;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class RewardController extends AbstractController
{
    /**
     * @Route("/reward", name="reward")
     */
    public function index()
    {

        $returnUserReward=$this->calcReward();
        
        //  print_r($returnUserReward);

        return new JsonResponse($this->serialize($returnUserReward), 200);
    }

    private function calcReward(){
        $repository = $this->getDoctrine()->getRepository(UserReward::class);
        $UserRewardList = $repository->findAll();

        $limitReward=200000; // set limit daily
        $rewards=array();

        $i=count($UserRewardList);
        foreach ($UserRewardList as $UserReward) {

            $i=$i-1;
            $rangeMin=$UserReward->getRangeMin();
            $rangeMax=$UserReward->getRangeMax();
            $name=$UserReward->getName();
            $reward;           
            
            if($limitReward>0){
                if ($i>0){ //not the last loop
                    $reward=rand($rangeMin, $rangeMax);
                    if($reward>$limitReward) //not the last but reach the daily limit reward
                        $reward=$limitReward;
                }else{
                    if ($limitReward>0){ 
                        if  ($limitReward>= $rangeMax){
                            $reward= $rangeMax; 
                        }else{
                            $reward= $limitReward; 
                        }        
                    }else {
                        $reward=0; //to makesure not send (-)
                    }      
                }
            }else{
                $reward=0;
            }
                    
           // echo $limitReward;echo "--".$name."--".$rangeMin."-". $rangeMax."--".$reward;
    
            $check=$limitReward-$reward;
            array_push($rewards, array( 'name'=>$name,
                                        'rangeMin'=>$rangeMin,
                                        'rangeMax'=>$rangeMax,
                                        'reward'=> $reward,
                                        'dailyLimit'=>$check)
                                );  
            $limitReward=$limitReward-$reward;              
        
        } 
        return ($rewards);

    }


    protected function serialize($UserReward)
    {
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];

        $serializer = new Serializer($normalizers, $encoders);

        $json = $serializer->serialize($UserReward, 'json');

        return $json;
    }
    
}
