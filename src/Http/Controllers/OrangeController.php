<?php

namespace Laravel_Orange\Orange_Money\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Facades\Http;

class OrangeController extends Controller
{
   

    public function __construct()
    {
         
    }
    public function index()
    {
        return $this->apiCall("ZZZ","SEEE",12.0);
    }
    
    /**
     * call of the API with the parameters: the referentil of the command, the command and the total sum
     */
    public function apiCall($refCommande,$commande,$somme)
    {
        $identifiant = md5(getenv("S2M_IDENTIFIANT"));
        $site = md5(getenv("S2M_SITE"));
        $cle_secrete =getenv("MARCHANT_KEEY");
        $algo = "SHA512";
        $dateh = date('c');
        $ref_commande = $refCommande;
        $total = $somme;
        $commande = $commande;
        $cle_bin = pack("H*", $cle_secrete);
        $message = "S2M_COMMANDE=$commande"."&S2M_DATEH=$dateh"."&S2M_HTYPE=$algo"."&S2M_IDENTIFIANT=$identifiant"."&S2M_REF_COMMANDE=$ref_commande"."&S2M_SITE=$site"."&S2M_TOTAL=$total";
        $hmacs = strtoupper(hash_hmac(strtolower($algo),$message, $cle_bin));
        return view ('orange::formular.paiement',[
            'S2M_IDENTIFIANT' => $identifiant,
            'S2M_SITE'        => $site,
            'S2M_REF_COMMANDE'=> $ref_commande,
            'S2M_COMMANDE'    =>$commande,
            'S2M_DATEH'       => $dateh,
            'S2M_TOTAL'       => $total,
            'S2M_HTYPE'       => $algo,
            'S2M_HMAC'        => $hmacs
        ]);
    }
    
}
