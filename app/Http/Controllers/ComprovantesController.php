<?php

namespace App\Http\Controllers;

use App\Models\ItensVenda;
use Illuminate\Http\Request;
Use App\Models\Venda;
Use Barryvdh\DomPDF\Facade\Pdf;


class ComprovantesController extends Controller
{
    
    public function geraPdf($id)
    
    {

        $vendas = Venda::find($id);
      //  $registros = Venda::with('categoria')->get();    
       
        
        
     //  return pdf::loadView('pdf.venda', compact(['vendas']))->stream();

       return view('pdf.venda', compact(['vendas']));
       

      


    }


}
