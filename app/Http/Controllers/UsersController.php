<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\User;

class UsersController extends Controller
{
    public function __construct()
    {
        //使用 Laravel 提供身份验证（Auth）中间件来过滤未登录用户的 edit, update 动作。
        //我们通过 except 方法来设定 指定动作 不使用 Auth 中间件进行过滤，意为 —— 除了此处指定的动作以外，所有其他动作都必须登录用户才能访问，类似于黑名单的过滤机制
        $this->middleware('auth', [
            'except' => ['show', 'create', 'store','index']
        ]);

        //只让未登录用户访问注册页面
        $this->middleware('guest', [
            'only' => ['create']
        ]);
    }

    /*
     * 根据我们前面使用 resource 方法生成的符合 RESTful 架构的路由可知，用户列表对应用户控制器的 index 动作，页面 URL 对应 /users。
     * 接下来我们将在用户控制器中加入 index 动作。
     * 并且因为用户列表的访问权限是公开的，所以我们还需要在 Auth 中间件 except 中新增 index 动作来允许游客访问
     * */
    public function index()
    {
        //$users = User::all();
        $users = User::paginate(10);
        return view('users.index', compact('users'));
    }

    public function create()
    {
        //echo phpinfo();die;
        return view('users.create');
    }

    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:50',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|confirmed|min:6'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        Auth::login($user);

        session()->flash('success', '欢迎，您将在这里开启一段新的旅程~');
        return redirect()->route('users.show', [$user]);
    }

    public function edit(User $user)
    {
        //var_dump($user->id);die;//2
        //authorize 方法接收两个参数，第一个为授权策略的名称，第二个为进行授权验证的数据。
        //这里 update 是指授权类里的 update 授权方法，$user 对应传参 update 授权方法的第二个参数。
        //正如上面定义 update 授权方法时候提起的，调用时，默认情况下，我们 不需要 传递第一个参数，
        //也就是当前登录用户至该方法内，因为框架会自动加载当前登录用户。
        $this->authorize('update', $user);
        return view('users.edit', compact('user'));
    }

    public function update(User $user, Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:50',
            'password' => 'nullable|confirmed|min:6'
        ]);

        $this->authorize('update', $user);

        $data = [];
        $data['name'] = $request->name;
        if ($request->password) {
            $data['password'] = bcrypt($request->password);
        }
        $user->update($data);

        session()->flash('success', '个人资料更新成功！');

        return redirect()->route('users.show', $user->id);
    }

    public function destroy(User $user)
    {
        //使用 authorize 方法来对删除操作进行授权验证即可。在删除动作的授权中，我们规定只有当前用户为管理员，且被删除用户不是自己时，授权才能通过
        $this->authorize('destroy', $user);
        $user->delete();
        session()->flash('success', '成功删除用户！');
        return back();
    }
}
