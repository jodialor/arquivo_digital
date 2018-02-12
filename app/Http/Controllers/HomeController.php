<?php

namespace App\Http\Controllers;
use DB;
use App\Quotation;
use illuminate\Http\Request;
use illuminate\Http\Response;
use App\User;
use App\Document;
use Illuminate\Support\Facades\Auth;


class HomeController extends Controller
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard');
    }
    public function getlogout(){
      Auth::logout();
      return redirect()->route('login');
    }
    public function getDashboard(){
      $doc=DB::table('documents')
            ->join('users', 'users.id', '=', 'documents.id_user')
            ->join('type_docs', 'type_docs.id', '=', 'documents.id_tipo_doc')
            ->join('departments', 'departments.id', '=', 'documents.id_departamento')
            ->select('documents.*', 'type_docs.type', 'users.name','departments.abbreviation')
            ->get();

      $user=DB::table('users')
      ->select('users.*')
      ->get();

      $departs=DB::table('departments')
      ->select('departments.*')
      ->get();

      $doc_types=DB::table('type_docs')
      ->select('type_docs.*')
      ->get();

      return view('dashboard', compact("doc","user","departs","doc_types"));
      //['doc'=>$doc], ['user'=>$user], ['departments'=>$departments], ['doc_types'=>$doc_types]
    }

    public function getLogin(){

      return redirect()->route('login');
    }

    public function postInsert(Request $request){
      //id e ano do ultimo documento inserido na BD
      $id_last_doc = DB::table('documents')->latest('id')->first()->id;
      $year_last_doc = DB::table('documents')->where('id', $id_last_doc)->value('year');

      //Validation
      $year=date("Y");
      $this->validate($request,[
        'utilizador' => 'required',
        'assunto' => 'required',
        'data' => 'required',
        'dest' => 'required',
        'type_doc' => 'required',
        'departamento' => 'required'
      ]);

      $id_user = $request["utilizador"];
      $assunto = $request["assunto"];
      $data = $request["data"];
      $receiver = $request["dest"];
      $id_tipo_doc = $request["type_doc"];
      $id_departamento =$request["departamento"];
      $file = '';

      // Inserir dados do documento na BD e obter o id do mesmo
      $id_doc_atual = DB::table('documents')->insertGetId([
           'number' => 0,
           'year' => $year,
           'id_user' => $id_user,
           'assunto' => $assunto,
           'data' => $data,
           'receiver' => $receiver,
           'id_tipo_doc' => $id_tipo_doc ,
           'id_departamento' => $id_departamento,
           'file' => $file
      ]);

      // Atribuir um número ao Documento criado, com base no ano em que foi criado

      //verificar se o ultimo doc existente foi ou não criado no ano atual
      if($year_last_doc != $year){  // se tiver sido num ano diferente, faz o seguinte
        // Obter todos os anos em que existam documentos criados
        $years_with_docs = DB::table('documents')->select('year')->distinct()->get()->toArray();

        foreach ($years_with_docs as $key => $at_year) {
          // verificar se no ano atual já existem docs
          if($year == $at_year->year){  // se sim, procura o número max e incrementa 1
            $max_number = DB::table('documents')->where('year', $year)->max('number');
            $doc_number = $max_number + 1;
            break;
          }
          else{ // caso contrário, atribui o valor "1" ao numero (corresponde ao 1º doc do ano em questão)
            $doc_number = 1;
          }
        }
      } else{ // caso os documentos sejam do mesmo ano, procura o número max e incrementa 1
          $max_number = DB::table('documents')->where('year', $year)->max('number');
          $doc_number = $max_number + 1;
      }

      // Inserir numero do documento na BD
      DB::table('documents')
        ->where('id', $id_doc_atual)
        ->update(['number' => $doc_number]);

      return redirect()->route('dashboard')->with(['message'=>'O documento foi Inserido com sucesso!']);;
    }

    public function postDeleteDoc(Request $request){
      $id_doc_apagar=$request["apaga_doc"];
      DB::table('documents')->where('id', '=',$id_doc_apagar)->delete();

      return redirect()->route('dashboard')->with(['message'=>' O documento foi Apagado com sucesso!']);
    }

    public function postEditDoc(Request $request){
      //Validation
      $this->validate($request,[
        'utilizador_edi' => 'required',
        'assunto_edi' => 'required',
        'date_edi' => 'required',
        'dest_edi' => 'required',
        'type_doc_edi' => 'required',
        'departamento_edi' => 'required',
        'id'=> 'required'
      ]);
      $year=date("Y");
      $id = $request['id'];
      $id_user = $request["utilizador_edi"];
      $assunto = $request["assunto_edi"];
      $data = $request["date_edi"];
      $receiver = $request["dest_edi"];
      $id_tipo_doc = $request["type_doc_edi"];
      $id_departamento =$request["departamento_edi"];
      $file = '';

      DB::table('documents')
            ->where('id', $id)
            ->update(['year' => $year,
             'id_user' => $id_user,
             'assunto' => $assunto,
             'data' => $data,
             'receiver' => $receiver,
             'id_tipo_doc' => $id_tipo_doc ,
             'id_departamento' => $id_departamento,
             'file' => $file]);
      return redirect()->route('dashboard')->with(['message'=>'O documento foi Alterado com sucesso!']);
    }

    // Atribuir número ao Documento criado
    public function generateDocNumber(int $year_last_doc, int $year){
      //verificar se o ultimo documento existente foi criado no ano atual
      if($year_last_doc != $year){
        $years_with_docs = DB::table('documents')->select('year')->distinct()->get()->toArray();

        foreach ($years_with_docs as $key => $at_year) {
          if($year == $at_year->year){
            $max_number = DB::table('documents')->where('year', $year)->max('number');
            $doc_number = $max_number + 1;
            break;
          }
          else{
          $doc_number = 1;
          }
        }
      } else{
        $max_number = DB::table('documents')->where('year', $year)->max('number');
        $doc_number = $max_number + 1;
      }
      return $doc_number;
    }

}
