public function date_Numid(Request $request){

        $validator = Validator::make($request->all(),[
            'name'=> 'required',
            'password'=> 'required',
           ]);
        if($validator->fails()){
            return $validator->errors();
        }




        $myDate =Carbon::now()->format('dmY');
        $count = 1;

        $table_count =DB::table('date_numid')->get()->count();
        $check1 = $table_count == 0;
        if($check1){
            $ref_code = $myDate.'00'.$count;
        }else{
            $last_row = DB::table('date_numid')->orderBy('id', 'desc')->first();
            $req_id = $last_row->user_id;
            $req_date = substr($req_id, 0, 8);
            $req_sr = substr($req_id, 8);
            $check = $myDate == $req_date ;
            if($check){
                $ref_code = $myDate.'00'.$req_sr+1;
            }else{
                $ref_code = $myDate.'00'.$count;
            }
        }

    //    $hash = Hash::make($request->password);
        $user =DB::table('date_numid')->insert(['name'=>$request->name,"password"=>$request->password,'user_id'=>$ref_code]);

        if($user){
        return json_encode([
            'status'=>'001',
            'message'=>"data insert successfully",
            'data' => $user,
            'ref' =>$ref_code
            ]);
        }else{
            return json_encode([
                'status'=>'002',
                'message'=>" not data insert successfully",
               ]);
        }

    }
