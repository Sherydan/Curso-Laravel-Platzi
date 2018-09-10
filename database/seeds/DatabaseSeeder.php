<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);

        # a cada usuario le creo 10 mensajes
        # clase a crear (user) veces (times) por cada usuario hacer (each)
        # la funcion anonima recibe el usuaruio (App\User $user)
        # dentro de la funcion anonima, creo un mensaje
        # en la funcion create, le digo que la columna "user_id" debe ser igual
        # al id del usuario que le pase en la funcion 
        
        $users = factory(App\User::class)->times(50)->create();
        $users->each( function (App\User $user) use ($users){
            $messages = factory(App\Message::class)->times(10)->create([
                'user_id' => $user->id,
            ]);

            $messages->each(function (App\Message $message) use ($users){
                factory(App\Response::class, random_int(1, 10))->create([
                    'message_id' => $message->id,
                    'user_id' => $users->random(1)->first()->id,
                ]);
            });
            /*
            Syncing Associations
            You may also use the sync method to construct many-to-many associations. The sync method accepts an array of IDs to place on the intermediate table. Any IDs that are not in the given array will be removed from the intermediate table. So, after this operation is complete, only the IDs in the given array will exist in the intermediate table:
            */
            $user->follows()->sync(
                $users->random(10)
            );

        });
        
    }
}
