<?php

namespace App\Http\Controllers;

use App\Admin;
use App\AgentMeta;
use Illuminate\Http\Request;

class AdminEmployeesController extends Controller
{
    public function save(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|unique:admins'
        ]);

        $employee = Admin::create($this->prepare_date($request));

        if($request->role_id == 4){
            $token = str_random(40);
            AgentMeta::create(['agent_id' => $employee->id, 'link' => $this->generate_agent_link($token), 'token' => $token]);  
        }

        session()->flash('success', 'Employee added');
        return redirect()->back();
    }

    public function delete()
    {
        $id = request()->id;
        Admin::find($id)->delete();

        return redirect()->route('admin.employees');
    }

    public function reset($id)
    {
        $employee = Admin::find($id);
        if($employee->role_id == 4){
            $employee->update(['password' => bcrypt($employee->meta->token)]);
        }
        $employee->update(['password' => bcrypt($this->get_default_pass())]);
        return redirect()->route('admin.employees');
    }

    public function changeRole($id)
    {
        $employee = Admin::find($id);
        if(request()->role_id == 4){
            $agent = AgentMeta::where('agent_id', $employee->id)->first();
            if(!$agent){
                $token = str_random(40);
                AgentMeta::create(['agent_id' => $employee->id, 'link' => $this->generate_agent_link($token), 'token' => $token]);
            }
        }
        $employee->update(['role_id' => request()->role_id]);
        return redirect()->route('admin.employees');
    }

    public function changePassword(Request $request)
    {
        $this->validate($request, [
            'old_password' => 'required',
            'password' => 'required|min:9|confirmed'
        ]);

        $success = auth('admin')->attempt($this->getCredentials($request));
        if(!$success) return redirect()->back();

        auth('admin')->user()->update(['password' => bcrypt($request->password)]);
        auth('admin')->logout();
        return redirect()->route('admin.get.login');
    }

    private function getCredentials(Request $request)
    {
        return ['email' => auth('admin')->user()->email, 'password' => $request->old_password];
    }

    private function prepare_date(Request $request)
    {
        return [
            'name' => $request->name,
            'email' => $request->email,
            'role_id' => $request->role,
            'status' => 'active',
            'password' => bcrypt($this->get_default_pass())
        ];
    }

    private function get_default_pass()
    {
        return 'easyTrading@2016';
    }

    private function generate_agent_link($token)
    {
        $url = route('user.get.register');
        return "{$url}?a={$token}";
    }
}
