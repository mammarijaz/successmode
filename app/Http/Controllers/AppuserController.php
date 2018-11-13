<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Kreait\Firebase;
use Kreait\Firebase\Factory;
use Google\Cloud\Firestore\FirestoreClient;
use Kreait\Firebase\ServiceAccount;


class AppuserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    Private $refUsers;

    public function __construct()
    {
        $this->middleware('auth');
     /*   $serviceAccount = ServiceAccount::fromJsonFile(__DIR__.'/FirebaseKey.json');
        $firebase = (new Factory)
        ->withServiceAccount($serviceAccount)
        ->create();  */
        putenv('GOOGLE_APPLICATION_CREDENTIALS='.__DIR__.'/FirebaseKey.json');

        $firestore = new FirestoreClient();

        $collectionReference = $firestore->collection('version');
        $this->refUsers = $collectionReference->document('1')->collection('smuser');
       // print_r( get_class_methods($firebase->getDatabase()  ) );

       // export GOOGLE_APPLICATION_CREDENTIALS=__DIR__.'/keyfile.json';
      //  $db = new FirestoreClient();
       // printf('Created Cloud Firestore client with default project ID.' . PHP_EOL);

    

        
        
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       // $users =  DB::table('users')->paginate(10);
       $usersRef=$this->refUsers->documents();
       // $ref=$_database->getReference();
        $users=[];
        if( !empty($usersRef) )
        {    
            
            foreach ($usersRef as $user) {
                $users[]=$user;
             }
        }

        return view('appusers.index',['users'=>$users]);
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
        $_database=$this->database;
        $_bucket=$this->bucket;
        $validated = $request->validated();
         
        
        $fileName=$request->file('songFile')->getClientOriginalName();

        $newSong = $_database
                ->push([
                     'title' => $validated['name'],
                     'originalFileName'=>$fileName
                ]);
        $firebaseSongKey=$newSong->getKey();

        $path=$request->file('songFile')->getRealPath();
        $contentType=$request->file('songFile')->getMimeType();   
        
        
        $f = fopen($path, 'r');
        $fireBaseFile='Meditations'.$firebaseSongKey;
        $newSongStorage=$_bucket->upload($f, [
            'metadata' => ['contentType' => $contentType],
            'name' => 'meditations/'.$fireBaseFile,
            'predefinedAcl' => 'publicRead',
        ]);

        $newSong->update([
                        'url'=>$newSongStorage->gcsUri(),
                         'fileName'=>$fireBaseFile 
                        ]);
        return redirect('/admin/songs')->with('status', 'Song is added successfully!!!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show($fileName)
    {
        $id=str_replace("Meditations","",$fileName);
        $song=$this->database->getChild($id)->getValue();
        return view('songs.show', ['song' => $song]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit($fileName)
    {
        $id=str_replace("Meditations","",$fileName);
        $song=$this->database->getChild($id)->getValue();
        return view('songs.edit', ['song' => $song]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $fileName)
    {
        $id=str_replace("Meditations","",$fileName);
        $song=$this->database->getChild($id);
        
        $song->update([
                        'title'=>$request->input('title') 
                        ]);
        return redirect('/admin/songs')->with('status', 'Song is updated successfully!!!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($fileName)
    {
        
        $id=str_replace("Meditations","",$fileName);
        $song=$this->database->getChild($id)->remove();
        $object=$this->bucket->object('meditations/'.$fileName); 
        $object->delete();
        return redirect('/admin/songs')->with('status', 'Song is deleted successfully!!!');
    }
}
