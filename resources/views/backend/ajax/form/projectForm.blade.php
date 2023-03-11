@isset($proj)
<form action="{{ route('projectDetailsUpdate', $proj) }}" method="POST">
@else
    <form action="{{ route('projectDetailsPost') }}" method="POST">
    @endisset
    @csrf

<div class="row match-height">



    <div class="col-md-6">

        <div class="form-body">
            <div class="row">

                <div class="col-md-4">
                    <label>Project No</label>
                </div>
                <div class="col-md-8 form-group">
                    <input type="text" id="" class="form-control"
                        name=""
                        value="{{ isset($p_code)? $p_code:"" }}"
                        placeholder="Project No" disabled readonly>
                    @error('proj_no')
                        <div class="btn btn-sm btn-danger">{{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label>Project Name</label>
                </div>
                <div class="col-md-8 form-group">
                    <input type="text" id="proj_name" class="form-control"
                        name="proj_name"
                        value="{{ isset($proj) ? $proj->proj_name : '' }}"
                        placeholder="Project Name" required>
                    @error('proj_name')
                        <div class="btn btn-sm btn-danger">{{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label>Type</label>
                </div>
                <div class="col-md-8 form-group">
                    <select name="proj_type" class="common-select2" style="width: 100% !important" id=""
                        required>
                        <option value="">Select...</option>
                        @foreach ($projectTypes as $item)
                            <option value="{{ $item->title }}"
                                {{ isset($proj->proj_type) ? ($proj->proj_type == $item->title ? 'selected' : '') : '' }}>
                                {{ $item->title }}</option>
                        @endforeach
                    </select>
                    @error('proj_type')
                        <div class="btn btn-sm btn-danger">{{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label>Consulting Agent</label>
                </div>
                <div class="col-md-8 form-group">
                    <input type="text" id="cons_agent"
                        class="form-control"
                        value="{{ isset($proj) ? $proj->cons_agent : '' }}"
                        name="cons_agent" placeholder="Consulting Agent"
                        required>
                    @error('cons_agent')
                        <div class="btn btn-sm btn-danger">{{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label>Site Location</label>
                </div>
                <div class="col-md-8 form-group ">
                    <input type="text" id="address" class="form-control"
                        name="address"
                        value="{{ isset($proj) ? $proj->address : '' }}"
                        placeholder="Site Location" required>
                    @error('address')
                        <div class="btn btn-sm btn-danger">{{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-body">
            <div class="row">

                <div class="col-md-4">
                    <label>Owner Name</label>
                </div>
                <div class="col-md-8 form-group">
                    <input type="text" id="owner_name"
                        class="form-control" name="owner_name"
                        value="{{ isset($proj) ? $proj->owner_name : '' }}"
                        placeholder="Owner Name" required>
                    @error('owner_name')
                        <div class="btn btn-sm btn-danger">{{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label>Mobile Phone Number
                    </label>
                </div>
                <div class="col-md-8 form-group">
                    <input type="number" id="cont_no" class="form-control"
                        name="cont_no"
                        value="{{ isset($proj) ? $proj->cont_no : '' }}"
                        placeholder="Mobile" required>

                    @error('cont_no')
                        <div class="btn btn-sm btn-danger">{{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label>Work Order Date</label>
                </div>
                <div class="col-md-8 form-group">
                    <input type="date" id="ord_date" class="form-control"
                        name="ord_date"
                        value="{{ isset($proj) ? $proj->ord_date : '' }}"
                        placeholder="Work Order Date" required>
                    @error('ord_date')
                        <div class="btn btn-sm btn-danger">{{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label>Handover Date</label>
                </div>
                <div class="col-md-8 form-group">
                    <input type="date" id="hnd_over_date"
                        class="form-control" name="hnd_over_date"
                        value="{{ isset($proj) ? $proj->hnd_over_date : '' }}"
                        placeholder="Work Order Date" required>
                    @error('hnd_over_date')
                        <div class="btn btn-sm btn-danger">{{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label>Profit Center</label>
                </div>
                <div class="col-md-8 form-group ">
                   <select name="profit_pc_code" class="form-control" id="" required>
                       <option value="">Select...</option>
                       @foreach ($profit_centers as $item)
                       <option value="{{ $item->pc_code }}">{{ $item->pc_name }} </option>

                       @endforeach
                   </select>
                    @error('profit_pc_code')
                        <div class="btn btn-sm btn-danger">{{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col-12 d-flex justify-content-end ">
                    <button class="btn btn-info project-form-btn mr-1"
                    data_target="{{ route('projectForm') }}" disabled>New</button>
                    <button type="submit"
                        class="btn btn-primary mr-1">Submit</button>
                    <button type="reset"
                        class="btn btn-light-secondary ">Reset</button>

                </div>
            </div>
        </div>
    </div>

</div>
    </form>
