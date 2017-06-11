<?php

namespace App\Http\Controllers;

use App\Ad;
use App\Admin;
use App\Role;
use App\User;
use App\AgentMeta;
use App\AgentSubscriber;
use Commerce\Transformers\Admin\AdTransformer;
use Commerce\Transformers\Admin\UsersTransformer;
use Commerce\Transformers\Admin\AgentsTransformer;
use Commerce\Transformers\Admin\AgentTransformer;
use Illuminate\Http\Request;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use Illuminate\Support\Facades\DB;

class AdminPagesController extends Controller
{
    /**
     * @var Manager
     */
    private $fractal;

    /**
     * AdminPagesController constructor.
     * @param Manager $fractal
     */
    public function __construct(Manager $fractal)
    {
        $this->fractal = $fractal;
    }

    public function dashboardPage()
    {
        return view('admin.pages.dashboard');
    }

    public function adsPage()
    {
        return view('admin.pages.ads');
    }

    public function adPage($uuid, Request $request)
    {
        if(!$request->has('action')) return redirect()->route('admin.ads');

        $ad = Ad::with('images', 'category', 'owner')->where('uuid', $uuid)->first();
        if(!$ad) return redirect()->route('admin.ads');

        $transformed_ad = $this->fractal->createData(new Item($ad, new AdTransformer))->toArray()['data'];

//        dd($transformed_ad);

        if($request->get('action') == 'view' && $ad->status == 'online'){
            return view('admin.pages.ad.view', ['ad' => $transformed_ad]);
        }elseif($request->get('action') == 'review'){
            return view('admin.pages.ad.review', ['ad' => $transformed_ad]);
        }

        return redirect()->route('admin.ads');
    }

    public function agentsPage()
    {
        $agents = Admin::where('role_id', 4)->get();
        $agents = $this->fractal->createData(new Collection($agents, new AgentsTransformer))->toArray()['data'];
        return view('admin.pages.agents', ['agents' => $agents]);
    }

    public function agentsNew()
    {
        
        DB::transaction(function(){
            $token = str_random(40);
            $agent = Admin::create([
                'name' => request()->name,
                'email' => request()->email,
                'status' => 'active',
                'role_id' => 4,
                'password' => bcrypt($token)
            ]);
            
            AgentMeta::create([
                'agent_id' => $agent->id,
                'link' => $this->generate_agent_link($token),
                'token' => $token
            ]);
        });

        return redirect()->back();
    }

    public function agentPage($id)
    {
        $meta = AgentMeta::where('token', $id)->first();
        if(!$meta) return redirect()->back();
        $agent = Admin::with('meta', 'subscribers')->find($meta->agent_id);
        if(!$agent) return redirect()->back();
        $agent = $this->fractal->createData(new Item($agent, new AgentTransformer))->toArray()['data'];
        // dd($agent);
        return view('admin.pages.agent', ['agent' => $agent]);
    }

    public function employeesPage()
    {
        $employees = Admin::all()
            ->reject(function($employee){
            return $employee->id == auth('admin')->user()->id;
        })
        ;
        $roles = Role::all();
        return view('admin.pages.employees', ['employees' => $employees, 'roles' => $roles]);
    }

    public function usersPage()
    {
        $users = User::with('location', 'ads')->get()->sortByDesc('created_at');
        $transformed = (new Manager())->createData(new Collection($users, new UsersTransformer()))->toArray()['data'];
        return view('admin.pages.users', ['users' => $transformed]);
    }

    public function usersSearch()
    {
        $q = request()->get('q');
        $user = User::with('ads')->where('phone', $q)->first();
        if(!$user) return ['incomplete_results' => false, 'items' => []];
        $agent = $this->get_agent($user);

        return response()->json([
            'incomplete_results' => false,
            'items' => [
                [
                    'name' => $user->name,
                    'phone' => $user->phone,
                    'agent' => $agent ? $agent->name : "N/A",
                    'url' => $agent ? route('admin.agent', ['id' => $agent->id]) : route('admin.agents'),
                    'ads' => $user->ads->count()
                ]
            ]
        ]);
    }

    private function get_agent($user)
    {
        $sub = AgentSubscriber::where('user_id', $user->id)->first();
        if(!$sub) return null;

        return Admin::find($sub->agent_id);
    }

    private function generate_agent_link($token)
    {
        $url = route('user.get.register');
        return "{$url}?a={$token}";
    }
}
