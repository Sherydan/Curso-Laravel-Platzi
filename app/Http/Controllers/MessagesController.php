<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Message;
use App\Response;
use App\Http\Requests\CreateMessageRequest;

class MessagesController extends Controller
{
    public function __construct()
    {   
        # implementar middleware a todas las vistas, excepto index y show
        $this->middleware('auth', ['except' => ['index', 'show', 'search', 'responses']]);
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

    /**
     * cree un request custom, el cual valida el request autimaticamente
     * el request esta en App\http\requests
     */
    public function store(CreateMessageRequest $request)
    {   
        # otra forma de obetener el id de usuario
        # $user = $request->user();
        # $user->id;

        # laravel ya crea la imagen con un nombre al azar
        $image = $request->file('image');
        $message = Message::create([
            'user_id' => auth()->user()->id,
            'content' => $request->input('message'),
            'image' => $image->store('messages', 'public'),
        ]);

        return redirect('messages/'.$message->id);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    /**
     * En vez de darle como parametro show($id) le doy un show(Message $message)
     * En vez de eso utilizo la funcionalidad route model binding
     * Uso el parametro show(Message $message) y si no existe, falle directamente
     * De esta manera, al llevar a produccion, laravel inmediatamente mostrara
     * una pagina 404 cuando el recurso no se encuentre en la BD
     */
    public function show(Message $message)
    {
        return view('messages.show', ['message' => $message]);
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

    public function search(Request $request){
        $query = $request->input('query');

        # para optimizar la query, le digo que junto con el mensaje, me traiga inmediatamente el user ligado a el
        # todo es posible gracias a la relacion que declare llamada "user" en el modelo de Message
        # (ver debugbar para verificar que query se repiten)
        $messages = Message::search($query)->paginate(10);
        # lo mismo que con with, le digo que cargue los usuarios
        $messages->load('user');

        return view('messages.index', [
            'messages' => $messages,
        ]);
    }

    public function responses(Message $message){
        # laravel automaticamente convierte a JSON el objeto de eloquent
        $responses = Response::with('user')->where('message_id', $message->id)->get();
        
        return $responses;
    }
}
