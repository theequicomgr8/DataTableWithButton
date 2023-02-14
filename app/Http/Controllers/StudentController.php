<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\Student;
class StudentController extends Controller
{
    public function show(Request $request)
    {
        $columns=[
            0=>"id",
            1=>"name",
            2=>"email",
            3=>"mobile"
        ];
        $totalRecord=Student::count();
        $totalFilered=$totalRecord;

        $limit=$request->input('length');
        $start=$request->input('start');
        $order=$columns[$request->input('order.0.column')];
        $dir=$request->input('order.0.dir');

        if(empty($request->input('search.value'))){
            $students=Student::offset($start)->limit($limit)->orderBy($order,$dir)->get();
        }

        $temp_ary=[];
        if(!empty($students)){
            foreach($students as $student){
                $result['id']=$student->id;
                $result['name']=$student->name;
                $result['email']=$student->email;
                $result['mobile']=$student->mobile;
                $temp_ary[]=$result;
            }
        }
        // $data=json_decode($temp_ary);
        $json_data=[
            "draw" => intval($request->input('draw')),
            "recordsTotal"=>intval($totalRecord),
            "recordsFiltered"=>intval($totalFilered),
            "data"=>$temp_ary
        ];
        echo json_encode($json_data);


    }
}
