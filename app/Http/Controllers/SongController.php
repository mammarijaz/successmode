<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Song\StoreSong;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Kreait\Firebase;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;


class SongController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       // $users =  DB::table('users')->paginate(10);
        return view('songs.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('songs.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSong $request)
    {
        $validated = $request->validated();
        $serviceAccount = ServiceAccount::fromJsonFile(__DIR__.'/FirebaseKey.json');
        $firebase = (new Factory)
        ->withServiceAccount($serviceAccount)
        ->withDefaultStorageBucket('successmode-c4782.appspot.com')
        ->create();

        $database = $firebase->getDatabase();
        $storage = $firebase->getStorage();
        $bucket=$storage->getBucket(); 
        

      /*  $newPost = $database
        ->getReference('/')
        ->push([
             'title' => 'Laravel FireBase Tutorial' ,
             'category' => 'Laravel'
        ]);
        echo '<pre>';
        print_r($newPost->getvalue()); */

       // var_dump( $request->file('songFile')-> );
       // die();
    //    $filesystem = $storage->getFilesystem('meditations');
     

        $path=$request->file('songFile')->getRealPath();
        $contentType=$request->file('songFile')->getMimeType();

        
        $fileName=$request->file('songFile')->getClientOriginalName();
        
        $f = fopen($path, 'r');
       
       /* $options = ['prefix' =>  'meditations/'];    
        foreach ($bucket->objects() as $object) {
                printf('Object: %s' . PHP_EOL, $object->name());
        }*/
       
        $bucket->upload($f, [
            'metadata' => ['contentType' => $contentType],
            'name' => 'meditations/'.$fileName,
            'predefinedAcl' => 'publicRead',
        ]); 
        

       /* $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
        ]); */
        return redirect('/admin/songs')->with('status', 'Song is added successfully!!!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('users.show', ['user' => $user]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('users.edit', ['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUser $request, User $user)
    {
        $validated = $request->validated();
        $user->name = $validated['name'];
        if(!empty($validated['password']))
            $user->password = bcrypt($validated['password']);
        $user->save();
        return redirect('/admin/users')->with('status', 'User is updated successfully!!!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect('/admin/users')->with('status', 'User is deleted successfully!!!');
    }
}
