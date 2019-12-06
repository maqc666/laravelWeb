<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Finder\Exception\AccessDeniedException;

class UsersController extends Controller
{
    public function me(){
        return $this->show(Auth::id());
    }
    public function show($id){
        $user=User::find($id);
        $user->links=true;
        return $this->response()->item($user,new UserTransformer());
    }

    public function update($id,UpdateUserRequest $request){
        $user=User::findOrFail($id);

        if(Gate::denies('update',$user)){
            throw new AccessDeniedHttpException();
        }
        try{
            $user=$request->performUpdate($user);
            return $this->response()->item($user,new UserTransformer());
        }catch(ValidatorException $e){
            throw new UpdateResourceFailedException('无法更新用户信息：'. output_msb($e->getMessageBag()));

        }
    }
}
