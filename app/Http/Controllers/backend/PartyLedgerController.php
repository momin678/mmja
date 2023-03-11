<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Journal;
use App\PartyInfo;
use Illuminate\Http\Request;

class PartyLedgerController extends Controller
{
        //work by tarek
        public function partyLedger()
        {
            $parties=PartyInfo::get();
            return view('backend.partyLedger.partyLedger',compact('parties'));
        }

        public function findPartyLedgers(Request $request)
        {
                        $partyInfo=PartyInfo::find($request->party);

                $journals=Journal::where('party_info_id',$request->party)->whereDate('date','>=',$request->from)->whereDate('date','<=',$request->to)->select('date','party_info_id')->distinct()->get();
                if ($request->ajax()) {
                    return Response()->json([
                        'page' => view('backend.partyLedger.partyLedgerAjax', ['journals'=>$journals,'from'=>$request->from,'to'=>$request->to,'partyInfo'=>$partyInfo])->render(),
                        'success' => true,
                    ]);
                }
        }


        public function findPartyLedgersDate(Request $request)
        {
            // return $request->all();
            $partyInfo=PartyInfo::find($request->party);
                $journals=Journal::where('party_info_id',$request->party)->whereDate('date',$request->date)->select('date','party_info_id')->distinct()->get();
                if ($request->ajax()) {
                    return Response()->json([
                        'page' => view('backend.partyLedger.partyLedgerDateAjax', ['journals'=>$journals,'date'=>$request->date,'partyInfo'=>$partyInfo])->render(),
                        'success' => true,
                    ]);
                }
        }


        public function printLedger($from,$to,$party)
        {
                $partyInfo=PartyInfo::find($party);
                $journals=Journal::where('party_info_id',$party)->whereDate('date','>=',$from)->whereDate('date','<=',$to)->select('date','party_info_id')->distinct()->get();
                return view('backend.partyLedger.partyLedgerPrint',compact('journals','from','to','party','partyInfo'));
        }

        public function printLedgerDate($date,$party)
        {
            // dd(1);
                $partyInfo=PartyInfo::find($party);
                $journals=Journal::where('party_info_id',$party)->whereDate('date',$date)->select('date','party_info_id')->distinct()->get();
                // dd($journals);
                return view('backend.partyLedger.partyLedgerPrint',compact('journals','date','party','partyInfo'));
        }

        public function new_party_ledger(Request $request){
            $parties=PartyInfo::get();
            return view('backend.partyLedger.new-party-ledger',compact('parties'));
        }
}
