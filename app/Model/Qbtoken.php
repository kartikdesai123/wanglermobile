<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use DB;
use Auth;
use Config;



class Qbtoken extends Model
{
     protected $table = 'qbtoken';
     
     function __construct() {
     }
     
     public function insertToken($accessToken,$realmId){
         $result = Qbtoken::where('id',1)
                    ->get()
                    ->count();
         
         if($result == 0){
            $objQbtoken =new Qbtoken();
            $objQbtoken->token = $accessToken->getAccessToken();
            $objQbtoken->sessiondata = serialize($accessToken);
            $objQbtoken->realmId = $realmId;
            $objQbtoken->created_at = date("Y-m-d h:i:s");
            $objQbtoken->updated_at = date("Y-m-d h:i:s");
            $objQbtoken->save();
         }else{
            $objQbtoken = Qbtoken::updateOrCreate(array('id' => 1));
            $objQbtoken->token = $accessToken->getAccessToken();
            $objQbtoken->sessiondata = serialize($accessToken);
            $objQbtoken->realmId = $realmId;
            $objQbtoken->created_at = date("Y-m-d h:i:s");
            $objQbtoken->updated_at = date("Y-m-d h:i:s");
            $objQbtoken->save();
         }         
     }
     
     public function gettoken(){
        $result= Qbtoken::select("token")
                ->where("id","1")
                ->get()
                ->toArray();
         return $result[0]['token'];
     }
     public function getsessiontoken(){
        $result= Qbtoken::select("sessiondata")
                ->where("id","1")
                ->get()
                ->toArray();
         return unserialize($result[0]['sessiondata']);
     }
     public function getrealmId(){
        $result= Qbtoken::select("realmId")
                ->where("id","1")
                ->get()
                ->toArray();
         return $result[0]['realmId'];
     }
}
