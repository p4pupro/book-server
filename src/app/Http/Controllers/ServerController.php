<?php
namespace App\Http\Controllers;
use App\Server;
use Illuminate\Http\Request;
use DB;
use Auth;

class ServerController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $user = Auth::user();

        $servers = DB::table('servers')
            ->select('servers.id as servId', 'servers.name as servName', 'servers.status as servStatus')
            ->get();
        return view('book', ['servers' => $servers]);    
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show()
    {
        $user = Auth::user();

        $serversFree = DB::table('servers')
            ->where('servers.status', 'like', 'free')
            ->select('servers.id as servId', 'servers.name as servName', 'servers.status as servStatus')
            ->get();

        $serversBusy = DB::table('reserved')
                ->leftJoin('users', 'users.id', '=', 'reserved.id_user')
                ->leftJoin('servers', 'servers.id', '=', 'reserved.id_server')
                ->where('servers.status', 'like', 'busy')
                ->select('users.name as devName', 'users.email as devEmail', 'servers.name as servName', 'servers.status as servStatus', 'servers.id as servId')
                ->get();

        $arrIds = [];
        foreach ($serversBusy as $id){ 
            $arrIds[] = [$id->servId];
        }
            
        
        $tempArrayBusy = [];
        foreach ($serversBusy as $busy){ 
            $tempArrayBusy[] = [$busy];
        }

        $tempArrayFree = [];
        foreach ($serversFree as $free){ 
            $tempArrayFree[] = [$free];
        }


        $allServers = array_merge($tempArrayBusy, $tempArrayFree);             

        return view('servers', ['servers' => $allServers]);
    }


    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, String $id)
    {
        $user = Auth::user();

        if (Auth::check()) {
            $serverOld = DB::table('servers')->where('id', '=', $id)->first();
            
            if($serverOld->status == 'free') {
                 $data = DB::table('servers')
                    ->where('id',  $id)
                    ->update(['status' => 'busy']);

                 $reservedByUser = DB::table('reserved')->insert(
                    ['id_user' => $user->id, 'id_server' => $id]
                 );

            } else {
                $userId = DB::table('reserved')->where('id_user', '=', $user->id)->select('reserved.id_user')->first();
                
                if($userId !== null && $userId->id_user === $user->id) {
                    $data = DB::table('servers')
                        ->where('id',  $id)
                        ->update(['status' => 'free']);

                    $unLookServer = DB::table('reserved')->where('id_server', '=', $id)->delete();    
                } else {

                  return redirect()->route('book-server')->withErrors(['errorNoOwner' => 'You can only unbook the servers you have book']); 
                  }
            }

        } else { 
           return redirect()->route('book-server')->withErrors(['errorNeedLogin' => 'You need to be login.']); 
        }

        
      
        if($data){
            return redirect()->route('server-status')->with('success', 'Server Updated Successfully');
        }else{
            return redirect()->route('server-status')->withErrors('error', 'No Changes');
        }
    }
  
}