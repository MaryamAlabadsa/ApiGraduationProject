<?php

namespace App\Http\Controllers\control_panel;

use App\Http\Controllers\Api\Profile\ProfileController;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Post;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
            $users = User::all();

            return view('users.index');
      }
    public function getData(Request $request)
    {
//        dd('$areas');
        $columns = array(

            array('db' => 'email', 'dt' => 2),
            array( 'db' => 'id',   'dt' => 0 )
        );

        $draw = (int)$request->draw;
        $start = (int)$request->start;
        $length = (int)$request->length;
        $order = $request->order[0]["column"];
        $direction = $request->order[0]["dir"];
        $search = trim($request->search["value"]);


        $value = array();

        if (!empty($search)) {
            $count = User::search($search)
                ->count();
            $items = User::search($search)
                ->limit($length)->offset($start)->orderBy($columns[$order]["db"], $direction)
                ->get();
        } else {
            $count = User::count();
            $items = User::
            limit($length)->offset($start)->orderBy($columns[$order]["db"], $direction)
                ->get();
        }
        foreach ($items as $index => $item) {
//            dd($item->unPaidMaterials);
            array_push($value, $item->Post_display_data);
        }
        return [
            "draw" => $draw,
            "recordsTotal" => $count,
            "recordsFiltered" => $count,
            "data" => (array)$value,
            "order" => $columns[$order]["db"]
        ];
//        return $areas;
    }



    public function showUserProfileCard(Request $request)
    {
        $userId=$request->id;
        $user = User::where('id', $userId)->first();
        $num_donation_posts= count($this->DonationPosts($userId));
        $num_request_posts= count($this->RequestPosts($userId));

        return response()->json(['view' => view('profile.userProfileCard', compact('user', 'num_donation_posts','num_request_posts'))->render(), 'User_id' =>$userId]);
    }





    public function RequestPosts($userId)
    {
        $posts = Post::where([['is_donation', '=', 1], ['first_user', '=', $userId]
        ])->get();
        $orders = Order::whereIn('post_id', Post::select('id')->where('is_donation', 0)->get())->where('user_id', $userId)->get();
        $all_data = $orders->merge($posts);
        $all_sorted_data = $all_data->sortByDesc('created_at');
        $data = array();
        foreach ($all_sorted_data as $all_sorted_datum) {
            array_push($data, $all_sorted_datum->get_data);
        }
        return $data;
    }

    public function DonationPosts($userId)
    {
        $posts = Post::where([['is_donation', '=', 0]
            , ['first_user', '=', $userId]
        ])->get();
        $orders = Order::whereIn('post_id', Post::select('id')->where('is_donation', 1)->get())->where('user_id', $userId)->get();

//        dd($orders);
        $all_data = $orders->merge($posts);
        $all_sorted_data = $all_data->sortByDesc('created_at');
        $data = array();
        foreach ($all_sorted_data as $all_sorted_datum) {
            array_push($data, $all_sorted_datum->get_data);
        }
        return $data;
    }










    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
//        $users = new User();
//        return view('users.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\StoreUserRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {

//        $user = User::create([
//            'name' => $request->name,
//            'email' => $request->email,
//            'phone' => $request->phone,
//            'password' => Hash::make($request->password),
////            'isAdmin' =>1
//        ]);
//        $user->update(['is_admin' =>1]);
//

//        event(new Registered($user));

//        return redirect('/users')->with('success', 'You have successfully add user.');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateUserRequest $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\User $user
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function destroy(User $user)
    {
//        $user->delete();
//        return redirect('/users')->with('success', 'You have successfully delete post.');
    }
}
