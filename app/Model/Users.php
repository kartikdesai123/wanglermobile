<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use DB;
use Auth;
use Config;
use File;
use Session;

class Users extends Model {

    protected $table = 'users';

    public function addUser($request) {
        $result = Users::where('email', $request->input('email'))
                ->count();
        if ($result > 0) {
            return 2;
        } else {
            $name = '';
            if ($request->file()) {
                $image = $request->file('profileImage');
                $name = 'admin' . time() . '.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('/uploads/users/');
                $image->move($destinationPath, $name);
            }

            $objUser = new Users();
            $objUser->firstname = $request->input('firstname');
            $objUser->lastname = $request->input('lastname');
            $objUser->email = $request->input('email');
            $objUser->password = Hash::make($request->input('password'));
            $objUser->user_image = $name;
            $objUser->type = "USER";
            $objUser->created_at = date('Y-m-d H:i:s');
            $objUser->updated_at = date('Y-m-d H:i:s');
            if ($objUser->save()) {
                return 1;
            } else {
                return 0;
            }
        }
    }

    public function saveEditUserInfo($request, $userId) {

        $name = '';
        $objUser = Users::find($userId);

        if ($request->file()) {

            $existImage = public_path('/uploads/users/') . $objUser->user_image;
            if (File::exists($existImage)) { // unlink or remove previous company image from folder
                File::delete($existImage);
            }

            $image = $request->file('profile_pic');
            $name = 'profile_img' . time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/uploads/users/');
            $image->move($destinationPath, $name);
            $objUser->user_image = $name;
        }
        // $objUser->name = !empty($request->input('newpassword')) ? Hash::make($request->input('newpassword')) : $request->input('oldpassword');
        $objUser->firstname = $request->input('firstname');
        $objUser->lastname = $request->input('lastname');

        if ($objUser->save()) {
            return TRUE;
        } else {

            return FALSE;
        }
    }

    public function updatePassword($request, $userId) {
        $objUser = Users::find($userId);
        $objUser->password = !empty($request->input('new_password')) ? Hash::make($request->input('new_password')) : $request->input('old_password');
        $objUser->save();
        return TRUE;
    }

    public function editUser($request) {
        $result = Users::where('email', $request->input('email'))
                ->where('id', '!=', $request->input('id'))
                ->count();
        if ($result > 0) {
            return 2;
        } else {
            $name = $request->input('oldImage');
            if ($request->file('profileImage')) {

                if ($request->input('oldImage') != null || $request->input('oldImage') != '') {
                    unlink(public_path('/uploads/users/' . $request->input('oldImage')));
                }
                $image = $request->file('profileImage');
                $name = 'admin' . time() . '.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('/uploads/users/');
                $image->move($destinationPath, $name);
            }

            $objUser = Users::find($request->input('id'));
            $objUser->firstname = $request->input('firstname');
            $objUser->lastname = $request->input('lastname');
            $objUser->email = $request->input('email');
            $objUser->user_image = $name;
            $objUser->type = "USER";
            $objUser->updated_at = date('Y-m-d H:i:s');
            if ($objUser->save()) {
                return 1;
            } else {
                return 0;
            }
        }
    }

    public function getData($request) {
        $requestData = $_REQUEST;
        $columns = array(
            // datatable column index  => database column name
            0 => 'users.id',
            1 => 'users.firstname',
            2 => 'users.lastname',
            3 => 'users.email',
        );

        $query = Users::from('users')
                ->where('users.type', 'USER');

        if (!empty($requestData['search']['value'])) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
            $searchVal = $requestData['search']['value'];
            $query->where(function($query) use ($columns, $searchVal, $requestData) {
                $flag = 0;
                foreach ($columns as $key => $value) {
                    $searchVal = $requestData['search']['value'];
                    if ($requestData['columns'][$key]['searchable'] == 'true') {
                        if ($flag == 0) {
                            $query->where($value, 'like', '%' . $searchVal . '%');
                            $flag = $flag + 1;
                        } else {
                            $query->orWhere($value, 'like', '%' . $searchVal . '%');
                        }
                    }
                }
            });
        }

        $temp = $query->orderBy($columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir']);

        $totalData = count($temp->get());
        $totalFiltered = count($temp->get());

        $resultArr = $query->skip($requestData['start'])
                        ->take($requestData['length'])
                        ->select('*')->get();
        $data = array();


        $i = 0;
        foreach ($resultArr as $row) {
            $i++;
            if ($row["user_image"] == NULL || $row["user_image"] == '') {
                $path = asset("public/uploads/users/user.jpg");
            } else {
                $path = asset("public/uploads/users/" . $row["user_image"]);
            }

            $actionHtml = '';
            $actionHtml .= '<center><a href="' . route('edit-users', array('id' => $row['id'])) . '" class="link-black text-sm" data-toggle="tooltip" data-original-title="Edit" > <i class="fa fa-edit"></i></a>';
            $actionHtml .= '<br><a href="#deleteModel" data-toggle="modal" data-id="' . $row['id'] . '" data-profileimage="' . $row['profileimage'] . '" class="link-black text-sm deleteicon" data-toggle="tooltip" data-original-title="Delete" > <i class="fa fa-trash"></i></a></center>';
            $nestedData = array();
            $nestedData[] = $i;
            $nestedData[] = '<center><img style="width:80px;height:80px " alt="image" class="img-circle"  src="' . $path . '" /></center>';
            $nestedData[] = $row["firstname"];
            $nestedData[] = $row["lastname"];
            $nestedData[] = $row["email"];
            $nestedData[] = $actionHtml;
            $data[] = $nestedData;
        }
        // echo "<pre>";print_r($data);exit;

        $json_data = array(
            "draw" => intval($requestData['draw']), // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
            "recordsTotal" => intval($totalData), // total number of records
            "recordsFiltered" => intval($totalFiltered), // total number of records after searching, if there is no searching then totalFiltered = totalData
            "data" => $data   // total data array
        );

        return $json_data;
    }

    public function getDetails($id) {
        $query = Users::from('users')
                ->where('id', $id)
                ->get();
        print_r($query);
        die();
        return $query;
    }

    public function getUserDetails($id) {
        $query = Users::select('firstname', 'lastname', 'email', 'user_image')
                ->where('id', $id)
                ->get();
        return $query;
    }
    
    public function getUserPassword($id) {
        $query = Users::select('password')
                ->where('id', $id)
                ->get();
        return $query;
    }

}
