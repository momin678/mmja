<?php

use App\Module;
use App\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Dashboard
        $moduleAppDashboard = Module::updateOrCreate(['name' => 'Admin Dashboard']);
        Permission::updateOrCreate([
            'module_id' => $moduleAppDashboard->id,
            'name' => 'Access Dashboard',
            'slug' => 'app.dashboard',
        ]);

        // Role management
        $moduleAppAccess = Module::updateOrCreate(['name' => 'Access Control']);
        Permission::updateOrCreate([
            'module_id' => $moduleAppAccess->id,
            'name' => 'User Management',
            'slug' => 'app.access_control.user',
        ]);
        Permission::updateOrCreate([
            'module_id' => $moduleAppAccess->id,
            'name' => 'Role Management',
            'slug' => 'app.access_control.role',
        ]);
        Permission::updateOrCreate([
            'module_id' => $moduleAppAccess->id,
            'name' => 'Settings',
            'slug' => 'app.access_control.settings',
        ]);

        

        // Mapping
        $mapping = Module::updateOrCreate(['name' => 'Mapping']);
        Permission::updateOrCreate([
            'module_id' => $mapping->id,
            'name' => 'Access Mapping',
            'slug' => 'app.mapping.index',
        ]);
        Permission::updateOrCreate([
            'module_id' => $mapping->id,
            'name' => 'Create Mapping',
            'slug' => 'app.mapping.create',
        ]);
        Permission::updateOrCreate([
            'module_id' => $mapping->id,
            'name' => 'Edit Mapping',
            'slug' => 'app.mapping.edit',
        ]);
        Permission::updateOrCreate([
            'module_id' => $mapping->id,
            'name' => 'Delete Mapping',
            'slug' => 'app.mapping.destroy',
        ]);

        // Project Details
        $project = Module::updateOrCreate(['name' => 'Project']);
        Permission::updateOrCreate([
            'module_id' => $project->id,
            'name' => 'Access Project',
            'slug' => 'app.project.index',
        ]);
        Permission::updateOrCreate([
            'module_id' => $project->id,
            'name' => 'Create Project',
            'slug' => 'app.project.create',
        ]);
        Permission::updateOrCreate([
            'module_id' => $project->id,
            'name' => 'Edit Project',
            'slug' => 'app.project.edit',
        ]);
        Permission::updateOrCreate([
            'module_id' => $project->id,
            'name' => 'Delete Project',
            'slug' => 'app.project.destroy',
        ]);

        // Bank Details
        $bank = Module::updateOrCreate(['name' => 'Bank Details']);
        Permission::updateOrCreate([
            'module_id' => $bank->id,
            'name' => 'Access Bank Details',
            'slug' => 'app.bank_details.index',
        ]);
        Permission::updateOrCreate([
            'module_id' => $bank->id,
            'name' => 'Create Bank Details',
            'slug' => 'app.bank_details.create',
        ]);
        Permission::updateOrCreate([
            'module_id' => $bank->id,
            'name' => 'Edit Bank Details',
            'slug' => 'app.bank_details.edit',
        ]);
        Permission::updateOrCreate([
            'module_id' => $bank->id,
            'name' => 'Delete Bank Details',
            'slug' => 'app.bank_details.destroy',
        ]);

        // Master Account
        $master_account = Module::updateOrCreate(['name' => 'Master Account']);
        Permission::updateOrCreate([
            'module_id' => $master_account->id,
            'name' => 'Access master account',
            'slug' => 'app.master_account.index',
        ]);
        Permission::updateOrCreate([
            'module_id' => $master_account->id,
            'name' => 'Create master account',
            'slug' => 'app.master_account.create',
        ]);
        Permission::updateOrCreate([
            'module_id' => $master_account->id,
            'name' => 'Edit master account',
            'slug' => 'app.master_account.edit',
        ]);
        Permission::updateOrCreate([
            'module_id' => $master_account->id,
            'name' => 'Delete master account',
            'slug' => 'app.master_account.destroy',
        ]);

        // Account Head
        $account_head = Module::updateOrCreate(['name' => 'Account Head']);
        Permission::updateOrCreate([
            'module_id' => $account_head->id,
            'name' => 'Access account head',
            'slug' => 'app.account_head.index',
        ]);
        Permission::updateOrCreate([
            'module_id' => $account_head->id,
            'name' => 'Create account head',
            'slug' => 'app.account_head.create',
        ]);
        Permission::updateOrCreate([
            'module_id' => $account_head->id,
            'name' => 'Edit account head',
            'slug' => 'app.account_head.edit',
        ]);
        Permission::updateOrCreate([
            'module_id' => $account_head->id,
            'name' => 'Delete account head',
            'slug' => 'app.account_head.destroy',
        ]);

        // Cost Center
        $cost_center = Module::updateOrCreate(['name' => 'Cost Center']);
        Permission::updateOrCreate([
            'module_id' => $cost_center->id,
            'name' => 'Access cost center',
            'slug' => 'app.cost_center.index',
        ]);
        Permission::updateOrCreate([
            'module_id' => $cost_center->id,
            'name' => 'Create cost center',
            'slug' => 'app.cost_center.create',
        ]);
        Permission::updateOrCreate([
            'module_id' => $cost_center->id,
            'name' => 'Edit cost center',
            'slug' => 'app.cost_center.edit',
        ]);
        Permission::updateOrCreate([
            'module_id' => $cost_center->id,
            'name' => 'Delete cost center',
            'slug' => 'app.cost_center.destroy',
        ]);

        // Profit Center
        $profit_center = Module::updateOrCreate(['name' => 'Profit Center']);
        Permission::updateOrCreate([
            'module_id' => $profit_center->id,
            'name' => 'Access profit center',
            'slug' => 'app.profit_center.index',
        ]);
        Permission::updateOrCreate([
            'module_id' => $profit_center->id,
            'name' => 'Create profit center',
            'slug' => 'app.profit_center.create',
        ]);
        Permission::updateOrCreate([
            'module_id' => $profit_center->id,
            'name' => 'Edit profit center',
            'slug' => 'app.profit_center.edit',
        ]);
        Permission::updateOrCreate([
            'module_id' => $profit_center->id,
            'name' => 'Delete profit center',
            'slug' => 'app.profit_center.destroy',
        ]);

        // Party Info
        $party_info = Module::updateOrCreate(['name' => 'Party Info']);
        Permission::updateOrCreate([
            'module_id' => $party_info->id,
            'name' => 'Access party info',
            'slug' => 'app.party_info.index',
        ]);
        Permission::updateOrCreate([
            'module_id' => $party_info->id,
            'name' => 'Create party info',
            'slug' => 'app.party_info.create',
        ]);
        Permission::updateOrCreate([
            'module_id' => $party_info->id,
            'name' => 'Edit party info',
            'slug' => 'app.party_info.edit',
        ]);
        Permission::updateOrCreate([
            'module_id' => $party_info->id,
            'name' => 'Delete party info',
            'slug' => 'app.party_info.destroy',
        ]);

       // Journal
       $document = Module::updateOrCreate(['name' => 'Document']);
       Permission::updateOrCreate([
           'module_id' => $document->id,
           'name' => 'Document',
           'slug' => 'app.document',
       ]);

        // Journal
        $journal = Module::updateOrCreate(['name' => 'Journal']);
        Permission::updateOrCreate([
            'module_id' => $journal->id,
            'name' => 'Journal Entry',
            'slug' => 'app.journal_entry',
        ]);
        Permission::updateOrCreate([
            'module_id' => $journal->id,
            'name' => 'Journal Authorize',
            'slug' => 'app.journal_authorize',
        ]);
        Permission::updateOrCreate([
            'module_id' => $journal->id,
            'name' => 'Journal approval',
            'slug' => 'app.journal_approval',
        ]);

        // Accounts Report
        $accounts_report = Module::updateOrCreate(['name' => 'Accounts Report']);
        Permission::updateOrCreate([
            'module_id' => $accounts_report->id,
            'name' => 'General Ledger',
            'slug' => 'app.acreport.gl',
        ]);
        Permission::updateOrCreate([
            'module_id' => $accounts_report->id,
            'name' => 'Trial Balance',
            'slug' => 'app.acreport.tb',
        ]);
        Permission::updateOrCreate([
            'module_id' => $accounts_report->id,
            'name' => 'Income Statement',
            'slug' => 'app.acreport.is',
        ]);
        Permission::updateOrCreate([
            'module_id' => $accounts_report->id,
            'name' => 'Balance Sheet',
            'slug' => 'app.acreport.bs',
        ]);
        Permission::updateOrCreate([
            'module_id' => $accounts_report->id,
            'name' => 'Cash Flow Statement',
            'slug' => 'app.acreport.cfs',
        ]);

        // Style
        $style = Module::updateOrCreate(['name' => 'Style']);
        Permission::updateOrCreate([
            'module_id' => $style->id,
            'name' => 'Access style',
            'slug' => 'app.style.index',
        ]);
        Permission::updateOrCreate([
            'module_id' => $style->id,
            'name' => 'Create style',
            'slug' => 'app.style.create',
        ]);
        Permission::updateOrCreate([
            'module_id' => $style->id,
            'name' => 'Edit style',
            'slug' => 'app.style.edit',
        ]);
        Permission::updateOrCreate([
            'module_id' => $style->id,
            'name' => 'Delete style',
            'slug' => 'app.style.destroy',
        ]);

        // Color
        $color = Module::updateOrCreate(['name' => 'Color']);
        Permission::updateOrCreate([
            'module_id' => $color->id,
            'name' => 'Access color',
            'slug' => 'app.color.index',
        ]);
        Permission::updateOrCreate([
            'module_id' => $color->id,
            'name' => 'Create color',
            'slug' => 'app.color.create',
        ]);
        Permission::updateOrCreate([
            'module_id' => $color->id,
            'name' => 'Edit color',
            'slug' => 'app.color.edit',
        ]);
        Permission::updateOrCreate([
            'module_id' => $color->id,
            'name' => 'Delete color',
            'slug' => 'app.color.destroy',
        ]);

        // Size
        $size = Module::updateOrCreate(['name' => 'Size']);
        Permission::updateOrCreate([
            'module_id' => $size->id,
            'name' => 'Access size',
            'slug' => 'app.size.index',
        ]);
        Permission::updateOrCreate([
            'module_id' => $size->id,
            'name' => 'Create size',
            'slug' => 'app.size.create',
        ]);
        Permission::updateOrCreate([
            'module_id' => $size->id,
            'name' => 'Edit size',
            'slug' => 'app.size.edit',
        ]);
        Permission::updateOrCreate([
            'module_id' => $size->id,
            'name' => 'Delete size',
            'slug' => 'app.size.destroy',
        ]);

        // Item List
        $item_list = Module::updateOrCreate(['name' => 'item-list']);
        Permission::updateOrCreate([
            'module_id' => $item_list->id,
            'name' => 'Access item list',
            'slug' => 'app.item_list.index',
        ]);
        Permission::updateOrCreate([
            'module_id' => $item_list->id,
            'name' => 'Create item list',
            'slug' => 'app.item_list.create',
        ]);
        Permission::updateOrCreate([
            'module_id' => $item_list->id,
            'name' => 'Edit item list',
            'slug' => 'app.item_list.edit',
        ]);
        Permission::updateOrCreate([
            'module_id' => $item_list->id,
            'name' => 'Delete item list',
            'slug' => 'app.item_list.destroy',
        ]);

        // Stock Management
        $stock = Module::updateOrCreate(['name' => 'Stock Managment']);
        Permission::updateOrCreate([
            'module_id' => $stock->id,
            'name' => 'Stock Position',
            'slug' => 'app.stock.position',
        ]);
        Permission::updateOrCreate([
            'module_id' => $stock->id,
            'name' => 'Reconciliation',
            'slug' => 'app.stock.reconciliation',
        ]);

        
        // Report 
        $report = Module::updateOrCreate(['name' => 'Report']);
        Permission::updateOrCreate([
            'module_id' => $report->id,
            'name' => 'Daily Sales',
            'slug' => 'app.daily_sales',
        ]);
        Permission::updateOrCreate([
            'module_id' => $report->id,
            'name' => 'Monthly Sales',
            'slug' => 'app.monthly_sales',
        ]);
        Permission::updateOrCreate([
            'module_id' => $report->id,
            'name' => 'Delivery Summery',
            'slug' => 'app.delivery_summery',
        ]);
        
        // Purchase
        $purchase = Module::updateOrCreate(['name' => 'Purchase']);
        Permission::updateOrCreate([
            'module_id' => $purchase->id,
            'name' => 'Requisition Entry',
            'slug' => 'app.requisition_entry',
        ]);
        Permission::updateOrCreate([
            'module_id' => $purchase->id,
            'name' => 'Requisition Authorize',
            'slug' => 'app.requisition_authorize',
        ]);
        Permission::updateOrCreate([
            'module_id' => $purchase->id,
            'name' => 'Requisition approval',
            'slug' => 'app.requisition_approval',
        ]);

        Permission::updateOrCreate([
            'module_id' => $purchase->id,
            'name' => 'Purchase Order',
            'slug' => 'app.po',
        ]);
        Permission::updateOrCreate([
            'module_id' => $purchase->id,
            'name' => 'PO Approval',
            'slug' => 'app.po_approval',
        ]);
        Permission::updateOrCreate([
            'module_id' => $purchase->id,
            'name' => 'Goods Receive',
            'slug' => 'app.gr',
        ]);
        Permission::updateOrCreate([
            'module_id' => $purchase->id,
            'name' => 'Invoice Posting',
            'slug' => 'app.ip',
        ]);


        // purchase return
        $p_return = Module::updateOrCreate(['name' => 'Purchase Return']);
        Permission::updateOrCreate([
            'module_id' => $p_return->id,
            'name' => 'Purchase Return Entry',
            'slug' => 'app.purchase_return_entry',
        ]);
        Permission::updateOrCreate([
            'module_id' => $p_return->id,
            'name' => 'Purchase Return Authorize',
            'slug' => 'app.purchase_return_authorize',
        ]);
        Permission::updateOrCreate([
            'module_id' => $p_return->id,
            'name' => 'Purchase Return approval',
            'slug' => 'app.purchase_return_approval',
        ]);
        
        // Payment Voucher
        $payment_voucher = Module::updateOrCreate(['name' => 'Payment Voucher']);
        Permission::updateOrCreate([
            'module_id' => $payment_voucher->id,
            'name' => 'Payment Voucher Entry',
            'slug' => 'app.payment_voucher_entry',
        ]);
        Permission::updateOrCreate([
            'module_id' => $payment_voucher->id,
            'name' => 'Payment Voucher Authorize',
            'slug' => 'app.payment_voucher_authorize',
        ]);
        Permission::updateOrCreate([
            'module_id' => $payment_voucher->id,
            'name' => 'Payment Voucher Approval',
            'slug' => 'app.payment_voucher_approval',
        ]);


        // Sales
        $sales = Module::updateOrCreate(['name' => 'Sales']);
        Permission::updateOrCreate([
            'module_id' => $sales->id,
            'name' => 'Counter tax invoice',
            'slug' => 'app.sales.counter_tax_invoice',
        ]);
        Permission::updateOrCreate([
            'module_id' => $sales->id,
            'name' => 'SO Receive',
            'slug' => 'app.sales.so',
        ]);
        Permission::updateOrCreate([
            'module_id' => $sales->id,
            'name' => 'Delivery Note',
            'slug' => 'app.sales.delivery_note',
        ]);
        Permission::updateOrCreate([
            'module_id' => $sales->id,
            'name' => 'Warehouse Tax Invoice',
            'slug' => 'app.sales.warehouse_tax_invoice',
        ]);

        Permission::updateOrCreate([
            'module_id' => $sales->id,
            'name' => 'Receipt Voucher',
            'slug' => 'app.sales.receipt_voucher',
        ]);

        Permission::updateOrCreate([
            'module_id' => $sales->id,
            'name' => 'Receipt Voucher Approval',
            'slug' => 'app.sales.rv_approval',
        ]);

        Permission::updateOrCreate([
            'module_id' => $sales->id,
            'name' => 'Sales Return',
            'slug' => 'app.sales.sr',
        ]);

    }
}
