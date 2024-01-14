<?php

namespace App\Http\Controllers;

use App\Models\Inventaris;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mockery\Generator\StringManipulation\Pass\Pass;

class InventarisController extends Controller
{
    public function index()
    {
        return view("inventaris");
    }
    public function action_inv($opsi, $param = null, $detail = null)
    {
        $inv_model = new Inventaris();
        switch ($opsi)
        {
            case 'data':
                isset($param) || isset($detail) ? $inventaris = null :
                $inventaris = $inv_model->getPerBranch();
                return view('inv.inventaris',['inventaris'=>$inventaris]);

            case 'edit':
                if($param == "id" && isset($detail)){
                    $edit = $inv_model->getOne($detail);
                }else{
                    $edit = null;
                }
                return view('inv.edit',['edit'=>$edit]);
            
            default:
                return redirect('/');
        }
    }
}
