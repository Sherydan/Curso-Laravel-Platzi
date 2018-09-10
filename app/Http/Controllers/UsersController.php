<?php

namespace App\Http\Controllers;
\Debugbar::disable();
use Exception;
use Illuminate\Http\Request;
use App\User;
use App\Conversation;
use App\PrivateMessage;
use App\Notifications\UserFollowed;
class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($username)
    {        
        $user = $this->findByUsername($username);
        
        return view('users.show', [
            'user' => $user,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    public function follows($username){
        $user = $this->findByUsername($username);

        return view('users.follows', [
            'user' => $user,
            'follows' => $user->follows,

        ]);
    }

    public function follow($username, Request $request){
        $user = $this->findByUsername($username);
        $me = $request->user();
        
        $me->follows()->attach($user);

        # $user = el usuario al que sigo, $me yo
        # notifica al usuario que yo lo sigo
        $user->notify(new UserFollowed($me));

        return redirect("users/$username")->withSuccess('Usario seguido!');
    }

    public function unfollow($username, Request $request){
        $user = $this->findByUsername($username);
        $me = $request->user();
        
        $me->follows()->detach($user);

        return redirect("users/$username")->withSuccess('Usario no seguido!');
    }

    public function followers($username){
        $user = $this->findByUsername($username);

        return view('users.follows', [
            'user' => $user,
            'follows' => $user->followers
        ]);
    }

    public function sendPrivateMessage($username, Request $request){
        $user = $this->findByUsername($username);

        $me = $request->user();
        $message = $request->input('message');

        # busco la conversacion, puede encontrar una antigua o crear una nueva,
        # pero siempre devolvera una conversacion
        $conversation = Conversation::between($me, $user);

        $privateMessage = PrivateMessage::create([
            'conversation_id' => $conversation->id,
            'user_id' => $me->id,
            'message' => $message,
        ]);

        return redirect('/conversations/'.$conversation->id);
    }

    public function showConversations(Conversation $conversation){
        # cargar relaciones
        $conversation->load('users', 'privateMessages');
        
        return view('users.conversation', [
            'conversation' => $conversation,
            'user' => auth()->user(),
        ]);
    }

    public function notifications(Request $request){
        # devolver todas las notificaciones del usuario logeado
        # recordar que $request siempre tiene el usuario logeado en su array
        return $request->user()->notifications;
    }

    private function findByUsername($username){
        return User::where('username', $username)->firstOrFail();

    }

    
}
