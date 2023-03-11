@extends('layouts.pdf.app')
@section('title', 'purchase return pdf print')
@section('content')
    <div class="container py-4">
        <div class="row">
            <div class="col-md-12">
                <section id="widgets-Statistics">
                    <div class="row">
                        <div class="col-12 text-center">
                            <h1>Purchase Return</h1>
                        </div>
                    </div>

                    <div class="">
                        <div class="card-body content-padding">
                            <div class="row">
                                <div class="col-sm-4 col-12">
                                    <label for="mode"><strong>PR No</strong></label>
                                    <p>{{$pt_info->purchase_return_no}}</p>
                                </div>
                                <div class="col-sm-4 col-12">
                                    <label for="mode"><strong>GR No</strong></label>
                                    <p>{{$pt_info->gr_no}}</p>
                                </div>
                                <div class="col-sm-4 col-12">
                                    <label for="mode"><strong>PO No</strong></label>
                                    <p>{{$pt_info->po_no}}</p>
                                </div>
                                <div class="col-sm-4 col-12">
                                    <label for="project_id"><strong>Branch Name</strong></label>
                                    <p>{{$pt_info->projectInfo->proj_name}}</p>
                                </div>
                                <div class="col-sm-4 col-12">
                                    <label for="mode"><strong>Supplier Name</strong></label>
                                    <p>{{$pt_info->partInfo->pi_name}}</p>
                                </div>
                                <div class="col-sm-4 col-12">
                                    <label for="mode"><strong>Delivery Note No</strong></label>
                                    <p>{{$pt_info->challan_number}}</p>
                                </div>
                                <div class="col-sm-4 col-12">
                                    <label for=""><strong>PT Date:</strong></label>
                                    <p>{{date('d-m-Y', strtotime($pt_info->date))}}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row"> 
                        <table class="table table-sm table-bordered">
                            <thead>
                                <tr>
                                    <th>Barcode</th>
                                    <th scope="col">Item Name</th>
                                    <th scope="col">Color</th>
                                    <th scope="col">Size</th>
                                    <th scope="col">Return Qty</th>
                                    <th scope="col">Cooment</th>
                                </tr>
                            </thead>
                            <tbody id="tempLists"  class="user-table-body">
                                @foreach ($pt_items as $item)
                                <tr class="data-row">
                                    <td> {{$item->itemName->barcode}} </td>
                                    <td> {{$item->itemName->item_name}} </td>
                                    <td>{{$item->itemName->brandName->name}}</td>
                                    <td> {{$item->itemName->group_name}} </td>
                                    <td> {{$item->return_qty}}</td>
                                    <td> {{$item->comment}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="row mt-5 pt-5">
                        <div class="col-12">
                            <div class="mt-5">
                                <div class="d-flex text-center" style="justify-content: space-between">
                                    <div>
                                        <h6>Prepared By:</h5>
                                        <h5>Mahidul Islam Bappi</h5>
                                    </div>
                                    <div>
                                        <h5>Endorsed By:</h5>
                                        <h5>Mohammad Habibur Rahman</h5>
                                    </div>
                                    <div>
                                        <h5>Authorized By:</h5>
                                        <h5>Md. Akhter Hossain</h5>
                                    </div>
                                    <div>
                                        <h5>Approved By:</h5>
                                        <h5>Salim Osman</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
@endsection
