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
    Private $database;
    Private $bucket;

    public function __construct()
    {
        $this->middleware('auth');
        $serviceAccount = ServiceAccount::fromJsonFile(__DIR__.'/FirebaseKey.json');
        $firebase = (new Factory)
        ->withServiceAccount($serviceAccount)
        ->withDefaultStorageBucket('successmode-c4782.appspot.com')
        ->create();

        $this->database = $firebase->getDatabase()->getReference('/songs');
        $storage = $firebase->getStorage();
        $this->bucket=$storage->getBucket();
        
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       // $users =  DB::table('users')->paginate(10);
        $ref=$this->database;
       // $ref=$_database->getReference();
        $songs=$ref->getValue();
        
        if($songs!=NULL)
        {    
            foreach ($songs as $song) {
                 $allSongs[]=$song;
             }
        }
        else  {
                 $allSongs=[];
             }     

        return view('songs.index',['songs'=>$allSongs]);
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

        ini_set('post_max_size', '100M'); 
        ini_set('upload_max_filesize', '100M'); 
        ini_set('memory_limit', '1000M'); 
        ini_set('max_execution_time', '1920');

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
