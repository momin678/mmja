
    <section id="widgets-Statistics">
        @isset($journalF)
        <form action="{{ route('journalEntryEditPost', $journalF) }}" method="POST" enctype="multipart/form-data" class="mt-2">
        @else
            <form action="{{ route('journalEntryPost') }}" method="POST" enctype="multipart/form-data">
            @endisset

            @csrf
            <div class="cardStyleChange">
                <div class="card-body">
                    <h4 class="mb-2">Journal Entry</h4>
                    <div class="row">
                        <div class="col-sm-2 form-group">
                            <label for="">Journal Entry No</label>
                            <input type="text" class="form-control inputFieldHeight" id="journal_no"
                                value="{{ isset($journalF) ? $journalF->journal_no : "$journal_no" }}"
                                name="journal_no" placeholder="Journal Entry No" readonly>
                            @error('journal_no')
                                <div class="btn btn-sm btn-danger">{{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-sm-4 form-group">
                            <label for="">Project</label>
                            <select name="project" class="common-select2" style="width: 100% !important" id="project"
                                required>
                                @foreach ($projects as $item)
                                    <option value="{{ $item->id }}"
                                        {{ isset($journalF) ? ($journalF->project_id == $item->id ? 'selected' : '') : '' }}>
                                        {{ $item->proj_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('project')
                                <div class="btn btn-sm btn-danger">{{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-sm-2 form-group">
                            <label for="">Cost Center Code</label>
                            <input type="text" name="cc_code" id="cc_code"
                                value="{{ isset($journalF) ? $journalF->costCenter->cc_code : '' }}"
                                class="form-control inputFieldHeight" placeholder="Cost Center Code"
                                required>
                            @error('cc_code')
                                <div class="btn btn-sm btn-danger">{{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-sm-4 form-group search-item">
                            <label for="">Cost Center Name</label>
                            <select name="cost_center_name" id="cost_center_name"
                            class="common-select2 party-info " style="width: 100% !important" data-target="" required>
                                <option value="">Select...</option>
                                @foreach ($cCenters as $item)
                                    <option value="{{ $item->id }}"
                                        {{ isset($journalF) ? ($journalF->cost_center_id == $item->id ? 'selected' : '') : '' }}>
                                        {{ $item->cc_name }}</option>
                                @endforeach
                            </select>
                            @error('cost_center_name')
                                <div class="btn btn-sm btn-danger">{{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-sm-2 form-group">
                            <label for="">Party Code</label>
                            <input type="text" name="pi_code" id="pi_code" class="form-control inputFieldHeight" name="" id="" required>
                            @error('party_info')
                                <div class="btn btn-sm btn-danger">{{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-sm-5 form-group search-item-pi">
                            <label for="">Party Name</label>
                            <select name="party_info" id="party_info"
                            class="common-select2 party-info" style="width: 100% !important" data-target="" required>
                                <option value="">Select...</option>
                                @foreach ($pInfos as $item)
                                    <option value="{{ $item->id }}"
                                        {{ isset($journalF) ? ($journalF->party_info_id == $item->id ? 'selected' : '') : '' }}>
                                        {{ $item->pi_name }}</option>
                                @endforeach
                            </select>
                            @error('party_info')
                                <div class="btn btn-sm btn-danger">{{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-sm-2 form-group">
                            <label for="">TRN</label>
                            <input type="text" class="form-control inputFieldHeight"
                                value="{{ isset($journalF) ? $journalF->partyInfo->trn_no : '' }}"
                                name="trn_no" id="trn_no" class="form-control" readonly>
                            @error('trn_no')
                                <div class="btn btn-sm btn-danger">{{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-sm-3 form-group">
                            <label for="">Invoice No</label>
                            <input type="text" class="form-control inputFieldHeight" name="invoice_no"
                                value="{{ isset($journalF) ? $journalF->invoice_no : '' }}"
                                id="invoice_no" placeholder="Invoice No" required>
                            @error('invoice_no')
                                <div class="btn btn-sm btn-danger">{{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-sm-4 form-group">
                            <label for="">Transaction Type</label>
                            <select name="transaction_type" id="transaction_type"   class="common-select2 " style="width: 100% !important"
                                required>
                                <option value="Increase" selected>General</option>
                                <option value="Decrease">Adjustment</option>
                            </select>
                            @error('transaction_type')
                                <div class="btn btn-sm btn-danger">{{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-sm-4 form-group">
                            <label for="">Payment Mode</label>
                            <select name="pay_mode" id="pay_mode"   class="common-select2 " style="width: 100% !important"
                                required>
                                <option value="">Select...</option>
                                
                                @foreach ($modes as $item)
                                    <option value="{{ $item->title }}"
                                        {{ isset($journalF) ? ($journalF->txn_mode == $item->title ? 'selected' : '') : '' }}>
                                        {{ $item->title }}</option>
                                @endforeach
                                <option value="NonCash">Special Transaction</option>
                                
                            </select>
                            @error('pay_mode')
                                <div class="btn btn-sm btn-danger">{{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-sm-2 form-group" id="printarea">
                            <label for="">Journal Date</label>
                            <input type="date" value="{{ isset($journalF) ? $journalF->date : Carbon\Carbon::now()->format('Y-m-d') }}" class="form-control inputFieldHeight" name="date" id="date" placeholder="dd-mm-yyyy" >
                            @error('date')
                                <div class="btn btn-sm btn-danger">{{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-sm-4 form-group non-cash-account-head" style="display: {{ isset($journalF) ? ($journalF->txn_mode == "Credit" ? '' : 'none') : 'none' }}">
                            <label for="">Account Head</label>
                            <select name="acc_head_2" id="acc_head_2" class="common-select2" style="width: 100% !important"
                                >
                                <option value="">Select...</option>
                                @foreach ($acHeads as $item)
                                    <option value="{{ $item->id }}"
                                        {{ isset($journalF) ? ($journalF->ac_head_id == $item->id ? 'selected' : '') : '' }}>
                                        {{ $item->fld_ac_code }} - {{ $item->fld_ac_head }}</option>
                                @endforeach
                            </select>
                        </div> 
                    </div>
                </div>
            </div>
            <div class="cardStyleChange border-top">
                <div class="card-body">
                    <div class="repeater-default" id="form-repeat-container">
                        <div data-repeater-list="group-a">
                            <div data-repeater-item id="mResultShow">
                                <div class="row justify-content-between every-form-row">
                                    <div class="col-md-4 col-sm-12">
                                        <label for="invoice_no">A/C Head</label>
                                        <select name="multi_acc_head" class="form-control common-select2 multi-acc-head input-due-payment">
                                            <option value="">Select A/C Head</option>
                                            @foreach ($acHeads as $item)
                                                <option value="{{ $item->id }}"
                                                    {{ isset($journalF) ? ($journalF->ac_head_id == $item->id ? 'selected' : '') : '' }}>
                                                    {{ $item->fld_ac_head }}</option>
                                            @endforeach
                                            
                                        </select>
                                    </div>
                                    <div class="col-md-2 col-sm-12">
                                        <label for="password">Total Amount</label>
                                        <input type="number" name="multi_total_amount" class="form-control amount_withvat inputFieldHeight" placeholder="Total Amount">
                                    </div>
                                    <div class="col-md-2 col-sm-12">
                                        <label for="password">Vat Rate</label>
                                        <select name="multi_tax_rate"  class="common-select2 form-control multi-tax-rate inputFieldHeight" style="width: 100% !important"
                                        required>
                                        @foreach ($vats as $item)
                                            <option value="{{ $item->id }}" >
                                                {{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                    </div>

                                    <div class="col-md-2 col-sm-12">
                                        <label for="password">Amount</label>
                                        <input type="number" name="multi_amount" class="form-control amount_without_vat inputFieldHeight"  step="any" placeholder="Amount">
                                    </div>
                                    
                                    <div class="col-md-2 col-sm-12 form-group d-flex align-items-center pt-2">
                                        {{-- <button class="btn btn-danger text-nowrap px-1" data-repeater-delete type="button"> <i class="bx bx-x"></i>
                                            Delete
                                        </button> --}}
                                        <button type="button" class="btn btn-danger formButton mDeleteIcon" data-repeater-delete title="Delete">
                                            <div class="d-flex">
                                                <div class="formSaveIcon">
                                                    <img  src="{{asset('assets/backend/app-assets/icon/delete-icon.png')}}" alt="" srcset=""  width="25">
                                                </div>
                                                <div><span> Delete</span></div>
                                            </div>
                                        </button>
                                    </div>
                                </div>
                                <hr>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col p-0">
                                <button class="btn btn-primary btn_create" id="mAddNewHead" data-repeater-create type="button"><i class="bx bx-plus"></i>
                                    Add
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 col-12">
                            <div class="form-group">
                                <label for="class-name">Total Amount</label>
                                <input type="text" id="total_amount" class="form-control @error('total_amount') error @enderror" name="total_amount" value="{{ isset($fee_collection) && $fee_collection->total_amount ? $fee_collection->total_amount : 0}}" placeholder="Total" required>
                                @error('total_amount')
                                <span class="error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        
                    </div>

                    
                </div>
            </div>
            <div class="cardStyleChange">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-8 form-group">
                            <label for="">Narration</label>
                            <input type="text" class="form-control" name="narration"
                                id="narration" placeholder="Narration"
                                value="{{ isset($journalF) ? $journalF->narration : '' }}"
                                required>
                        </div>

                        <div class="col-sm-3 form-group">
                            <label for="">Voucher Scan/File</label>
                            <input type="file" class="form-control" name="voucher_scan" >
                        </div>

                        

                        <div class="col-sm-12 text-right">
                            <br>
                            <a href="{{ route('journalEntry') }}"
                                class="btn btn-primary {{ isset($journalF) ? '' : 'disabled' }}">New</a>
                            <button class="btn btn-info" type="submit">Submit</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </section>
