<nav class="header-navbar main-header-navbar navbar-expand-lg navbar navbar-with-menu fixed-top ">
    <div class="navbar-wrapper">
        <div class="navbar-container content">
            <div class="navbar-collapse" id="navbar-mobile">
                <div class="mr-auto float-left bookmark-wrapper d-flex align-items-center">
                    <ul class="nav navbar-nav">
                        <li class="nav-item mobile-menu d-xl-none mr-auto"><a class="nav-link nav-menu-main menu-toggle hidden-xs" href="javascript:void(0);"><i class="ficon bx bx-menu"></i></a></li>
                    </ul>

                </div>
                <ul class="nav navbar-nav float-right">

                    <li class="dropdown dropdown-notification nav-item">
                        <a class="nav-link nav-link-label" href="javascript:void(0);" data-toggle="dropdown">
                            <i class="ficon bx bx-bell bx-tada bx-flip-horizontal"></i>
                            <span class="badge badge-pill badge-danger badge-up">
                                @php
                                $m_n = 0;
                                $tarek_notification = 0;
                                    $rv_approval = App\ReceiptVoucher::where('status', 1)->count();
                                    $rv_approval_revise = App\ReceiptVoucher::where('status', 99)->count();
                                    $po_generation = App\Purchase::where('status', 0)->count();
                                    $po_generation_revise = App\Purchase::where('status', 99)->count();
                                    $authrize_pv = App\PaymentVoucher::where('status', 0)->count();
                                    $approve_pv = App\PaymentVoucher::where('status', 1)->count();
                                    $rejected_pv_all_editor = App\PaymentVoucher::where('status', 100)->count();
                                    $revise_pv_all_editor = App\PaymentVoucher::where('status', 99)->count();
                                    $rejected_pv_authorize = App\PaymentVoucher::where('status', 100)->where("state", "PV Approval")->count();
                                    $revise_pv_authorizer_approver = App\PaymentVoucher::where('status', 99)->where("state", "PV Approval")->count();
                                    $authrize_pt = App\PurchaseReturn::where('status', 0)->count();
                                    $approve_pt = App\PurchaseReturn::where('status', 1)->count();
                                    $rejected_pt_all_editor = App\PurchaseReturn::where('status', 100)->count();
                                    $rejected_pt_authorize = App\PurchaseReturn::where('status', 100)->where("state", "PT Approval")->count();
                                    $revise_pt_editor_approver = App\PurchaseReturn::where('status', 99)->where("state", "PT Approval")->count();
                                    $revise_pt_editor_authorizer = App\PurchaseReturn::where('status', 99)->where("state", "PT Authorizer")->count();
                                    $revise_pt_authorizer_approver = App\PurchaseReturn::where('status', 99)->where("state", "PT Approval")->count();
                                    $revise_pt_editor = App\PurchaseReturn::where('status', 99)->where("state", "PT Approval")->count();
                                    $authrizeRequisition = App\PurchaseRequisition::where('status', 0)->count();
                                    $approveRequisition = App\PurchaseRequisition::where('status', 1)->count();
                                    $rejectedRequisition = App\Notification::where('state', 'Editor')->where('status', 100)->count();
                                    $reviseRequisitionEditor = App\PurchaseRequisition::where('status', 99)->count();
                                    $reviseRequisitionAuthorize = App\Notification::where('state', 'Authorize')->where('status', 99)->count();
                                    
                                    if(Auth::user()->hasPermission('app.po')){ $m_n+=$rv_approval; }
                                    if(Auth::user()->hasPermission('app.sales.receipt_voucher')){ $m_n+=$rv_approval_revise; }
                                    if(Auth::user()->hasPermission('app.po')){ $m_n+=$po_generation_revise; }
                                    if(Auth::user()->hasPermission('app.po_approval')){ $m_n+=$po_generation; }
                                    if(Auth::user()->hasPermission('app.requisition_authorize')){ $m_n+=$authrizeRequisition; }
                                    if(Auth::user()->hasPermission('app.requisition_approval')){ $m_n+=$approveRequisition; }
                                    if(Auth::user()->hasPermission('app.requisition_entry')){ $m_n+=$rejectedRequisition; }
                                    if(Auth::user()->hasPermission('app.requisition_entry')){ $m_n+=$reviseRequisitionEditor; }
                                    if(Auth::user()->hasPermission('app.requisition_authorize')){ $m_n+=$reviseRequisitionAuthorize; }
                                    if(Auth::user()->hasPermission('app.purchase_return_authorize')){ $m_n+=$authrize_pt; }
                                    if(Auth::user()->hasPermission('app.purchase_return_entry')){ $m_n+=$revise_pt_editor_authorizer; }
                                    if(Auth::user()->hasPermission('app.purchase_return_authorize')){ $m_n+=$revise_pt_authorizer_approver; }
                                    if(Auth::user()->hasPermission('app.purchase_return_entry')){ $m_n+=$revise_pt_editor_approver; }
                                    if(Auth::user()->hasPermission('app.purchase_return_authorize')){ $m_n+=$rejected_pt_authorize; }
                                    if(Auth::user()->hasPermission('app.purchase_return_approval')){ $m_n+=$approve_pt; }
                                    if(Auth::user()->hasPermission('app.purchase_return_entry')){ $m_n+=$rejected_pt_all_editor; }
                                    if(Auth::user()->hasPermission('app.payment_voucher_authorize')){ $m_n+=$authrize_pv; }
                                    if(Auth::user()->hasPermission('app.payment_voucher_approval')){ $m_n+=$approve_pv; }
                                    if(Auth::user()->hasPermission('app.payment_voucher_entry')){ $m_n+=$rejected_pv_all_editor; }
                                    if(Auth::user()->hasPermission('app.payment_voucher_entry')){ $m_n+=$revise_pv_all_editor; }
                                    if(Auth::user()->hasPermission('app.payment_voucher_authorize')){ $m_n+=$rejected_pv_authorize; }
                                    if(Auth::user()->hasPermission('app.payment_voucher_authorize')){ $m_n+=$revise_pv_authorizer_approver; }
                                @endphp
                                {{-- @if (auth()->user()->hasPermission('app.journal_approval'))
                                    @if(auth()->user()->hasPermission('app.journal_authorize'))
                                    @if(auth()->user()->hasPermission('app.journal_entry'))
                                    @php
                                        $tarek_notification = App\Journal::where('state',"Approval")->where('checked', false)->count()+
                                        App\Journal::where('state',"Authorization")->where('checked', false)->count()+
                                        App\Journal::where('state',"Entry")->where('checked', false)->count();
                                    @endphp
                                    @else
                                    @php
                                        $tarek_notification = App\Journal::where('state',"Approval")->where('checked', false)->count()+App\Journal::where('state',"Authorization")->where('checked', false)->count();
                                    @endphp
                                    @endif
                                @elseif(auth()->user()->hasPermission('app.journal_entry'))
                                    @php
                                        $tarek_notification = App\Journal::where('state',"Approval")->where('checked', false)->count()+App\Journal::where('state',"Entry")->where('checked', false)->count()
                                    @endphp
                                @else 

                                @php
                                    $tarek_notification = App\Journal::where('state',"Approval")->where('checked', false)->count();
                                @endphp
                                @endif
                                @elseif (auth()->user()->hasPermission('app.journal_authorize'))
                                    @if(auth()->user()->hasPermission('app.journal_entry'))
                                    @php
                                        $tarek_notification = App\Journal::where('state',"Authorization")->where('checked', false)->count()+App\Journal::where('state',"Entry")->where('checked', false)->count();
                                    @endphp
                                    @else
                                    @php
                                        $tarek_notification = App\Journal::where('state',"Authorization")->where('checked', false)->count();
                                    @endphp
                                    @endif
                                @elseif(auth()->user()->hasPermission('app.journal_entry'))
                                    @php
                                        $tarek_notification = App\Journal::where('state',"Entry")->where('checked', false)->count();
                                    @endphp
                                @endif
                                --}}
                                {{$tarek_notification + $m_n}}
                            </span>
                        </a>
                            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                                {{-- @if (auth()->user()->hasPermission('app.journal_approval'))
                                    @if(App\Journal::where('state',"Approval")->where('checked', false)->count()>0)
                                    <div class="dropdown-divider"></div>
                                    <a href="{{ route('journalApproval') }}" class="dropdown-item">
                                    <strong style="color: red">{{ App\Journal::where('state',"Approval")->where('checked', false)->count() }}</strong>&nbsp;  Pending Journal for Approval
                                    </a>
                                    @endif
                                @endif
                                @if(auth()->user()->hasPermission('app.journal_authorize'))
                                    @if(App\Journal::where('state',"Authorization")->where('checked', false)->count()>0)
                                        <div class="dropdown-divider"></div>
                                        <a href="{{ route('journalAuthorize') }}" class="dropdown-item">
                                            <strong style="color: red"> {{ App\Journal::where('state',"Authorization")->where('checked', false)->count() }} </strong>&nbsp; Pending Journal for Authorization
                                        </a>
                                    @endif
                                @endif
                                @if(auth()->user()->hasPermission('app.journal_entry'))
                                    @if(App\Journal::where('state',"Entry")->where('checked', false)->count()>0)
                                    <div class="dropdown-divider"></div>
                                    <a href="{{ route('journalEntry') }}" class="dropdown-item">
                                        <strong style="color: red"> {{ App\Journal::where('state',"Entry")->where('checked', false)->count() }} </strong>&nbsp; Pending journal Feedback
                                    </a>
                                    @endif
                                @endif --}}
                                {{-- start work by mominul --}}
                                @if ($rv_approval>0 && Auth::user()->hasPermission('app.po'))
                                <div class="dropdown-divider"></div>
                                <a href="{{ route('receipt-voucher-approval-list') }}" class="dropdown-item">
                                    <strong style="color: red"> {{ $rv_approval }} </strong>&nbsp; Pending - Approval - Receipt  Voucher
                                </a>
                                @endif
                                @if ($rv_approval_revise>0 && Auth::user()->hasPermission('app.sales.receipt_voucher'))
                                <div class="dropdown-divider"></div>
                                <a href="{{ route('rv-revise-list') }}" class="dropdown-item">
                                    <strong style="color: red"> {{ $rv_approval_revise }} </strong>&nbsp; Revise - Editor - Receipt  Voucher
                                </a>
                                @endif
                                @if ($po_generation_revise>0 && Auth::user()->hasPermission('app.po'))
                                <div class="dropdown-divider"></div>
                                <a href="{{ route('po-generation-revise-list') }}" class="dropdown-item">
                                    <strong style="color: red"> {{ $po_generation_revise }} </strong>&nbsp; Revise - Editor - PO Generation
                                </a>
                                @endif
                                @if ($po_generation>0 && Auth::user()->hasPermission('app.po_approval'))
                                <div class="dropdown-divider"></div>
                                <a href="{{ route('po-generation-approval-list') }}" class="dropdown-item">
                                    <strong style="color: red"> {{ $po_generation }} </strong>&nbsp; Pending - Approval - PO Generation
                                </a>
                                @endif
                                @if ($authrizeRequisition>0 && Auth::user()->hasPermission('app.requisition_authorize'))
                                <div class="dropdown-divider"></div>
                                <a href="{{ route('authorize-requisition') }}" class="dropdown-item">
                                    <strong style="color: red"> {{ $authrizeRequisition }} </strong>&nbsp; Pending - Authorize - Purchase Requisition
                                </a>
                                @endif
                                @if ($approveRequisition>0  && Auth::user()->hasPermission('app.requisition_approval'))
                                <div class="dropdown-divider"></div>
                                <a href="{{ route('approve-requisition') }}" class="dropdown-item">
                                    <strong style="color: red"> {{ $approveRequisition }} </strong>&nbsp; Pending - Approval - Purchase Requisition
                                </a>
                                @endif
                                @if ($rejectedRequisition>0 && Auth::user()->hasPermission('app.requisition_entry'))
                                <div class="dropdown-divider"></div>
                                <a href="{{ route('rejected-requisition') }}" class="dropdown-item">
                                    <strong style="color: red"> {{ $rejectedRequisition }} </strong>&nbsp; Rejected - Editor - Purchase Requisition
                                </a>
                                @endif
                                @if ($reviseRequisitionEditor>0 && Auth::user()->hasPermission('app.requisition_entry'))
                                <div class="dropdown-divider"></div>
                                <a href="{{ route('revise-requisition-editor') }}" class="dropdown-item">
                                    <strong style="color: red"> {{ $reviseRequisitionEditor }} </strong>&nbsp; Revise - Editor - Purchase Requisition
                                </a>
                                @endif
                                @if ($reviseRequisitionAuthorize>0 && Auth::user()->hasPermission('app.requisition_authorize'))
                                <div class="dropdown-divider"></div>
                                <a href="{{ route('revise-requisition-authorize') }}" class="dropdown-item">
                                    <strong style="color: red"> {{ $reviseRequisitionAuthorize }} </strong>&nbsp; Revise - Authorizer - Purchase Requisition
                                </a>
                                @endif
                                @if ($authrize_pt>0 && Auth::user()->hasPermission('app.purchase_return_authorize'))
                                <div class="dropdown-divider"></div>
                                <a href="{{ route('purchase-return-authorize') }}" class="dropdown-item">
                                    <strong style="color: red"> {{ $authrize_pt }} </strong>&nbsp; Pending - Authorize - Purchase Return
                                </a>
                                @endif
                                @if ($revise_pt_editor_authorizer>0 && Auth::user()->hasPermission('app.purchase_return_entry'))
                                <div class="dropdown-divider"></div>
                                <a href="{{ route('purchase-return-revise') }}" class="dropdown-item">
                                    <strong style="color: red"> {{ $revise_pt_editor_authorizer }} </strong>&nbsp; Revise - Editor - Purchase Return
                                </a>
                                @endif
                                @if ($revise_pt_authorizer_approver>0 && Auth::user()->hasPermission('app.purchase_return_authorize'))
                                <div class="dropdown-divider"></div>
                                <a href="{{ route('revise-pt-authorize-list') }}" class="dropdown-item">
                                    <strong style="color: red"> {{ $revise_pt_authorizer_approver }} </strong>&nbsp; Revise - Authorizer - Purchase Return
                                </a>
                                @endif
                                @if ($revise_pt_editor_approver>0 && Auth::user()->hasPermission('app.purchase_return_entry'))
                                <div class="dropdown-divider"></div>
                                <a href="{{ route('purchase-return-revise') }}" class="dropdown-item">
                                    <strong style="color: red"> {{ $revise_pt_editor_approver }} </strong>&nbsp; Revise - Editor - Purchase Return
                                </a>
                                @endif
                                @if ($rejected_pt_authorize>0 && Auth::user()->hasPermission('app.purchase_return_authorize'))
                                <div class="dropdown-divider"></div>
                                <a href="{{ route('pt-rejected-list-authorize') }}" class="dropdown-item">
                                    <strong style="color: red"> {{ $rejected_pt_authorize }} </strong>&nbsp; Rejected - Authorizer - Purchase Return
                                </a>
                                @endif
                                @if ($approve_pt>0 && Auth::user()->hasPermission('app.purchase_return_approval'))
                                <div class="dropdown-divider"></div>
                                <a href="{{ route('purchase-return-approval') }}" class="dropdown-item">
                                    <strong style="color: red"> {{ $approve_pt }} </strong>&nbsp; Pending - Approval - Purchase Return
                                </a>
                                @endif
                                @if ($rejected_pt_all_editor>0 && Auth::user()->hasPermission('app.purchase_return_entry'))
                                <div class="dropdown-divider"></div>
                                <a href="{{ route('pt-rejected-list-editor') }}" class="dropdown-item">
                                    <strong style="color: red"> {{ $rejected_pt_all_editor }} </strong>&nbsp; Rejected  - Editor - Purchase Return
                                </a>
                                @endif
                                @if ($authrize_pv>0 && Auth::user()->hasPermission('app.payment_voucher_authorize'))
                                <div class="dropdown-divider"></div>
                                <a href="{{ route('pending-pv-authorize') }}" class="dropdown-item">
                                    <strong style="color: red"> {{ $authrize_pv }} </strong>&nbsp; Pending - Authorize - Payment Voucher
                                </a>
                                @endif
                                @if ($approve_pv>0 && Auth::user()->hasPermission('app.payment_voucher_approval'))
                                <div class="dropdown-divider"></div>
                                <a href="{{ route('pending-pv-approval') }}" class="dropdown-item">
                                    <strong style="color: red"> {{ $approve_pv }} </strong>&nbsp; Pending - Approval - Payment Voucher
                                </a>
                                @endif
                                @if ($rejected_pv_all_editor>0 && Auth::user()->hasPermission('app.payment_voucher_entry'))
                                <div class="dropdown-divider"></div>
                                <a href="{{ route('rejected-pv-all-editor') }}" class="dropdown-item">
                                    <strong style="color: red"> {{ $rejected_pv_all_editor }} </strong>&nbsp; Rejected - Editor - Payment Voucher
                                </a>
                                @endif
                                @if ($revise_pv_all_editor>0 && Auth::user()->hasPermission('app.payment_voucher_entry'))
                                <div class="dropdown-divider"></div>
                                <a href="{{ route('revise-pv-all-editor') }}" class="dropdown-item">
                                    <strong style="color: red"> {{ $revise_pv_all_editor }} </strong>&nbsp; Revise - Editor - Payment Voucher
                                </a>
                                @endif
                                @if ($rejected_pv_authorize>0 && Auth::user()->hasPermission('app.payment_voucher_authorize'))
                                <div class="dropdown-divider"></div>
                                <a href="{{ route('rejected-pv-authorize') }}" class="dropdown-item">
                                    <strong style="color: red"> {{$rejected_pv_authorize }} </strong>&nbsp; Rejected - Authorizer - Payment Voucher
                                </a>
                                @endif
                                @if ($revise_pv_authorizer_approver>0 && Auth::user()->hasPermission('app.payment_voucher_authorize'))
                                <div class="dropdown-divider"></div>
                                <a href="{{ route('revise-pv-authorizer-approver') }}" class="dropdown-item">
                                    <strong style="color: red"> {{$revise_pv_authorizer_approver }} </strong>&nbsp; Revise - Authorizer - Payment Voucher
                                </a>
                                @endif
                                {{-- end work by mominul --}}
                    </li>
                    <li class="dropdown dropdown-user nav-item"><a class="dropdown-toggle nav-link dropdown-user-link" href="javascript:void(0);" data-toggle="dropdown">
                            <div class="user-nav d-sm-flex d-none"><span class="user-name">{{ Auth::user()->name}}</span><span class="user-status text-muted">Available</span></div><span><img class="round" src="{{ asset('assets/backend')}}/app-assets/user.png" alt="avatar" height="40" width="40"></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right pb-0">
                            <a class="dropdown-item" href="#"><i class="bx bx-user mr-50"></i> Edit Profile</a>
                            {{-- <a class="dropdown-item" href="app-email.html"><i class="bx bx-envelope mr-50"></i> My Inbox</a>
                            <a class="dropdown-item" href="app-todo.html"><i class="bx bx-check-square mr-50"></i> Task</a>
                            <a class="dropdown-item" href="app-chat.html"><i class="bx bx-message mr-50"></i> Chats</a>  --}}
                            <div class="dropdown-divider mb-0"></div>
                            <a class="dropdown-item" onclick="event.preventDefault();
                            document.getElementById('logout-form-n').submit();" href="#"><i class="bx bx-power-off mr-50"></i> Logout</a>
                            <form id="logout-form-n" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>
