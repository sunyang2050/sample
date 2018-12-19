<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

/*
 * 在完成对未登录用户的限制之后，接下来我们要限制的是已登录用户的操作，当 id 为 1 的用户去尝试更新 id 为 2 的用户信息时，
 * 我们应该返回一个 403 禁止访问的异常。在 Laravel 中可以使用 授权策略 (Policy) 来对用户的操作权限进行验证，在用户未经授权进行操作时将返回 403 禁止访问的异常。
 * 我们可以使用以下命令来生成一个名为 UserPolicy 的授权策略类文件，用于管理用户模型的授权。
 * $ php artisan make:policy UserPolicy
 */
class UserPolicy
{
    use HandlesAuthorization;

    /*
     * 所有生成的授权策略文件都会被放置在 app/Policies 文件夹下。
    让我们为默认生成的用户授权策略添加 update 方法，用于用户更新时的权限验证

    update 方法接收两个参数，第一个参数默认为当前登录用户实例，第二个参数则为要进行授权的用户实例。
    当两个 id 相同时，则代表两个用户是相同用户，用户通过授权，可以接着进行下一个操作。
    如果 id 不相同的话，将抛出 403 异常信息来拒绝访问。
    */
    public function update(User $currentUser, User $user)
    {
        //var_dump($currentUser->id,$user->id);die;
        return $currentUser->id === $user->id;
    }

    //只有当前登录用户为管理员才能执行删除操作；
    //删除的用户对象不是自己（即使是管理员也不能自己删自己）
    public function destroy(User $currentUser, User $user)
    {
        return $currentUser->is_admin && $currentUser->id !== $user->id;
    }
}
