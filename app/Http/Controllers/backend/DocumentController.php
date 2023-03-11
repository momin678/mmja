<?php

namespace App\Http\Controllers\backend;

use App\AccountsDocument;
use App\AccountsDocumentItems;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search_value = '';
        $documents= AccountsDocument::orderBy('id', 'desc');
        if($request->document_name){
            $search_value = $request->document_name;
            $documents= $documents->where('name','LIKE', "%$request->document_name%");
        }
        $documents = $documents->get();
        return view('backend.accounts-document.index', compact('documents', 'search_value'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.accounts-document.form'); 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request;
        $this->validate($request, [
                'document_name' => 'required',
                'files' => 'required',
                'files.*' => 'mimes:doc,pdf,docx,zip,jpg,png,jpeg'
        ]);

        $account_document= new AccountsDocument;
        $account_document->name= $request->document_name;
        $account_document->save();

        if($account_document){
            foreach($request->file('files') as $file){
                $name= $file->getClientOriginalName();
                $name = pathinfo($name, PATHINFO_FILENAME);
                $ext= $file->getClientOriginalExtension();
                $account_doc_name= $name.time().'.'.$ext;
                
                $file->storeAs( 'public/upload/documents', $account_doc_name);
    
                AccountsDocumentItems::create([
                    'accounts_document_id'  => $account_document->id,
                    'display_name'          => $name,
                    'filename'              => $account_doc_name
                ]);
    
            }
        }

        $notification= array(
            'message'       => 'Document saved successfully!',
            'alert-type'    => 'success'
        );

        return redirect('document')->with($notification);
    }

    public function search(Request $request){
        // return $request;
        $documents= AccountsDocument::where('name','LIKE', "%$request->document_name%")->get();
        // return $documents;
        return view('backend.accounts-document.index', compact('documents'));
         
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
}
