<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Todo;
use App\Models\Employees;
use App\Http\Requests\TodoCreateRequest;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $todos=Todo::get();
        $employees=Employees::get();
        $employeesArray=array();
        for ($i = 1; $i <= 5; $i++){
            $total1=0;
            $total2=0;
            $total3=0;
            $total4=0;
            $total5=0;
            $totalEmployees=0;
            $todolevel1=array();
            $todolevel2=array();
            $todolevel3=array();
            $todolevel4=array();
            $todolevel5=array();
            foreach ($todos as $todo){
                switch ($todo['zorlukDerecesi']) {
                    case 1:
                        $total1+=$todo['isinTahminiSuresi'];
                        $newdata =  array($todo['id'],$todo['isinAdi'],$todo['zorlukDerecesi'],$todo['isinTahminiSuresi']);
                        array_push($todolevel1,$newdata);
                        $todolevel1[0] = array_unique($todolevel1[0]);
                        break;
                    case 2:
                        $total2+=$todo['isinTahminiSuresi'];
                        $newdata =  array($todo['id'],$todo['isinAdi'],$todo['zorlukDerecesi'],$todo['isinTahminiSuresi']);
                        array_push($todolevel2,$newdata);
                        $todolevel2[0] = array_unique($todolevel2[0]);
                        break;
                    case 3:
                        $total3+=$todo['isinTahminiSuresi'];
                        $newdata =  array($todo['id'],$todo['isinAdi'],$todo['zorlukDerecesi'],$todo['isinTahminiSuresi']);
                        array_push($todolevel3,$newdata);
                        $todolevel3[0] = array_unique($todolevel3[0]);
                        break;
                    case 4:
                        $total4+=$todo['isinTahminiSuresi'];
                        $newdata =  array($todo['id'],$todo['isinAdi'],$todo['zorlukDerecesi'],$todo['isinTahminiSuresi']);
                        array_push($todolevel4,$newdata);
                        $todolevel4[0] = array_unique($todolevel4[0]);
                        break;
                    case 5:
                        $total5+=$todo['isinTahminiSuresi'];
                        $newdata =  array($todo['id'],$todo['isinAdi'],$todo['zorlukDerecesi'],$todo['isinTahminiSuresi']);
                        array_push($todolevel5,$newdata);
                        $todolevel5[0] = array_unique($todolevel5[0]);
                        break;
                    
                    default:
                        # code...
                        break;
                }
            }             
        }
        $total= $total1+$total2+$total3+$total4+$total5; 
        
        foreach($employees as $employee){
            $totalEmployees+=$employee['calisan'];
            $employeesArray=array(
                array($employee['developer'],$employee['sure'],$employee['zorluk'],$employee['calisan'])
            );
        }
        foreach($employeesArray as $employee){
            while ( $total5<($total/$totalEmployees)*$employee[3]-5 && $employee[2]===5 ){
                $shiftArray = array_shift($todolevel4);
                if (!empty($shiftArray)) { 
                    array_unshift($todolevel5,$shiftArray);
                    $total5+=$shiftArray[3];
                    $total4-=$shiftArray[3]; 
                } 
            }
            while ( $total4<($total/$totalEmployees)*$employee[3]-5 || $employee[2] === 4 ){
                $shiftArray = array_shift($todolevel3);
                if (!empty($shiftArray)) { 
                    array_unshift($todolevel4,$shiftArray);
                    $total4+=$shiftArray[3];
                    $total3-=$shiftArray[3];
                }
            }
            while ( $total3<($total/$totalEmployees)*$employee[3]-5 || $employee[2] === 3 ){
                $shiftArray = array_shift($todolevel2);
                if (!empty($shiftArray)) { 
                    array_unshift($todolevel3,$shiftArray);
                    $total3+=$shiftArray[3];
                    $total2-=$shiftArray[3];
                }
            }
            while ( $total2<($total/$totalEmployees)*$employee[3]-5 || $employee[2] === 2 ){
                $shiftArray = array_shift($todolevel1);
                if (!empty($shiftArray)) {  
                    array_unshift($todolevel2,$shiftArray);
                    $total2+=$shiftArray[3];
                    $total1-=$shiftArray[3];
                }
            }
        }
        $total=array(
            'level1'=>array(1,intval($total1/45),$total1%45),
            'level2'=>array(2,intval($total2/45),$total2%45),
            'level3'=>array(3,intval($total3/45),$total3%45),
            'level4'=>array(4,intval($total4/45),$total4%45),
            'level5'=>array(5,intval($total5/45),$total5%45)
        );
        $todos=array();
        foreach ($todolevel1 as  $todolevel) {
            $newdata = array(1,$todolevel[0],$todolevel[1],$todolevel[2],$todolevel[3]);
            array_push($todos,$newdata);
        }
        foreach ($todolevel2 as  $todolevel) {
            $newdata = array(2,$todolevel[0],$todolevel[1],$todolevel[2],$todolevel[3]);
            array_push($todos,$newdata);
        }
        foreach ($todolevel3 as  $todolevel) {
            $newdata = array(3,$todolevel[0],$todolevel[1],$todolevel[2],$todolevel[3]);
            array_push($todos,$newdata);
        }
        foreach ($todolevel4 as  $todolevel) {
            $newdata = array(4,$todolevel[0],$todolevel[1],$todolevel[2],$todolevel[3]);
            array_push($todos,$newdata);
        }
        foreach ($todolevel5 as  $todolevel) {
            $newdata = array(5,$todolevel[0],$todolevel[1],$todolevel[2],$todolevel[3]);
            array_push($todos,$newdata);
        }
        return view('index',compact('todos','total'));
    }

    public function list()
    {
        $todos=Todo::paginate(70);
        return view('list',compact('todos'));

        
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         return view('create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TodoCreateRequest $request)
    {
        
        try {
            $jsonUrl=$request->post('jsonUrl');
            $jsonData = file_get_contents($jsonUrl);
            $jsonArray= json_decode($jsonData, true);
            $rewriteKeys = array('zorluk' => 'zorlukDerecesi', 'sure' => 'isinTahminiSuresi', 'id' => 'isinAdi','level'=>'zorlukDerecesi','estimated_duration'=>'isinTahminiSuresi');
            $newArr = array();  
            switch (count($jsonArray[0])) {
                case 1:
                    foreach($jsonArray as $key =>  $value) {
                        foreach ($value as $key1 => $value1) {
                            $newArr[ 'isinAdi' ] = $key1;
                           foreach ($value1 as $key2 => $value2) {
                                if ( $rewriteKeys[ $key2 ]) {
                                    $newArr[ $rewriteKeys[ $key2 ] ] = $value2;
                                }  
                           }
                        }
                      Todo::create($newArr);
                    }
                    break;
                
                case 3:
                    foreach($jsonArray as $key => $values) {
                        foreach ($values as $key => $value) {
                            $newArr[ $rewriteKeys[ $key ] ] = $value;
                           
                        }
                         Todo::create($newArr);
                    }
                    break;
                
                default:
                    return redirect()->route('todos.create')->withErrors('JSON error');
                    break;
            }
        
       
        
       
        return redirect()->route('list')->withSuccess('Başarılı.');
        } catch (\Throwable $th) {
            return redirect()->route('todos.create')->withErrors('Error.');
        }
            
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
