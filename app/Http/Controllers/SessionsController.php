<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class SessionsController extends Controller
{


    /**
     * SessionsController constructor.
     */
    public function __construct()
    {
        $this->middleware('guest', [
            'only' => ['create']
        ]);
    }


    /**
     * 登录显示页面
     * @User: w
     * @Date: 2021/9/17
     * @Time: 下午10:46
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('sessions.create');
    }


    /**
     * 登录
     * @User: w
     * @Date: 2021/9/17
     * @Time: 下午10:53
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $credentials = $this->validate($request, [
            'email' => 'required|email|max:255',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials, $request->has('remember'))) {
            session()->flash('success', '欢迎回来！');
            $fallback = route('users.show', Auth::user());
            return redirect()->intended($fallback);
        } else {
            session()->flash('danger', '很抱歉，您的邮箱和密码不匹配');
            return redirect()->back()->withInput();
        }
    }

    /**
     * 退出
     * @User: w
     * @Date: 2021/9/17
     * @Time: 下午11:01
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy()
    {
        Auth::logout();
        session()->flash('success', '您已成功退出！');
        return redirect('login');
    }

}
