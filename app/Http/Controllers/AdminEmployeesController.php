<?php

namespace App\Http\Controllers;

use App\Admin;
use Illuminate\Http\Request;

class AdminEmployeesController extends Controller
{
    public function save(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|unique:admins'
        ]);

        Admin::create($this->prepare_date($request));

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
        $employee->update(['password' => bcrypt($this->get_default_pass())]);
        return redirect()->route('admin.employees');
    }

    public function changeRole($id)
    {
        $employee = Admin::find($id);
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
}
